<?php
function hash_password($input) {
	//todo change hash algorithm
	return hash("SHA512", $input, false);
}

function show_error($msg) {
	$location = "error.php?m=".$msg;
	header("location: ".$location);
}

function strip($var, $connect) {
	return mysqli_real_escape_string($connect, htmlspecialchars(strip_tags($var)));
}

?>