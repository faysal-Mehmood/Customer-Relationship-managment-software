<?php

class mail{
   function sendmail($email_id,$first){
    require  'admin/phpmailer/PHPMailerAutoload.php';
    require 'admin/phpmailer/class.phpmailer.php'; // path to the PHPMailer class
            require 'admin/phpmailer/class.smtp.php';




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

$mail->Subject = "TCS Team";
$mail->Body = "<i>Hello $first, <br>Thanks for contacting us.<br> Our team will contact you within 24hours.Stay tuned and active for further updates<br>Regard TCS team. </i>";
$mail->AltBody = "This is the plain text version of the email content";

if(!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    
}else{
    
}
    }
}
?>