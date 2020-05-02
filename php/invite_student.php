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

 $query = "Select email from course_student where course='$course' and section=$sec";
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
if (!$result) {
		
			mysqli_error($con);
		
		exit();
	}
     if(mysqli_num_rows($result1) > 0){
      $Acode = rand();
      $type=3;
      $sql = "UPDATE user_x2 SET Acode='$Acode' WHERE Email = '$email'";
  mysqli_query($con, $sql);
     
  $msg = "Please click the <a href='http://cis-linux2.temple.edu/~tug43815/AttendU/Project/php/authenticate.php?Acode=$Acode&Email=$email&type=$type'>link</a> to complete registration process.";
}else{
 $msg = "You enrolled in the $course course in section $sec.";
    
  }


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
$FirstName=$_POST['first_name'];
$LastName=$_POST['last_name'];
$Stu_id=$_POST['student_id'];

$type=3;
 $query1 = "Select * from user_x2 where Email='$email' and type=$type and (Password != '' OR Password IS NOT NULL)";
$result1 = mysqli_query($con, $query1);


     if(mysqli_num_rows($result1) < 1){
      $Acode = rand();
$Rdatetime = date("Y-m-d h:i:s"); //this line has a problem
      $type=3;
 $query2 = "Select * from user_x2 where Email='$email' and type=$type and (Password = '' OR Password IS NULL)";
$result2 = mysqli_query($con, $query2);
if(mysqli_num_rows($result1) > 0){
 $sql = "UPDATE user_x2 SET Acode='$Acode' WHERE Email = '$email'";
  mysqli_query($con, $sql);
}else{
$sql = "Insert into user_x2 (FirstName,LastName,Email,Acode, "
		."Rdatetime, Status ,type,StudentID) values ('$FirstName','$LastName','$email',"
		."'$Acode','$Rdatetime', 1,$type,$Stu_id);";
  $res=mysqli_query($con, $sql);


if(!$res){
echo "Query not worked";
}
}
     
 
  $msg ="Please click the <a href='http://cis-linux2.temple.edu/~tug43815/AttendU/Project/php/authenticate.php?Acode=$Acode&Email=$email&type=$type'>link</a> to complete registration process.";

 }else{
 $msg = "You enrolled in the $course course in section $sec.";
    
  }
  $date=date("Y/m/d");
  $query7 = "Select * from course_student where email='$email' and course='$course' and section=$sec";
  $result7 = mysqli_query($con, $query7);
if(mysqli_num_rows($result7)<1){
    $sql = "Insert into course_student (email,course,section) values ('$email','$course',$sec);";
  $res=mysqli_query($con, $sql);

  $query8 = "Select * from daily_check where daily_date='$date' and Course='$course' and Section=$sec";
  $result8 = mysqli_query($con, $query8);
  if(mysqli_num_rows( $result8)>0){

    $query4 = "SELECT * FROM courses WHERE ClassName='$course' AND SecNumber=$sec;";
    $result4 = mysqli_query($con, $query4);
    $row4 = mysqli_fetch_array($result4);
     $tAtt=$row4['attendance_t'];
     echo "Total att".$tAtt;
    
     $query5 = "SELECT * FROM course_student WHERE course='$course' AND section=$sec AND email='$email';";
    $result5 = mysqli_query($con, $query5);
    $row5 = mysqli_fetch_array($result5);
     $sAtt=$row5['attendance'];

    $query9 = "INSERT INTO daily_check (Stu_email,Course,Section,daily_date,my_total_att,t_total_att) VALUES ('$email','$course',$sec,'$date',$sAtt,$tAtt);";
	 	echo $query9;
	$result9 = mysqli_query($con, $query9);
  }

}

 



echo $msg;

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
