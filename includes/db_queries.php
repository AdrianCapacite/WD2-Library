<?php
/**
 * Library Website Database
 * Author: Adrian Thomas Capacite C21348423
 *
 * ======== DATABASE QUERIES ========
 *
 */

/**
 * Fetch books from database
 *
 * Keyword searches for title and author, partial keywords are allowed
 *
 * Columns: isbn, title, author, edition, year, reserved, category, reservedby, reserveddate
 *
 * @param string $keyword
 * @param string $category
 * @param string $orderby
 * @param string $order
 * @param int $limit
 * @param int $offset
 */
function queryBooks($keyword, $category, $orderby, $order, $limit = 5, $offset = 0, $reservedby = null):mysqli_result {
  $dbConn = initDb(); // Connect database connection

  // SELECT ... FROM
  $cols = "`book`.`isbn`, `book`.`title`, `book`.`author`, `book`.`edition`, `book`.`year`, `book`.`reserved`, `category`.`details` \"category\", `user`.`username` \"reservedby\", `reserved`.`reserveddate`";
  $query = "SELECT $cols FROM book ";

  // JOIN everything in book and matching on category
  $query .= "LEFT JOIN category ON `book`.`category` = `category`.`id` ";

  // JOIN everything in book and matching on reserved > user
  $query .= "LEFT JOIN reserved ON `book`.`isbn` = `reserved`.`isbn` ";
  $query .= "LEFT JOIN user ON `reserved`.`username` = `user`.`username` ";

  // WHERE title or author AND category (AND reserved)
  $query .= "WHERE (`title` LIKE '%$keyword%' OR `author` LIKE '%$keyword%') ";
  $query .= "AND `category`.`details` LIKE '%$category%' ";
  if ($reservedby != null) {
    $query .= "AND `reserved`.`username` = '$reservedby' ";
  }

  // ORDER BY and offset
  $query .= "ORDER BY $orderby $order ";
  $query .= "LIMIT $limit OFFSET $offset";

  $result = mysqli_query($dbConn, $query);
  mysqli_close($dbConn);

  return $result;
}

function reserveBook($isbn, $username):bool {
  $dbConn = initDb(); // Connect database connection

  // Check if book is in reserved table
  $query = "SELECT * FROM `reserved` WHERE `isbn` = '$isbn'";
  if (mysqli_num_rows(mysqli_query($dbConn, $query)) > 0) {
    mysqli_close($dbConn);
    return false; // Unable to reserve book
  }

  // Update book reserved to 'Y'
  $query = "UPDATE `book` SET `reserved` = 'Y' WHERE isbn = '$isbn'";
  mysqli_query($dbConn, $query);

  // Add isbn and username to reserved table
  $query = "INSERT INTO `reserved` (`isbn`, `username`, `reserveddate`) VALUES ('$isbn', '$username', CURDATE())";
  echo $query;
  $result = mysqli_query($dbConn, $query);
  mysqli_close($dbConn);

  return true;
}

function unreserveBook($isbn, $username):bool {
  $dbConn = initDb(); // Connect database connection

  // Check if book is reserved by user
  $query = "SELECT * FROM `reserved` WHERE `isbn` = '$isbn' AND `username` = '$username'";
  if (mysqli_num_rows(mysqli_query($dbConn, $query)) == 0) {
    mysqli_close($dbConn);
    return false; // Unable to unreserve book
  }

  // Update book reserved to 'N'
  $query = "UPDATE `book` SET `reserved` = 'N' WHERE isbn = '$isbn'";
  mysqli_query($dbConn, $query);

  // Remove isbn and username from reserved table
  $query = "DELETE FROM `reserved` WHERE `isbn` = '$isbn' AND `username` = '$username'";
  $result = mysqli_query($dbConn, $query);
  mysqli_close($dbConn);

  return true;
}

/**
 * Returns associative array of categories from database
 *
 * @return
 */
function getCategories():array {
  $dbConn = initDb(); // Connect database connection

  $query = "SELECT details FROM category";
  $result = mysqli_query($dbConn, $query);
  $categories = [];

  while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row['details'];
  }
  mysqli_close($dbConn);


  return $categories;
}

/**
 * Returns count of books in database from a query
 */
function countBooks($keyword, $category, $limit = 5, $offset = 0, $reservedby = null):int {
  $dbConn = initDb(); // Connect database connection

  $query = "SELECT 1 FROM book ";

  // JOIN everything in book and matching on category
  $query .= "LEFT JOIN category ON `book`.`category` = `category`.`id` ";

  // JOIN everything in book and matching on reserved > user
  $query .= "LEFT JOIN reserved ON `book`.`isbn` = `reserved`.`isbn` ";
  $query .= "LEFT JOIN user ON `reserved`.`username` = `user`.`username` ";

  // WHERE
  $query .= "WHERE (`title` LIKE '%$keyword%' OR `author` LIKE '%$keyword%') ";
  $query .= "AND `category`.`details` LIKE '%$category%' ";
  if ($reservedby != null) {
    $query .= "AND `reserved`.`username` = '$reservedby' ";
  }

  if ($limit != null) {
    $query .= "LIMIT $limit OFFSET $offset";
  }
  $result = mysqli_query($dbConn, $query);

  $count = mysqli_num_rows($result);

  mysqli_close($dbConn);

  return $count;
}
?>