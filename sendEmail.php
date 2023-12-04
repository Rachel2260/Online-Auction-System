<?php
//Tips
//sendmail file (installed on mac)
//php.ini to configure
//log files /var/log/mail.log-- find it alter
//gmail , application password

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'D:\Coding\WAMP\www\COMP0178\Online-Auction-System\vendor\phpmailer\phpmailer\src\Exception.php';
require_once 'D:\Coding\WAMP\www\COMP0178\Online-Auction-System\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require_once 'D:\Coding\WAMP\www\COMP0178\Online-Auction-System\vendor\phpmailer\phpmailer\src\SMTP.php';


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {

    $mail->CharSet ="UTF-8";                     
    $mail->SMTPDebug = 0;                        
    $mail->isSMTP();                             
    $mail->Host = 'smtp.gmail.com';             
    $mail->SMTPAuth = true;                     
    $mail->Username = 'weiweiruo2333@gmail.com';
    #APP password : Mail's APP password
	$mail->Password = 'ezrjqouiinocnjua';
    $mail->SMTPSecure = 'ssl';  
    $mail->Port = 465;    

    $mail->setFrom('weiweiruo2333@gmail.com', 'Quick Auction WebSite');
    #here for receiver
   // $mail->addAddress('958375266@qq.com','Test Recipient');  
    $mail->addAddress($email,$receiver);  
    $mail->addReplyTo('weiweiruo2333@gmail.com', 'info');
    

    //Content
    $mail->isHTML(true);                   
    $mail->Subject = $email_title;
    $mail->Body    = $content;
    $mail->AltBody = 'Non-HTML email content';

    $mail->send();
} catch (Exception $e) {
    echo 'Email sent unsuccessfully: ', $mail->ErrorInfo;
}
?>
