<?php
 session_start();
    require_once("config.php");
    require 'PHPMailerAutoload.php';

     $con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
    if (!$con) {

        $_SESSION["Message"] = "Database connection failed: ".
            mysqli_error($con);
        header("location: index.html");
        exit();
    }



if(isset($_POST["invite_all"]))
{

$course=$_SESSION['course'];
$sec=$_SESSION['section'];

 $query = "Select email from course_student where course='$course' and section='$sec'";
    $result = mysqli_query($con, $query);

     if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
     header("location:../SentInviteToAllStudents.html");
    exit();
}

 while ($row = mysqli_fetch_array($result)) {
  $email=$row['email'];

 $query1 = "Select * from user_x2 where Email='$email' and (Password = '' OR Password IS NULL)";
    $result1 = mysqli_query($con, $query1);

     if(mysqli_num_rows($result1) > 0){
      $Acode = rand();
      $type=3;
      $sql = "UPDATE User_X2 SET Acode='$Acode' WHERE Email = '$email'";
  mysqli_query($con, $sql);

     $msg = "Please click the <a href='http://localhost:8080/public_html/4398/Project/php/authenticate.php?Acode=$Acode&Email=$email&type=$type'>link</a> to complete registration process.";
 }else{
 $msg = "You enrolled in the $course course in section $sec.";

  }


$mail = new PHPMailer;

//$mail->SMTPDebug = 2;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = EMAIL;                 // SMTP username
$mail->Password = PASS;                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to



$mail->setFrom(EMAIL, 'Mailer');
//$mail->addAddress('tuf64734@temple.edu', 'Meet Patel');     // Add a recipient
//$mail->addAddress('tuf64734@temple.edu');               // Name is optional
$mail->addReplyTo(EMAIL, 'Information');
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


$mail->addAddress($row['email']);
$mail->Subject = "Welcome to AttendU";
$mail->Body = $msg;


if(!$mail->send()) {
        $_SESSION["Message"] = "Mailer error: ".$mail->ErrorInfo;

    print "Mail send failed: ".$mail->ErrorInfo;

} else {
  print "Email sent ... <br>";


}



 }

 header("location:../SentInviteToAllStudents.html");
    exit();

}



if(isset($_POST["invite_one"]))
{

$course=$_SESSION['course'];
$sec=$_SESSION['section'];

$email=$_POST['email'];


 $query1 = "Select * from user_x2 where Email='$email' and (Password = '' OR Password IS NULL)";
    $result1 = mysqli_query($con, $query1);

     if(mysqli_num_rows($result1) > 0){
      $Acode = rand();
      $type=3;
      $sql = "UPDATE User_X2 SET Acode='$Acode' WHERE Email = '$email'";
  mysqli_query($con, $sql);

     $msg = "Please click the <a href='http://localhost:8080/public_html/4398/Project/php/authenticate.php?Acode=$Acode&Email=$email&type=$type'>link</a> to complete registration process.";
 }else{
 $msg = "You enrolled in the $course course in section $sec.";

  }


$mail = new PHPMailer;

//$mail->SMTPDebug = 2;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = EMAIL;                 // SMTP username
$mail->Password = PASS;                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to



$mail->setFrom(EMAIL, 'Mailer');
//$mail->addAddress('tuf64734@temple.edu', 'Meet Patel');     // Add a recipient
//$mail->addAddress('tuf64734@temple.edu');               // Name is optional
$mail->addReplyTo(EMAIL, 'Information');
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


$mail->addAddress($email);
$mail->Subject = "Welcome to AttendU";
$mail->Body = $msg;


if(!$mail->send()) {
        $_SESSION["Message"] = "Mailer error: ".$mail->ErrorInfo;

    print "Mail send failed: ".$mail->ErrorInfo;

} else {
  print "Email sent ... <br>";


}





 header("location:../SentInviteToSome.html");
    exit();

}


?>
