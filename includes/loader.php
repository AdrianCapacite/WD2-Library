<?php
/**
 * Library Website Database
 * Author: Adrian Thomas Capacite C21348423
 *
 * Gathers all the necessary files and checks if user is logged in
 */
// Includes all the necessary files
session_start();

// import all required files
require_once './includes/functions.php';
require_once './includes/auth.php';
require_once './includes/db.php';
require_once './includes/db-queries.php';

// Check database connection
checkDatabaseConnection();

?>