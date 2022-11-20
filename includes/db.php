<!-- DB Connection -->
<?php
    // Associative array of DB connection info
    $dbCred = array(
        "hostname" => "localhost",
        "username" => "root",
        "password" => "",
        "database" => "library"
    );

    /**
     * Connect to the database using the credentials in $dbCred
     * Peforms sql query and returns the result
     * @param query
     * @return mysqli_result
     */
    function sql_query($query) {
        // Connect to DB
        $dbConn = mysqli_connect($dbCred["hostname"], $dbCred["username"], $dbCred["password"], $dbCred["database"]);

        // Run query
        $result = mysqli_query($dbConn, $query);

        // Close connection
        mysqli_close($dbConn);

        // Return result
        return $result;
    }

?>