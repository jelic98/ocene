<?php
require_once('connection.php');
require_once('functions.php');

$email = htmlspecialchars(strip_tags($_POST['email']));
$username = htmlspecialchars(strip_tags($_POST['username']));
$username = mysqli_real_escape_string($connect, $username);

$cmd = "SELECT * FROM `ucenik` WHERE `username`='$username'";
$rows = mysqli_query($connect, $cmd) or die(mysqli_error($connect));

$number_of_rows = mysqli_num_rows($rows);

if($number_of_rows == 0) {
	handleError("Korisnik ne postoji");
}else{
	$ocene = array();
	$predmeti = array("srpski","engleski","drstr","filozofija","istorija","geografija","biologija","matematika","fizika","informatika","hemija","fizicko","vladanje");
	$body = "";

	if($rows) {
		while($row = mysqli_fetch_array($rows)) {
			$ocene[0] = $row['srp'];
			$ocene[1] = $row['eng'];
			$ocene[2] = $row['jez'];
			$ocene[3] = $row['fil'];
			$ocene[4] = $row['ist'];
			$ocene[5] = $row['geo'];
			$ocene[6] = $row['bio'];
			$ocene[7] = $row['mat'];
			$ocene[8] = $row['fiz'];
			$ocene[9] = $row['inf'];
			$ocene[10] = $row['hem'];
			$ocene[11] = $row['fzc'];
			$ocene[12] = $row['vla'];
		}
	}

	for($i = 0; $i <= 12; $i++) {
		$string = $ocene[$i];
		$body .= $predmeti[$i];

		for($j = strlen($predmeti[$i]); $j < 15;$j++) {
			$body .= " ";
		}

		while(strlen($string) > 0) {
			$body .= " ".substr($string, 0, 1);
			$string = substr($string, 1);
		}

		$body .= "\n";
	}

	mail($email, "Ocena korisnika ".$username, $body, "From: ocene@ecloga.org") or die("Slanje nije uspelo");
	header("location: index.php");
	mysqli_close($connect);
}
?>