<?php
session_start();
require_once('connection.php');

$login = 0;

if(!empty($_SESSION['id'])) {
	$login = 1; 
}
?>
<html>
	<head>
		<link rel="icon" href="icon-outline.ico" type="icon/ico">
		<title>Izmena</title>
		<link href="main.css" rel='stylesheet' type='text/css'/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	</head>
	<body>  
		<?php
		if($login == 1) {
			$predmeti = array("srpski","engleski","drstr","filozofija","istorija","geografija","biologija","matematika","fizika","informatika","hemija","fizicko","vladanje");
			$ocene = array();

			$id = $_SESSION['id'];

			$cmd = "SELECT * FROM `ucenik` WHERE `id`='$id'";
			$rows = mysqli_query($connect, $cmd) or die(mysqli_error($connect));

			$number_of_rows = mysqli_num_rows($rows);

			if($rows) {
				while($row = mysqli_fetch_array($rows)) {
					$username = $row['username'];
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
				}
			}

			mysqli_close($connect);

			for($i = 1; $i <= 13; $i++) {
				$string = $_SESSION[$predmeti[$i-1]];
				$temp = array();

				while(strlen($string) > 0) {
					array_push($temp, substr($string, 0, 1));
					$string = substr($string, 1);
				}

				array_push($ocene, $temp);
			} 

			echo '<h1>Izmena ocena</h1>';
			echo '<form action="save.php" method="get">';
			echo '<table>';
			echo '<tr id="headline">';
			echo '<td><b>PREDMET</b></td>';
			echo '<td><b>OCENE</b></td>';
			echo '</tr>';

			$index = 0;
			$s = 0;
			$b = 0;
			$prosek2 = 0;

			foreach($ocene as $ocena) {
				$index++;
				$brojac = 0;
				$suma = 0;
				$prosek = 0;
				$red = "";

				if($index % 2 != 0) {
					$red = "diff";
				}

				echo '<tr>';
				echo '<td class="prva '.$red.'">'.strtoupper($predmeti[$index-1]).'</td>';

				echo '<td class="druga '.$red.'">';
				echo '<input name="'.$predmeti[$index-1].'" type="text" value="';

				foreach($ocena as $p) {
					if($p <> 0) {
						echo $p." ";  
					} 

					$suma += $p; 
					$brojac++;
				}

				echo '">';
			}

			echo '</table>';
			echo '<a href="index.php"><button class="red"><i class="fa fa-arrow-left"></i> Nazad</button></a>';
			echo '<button type="submit" class="blue"><i class="fa fa-floppy-o"></i> Sacuvaj</button>';
			echo '</form>';
		}else {
			header("location: index.php");
		}
		?>
	</body>
</html>