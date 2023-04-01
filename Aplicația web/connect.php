<?php

$dbusername = "3982527_monreg2";
$dbpassword = "123456789abcd";
$server = "fdb34.awardspace.net";

// Conectare

if ($dbconnect = mysqli_connect($server, $dbusername, $dbpassword)){
    mysqli_select_db($dbconnect, "3982527_monreg");
    echo 'Connected to database!';
}else{
    echo 'Connection failed.';
}


?>