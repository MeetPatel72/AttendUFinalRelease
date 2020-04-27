<?php
	session_start();
	$_SESSION["loginRole"]= 1;
	header("location:../loginForm.html");
	exit(); 
?>