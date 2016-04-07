<?php
session_start();
require_once('connection.php');

$id = $_SESSION['id'];

$baza = array("srp","eng","jez","fil","ist","geo","bio","mat","fiz","inf","hem","fzc","vla");
$predmeti = array("srpski","engleski","drstr","filozofija","istorija","geografija","biologija","matematika","fizika","informatika","hemija","fizicko","vladanje");

for($i = 1; $i <= 13;$i++) {
	$temp = htmlspecialchars(strip_tags($_GET[$predmeti[$i-1]]));
	$temp = mysqli_real_escape_string($connect, $temp);

	$offset = 0;
	$found = 0;

	if(!empty($temp)) {
		for($j = 0; $j < strlen($temp); $j++) {
			if($found == 0) {
				if(substr($temp, $j, 1) == " ") {
					$found = 1;
					$temp = str_replace(" ", "", $temp);
				}   
			}else {
				break;
			}
		}

		while(strpos($temp, " ") > 0) {
			$temp = str_replace(" ", "", $temp);
		}

		if(ctype_digit($temp)) {
			for($j = 0; $j < strlen($temp); $j++) {
				if(intval(substr($temp, $j, 1)) > 5 || intval(substr($temp, $j, 1)) < 1) {
					$offset = 1;
					break;
				}
			}

			if($offset == 0) {
				$cmd = "UPDATE `ucenik` SET `".$baza[$i-1]."`='$temp' WHERE `id`='$id'";
				mysqli_query($connect, $cmd) or die(mysqli_error($connect));
			}
		}
	}else {
		$cmd = "UPDATE `ucenik` SET `".$baza[$i-1]."`='0' WHERE `id`='$id'";
		mysqli_query($connect, $cmd) or die(mysqli_error($connect));
	}
}

header("location: index.php");
mysqli_close($connect);
?>