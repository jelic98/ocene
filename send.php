<?php
session_start();
require_once('connection.php');

$id = $_SESSION['id'];

$cmd = "SELECT * FROM `ucenik` WHERE `id`='$id'";
$rows = mysqli_query($connect, $cmd) or die(mysqli_error($connect));

if($rows) {
	while($row = mysqli_fetch_array($rows)) {
		$username = $row['username'];
	}
}

$message = htmlspecialchars(strip_tags($_POST['message']));
$message = mysqli_real_escape_string($connect, $message);

if(!empty($message)) {
	$cmd = "INSERT INTO `poruke`(`username`, `poruka`) VALUES('$username', '$message')";
	mysqli_query($connect, $cmd) or die(mysqli_error($connect));
}

header("location: index.php");
mysqli_close($connect);
?>