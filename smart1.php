<?php
echo phpinfo();
die;
session_start();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
    $mysql_hostname = "dentaldatabase.cfmwceiao6yh.us-east-1.rds.amazonaws.com";
    $mysql_user = "papi2";
    $mysql_password = "12345678";
    $mysql_database = "bravodent";
    
    $prefix = "";
    
    $bd = mysqli_connect($mysql_hostname, $mysql_user, $mysql_password,$mysql_database) or die("Could not connect database");

    if (!$bd) {
    die("Connection failed: " . mysqli_connect_error());
    $noof=0;
}




    mysqli_query($bd, "INSERT INTO weekly(mid,name) values('25525','raj')");
      
echo "Connect Successfully. Host info: " . mysqli_get_host_info($bd);
      
       
    ?>