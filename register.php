<?php
session_start();
require_once('connection.php');
require_once('functions.php');

$username = strip($_POST['username'], $connect);
$password = strip($_POST['password'], $connect);
$repeat = strip($_POST['repeat'], $connect);
$school = strip($_POST['school'], $connect);
$grade = strip($_POST['grade'], $connect);

$date = date('d.m.Y.');

$cmd = "SELECT * FROM `~korisnik` WHERE `username`='$username'";
$rows = mysqli_query($connect, $cmd);

$number_of_rows = mysqli_num_rows($rows);

if($number_of_rows > 0) {
	show_error("Korisnik sa unetim korisnickim imenom vec postoji");
}else {
	if($password != $repeat) {
		show_error("Lozinke se ne poklapaju");
	}else {
		$password_hash = hash_password($password);

		$cmd = "INSERT INTO `~korisnik`(`username`, `password`, `school`, `grade`, `date`) VALUES('$username', '$password_hash', '$school', '$grade', '$date')";
		mysqli_query($connect, $cmd);

		$_SESSION['username'] = $username;
		$_SESSION['school'] = $school;
		$_SESSION['grade'] = $grade;
		$_SESSION['config'] = 0;

		header("location: configure.html");
	}
}

mysqli_close($connect);
?>