<?php
class mail{
    function sendmail($email_id,$teacher_name){
require  '../phpmailer/PHPMailerAutoload.php';
require '../phpmailer/class.phpmailer.php'; // path to the PHPMailer class
        require '../phpmailer/class.smtp.php';




$mail = new PHPMailer;

$mail->IsSMTP();
$mail->Host="smtp.gmail.com";
$mail->Port="587";
$mail->SMTPAuth=true;
$mail->SMTPSecure='tls';

$mail->Username = "faisyraja26@gmail.com";
$mail->Password = "mpb&faisu2618";

$mail->setFrom("faisyraja26@gmail.com", "TCS");
$mail->addAddress($email_id);
$mail->addReplyTo("faisyraja26@gmail.com", "TCS");
//Provide file path and name of the attachments
//$mail->addAttachment("file.txt", "File.txt");        
//$mail->addAttachment("images/profile.png"); //Filename is optional

$mail->isHTML(true);

$mail->Subject = "Assignent Work Assigned by TCS Team";
$mail->Body = "<i>Hello $teacher_name,<br>I hope you will be fine and doing well.<br>Please consider this email regarding assignment work.<br>
Please check your login on TCS by your username and password, and find the assignment regarding student.Also keep in mind the deadline for the assignment work.<br>THanks Keep in touch with TCS Team. </i>";
$mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    
}else {
    echo "Message has been sent successfully";

}
    }
}
?>