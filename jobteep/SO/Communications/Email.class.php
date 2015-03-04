<?php
include_once 'Libraries/PHPMailer/PHPMailerAutoload.php';
include_once 'SO/Exceptions/Email/FailSendingMailException.exception.php';

class Email {
	private $mail;
	
	function Email() {
		//CONFIGURACIÓN DEL CORREO
		$this->mail = new PHPMailer();
		$this->mail->setLanguage('es', 'Model/Modules/PHPMailer/language/phpmailer.lang-es.php');
		$this->mail->isSMTP();                                      // Set mailer to use SMTP
		$this->mail->Host = 'smtp.1and1.es';  						// Specify main and backup SMTP servers
		$this->mail->SMTPAuth = true;                               // Enable SMTP authentication
		$this->mail->Username = 'app@jobteep.com';               // SMTP username
		$this->mail->Password = 'Gus@nillo87';                      // SMTP password
		$this->mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		$this->mail->From = 'app@jobteep.com';
		$this->mail->FromName = 'JOBTeep | App';
		$this->mail->WordWrap = 50;
		$this->mail->isHTML(true);                                  // Set email format to HTML
		$this->mail->addReplyTo('app@jobteep.com', 'JOBTeep | App');
	}
	
	private function clear () {
		$this->mail->clearAddresses();
		$this->mail->clearAttachments();
		$this->mail->clearBCCs();
		$this->mail->clearCCs();
	}
	
	public function sendMail ($subject, $body, $recipients, $altBody = null, $attachment = null, $cc = null, $bcc = null) {
		$this->mail->Subject = utf8_decode($subject);
		$this->mail->Body = utf8_decode($body);
		//AÑADIMOS DESTINATARIOS
		//Array formado por "Email" => "Nombre"
		foreach ($recipients as $email => $name) {
			$this->mail->addAddress($email, utf8_decode($name));
		}
		//ALTBODY EN CASO DE QUE NO SE PERMITA HTML
		if (!is_null($altBody))
			$this->mail->AltBody = utf8_decode($altBody);
		//AÑADIMOS ARCHIVOS ADJUNTOS
		//Array formado por "Dirección" => "NuevoNombre.extension"
		if (!is_null($attachment)) {
			foreach ($attachment as $path => $name) {
				$this->mail->addAttachment($path, $name);
			}
		}
		//AÑADIMOS EN COPIA
		//Array formado por "Dirección"
		if (!is_null($cc)) {
			for ($i = 0; $i < count($cc); $i++) {
				$this->mail->addCC($cc[$i]);
			}
		}
		//AÑADIMOS EN COPIA OCULTA
		//Array formado por "Dirección"
		if (!is_null($bcc)) {
			for ($i = 0; $i < count($bcc); $i++) {
				$this->mail->addBCC($bcc[$i]);
			}
		}
		if(!$this->mail->send()) {
			$this->clear();
			throw new FailSendingMailException($this->mail->ErrorInfo);
		}
		
		$this->clear();
	}
}