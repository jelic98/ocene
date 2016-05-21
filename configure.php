<?php
session_start();
require_once('connection.php');
require_once('functions.php');

if($_SESSION['config'] == 0) {
	$username = $_SESSION['username'];
	$total = $_GET['total'];

	$cmd = "CREATE TABLE `".$username."`(";
	$cmd_insert = "INSERT INTO `".$username."` (";

	for($i = 1; $i <= $total; $i++) {
		$predmet = strip($_POST[$i], $connect);

		if(!empty($predmet) && strpos($predmet, $cmd) == 0) {
			$cmd .= "`".$predmet."` varchar(255)";
			$cmd_insert .= "`".$predmet."`";

			if($i < $total) {
				$cmd .= ", ";
				$cmd_insert .= ", ";
			}
		}
	}

	$cmd .= ");";
	mysqli_query($connect, $cmd);

	$cmd_insert .= ") VALUES (";

	for($i = 1; $i <= $total; $i++) {
		$cmd_insert .= "0";

		if($i < $total) {
			$cmd_insert .= ", ";
		}
	}

	$cmd_insert .= ");";
	mysqli_query($connect, $cmd_insert);

	$cmd = "UPDATE `~korisnik` SET `config`='1' WHERE `username`='$username';";
	mysqli_query($connect, $cmd);

	$_SESSION['config'] = 1;
	mysqli_close($connect);
}

header("location: index.php");
?>