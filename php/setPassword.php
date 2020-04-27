<?php
	session_start();
	require_once("config.php");
	// Get data off the web:
	$Email = $_SESSION["Email"];
	$type=$_SESSION["loginRole"];
	$Password = md5($_POST["Password"]);

	print "Web data ($Email) ($Password) <br>";
	// Connect to DB
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = -1;
		$_SESSION["Message"] = "Database connection failed: ".
			mysqli_error($con);
		header("location:../loginForm.html");
		exit();
	}
	print "Database connected <br>";
	// Build query to update user with the password
	$query = "Update User_X2 set Password='$Password' where Email='$Email' and type='$type';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = -6;
		$_SESSION["Message"] = "Password update failed: ".
			mysqli_error($con);
		header("location:../loginForm.html");
		exit();
	}
	// Password set successfully
	$_SESSION["RegState"] = 1;
	$_SESSION["Message"] = "Password set. Please login.";
	header("location:../loginForm.html");
	exit();
?>
