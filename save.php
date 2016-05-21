<?php
session_start();
require_once('connection.php');

$username = $_SESSION['username'];

$predmeti = array();

$cmd = "SHOW COLUMNS FROM `".$username."`;";
$result = mysqli_query($connect, $cmd);

while($row = mysqli_fetch_array($result)){
	$predmeti[] = $row['Field'];
}

for($i = 1; $i <= count($predmeti); $i++) {
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
				$cmd = "UPDATE `".$username."` SET `".$predmeti[$i-1]."`='$temp';";
				mysqli_query($connect, $cmd);
			}
		}
	}else {
		$cmd = "UPDATE `".$username."` SET `".$predmeti[$i-1]."`='0';";
		mysqli_query($connect, $cmd);
	}
}

header("location: index.php");
mysqli_close($connect);
?>