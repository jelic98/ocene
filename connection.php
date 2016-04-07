<?php
$connect = mysqli_connect("127.0.0.1", "root", "root") or die(mysqli_error($connect)); 
mysqli_select_db($connect, "jelic98_database") or die(mysqli_error($connect));   
?>