<?php
if(isset($_POST['email'])){
		$mailTo = "hi@jobteep.com";
		$subject = "Email de la web";
		$body = "Nuevo mensaje de la web
<br><br>
FROM: ".$_POST['email']."<br>
NAME: ".$_POST['author']."<br>
COMMENTS: ".$_POST['message']."<br>";	
		$headers = "To: JOBTeep <".$mailTo.">\r\n";
		$headers .= "From: ".$_POST['author']." <".$_POST['email'].">\r\n";
		$headers .= "Content-Type: text/html";
		//envio destinatario
		$mail_success =  mail($mailTo, utf8_decode($subject), utf8_decode($body), $headers);		
}
?>  