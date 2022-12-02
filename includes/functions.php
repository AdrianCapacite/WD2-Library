<?php
// ======== GLOBALS ========

// ======== DATABASE ========

/**
 * Connect to the database using mysqli_connect
 *
 * @param array $dbCred(hostname, username, password, database)
 * @return mysqli
 */
function initDb($dbCred):mysqli {
  $dbConn = mysqli_connect($dbCred['hostname'], $dbCred['username'], $dbCred['password'], $dbCred['database']) or die("Could not connect to database");
  return $dbConn;
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
    redirectTo("./index.php");
  } else {
    $_SESSION['authError'] = "Incorrect username or password";
    mysqli_close($dbConn);
    redirectTo("./login.php");
  }
}

/**
 * Restart session and redirect to login.php
 * @return void
 */
function logout() {
  session_destroy();
  session_start();
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

  // Check if user already exists then redirect to register.php
  $query = "SELECT 1 FROM user WHERE username = '$username'";
  $result = mysqli_query($dbConn, $query);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION['authError'] = "Username already exists";
    redirectTo("./register.php");
  }

  // Add user to database
  $query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
  $result = mysqli_query($dbConn, $query);

  // If user was added to database then login
  echo "reg";
  if ($result) {
    $_Session['info'] = "User created successfully";
    login($username, $password);
  } else {
    $_SESSION['authError'] = "Could not register user";
    redirectTo("./register.php");
  }
}

/**
 * Returns true if user details in session are correct
 *
 * @return boolean
 */
function isLoggedIn() {
  if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    // Database connection
    $config = include('./conf/config.php');
    // print_r($config);
    $dbConn = initDb($config['db']);

    // Check if user login details are correct in DB
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
  echo "<script>console.log('PHP: " . htmlentities($message) ."');</script>";
}
?>