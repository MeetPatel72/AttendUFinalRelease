<?php 
    session_start();
	require_once("config.php");

		// Connect to DB!
	$con = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
	if (!$con) {
		
		$_SESSION["Message"] = "Database connection failed: ".
			mysqli_error($con);
		header("location:../ProfDASH.html");
		exit();
	}

	$_SESSION["loginRole"]= 2;

$a=1;
$b=0;



if(isset($_POST['stu_ans'])){

$course=$_SESSION['course'];
$sec=$_SESSION['section'];
$email=$_SESSION['logged_email'];

if(isset($_GET['c_ans']) && isset($_GET['time'])){
	$ans=$_GET['c_ans'];
	$time=$_GET['time'];
	$stu_ans=$_POST['stu_ans'];
    $c_time=date("Y-m-d H:i:s");

    if((time()-(60*10)) < strtotime($time)){

    	if($ans==$stu_ans){
$query="UPDATE course_student SET grade=grade+1,current_ques_status=$a WHERE course='$course' AND section=$sec AND email='$email'";
echo $query;
 $result = mysqli_query($con, $query);

$date=date("Y/m/d");

 $query2="UPDATE daily_check SET daily_answer=daily_answer+1 WHERE Course='$course' AND Section=$sec AND Stu_email='$email' AND daily_date='$date'";
 echo $query2;
 $result2 = mysqli_query($con, $query2);
if (!$result2) {
	
			 printf("Error: %s\n", mysqli_error($con));
	
		exit();
	}
 
    	}else{
$query="UPDATE course_student SET current_ques_status=$a WHERE course='$course' AND section=$sec AND email='$email'";

 $result = mysqli_query($con, $query);

    	}
    	
    }


}
header("location:../StudentQA.html");
		exit();

}



if(isset($_POST["qa_two"]))
{
$ques=$_POST['two_ques'];
$correct_ans=$_POST['two_ans'];
$ans1="true";
$ans2="false";
$ans3="";
$ans4="";
$course=$_SESSION["course"];
$sec=$_SESSION["section"];

}

if(isset($_POST["qa_three"]))
{
$ques=$_POST['ques'];
$correct_ans=$_POST['correct'];
$ans1=$_POST['option_one'];
$ans2=$_POST['option_two'];
$ans3=$_POST['option_three'];
$ans4="";
$course=$_SESSION["course"];
$sec=$_SESSION["section"];

}


if(isset($_POST["qa_four"]))
{
$ques=$_POST['ques'];
$correct_ans=$_POST['correct'];
$ans1=$_POST['option_one'];
$ans2=$_POST['option_two'];
$ans3=$_POST['option_three'];
$ans4=$_POST['option_four'];
$course=$_SESSION["course"];
$sec=$_SESSION["section"];

}




 $query = "Update courses set ques='$ques',option_one='$ans1',option_two='$ans2',option_three='$ans3',option_four='$ans4', correct_ans='$correct_ans',grade_t= grade_t+1,ques_time=now() where ClassName='$course' And SecNumber=$sec";
 $result = mysqli_query($con, $query);
if (!$result) {
	
			 printf("Error: %s\n", mysqli_error($con));
	
		exit();
	}

	$query2="Update course_student set current_ques_status=$b where course='$course' And section=$sec";
    $result2 = mysqli_query($con, $query2);

    if (!$result2) {
	
			 printf("Error: %s\n", mysqli_error($con));
	
		exit();
	}


$date=date("Y/m/d");

$query1 = "SELECT * FROM daily_check WHERE daily_date='$date' AND Course='$course' AND Section=$sec;";
echo $query1;
	$result1 = mysqli_query($con, $query1);

	if (mysqli_num_rows($result1) < 1) {
		
		$query2 = "SELECT email FROM course_student WHERE course='$course' AND section=$sec;";
		
	$result2 = mysqli_query($con, $query2);

	 while ($row = mysqli_fetch_array($result2)) {
$d=1;

		 $Email=$row['email'];
		 echo $Email;
	 	$date=date("Y/m/d");

$query4 = "SELECT * FROM courses WHERE ClassName='$course' AND SecNumber=$sec;";
$result4 = mysqli_query($con, $query4);
$row4 = mysqli_fetch_array($result4);
 $tAtt=$row4['attendance_t'];
 echo "Total att".$tAtt;

 $query5 = "SELECT * FROM course_student WHERE course='$course' AND section=$sec AND email='$Email';";
$result5 = mysqli_query($con, $query5);
$row5 = mysqli_fetch_array($result5);
 $sAtt=$row5['attendance'];
	 	
	 	$query3 = "INSERT INTO daily_check (Stu_email,Course,Section,daily_date,daily_QA,my_total_att,t_total_att) VALUES ('$Email','$course',$sec,'$date',$d,$sAtt,$tAtt);";
	 	echo $query3;
	$result3 = mysqli_query($con, $query3);

	 }


	} else{
		
	 	$sql = "UPDATE daily_check SET daily_QA = daily_QA+1 WHERE Course='$course' AND Section=$sec AND daily_date='$date'";
	 	echo $sql;
	$result4= mysqli_query($con, $sql);
	 if (!$result4) {
	
			 printf("Error: %s\n", mysqli_error($con));
	
		exit();
	}

	 }






 header("location:../ProfDASH.html");
		exit();
	


	?>