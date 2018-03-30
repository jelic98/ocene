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
		<title>Cloud Ocene</title>
		<link href="main.css" rel='stylesheet' type='text/css'/>
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<script>
			$(function() {
				$("#h1").hide().fadeIn(1000);  
				$(".buttons").hide().fadeIn(2500);  
				$("#p").hide().fadeIn(5000);
			}); 
		</script>
	</head>
	<body>  
		<?php
		if($login == 1) {
			$username = $_SESSION['username'];
			$config = $_SESSION['config'];

			if($config == 0) {
				header("location: configure.html");
			}

			$predmeti = array();
			$ocene = array();

			$cmd = "SHOW COLUMNS FROM `".$username."`;";
			$result = mysqli_query($connect, $cmd);

			while($row = mysqli_fetch_array($result)){
				$predmeti[] = $row['Field'];
			}

			$cmd = "SELECT * FROM `".$username."`;";
			$result = mysqli_query($connect, $cmd);
			$rows = mysqli_fetch_row($result);

			for($i = 0; $i < count($predmeti); $i++) {
				$_SESSION[$predmeti[$i]] = $rows[$i];
			}

			$prosek_kraj = 0;
			$suma_kraj = 0;
			$predmeti_kraj = 0;
			$broj_jedinica = 0;

			for($i = 1; $i <= count($predmeti); $i++) {
				$string = $_SESSION[$predmeti[$i-1]];
				$temp = array();

				while(strlen($string) > 0) {
					array_push($temp, substr($string, 0, 1));
					$string = substr($string, 1);
				}

				array_push($ocene, $temp);
			} 

			echo '<h1>Ocene korisnika '.$username.'</h1>';
			echo '<table>';
			echo '<tr id="headline">';
			echo '<td><b>PREDMET</b></td>';
			echo '<td><b>OCENE</b></td>';
			echo '<td><b>PROSEK</b></td>';
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

				foreach($ocena as $p) {
					if($p <> 0) {
						echo $p." ";  
					} 

					$suma += $p; 
					$brojac++;
				}

				echo '</td>';

				if($brojac > 0 ) {
					$prosek = $suma / $brojac;
				}

				if(round($prosek) == 1) {
					$broj_jedinica++;
				}

				echo '<td class="treca '.$red.'">'.round($prosek).'</td>';

				echo '</tr>';

				if($suma > 0) {
					$s += $suma;
					$prosek2 += round($prosek);
					$b++;
				}
			}

			echo '<tr id="ukupno">';
			echo '<td>UKUPNO</td>';
			echo '<td>'.$prosek2.'</td>';

			$prosek3 = 0;

			if($b > 0) {
				$prosek3 = $prosek2 / $b; 
			}

			if($broj_jedinica == 0) {
				echo '<td><b>'.round($prosek3, 2).'<b></td>';
			}else {
				echo '<td><b>NEDOVOLJAN<b></td>';
			}

			echo '</tr>';

			$prosek_kraj = round($prosek3);
			$predmeti_kraj = $b;
			$suma_kraj = $prosek2;

			if($broj_jedinica == 0) {
				if($predmeti_kraj > 0) {
					$max = $predmeti_kraj * 5;
					$checkpoint_found = false;
					$granice = array();
					$popraviti = 0;
					$index = 1;

					for($i = $predmeti_kraj; $i <= $max; $i++) {
						if(!$checkpoint_found) {
							if(round($i / $predmeti_kraj) > $index) {
								$checkpoint_found = true;
							}
						}

						if($checkpoint_found) {
							$granice[$index] = $i; 
							$index++;
							$checkpoint_found = false;   
						}
					}

					$granice[$index] = $max;

					foreach($granice as $granica) {
						if($suma_kraj < $granica) {
							$popraviti = $granica - $suma_kraj;
							$padez = "";

							if($popraviti >= 5) {
								$padez = "ocena";
							}else {
								if($popraviti == 1) {
									$padez = "ocenu";
								}else {
									$padez = "ocene";   
								}
							}

							echo '<tr><td class="saveti">Za prosek '.round($granica / $predmeti_kraj, 2).' popraviti '.$popraviti.' '.$padez.'</td></tr>'; 
						}
					}    
				}	
			}else {
				if($broj_jedinica >= 5) {
					$padez = "ocena";
				}else {
					if($broj_jedinica == 1) {
						$padez = "ocenu";
					}else {
						$padez = "ocene";   
					}
				}

				echo '<tr><td class="saveti">Ako hoces na more popravi '.$broj_jedinica.' '.$padez.'</td></tr>'; 
			}

			if(5 * count($predmeti) == $prosek2) {
				echo '<tr><td class="saveti">Svaka cast!</td></tr>'; 
			}

			echo '</table>';

			echo '<a href="update.php"><button class="blue"><i class="fa fa-pencil"></i> Izmeni</button></a>';
			echo '<a href="send.html"><button class="dark"><i class="fa fa-envelope"></i> Posalji</button></a>';
			echo '<a href="reset.php"><button class="green"><i class="fa fa-refresh"></i> Resetuj</button></a>';
			echo '<a href="contact.php"><button class="dark"><i class="fa fa-envelope"></i> Kontakt</button></a>';
			echo '<a href="about.html"><button class="orange"><i class="fa fa-info"></i> O sajtu</button></a>';
			echo '<a href="logout.php"><button class="red"><i class="fa fa-sign-out"></i> Odjavi se</button></a>';
		}else {
			echo '<div class="center">';
			echo '<h1 id="h1">Cloud Ocene</h1>';
			echo '<a class="buttons" href="login.html"><button class="blue"><i class="fa fa-sign-in"></i> Prijava</button></a>';
			echo '<a class="buttons" href="register.html"><button class="green"><i class="fa fa-user"></i> Registracija</button></a>';
			echo '<p id="p">Popravi prosek!</p>';
			echo '</div>';
			echo '<div class="footer">';
			echo '<a href="/"><img src="power.png"/></a>';
			echo '</div>';
		}
		?>
	</body>
</html>
