<?php
error_reporting(0);
// Prepare variables for database connection
$dbusername = "";
$dbpassword = "";
$server = "";

// Connect to database
$dbconnect = mysqli_connect($server, $dbusername, $dbpassword);
$dbselect = mysqli_select_db($dbconnect, $dbusername);

// TEMP SELECTED FROM DATABASE
$YearNow = date('Y');
$MonthNow = date('m');
$DayNow = date('d');
$sql = "SELECT temp FROM test WHERE time LIKE '".$YearNow."-".$MonthNow."-".$DayNow."%'";
$result = mysqli_query($dbconnect, $sql);
$valMar = array();

echo "<script> var mar = []; </script>"; 

if (mysqli_num_rows($result) > 0) {
   
  while($row = mysqli_fetch_assoc($result)) {

    if (is_numeric($row["temp"]) && $row["temp"] <> -127 ){
      $mar = $row["temp"];
    }

    $tmar = $mar;      
    array_push($valMar, $tmar);

  }

  $jsTempMar = json_encode($valMar);
  
  echo "<script type=\"text/javascript\"> 
  
  
  var obj = ".$jsTempMar.";  
  var numberArray = [];
  lengthObj = obj.length;
  for (var i = 0; i < lengthObj; i++){
    numberArray.push(parseFloat(obj[i]));
    mar.push(numberArray[i]);
  } 
  </script>";
    
}else{
  echo "Nu s-au gasit valorile";
}


mysqli_close($dbconnect);

?>
