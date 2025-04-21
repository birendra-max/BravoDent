<?php
// echo phpinfo();
// die;
session_start();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "bravodent_database";
    $prefix = "";
    
    $bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password,$mysql_database) or die("Could not connect database");
    if (!$bd) {
    die("Connection failed: " . mysqli_connect_error());
    $noof=0;
    // Turn off all error reporting
error_reporting(0);

// Display all errors
error_reporting(E_ALL);

// Display all errors except notices
error_reporting(E_ALL & ~E_NOTICE);
}


   // mysqli_query($bd, "SET SESSION sql_mode = 'TRADITIONAL'");

    
    ?>