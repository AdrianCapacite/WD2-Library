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
function initDb($dbCred = null):bool|mysqli {
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
  $dbConn = initDb();
  if (!$dbConn) {
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



?>