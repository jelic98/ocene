<?php
function hashPassword($input) {
	return hash("SHA512", $input, false);
}

function handleError($msg) {
	$location = "error.php?m=".$msg;
	header("location: ".$location);
}
?>