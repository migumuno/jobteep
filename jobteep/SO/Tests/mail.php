<?php
include_once 'Model/Modules/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.1and1.es';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'app@jobteep.com';                 // SMTP username
$mail->Password = 'Gus@nillo87';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'app@jobteep.com';
$mail->FromName = 'The Jobfeel | App';
$mail->addAddress('miguelamv11@gmail.com', 'Miguel Ángel Muñoz');     // Add a recipient
$mail->addReplyTo('app@jobteep.com', 'The Jobfeel | App');
/*$mail->addCC('cc@example.com');
$mail->addBCC('bcc@example.com');*/

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
/*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Esto es la primera prueba';
$mail->Body    = 'Esto es el primer mensaje de prueba en html <b>en negrita!</b><br>
Document Root: '.$_SERVER['DOCUMENT_ROOT'].'<br>
Remote Address: '.$_SERVER['REMOTE_ADDR'].'<br>
Remote Host: '.$_SERVER['REMOTE_HOST'].'<br>
Remote User: '.$_SERVER['REMOTE USER'].'<br>
Remote Port: '.$_SERVER['REMOTE_PORT'].'<br>
Request Uri: '.$_SERVER['REQUEST_URI'];
$mail->AltBody = 'Esto es el primer mensaje de prueba en html para mailer clients que no permiten HTML.';

if(!$mail->send()) {
echo 'El mensaje no se pudo enviar.';
echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
echo 'El mensaje se ha enviado con éxito!';
}
?>