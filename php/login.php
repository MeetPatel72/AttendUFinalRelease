<?php
	session_start();
	require_once("config.php");
	// Get data off the web!
	$Email = $_POST["email"];
$pass=$_POST["password"];
	$Password = md5($_POST["password"]);
	$rememberMe = $_POST["rememberMe"]; // You have to figure how to handle cookies
	$type=$_SESSION["loginRole"];
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
	$query = "Select * from user_x2 where Password='$Password' and Email='$Email' and type='$type';";
	$result = mysqli_query($con, $query);
	if (!$result) {
		$_SESSION["RegState"] = -7;
		$_SESSION["Message"] = "Login query failed: ".
			mysqli_error($con);
		header("location:../loginForm.html");
		exit();
	}
	// check if only one row matched
	if (mysqli_num_rows($result) != 1) {
		$_SESSION["RegState"] = -8;
		$_SESSION["Message"] = "Either email or password did not match. Please try again.";
		header("location:../loginForm.html");
		exit();
	}

$row=mysqli_fetch_array($result);

	$_SESSION['loggedname']=$row['FirstName']." ".$row['LastName'] ;
	$_SESSION["RegState"] = 4; // Login success???
$_SESSION["logged_email"]=$Email;

if($rememberMe=='1' || $rememberMe=='on')//set cookie for remember me
                    {
                    	$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
                    $hour = time() + 3600 * 24 * 30;
                    setcookie('username', $Email, $hour, "/", false);
                         setcookie('pass', $pass, $hour, "/", false);
                    }

	// if $_SESSION["loginRole"] == "admin" ...
	if($_SESSION["loginRole"]==1){header("location:../ADtable.php");}
		if($_SESSION["loginRole"]==2){header("location:../ProfDASH.html");}
			if($_SESSION["loginRole"]==3){header("location:../StudentDASH.html");}
	
	exit();
?>
