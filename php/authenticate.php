<?php
	session_start();
	require_once("config.php");
	// Get data off the web:
	$Email = $_GET["Email"];
	$Acode = $_GET["Acode"];
	$type = $_GET["type"];
	$_SESSION["loginRole"]=$type;
	//print "Web data ($Email) ($Acode) <br>";
	// Connect to DB
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = -1;
		$_SESSION["Message"] = "Database connection failed: ".
			mysqli_error($con);
		header("location:../loginForm.html"); // where should it go to report errors?
		exit();
	}
	print "Database connected <br>";
	// Build query to check if Email and Acode match?
	$query = "Select * from User_X2 where Email='$Email' and Acode='$Acode' and type='$type';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = -2;
		$_SESSION["Message"] = "Select Query failed: ".
			mysqli_error($con);

		header("location:../loginForm.html");
		exit();
	}
	// check if only one row matched
	if (mysqli_num_rows($result) != 1) {
		$_SESSION["RegState"] = -4;
		$_SESSION["Message"] = "Either email or activation code did not match. Please register again.";
		header("location:../loginForm.html");
		exit();
	}
	// Authentication succeeded
	$Acode = rand(); 	// Replacing the old Acode
	$Adatetime = date("Y-m-d h:i:s");
	$query = "Update User_X2 set Acode='$Acode', Adatetime='$Adatetime' where Email='$Email' and type='$type';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = -5;
		$_SESSION["Message"] = "Acode update failed: ".
			mysqli_error($con);
		header("location:../loginForm.html");
		exit();
	}
	// Save Email
	$_SESSION["Email"] = $Email;
	$_SESSION["RegState"] = 7; // To trigger password form
	header("location:../loginForm.html");
	exit();
?>
