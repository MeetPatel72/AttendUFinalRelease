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
$a=1;
$b=0;

if(isset($_POST['stu_att'])){

$course=$_SESSION['course'];
$sec=$_SESSION['section'];
$email=$_SESSION['logged_email'];

if(isset($_GET['time'])){
$time=$_GET['time'];
if((time()-(60*10)) < strtotime($time)){
  $query="Update course_student set attendance=attendance+1,current_att_status=$a where course='$course' And section=$sec And email='$email'";
 $result = mysqli_query($con, $query);

 $date=date("Y/m/d");
$d=1;
 $query2="UPDATE daily_check SET daily_Attendance=$d,my_total_att=my_total_att+1 WHERE Course='$course' AND Section=$sec AND Stu_email='$email' AND daily_date='$date'";
 
 $result2 = mysqli_query($con, $query2);
}

}

header("location:../StuAttendance.html");
    exit();

}


if(isset($_POST["attendance"]))
{

if(isset($_GET['time'])){
$time=strtotime($_GET['time']);

//$date = date('d-m-Y', $time);
///$time=DATE($time);
//$date2='28-04-2020';
//echo $date ." ".date("d-m-Y");

}

$f=1;
  $date=date("Y/m/d");
  $course=$_SESSION["course"];
  $sec=$_SESSION["section"];

$query1 = "SELECT * FROM daily_check WHERE daily_date='$date' AND Course='$course' AND Section=$sec AND att_check=$f;";
  $result1 = mysqli_query($con, $query1);
if (mysqli_num_rows($result1) < 1) {


//////////////


///////////
 $query = "Update courses set attendance_time=now(),attendance_t=attendance_t+1 where ClassName='$course' And SecNumber=$sec";
 $result = mysqli_query($con, $query);

    if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
     header("location:../ProfCreateAttend.html");
    exit();
}
$a=0;
 $query2 = "Update course_student set current_att_status=$a where course='$course' And section=$sec";
 $result2 = mysqli_query($con, $query2);




$query1 = "SELECT * FROM daily_check WHERE daily_date='$date' AND Course='$course' AND Section=$sec;";

  $result1 = mysqli_query($con, $query1);

  if (mysqli_num_rows($result1) < 1) {
    echo "hello";
    $query2 = "SELECT email FROM course_student WHERE course='$course' AND section=$sec;";
   
  $result2 = mysqli_query($con, $query2);

   while ($row = mysqli_fetch_array($result2)) {
$d=0;
    $Email=$row['email'];
    $date=date("Y/m/d");


$query4 = "SELECT * FROM courses WHERE ClassName='$course' AND SecNumber=$sec;";
$result4 = mysqli_query($con, $query4);

$row4 = mysqli_fetch_array($result4);
 $tAtt=$row4['attendance_t'];

 $query5 = "SELECT * FROM course_student WHERE course='$course' AND section=$sec AND email='$Email';";
$result5 = mysqli_query($con, $query5);

$row5 = mysqli_fetch_array($result5);
 $sAtt=$row5['attendance'];
  $d=1;
$p=0;
    $query3 = "INSERT INTO daily_check (Stu_email,Course,Section,daily_date,daily_QA,my_total_att,t_total_att,att_check) VALUES ('$Email','$course',$sec,'$date',$p,$sAtt,$tAtt,$d);";


  $result3 = mysqli_query($con, $query3);
echo $query3;
      if (!$result3) {
    printf("Error: %s\n", mysqli_error($con));
  
    exit();
}
   }


  } else{
$d=1;
 $query2 = "Update daily_check set t_total_att=t_total_att+1,att_check=$d where course='$course' And section=$sec";
 $result2 = mysqli_query($con, $query2);

  }

}

  header("location:../ProfDASH.html");
    exit();


}
?>