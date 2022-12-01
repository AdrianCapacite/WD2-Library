<!-- DB Connection -->
<?php
    require_once 'functions.php';
    // Associative array of DB connection info
    $dbCred = array(
        "hostname" => "localhost",
        "username" => "root",
        "password" => "",
        "database" => "library"
    );
    $dbConn = mysqli_connect($dbCred["hostname"], $dbCred["username"], $dbCred["password"], $dbCred["database"]) or die("Error: Unable to connect to MySQL database.");
    consoleLog("Sucessfully connected to MySQL database");
?>