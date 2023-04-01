<?php

error_reporting(0);
ignore_user_abort(true);
set_time_limit(0);

// Prepare variables for database connection
$dbusername = "";
$dbpassword = "";
$server = "";

// Connect to database
$dbconnect = mysqli_connect($server, $dbusername, $dbpassword);
$dbselect = mysqli_select_db($dbconnect, $dbusername);

$atemp = $_GET["altemp"];
$alert1 = "<p id=\"alertTemp\" class=\"_ALERT\">ATENTIE! Temperatura a depasit <span id=\"tempA\">".$atemp."</span>°C</p>";
// TEMP SELECTED FROM DATABASE
$sql2 = "SELECT temp FROM test ORDER BY id DESC LIMIT 1";
$result2 = mysqli_query($dbconnect, $sql2);

if (mysqli_num_rows($result2) > 0) {
  while($row = mysqli_fetch_assoc($result2)) {
    
    $temp = $row["temp"];

  }
}

if ($temp > $atemp){
  echo $alert1;
}


mysqli_close($dbconnect);



?>
