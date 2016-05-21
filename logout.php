<?php
session_start();
$_SESSION = array();
session_destroy();
$_SESSION['username'] = null;

header("location: index.php");
?>