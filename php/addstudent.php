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

if(isset($_GET['type'])){
      //$Email=$_SESSION["logged_email"];
  $course=$_SESSION["course"];
$sec=$_SESSION["section"];
  $email = $_POST["email"];

   $query = "Delete from course_student where email='$email' and course='$course' and section='$sec';";
    $result = mysqli_query($con, $query);

    header("location:../ProfStudents.html");
    exit();
    }

if(isset($_POST["import"]))
{
  $msg='';
  $course=$_POST["course"];
  $sec=$_POST["sec"];
 $extension = end(explode(".", $_FILES["excel"]["name"])); // For getting Extension of selected file
 $allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
 if(in_array($extension, $allowed_extension)) //check selected file extension is present in allowed extension array
 {
  $file = $_FILES["excel"]["tmp_name"]; // getting temporary source of excel file
  include("PHPExcel/IOFactory.php"); // Add PHPExcel Library in this code
  $objPHPExcel = PHPExcel_IOFactory::load($file); // create object of PHPExcel library by using load() method and in load method define path of selected file


  foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
  {
   $highestRow = $worksheet->getHighestRow();
   for($row=2; $row<=$highestRow; $row++)
   {

    $name = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
    $studentId = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(1, $row)->getValue());
      $email = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(2, $row)->getValue());
    $crhrs = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(3, $row)->getValue());
      $crlvl = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(4, $row)->getValue());
    $coll = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(5, $row)->getValue());
      $class = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(6, $row)->getValue());
    $prgm = mysqli_real_escape_string($con, $worksheet->getCellByColumnAndRow(7, $row)->getValue());
$myArray = explode(',', $name);
$fname=$myArray[0];
$lname=$myArray[1];
$status=1;
$type=3;
$Acode = rand(); // get a new activation code
  $Rdatetime = date("Y-m-d h:i:s"); //this line has a problem

  $query1 = "Select * from user_x2 where Email='$email'";
    $result1 = mysqli_query($con, $query1);
    //$row = mysqli_fetch_row($result);
    if(mysqli_num_rows($result1) < 1){

     $query = "INSERT INTO user_x2(FirstName, LastName,Email,StudentID,CrHrs,CrLvl,Coll,Class,Prgrm,Status,type,Acode,Rdatetime) VALUES ('".$fname."', '".$lname."','".$email."', '".$studentId."','".$crhrs."', '".$crlvl."','".$coll."', '".$class."','".$prgm."','".$status."','".$type."','".$Acode."','".$Rdatetime."')";
    mysqli_query($con, $query);

    $msg = "Please click the <a href='http://localhost:8080/public_html/AttendUFinalTest/php/authenticate.php?Acode=$Acode&Email=$email&type=$type'>link</a> to complete registration process.";


    }

     $query3 = "Select * from course_student where email='$email' and course='$course' and section='$sec'";
    $result3 = mysqli_query($con, $query3);
     if(mysqli_num_rows($result3) < 1){

      $query2 = "INSERT INTO course_student(email,course,section) VALUES ('".$email."', '".$course."','".$sec."')";
    mysqli_query($con, $query2);

if(empty($msg)){
   $msg = "You enrolled in the $course course in section $sec.";
}
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


$mail->addAddress($email,"$FirstName $LastName");
$mail->Subject = "Welcome to AttendU";
$mail->Body = $msg;


if(!$mail->send()) {
        $_SESSION["Message"] = "Mailer error: ".$mail->ErrorInfo;

    print "Mail send failed: ".$mail->ErrorInfo;

} else {
  print "Email sent ... <br>";


}


   }
  }
 $_SESSION["Message"]  .= 'File uploaded';

 }
 else
 {
  $_SESSION["Message"]  = 'Invalid File'; //if non excel file then

 }
 header("location:../ProfStudents.html");
    exit();
}
?>
