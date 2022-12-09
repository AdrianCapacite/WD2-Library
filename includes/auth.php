<?php
/**
 *
 * ======== AUTHENTICATION ========
 *
 */

// ======== GLOBALS =========

// ======== FUNCTIONS ========
/**
 * Match username and password against database and add to session if correct then redirect to index.php
 *
 * ENSURE INPUT IS SANITIZED BEFORE CALLING THIS FUNCTION
 *
 * @param string $username
 * @param string $password
 */
function login($username, $password) {
  if (verifyUser($username, $password) === 2) {
    $_SESSION['account'] = array('username' => $username,
                                 'password' => $password);
    redirectTo("./index.php");
    return;
  } else {
    sessionMessage("Incorrect username or password", 3);
    redirectTo("./login.php");
    return;
  }
}

/**
 * Restart session and redirect to login.php
 * @return void
 */
function logout() {
  session_destroy();
  session_start();
  sessionMessage("Logged out", 1);
  redirectTo("./login.php");
}

/**
 * Adds a new user to the database, if the username is not already taken
 *
 * ENSURE INPUT IS SANITIZED BEFORE CALLING THIS FUNCTION
 *
 * @param string $username
 * @param string $password
 * @return void
 */
function register($username, $password) {
  // Check if user exists then tell user that username is taken
  if (verifyUser($username) === 1) {
    sessionMessage("Username already taken", 3);
    redirectTo("./register.php");
    return;
  }

  // Add user to database
  $dbConn = initDb(); // Connect to database
  $query = "INSERT INTO user (username, password) VALUES ('$username', '$password')";
  $result = mysqli_query($dbConn, $query);
  mysqli_close($dbConn);

  // If the user is added sucessfully then login, else stay in register
  if ($result) {
    // $_SESSION['info'] = "User added sucessfully";
    sessionMessage("User added sucessfully, please update your membership details", 1);
    login($username, $password);
    return;
  } else {
    // $_SESSION['authError'] = "Could not register user";
    sessionMessage("Could not register user", 3);
    redirectTo("./register.php");
    return;
  }
}

/**
 * Returns true if user details in session are correct
 *
 * @return boolean
 */
function isLoggedIn() {
  if (isset($_SESSION['account'])) {
  // if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    // $username = dbEscapeString($_SESSION['username']);
    // $password = dbEscapeString($_SESSION['password']);
    $username = dbEscapeString($_SESSION['account']['username']);
    $password = dbEscapeString($_SESSION['account']['password']);

    // If username and password match, return true
    if (verifyUser($username, $password) === 2) {
      return true;
    }
  }
  return false;
}

/**
 * Verify username or both username and password is in database
 *
 * 0: User does not exist or password is incorrect;
 *
 * 1: User exists;
 *
 * 2: User exists and password is correct
 *
 * @param string $username
 * @param string $password = null
 * @return 0 user does not exist or password is incorrect
 * @return 1 user exists
 * @return 2 user exists and password is correct
 */
function verifyUser($username, $password = null) {
  $dbConn = initDb(); // Connect to database

  // Check if user does not exist, return 0
  $query = "SELECT 1 FROM user WHERE username = '$username'";
  if (mysqli_num_rows(mysqli_query($dbConn, $query)) != 1) {
    mysqli_close($dbConn);
    return 0; // User does not exist
  }

  // If password is passed and does not match, return 0
  if ($password != null) {
    $query = "SELECT 1 FROM user WHERE username = '$username' AND password = '$password'";
    if (mysqli_num_rows(mysqli_query($dbConn, $query)) != 1) {
      mysqli_close($dbConn);
      return 0; // User exists but password is incorrect
    }
    mysqli_close($dbConn);
    return 2; // User exists and password is correct
  }

  mysqli_close($dbConn);
  return 1; // User exists
}

?>