<?php
	session_start();
	require_once("config.php");

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	require '../PHPMailer-master/src/Exception.php';
	require '../PHPMailer-master/src/PHPMailer.php';
	require '../PHPMailer-master/src/SMTP.php';

	//Get the data off web
	$Email = $_GET["email"];
	$FirstName = $_GET["first_name"];
	$LastName = $_GET["last_name"];
	print "Web data ($Email) ($FirstName) ($LastName) <br>";
	// Connect to DB

	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = -1;
		$_SESSION["Message"] = "Database connection failed: ".
			mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Database connected <br>";
	// Build in insert query
	$Acode = rand(); // get a new activation code
	$Rdatetime = date("Y-m-d h:i:s"); //this line has a problem
	//this is my USER insted on User_X2 Table name in database
	//$query = "Insert into Admin (ID,Admin_ID,AdminEmail,Password ) values (1,1,'tug2323', 'jsudw');";
	// execute the query
	//$insert_Admin_query = "INSERT into Admin (Admin_ID, AdminEmail) VALUES (23, '$Email');";
	//$query_2 = "Insert into Admin (Admin_ID,AdminEmail) values (23, '$Email');";
	//$query = mysqli_query($con, $query2); //ask the database to to execute the query above
	$query = "Insert into Admin(FirstName, LastName, Email)"."values ('$FirstName','$LastName','$Email');";
	$query1 = "Insert into User_X2 (FirstName,LastName,Email,Acode, "
		."Rdatetime, Status) values ('$FirstName','$LastName','$Email',"
		."'$Acode','$Rdatetime', 1);";


	$result = mysqli_query($con, $query);
	$result1 = mysqli_query($con, $query1);
	// check for correctness
	if (!$result) {
		$_SESSION["RegState"] = -2;
		$_SESSION["Message"] = "Query failed: ".
			mysqli_error($con);
		header("location:../index.php");
		exit();
	}
	print "Query worked!! <br>";
	// Registration success. Build authentication email
	// Build the PHPMailer object:
	$mail= new PHPMailer(true);
	try {
		$mail->SMTPDebug = 2; // Wants to see all errors
		$mail->IsSMTP();
		$mail->Host="smtp.gmail.com";
		$mail->SMTPAuth=true;
		$mail->Username="isratjannat315@gmail.com";
		$mail->Password = '315Mahims513';
		$mail->SMTPSecure = "ssl";
		$mail->Port=465;
		$mail->SMTPKeepAlive = true;
		$mail->Mailer = "smtp";
		$mail->setFrom("tuf64734@temple.edu", "AttendU"); //add your email to get the eamil and your name
		$mail->addReplyTo("tuf64734@temple.edu","AttendU"); //same thing here
		$msg = "Please click the link to complete registration process:"
			."http://cis-linux2.temple.edu/~tuf64734/4398/Project/php/authenticate.php?Acode=$Acode&Email=$Email";
		$mail->addAddress($Email,"$FirstName $LastName");
		$mail->Subject = "Welcome to AttendU";
		$mail->Body = $msg;
		$mail->send();
		print "Email sent ... <br>";
		$_SESSION["RegState"] = 3;
		$_SESSION["Message"] = "Email sent.";
		header("location:../ADlogin.php");
		exit();
	} catch (phpmailerException $e) {
		$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
		$_SESSION["RegState"] = -4;
		print "Mail send failed: ".$e->errorMessage;
		header("location:../index.php");
		exit();
	}
?>
