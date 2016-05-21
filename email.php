<?php
require_once('connection.php');
require_once('functions.php');

$email = strip($_POST['email'], $connect);
$username = strip($_POST['username'], $connect);

$predmeti = array();

$cmd = "SHOW COLUMNS FROM `".$username."`;";
$result = mysqli_query($connect, $cmd);

while($row = mysqli_fetch_array($result)){
	$predmeti[] = $row['Field'];
}

$cmd = "SELECT * FROM `".$username."`;";
$rows = mysqli_query($connect, $cmd);

$number_of_rows = mysqli_num_rows($rows);

if($number_of_rows == 0) {
	show_error("Korisnik ne postoji");
}else{
	$ocene = array();
	$body = "";

	$cmd = "SELECT * FROM `".$username."`;";
	$result = mysqli_query($connect, $cmd);
	$rows = mysqli_fetch_row($result);

	for($i = 0; $i < count($predmeti); $i++) {
		$ocene[$i] = $rows[$i];
	}

	for($i = 0; $i < count($predmeti); $i++) {
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

	mail($email, "Ocene korisnika ".$username, $body, "From: ocene@ecloga.org") or die("Slanje nije uspelo");
	header("location: index.php");
	mysqli_close($connect);
}
?>