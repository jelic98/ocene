<?php
session_start();
require_once('connection.php');

$id = $_SESSION['id'];

$predmeti = array("srp","eng","jez","fil","ist","geo","bio","mat","fiz","inf","hem","fzc","vla");

for($i = 1; $i <= 13;$i++) {
	$cmd = "UPDATE `ucenik` SET `".$predmeti[$i-1]."`='0' WHERE `id`='$id'";
	mysqli_query($connect, $cmd) or die(mysqli_error($connect)); 
}

header("location: index.php");
mysqli_close($connect);
?>