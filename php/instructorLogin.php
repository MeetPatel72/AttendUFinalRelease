<?php
	session_start();
	$_SESSION["loginRole"]= 2;
	header("location:../loginForm.html");
	exit(); 
?>