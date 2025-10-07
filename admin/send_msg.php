<?php
include "./../include/config.php";
require './../PHPMailer/PHPMailer.php';
require './../PHPMailer/SMTP.php';
require './../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['eid']) && isset($_POST['attendanceid']) && $_POST['eid'] > 0) {
    $id = mysqli_real_escape_string($conn, $_POST['eid']);
    $attendanceid = mysqli_real_escape_string($conn, $_POST['attendanceid']);
	$res=mysqli_query($conn,"select employee.id,employee.full_name,employee.email,attendance.id,attendance.employee_id,attendance.send from employee
        JOIN attendance ON employee_id = employee.email 
        where attendance.send='1' and employee.id=$id;");
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		$email=$row['email'];
		$full_name=$row['full_name'];
		$html="<html>
				
				<body>
					
					<div class='container-fluid' style=' max-width: 600px; margin: 0 auto;'>
					<img src='https://jiffy.mineit.tech/assets2/img/Jiffy-logo.png' width='800px' height='100px' alt='Jiffy Logo'/ class='text-left'>
					<hr>
					Dear,$full_name<br>
		  			<p class='text-justify'>I hope this email finds you well. I would like to take a moment to address an important matter that concerns our companys productivity and teamwork. Recently, we have noticed a consistent pattern of late logins to work from certain team members, including yourself. While we understand that unforeseen circumstances can sometimes cause delays, its essential for all of us to uphold a consistent schedule to ensure the smooth functioning of our teams and projects.<br><br> Punctuality is not only a sign of professionalism, but it also helps us create a work environment where everyone can rely on each other to be present and ready to contribute. Timely logins contribute to effective communication, collaboration, and the overall success of our projects.<br><br>We kindly request your cooperation in ensuring that you arrive on time and log in promptly moving forward. If there are any challenges you were facing that are affecting your ability to be punctual, please feel free to reach out to your immediate supervisor or our HR department. We are here to support you and address any concerns you may have. Lets work together to maintain a positive and efficient work environment for the benefit of all team members.<br> Your commitment to punctuality is greatly appreciated and does not go unnoticed.
		Thank you for your attention to this matter.</p>
		<hr>
		<p class='text-center'>Powered by Jiffy</p>
		</div>
		
		</body></html>";
		smtp_mailer($email,'Importance of Timely Logins', $html);
		mysqli_query($conn,"update attendance set send =3 where id='$attendanceid'");
		$status=true;
		$msg="Sent";
	}else{
		$status=false;
		$msg="Invalid Details";
	}
}else{
	$status=false;
	$msg="Id not found";
}

echo json_encode(array('status'=>$status,'msg'=>$msg));





function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = 'jiffymine@gmail.com';
	$mail->Password = 'holxypcuvuwbhylj';
	$mail->SetFrom("jiffymine@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		//echo $mail->ErrorInfo;
	}else{
		//echo 'Sent';
	}
}
?>