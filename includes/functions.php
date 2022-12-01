<?php
// ======== GLOBALS ========

// ======== DATABASE ========

/**
 * Connect to the database using mysqli_connect
 *
 * @param array $dbCred(hostname, username, password, database)
 * @return mysqli
 */
function initDb($dbCred) {
  return mysqli_connect($dbCred["hostname"], $dbCred["username"], $dbCred["password"], $dbCred["database"]) or die("Error: Unable to connect to MySQL database.");
}

/**
 * Try connect to database and redirect to error page if failed
 */
function checkDatabaseConnection() {
  $config = include('./conf/config.php');
  $dbCred = $config['db'];
  if (!initDb($dbCred)) {
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
function dbEscapeString($string) {
  $config = include('./conf/config.php');
  $dbConn = initDb($config['db']);

  $string = mysqli_real_escape_string($dbConn, $string);
  mysqli_close($dbConn);

  return $string;
}

// ======== AUTHENTICATION ========

/**
 * Match username and password against database and add to session if correct then redirect to index.php
 *
 * @param string $username
 * @param string $password
 */
function login($username, $password) {
  // Database connection
  $config = include('./conf/config.php');
  $dbConn = initDb($config['db']);

  // Check if user login details are correct in DB
  $query = "SELECT 1 FROM user WHERE username = '$username' AND password = '$password'";
  $result = mysqli_query($dbConn, $query);

  // If uesr exists then
  if (mysqli_num_rows($result) == 1) {
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;

    mysqli_close($dbConn);
    header("Location: ./index.php");
  } else {
    $_SESSION['loginError'] = "Incorrect username or password";
    mysqli_close($dbConn);
    header("Location: ./login.php");
  }
}

/**
 * Restart session and redirect to login.php
 * @return void
 */
function logout() {
  session_start();
  session_destroy();
  header("Location: ./login.php");
}

/**
 * Adds a new user to database then logs in
 *
 * @param string $username
 * @param string $password
 * @return void
 */
function register($username, $password) {
  // Database connection
  $config = include('./conf/config.php');
  $dbConn = initDb($config['db']);

  // Check if user already exists
  $query = "SELECT 1 FROM user WHERE username = '$username'";
  $result = mysqli_query($dbConn, $query);

  // If user exists then exit
  if (mysqli_num_rows($result) == 1) {
    $_SESSION['registerError'] = "Username already exists";
    redirectTo("register.php");
  }

}

/**
 * Returns true if user details in session are correct
 *
 * @return boolean
 */
function isLoggedIn() {
  // Check if user is logged in
  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $query = "SELECT 1 FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($dbConn, $query);

    if (mysqli_num_rows($result) == 1) {
      return true;
    }
  }
  return false;
}

// ======== UTILITIES ========

function currentPage() {
  return $_SERVER["PHP_SELF"];
}

function redirectTo($href){
  header( "Location: {$href}" );
  exit;
}

function redirectError($errid){
  $_SESSION['error'] = array('date' => date("d/m/y H:i:s"), 'message' => $errid);
  redirectTo('./error.php');
}
function consoleLog($message){
  echo "<script>console.log('" . htmlentities($message) ."');</script>";
}
?>