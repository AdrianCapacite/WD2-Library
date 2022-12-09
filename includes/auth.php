<?php
/**
 * Library Website Database
 * Author: Adrian Thomas Capacite C21348423
 *
 * ======== AUTHENTICATION ========
 *
 */

/**
 * Query database if user and password are correct
 * If correct then add user to session and redirect to index.php
 *
 * ENSURE INPUT IS SANITIZED BEFORE CALLING THIS FUNCTION
 *
 * @param string $username
 * @param string $password
 * @param string $redirect (optional) Redirect to this page after login
 * @return void
 */
function login($username, $password, $redirect = null):void {
	// Check if username and password is correct
	// If correct then add user to session and redirect to index.php
	// else redirect to login.php
	if (verifyUser($username, $password) === 2) {
		$_SESSION['account'] = array('username' => $username, 'password' => $password);
		if ($redirect) {
			redirectTo($redirect);
		}
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
function logout():void {
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
function register($username, $password):void {
	// Check if user exists then tell user that username is taken
	if (verifyUser($username) === 1) {
		sessionMessage("Username already taken", 3);
		redirectTo("./register.php");
		return;
	}

	// Check if password is 6
	if (strlen($password) != 6) {
		sessionMessage("Password must be 6 characters", 3);
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
		sessionMessage("User registered sucessfully, please update your membership details", 1);
		login($username, $password, "./membership.php");
		return;
	} else {
		// $_SESSION['authError'] = "Could not register user";
		sessionMessage("Could not register user", 3);
		redirectTo("./register.php");
		return;
	}
}

/**
 * Verifies if user details in session is correct
 *
 * @return boolean
 */
function isLoggedIn():bool {
	if (isset($_SESSION['account'])) {
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
 * @return int
 */
function verifyUser($username, $password = null):int {
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