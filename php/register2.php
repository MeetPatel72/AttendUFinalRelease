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

	//Get the data off web
	$Email = $_GET["email"];
	$FirstName = $_GET["first_name"];
	$LastName = $_GET["last_name"];
	$type=$_SESSION["loginRole"];
	print "Web data ($Email) ($FirstName) ($LastName) <br>";
	// Connect to DB

	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con) {
		$_SESSION["RegState"] = -1;
		$_SESSION["Message"] = "Database connection failed: ".
			mysqli_error($con);
		header("location:../registerForm.html");
		exit();
	}
	print "Database connected <br>";

		$query1 = "Select * from user_x2 where Email='$Email'";
		$result1 = mysqli_query($con, $query1);
    //$row = mysqli_fetch_row($result);
    if(mysqli_num_rows($result1) > 0){
    	$_SESSION["Message"]="User already exist";

header("location:../registerForm.html");
		exit();
    }
	// Build in insert query
	$Acode = rand(); // get a new activation code
	$Rdatetime = date("Y-m-d h:i:s"); //this line has a problem

	//this is my USER insted on user_x2 Table name in database
	$query = "Insert into user_x2 (FirstName,LastName,Email,Acode, "
		."Rdatetime, Status ,type) values ('$FirstName','$LastName','$Email',"
		."'$Acode','$Rdatetime', 1,$type);";
	// execute the query
	//$insert_Admin_query = "INSERT into Admin (Admin_ID, AdminEmail) VALUES (23, '$Email');";
	//$query_2 = "Insert into Admin (Admin_ID,AdminEmail) values (23, '$Email');";
	//$yolo = mysqli_query($con, $query2); //ask the database to to execute the query above
	//$query1 = "Insert into Admin (ID,Admin_ID,AdminEmail)". "values (1,1,'$Email');";

	//next setp is to figure out how to figure out who is who at the regestration time.

	//check all the data input is emapty
	if(empty($FirstName) || empty($LastName) || empty($Email)){
		$_SESSION["RegState"] = -9;
		$_SESSION["Message"] = "Please Enter First Name, Last Name and Email: ".
		header("location:../registerForm.html");
		exit();
	}

	$result = mysqli_query($con, $query);
	// check for correctness
	if (!$result) {
		$_SESSION["RegState"] = -2;
		$_SESSION["Message"] = "Query failed: ".
			mysqli_error($con);
		header("location:../registerForm.html");
		exit();
	}
	print "Query worked!! <br>";
	// Registration success. Build authentication email
	// Build the PHPMailer object


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
//sftp://tug43815@cis-linux2.temple.edu/home/TU/tug43815/public_html/AttendU/Project/php/authenticate.php
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
		print "Mail send failed: ".$mail->ErrorInfo;
		header("location:../registerForm.html");
		exit();
} else {
	print "Email sent ... <br>";
		$_SESSION["RegState"] = -5;     //was 3
		$_SESSION["Message"] = "Email sent.";
		header("location:../loginForm.html"); //by instrctor resisterForm.php
		exit();
   
}
	/*$mail= new PHPMailer(true);
	try {
		echo !extension_loaded('openssl')?"Not Available":"Available";
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
		$mail->IsHTML(true);
		$mail->setFrom("cis105223053238@gmail.com", "AttendU"); //add your email to get the eamil and your name
		$mail->addReplyTo("cis105223053238@gmail.com","AttendU"); //same thing here
		$msg = "Please click the <a href='http://cis-linux2.school.edu/~username/yourfolder/Project/php/authenticate.php?Acode=$Acode&Email=$Email'>link</a> to complete registration process.";
		$mail->addAddress($Email,"$FirstName $LastName");
		$mail->Subject = "Welcome to AttendU";
		$mail->Body = $msg;
		$mail->send();

		print "Email sent ... <br>";
		$_SESSION["RegState"] = -5;     //was 3
		$_SESSION["Message"] = "Email sent.";
		header("location:../loginForm.php"); //by instrctor resisterForm.php
		exit();
	} catch (phpmailerException $e) {
		$_SESSION["Message"] = "Mailer error: ".$e->errorMessage();
		$_SESSION["RegState"] = -4;
		print "Mail send failed: ".$e->errorMessage;
		header("location:../registerForm.php");
		exit();
	}*/
?>
