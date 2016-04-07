<?php
session_start();
$_SESSION = array();
session_destroy();
$_SESSION['id'] = null;

header("location: index.php");
?>