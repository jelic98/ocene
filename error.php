<?php
$msg = $_GET['m'];
?>
<html>
	<head>
		<title>Greska</title>
		<link rel="icon" href="icon-outline.ico" type="icon/ico">
		<link href="main.css" rel='stylesheet' type='text/css'/>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	</head>
	<body>
		<div class="center">
			<h2><?php echo $msg; ?></h2>
			<a href="index.php"><button class="red"><i class="fa fa-arrow-left"></i> Pocetak</button></a>
		</div>
	</body>
</html>