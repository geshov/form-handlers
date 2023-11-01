<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "vendor/PHPMailer/src/Exception.php";
require "vendor/PHPMailer/src/PHPMailer.php";
require "vendor/PHPMailer/src/SMTP.php";

require "credentials.php";

$_from = filter_var($_POST["_from"], FILTER_SANITIZE_SPECIAL_CHARS);
$_subject = filter_var($_POST["_subject"], FILTER_SANITIZE_SPECIAL_CHARS);
$_honey = filter_var($_POST["_honey"], FILTER_SANITIZE_SPECIAL_CHARS);
if ($_honey) exit("Bot detected");

$name = filter_var($_POST["name"], FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$subject = filter_var($_POST["subject"], FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_var($_POST["message"], FILTER_SANITIZE_SPECIAL_CHARS);

$to = filter_var($_GET["email"], FILTER_SANITIZE_EMAIL);

$body = <<<END
<div><strong>Имя</strong>: $name</div>
<div><strong>Email</strong>: $email</div>
<div><strong>Тема</strong>: $subject</div>
<div><strong>Сообщение</strong>: $message</div>
END;

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host = "smtp.gmail.com";
  $mail->SMTPAuth = true;
  $mail->Username = $from;
  $mail->Password = $password;
  $mail->SMTPSecure = "tls";
  $mail->Port = 587;
  $mail->CharSet = "UTF-8";
  $mail->Encoding = "base64"; 

  $mail->setFrom($from, $_from);
  $mail->addReplyTo($email, $name);
  $mail->addAddress($to);

  $mail->isHTML(true);
  $mail->Subject = $_subject;
  $mail->Body = $body;

  $mail->send();
  echo "Message has been sent";
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
