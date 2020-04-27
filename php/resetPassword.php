<?php
	session_start();
	$_SESSION["RegState"] = 8;
	header("location:../loginForm.html");
	exit();
?>
