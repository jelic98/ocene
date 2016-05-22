<?php
session_start();
require_once('connection.php');

$login = 0;

if(!empty($_SESSION['username'])) {
	$login = 1; 
}
?>
<html>
	<head>
		<link rel="icon" href="icon-outline.ico" type="icon/ico">
		<title>Izmena</title>
		<link href="main.css" rel='stylesheet' type='text/css'/>
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	</head>
	<body>  
		<?php
		if($login == 1) {
			$predmeti = array();
			$ocene = array();

			$username = $_SESSION['username'];

			$cmd = "SHOW COLUMNS FROM `".$username."`;";
			$result = mysqli_query($connect, $cmd);

			while($row = mysqli_fetch_array($result)){
				$predmeti[] = $row['Field'];
			}

			mysqli_close($connect);

			for($i = 1; $i <= count($predmeti); $i++) {
				$string = $_SESSION[$predmeti[$i - 1]];
				$temp = array();

				while(strlen($string) > 0) {
					array_push($temp, substr($string, 0, 1));
					$string = substr($string, 1);
				}

				array_push($ocene, $temp);
			} 

			echo '<h1>Izmena ocena</h1>';
			echo '<form class="w3-container" action="save.php" method="get">';
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
				echo '<input class="w3-input" name="'.$predmeti[$index - 1].'" type="text" value="';

				foreach($ocena as $p) {
					if($p <> 0) {
						echo $p.' ';  
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