<?php
    session_start();
    require_once "db.php";
    // require_once './functions.php';

    // Functions
    function getMessage() {
        if (isset($_SESSION['error'])) {
            consoleLog("ERROR:" . $_SESSION['error']);
            unset($_SESSION['error']);
        }

        if (isset($_SESSION['info'])) {
            consoleLog("INFO:" . $_SESSION['info']);
            unset($_SESSION['info']);
        }
    }

    // Handle login
    $GLOBALS['loggedIn'] = false;

    // Check if user login details are correct in DB
    // To set username and password, login.php must be used
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $query = "SELECT 1 FROM user WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($dbConn, $query);
        if (mysqli_num_rows($result) == 1) {
            $GLOBALS['loggedIn'] = true;
        }
        else {
            $GLOBALS['loggedIn'] = false;
        }
    } else {
        $GLOBALS['loggedIn'] = false;
    }

?>