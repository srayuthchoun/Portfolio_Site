<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
//require_once('email_config.php');
require('PHPMailerAutoload.php');
$config = parse_ini_file('/var/www/cfg.ini', true);
$mail = new PHPMailer();
$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication


$mail->Username = $config['username'];                  // SMTP username
$mail->Password = $config['password'];                 // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to
$options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->smtpConnect($options);
$mail->From = 'noreply@srayuthchoun.com';
$mail->FromName = 'noreply';
$mail->addAddress('srayuthchoun.portfolio@gmail.com', 'Srayuth');     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo($_POST['email'], $_POST['name']);
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Someone has contacted you from your website.';
$stuff = '';
foreach ($_POST as $key => $value) {
    $stuff .= "<h3>$key : $value</h3>";
}
$mail->Body = $stuff;
$mail->AltBody = strip_tags($_POST['message']);

if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>