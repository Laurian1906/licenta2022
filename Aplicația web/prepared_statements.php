<?php
error_reporting(0);
// Prepare variables for database connection
$dbusername = "";
$dbpassword = "";
$server = "";

// Connect to database
$dbconnect = mysqli_connect($server, $dbusername, $dbpassword);
$dbselect = mysqli_select_db($dbconnect, $dbusername);

$begin_date = $_GET["begin_date"];
$end_date = $_GET["end_date"];

$stmt = $dbconnect->prepare("SELECT temp FROM test WHERE time BETWEEN ? AND ?"); 
$stmt->bind_param("ss", $begin_date, $end_date);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
$t_pre_stats = array();

while ($user = $result->fetch_assoc()){

  if (is_numeric($user["temp"]) && $user["temp"] <> -127 ){
    $t = $user["temp"];
  }
  
  $tempp = $t;
  array_push($t_pre_stats, $tempp);
  
  //$json = array("temp:" => $t);
  //echo json_encode($json);
} // fetch data 


  
$js_t_pre_stats = json_encode($t_pre_stats);
echo "<script>
var jsValues = ".$js_t_pre_stats." 
var fValues = new Array();
    for(var i=0;i<jsValues.length;i++){
      fValues.push(parseFloat(jsValues[i]));
    }
    stats1.series[0].setData(fValues)
       
</script>"; 


?>
