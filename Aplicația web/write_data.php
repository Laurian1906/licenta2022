<?php
error_reporting(0);
// Prepare variables for database connection
$dbusername = "3982527_monreg2";
$dbpassword = "123456789abcd";
$server = "fdb34.awardspace.net";

// Connect to database
$dbconnect = mysqli_connect($server, $dbusername, $dbpassword);
$dbselect = mysqli_select_db($dbconnect, $dbusername);

$headers = getallheaders();
if(array_key_exists("X-Auth-Token", $headers) && $headers["X-Auth-Token"] == "23q4fg98herw8vuhq8rvjhnbq3jnrgfq03u4hrnvjuiqdenv8721812e91283e1092diqjcnvjaewnvoiqa"){

// TEMP INSERTED IN DATABASE
$temps = $_GET["value"];
$humi = $_GET["humi"];

if (!is_null($temps)){
   $sqlt = "INSERT INTO test (temp) VALUES ('".$temps."')" ;
   $result = mysqli_query($dbconnect, $sqlt);
}

if (!is_null($humi)){
   $sqlu = "INSERT INTO umiditate (humi) VALUES ('".$humi."')" ;
   $result = mysqli_query($dbconnect, $sqlu);
}

}

// TEMP SELECTED FROM DATABASE
$sql2 = "SELECT temp FROM test ORDER BY id DESC LIMIT 1";
$result2 = mysqli_query($dbconnect, $sql2);

if (mysqli_num_rows($result2) > 0) {
  while($row = mysqli_fetch_assoc($result2)) {
    
    $temp = $row["temp"];

  }
}

// HUMI SELECTED FROM DATABASE
$sql3 = "SELECT humi FROM umiditate ORDER BY id DESC LIMIT 1";
$result3 = mysqli_query($dbconnect, $sql3);

if (mysqli_num_rows($result3) > 0) {
  while($row = mysqli_fetch_assoc($result3)) {
    
    $humi = $row["humi"];
  }
}

echo json_encode( 

  array(
   "temp" => $temp,
   "humi" => $humi 
  )
  
);



mysqli_close($dbconnect);

?>
