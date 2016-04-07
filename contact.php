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
		<title>Kontakt</title>
		<link href="main.css" rel='stylesheet' type='text/css'/>
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	</head>
	<body>  
		<?php
		if($login == 1) {
			echo '<div class="form">';
			echo '<h1>Posalji pozdrav!</h1>';
			echo '<form class="w3-container" action="send.php" method="post">';
			echo '<p><textarea name="message" id="msg" cols="50" rows="10" class="w3-input" type="text" placeholder="Poruka" autofocus required></textarea></p>';
			echo '<button class="blue" type="submit"><i class="fa fa-envelope"></i> Posalji</button>';
			echo '</form>';
			echo '</div>';
		}else {
			header("location: index.php");
		}
		?>
	</body>
</html>