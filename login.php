<?php
session_start();
require_once('connection.php');
require_once('functions.php');

$username = htmlspecialchars(strip_tags($_POST['username']));
$username = mysqli_real_escape_string($connect, $username);
$password = htmlspecialchars(strip_tags($_POST['password']));
$password = mysqli_real_escape_string($connect, $password);
$password_hash = hashPassword($password);

$cmd = "SELECT * FROM `ucenik` WHERE `username`='$username' AND `password`='$password_hash'";
$rows = mysqli_query($connect, $cmd) or die(mysqli_error($connect));

$number_of_rows = mysqli_num_rows($rows);

if($number_of_rows == 1) {
	if($rows) {
		while($row = mysqli_fetch_array($rows)) {
			$_SESSION['id'] = $row['id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['srpski'] = $row['srp'];
			$_SESSION['engleski'] = $row['eng'];
			$_SESSION['drstr'] = $row['jez'];
			$_SESSION['filozofija'] = $row['fil'];
			$_SESSION['istorija'] = $row['ist'];
			$_SESSION['geografija'] = $row['geo'];
			$_SESSION['biologija'] = $row['bio'];
			$_SESSION['matematika'] = $row['mat'];
			$_SESSION['fizika'] = $row['fiz'];
			$_SESSION['informatika'] = $row['inf'];
			$_SESSION['hemija'] = $row['hem'];
			$_SESSION['fizicko'] = $row['fzc'];
			$_SESSION['vladanje'] = $row['vla'];

			header("location: index.php");
		}
	}
}else {
	header('location: login.html');
}

mysqli_close($connect);
?>