<?php
session_start();
require_once('connection.php');
require_once('functions.php');

$username = $_SESSION['username'];
$message = strip($_POST['message'], $connect);
$date = date('d.m.Y.');

if(!empty($message)) {
	$cmd = "INSERT INTO `~poruka`(`username`, `text`, `date`) VALUES('$username', '$message', '$date');";
	mysqli_query($connect, $cmd);
}

header("location: index.php");
mysqli_close($connect);
?>