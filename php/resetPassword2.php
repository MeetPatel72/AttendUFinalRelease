<?php
	session_start();
	require_once("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailerAutoload.php';
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

	//Get the data off web!
	$Email = $_GET["Email"];
	$type=$_SESSION["loginRole"];
	print "Web data ($Email) <br>";
	if(empty($Email)){
		$_SESSION["RegState"] = 8;
		$_SESSION["Message"] = "Please Enter the Email! ".
		header("location:../loginForm.html");
		exit();
	}
	$Acode = rand();

	// Connect to DB
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = -1;
		$_SESSION["Message"] = "Database connection failed: ".
		mysqli_error($con);
		header("location:../index.html");
		exit();
	}
	print "Database connected <br>";
	// Looks for the entered email in the table
	$sel_query = "SELECT * FROM user_x2 WHERE Email ='$Email' and type='$type'";
	$result = mysqli_query($con, $sel_query);

	$sql = "UPDATE user_x2 SET Acode='$Acode' WHERE Email = '$Email' and type='$type'";
	mysqli_query($con, $sql);

	// check for correctness
	if (mysqli_num_rows($result) <= 0) {
		$_SESSION["RegState"] = -2;
		$_SESSION["Message"] = "Incorrect Email.  Enter again".
		header("location:../index.html");
		exit();
	}
	print "Query worked!! <br>";
	// Registration success. Build authentication email

	// Build the PHPMailer object:


$mail = new PHPMailer;

//$mail->SMTPDebug = 2;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'attendu.temple';                 // SMTP username
$mail->Password = 'Temple123!';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to



$mail->setFrom('attendu.temple@gmail.com', 'AttendU');

$mail->addReplyTo('attendu.temple@gmail.com', 'Information');
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
 $msg = "Please click the <a href='http://cis-linux2.temple.edu/~tug43815/AttendU/Project/php/authenticate.php?Acode=$Acode&Email=$Email&type=$type'>link</a> to complete registration process.";


$mail->addAddress($Email,"$FirstName $LastName");
$mail->Subject = "Welcome to AttendU";
$mail->Body = $msg;


if(!$mail->send()) {
       $_SESSION["Message"] = "Mailer error: ".$mail->ErrorInfo;
		$_SESSION["RegState"] = -4;
		//print "Mail send failed: ".$mail->ErrorInfo;
		header("location:../index.html");
		exit();
} else {
	//print "Email sent ... <br>";
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "Email sent.";
		header("location:../loginForm.html");
        exit();
}
	/*$mail= new PHPMailer(true);
	try {
		$mail->SMTPDebug = 2; // Wants to see all errors
		$mail->IsSMTP();
		$mail->Host="smtp.gmail.com";
		$mail->SMTPAuth=true;
		$mail->Username="cis105223053238@gmail.com";
		$mail->Password = 'g+N3NmtkZWe]m8"M';
		$mail->SMTPSecure = "ssl";
		$mail->Port=465;
		$mail->SMTPKeepAlive = true;
		$mail->Mailer = "smtp";
		$mail->setFrom("Your email", "AttendU");
		$mail->addReplyTo("Your email","AttendU");
		$msg = "Please click the link to complete registration process:"
			."http://cis-linux2.school.edu/~username/yourfolder/Project/php/authenticate.php?Acode=$Acode&Email=$Email";
		$mail->addAddress($Email,"$FirstName $LastName");
		$mail->Subject = "Welcome to (my project)";
		$mail->Body = $msg;
		$mail->send();
		print "Email sent ... <br>";
		$_SESSION["RegState"] = 4;
		$_SESSION["Message"] = "Email sent.";
		header("location:../loginForm.php");
		exit();
	} catch (phpmailerException $e) {
		$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
		$_SESSION["RegState"] = -4;
		print "Mail send failed: ".$e->errorMessage;
		header("location:../index.php");
		exit();
	}*/
?>
