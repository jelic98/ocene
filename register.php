<?php
session_start();
require_once('connection.php');
require_once('functions.php');

$username = htmlspecialchars(strip_tags($_POST['username']));
$username = mysqli_real_escape_string($connect, $username);
$password = htmlspecialchars(strip_tags($_POST['password']));
$password = mysqli_real_escape_string($connect, $password);
$repeat = htmlspecialchars(strip_tags($_POST['repeat']));
$repeat = mysqli_real_escape_string($connect, $repeat);

$cmd = "SELECT * FROM `ucenik` WHERE `username`='$username'";
$rows = mysqli_query($connect, $cmd) or die(mysqli_error($connect));

$number_of_rows = mysqli_num_rows($rows);

if($number_of_rows > 0) {
	handleError("Korisnik sa unetim imenom vec postoji");
}else {
	if($password != $repeat) {
		handleError("Lozinke se ne poklapaju");
	}else {
		$password_hash = hashPassword($password);

		$cmd = "INSERT INTO `ucenik`(`username`, `password`) VALUES('$username', '$password_hash')";
		mysqli_query($connect, $cmd) or die(mysqli_error($connect));

		header("location: login.html");
	}
}

mysqli_close($connect);
?>