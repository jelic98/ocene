<?php
session_start();
require_once('connection.php');
require_once('functions.php');

$username = strip($_POST['username'], $connect);
$password = strip($_POST['password'], $connect);

$password_hash = hash_password($password);

$cmd = "SELECT * FROM `~korisnik` WHERE `username`='$username' AND `password`='$password_hash';";
$rows = mysqli_query($connect, $cmd);

$number_of_rows = mysqli_num_rows($rows);

if($number_of_rows == 1) {
	if($rows) {
		while($row = mysqli_fetch_array($rows)) {
			$_SESSION['username'] = $row['username'];
			$_SESSION['school'] = $row['school'];
			$_SESSION['grade'] = $row['grade'];
			$_SESSION['config'] = $row['config'];

			if($_SESSION['config'] == 1) {
				header("location: index.php");	
			}else {
				header("location: configure.html");
			}
		}
	}
}else {
	show_error("Pogresno korisnicko ime ili lozinka");
}

mysqli_close($connect);
?>