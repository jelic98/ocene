<?php
session_start();
require_once('connection.php');

$username = $_SESSION['username'];

$predmeti = array();

$cmd = "SHOW COLUMNS FROM `".$username."`;";
$result = mysqli_query($connect, $cmd);

while($row = mysqli_fetch_array($result)){
	$predmeti[] = $row['Field'];
}

for($i = 0; $i < count($predmeti); $i++) {
	$cmd = "UPDATE `".$username."` SET `".$predmeti[$i]."`='0';";
	mysqli_query($connect, $cmd); 
}

header("location: index.php");
mysqli_close($connect);
?>