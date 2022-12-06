<?php
/**
 *
 * ======== DATABASE ========
 *
 */

/**
 * Connect to the database using mysqli_connect
 *
 * @param array $dbCred(hostname, username, password, database)
 * @return mysqli
 */
function initDb($dbCred = null):mysqli {
  if ($dbCred == null) {
    $dbCred = getConfig('db');
  }
  $dbConn = mysqli_connect($dbCred['hostname'], $dbCred['username'], $dbCred['password'], $dbCred['database']) or die("Could not connect to database");
  return $dbConn;
}

/**
 * Try connect to database and redirect to error page if failed
 */
function checkDatabaseConnection() {
  if (!initDb()) {
    redirectError("Database connection failed");
    header("Location: ./error.php");
  } else {
    mysqli_close($dbConn);
  }
}

/**
 * Use mysqli_real_escape_string to escape special characters in a string for use in an SQL statement
 *
 * @param string $string
 * @return string
 */
function dbEscapeString($string):string {
  $dbConn = initDb(); // Connect database connection
  $string = mysqli_real_escape_string($dbConn, $string);
  mysqli_close($dbConn);
  return $string;
}

// ======== QUERIES ========

function queryBooks($keyword, $category, $orderby, $order, $limit = 5):mysqli_result {
  $dbConn = initDb(); // Connect database connection

  // SELECT ... FROM
  $cols = "`book`.`isbn`, `book`.`title`, `book`.`author`, `book`.`edition`, `book`.`year`, `book`.`reserved`, `category`.`details`, `user`.`username`";
  $query = "SELECT $cols FROM book ";

  // JOIN everything in book and matching on category
  $query .= "LEFT JOIN category ON `book`.`category` = `category`.`id` ";

  // JOIN everything in book and matching on reserved > user
  $query .= "LEFT JOIN reserved ON `book`.`isbn` = `reserved`.`isbn` ";
  $query .= "LEFT JOIN user ON `reserved`.`username` = `user`.`username` ";

  // WHERE title AND category
  $query .= "WHERE title LIKE '%$keyword%' AND category LIKE '%$category%'";

  // ORDER BY
  $query .= "ORDER BY $orderby $order LIMIT $limit";

  echo $query;

  $result = mysqli_query($dbConn, $query);
  mysqli_close($dbConn);

  return $result;
}

/**
 * Returns associative array of categories from database
 *
 * @return
 */
function getCategories():mysqli_result {
  $dbConn = initDb(); // Connect database connection

  $query = "SELECT details FROM category";
  $result = mysqli_query($dbConn, $query);
  mysqli_close($dbConn);


  return $result;
}

?>