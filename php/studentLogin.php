<?php
	session_start();
	$_SESSION["loginRole"]=3;
	header("location:../loginForm.html");
	exit(); 
?>