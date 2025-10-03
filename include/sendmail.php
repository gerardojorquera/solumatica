<?php
	function sendmail($from, $to, $cco, $subject, $body)
	{
		//$from = 'info@solumatica.cl';
		//$to = 'info@solumatica.cl';
		//$subject = "Asunto prueba pechugin";
		//$body = "Todo facil pechunet 123456";
		
		$headers = 'From: '.$from. "\r\n".
		'Bcc: '. $cco. "\r\n".	
		'Reply-To: '.$from. "\r\n" .
		'MIME-Version: 1.0' . "\r\n" .
		'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();		
		//'Content-type: text/html; charset=utf-8' . "\r\n" .

		//$subject = utf8_decode($subject);
		$body = utf8_decode($body);

		try {
			
			//ini_set('SMTP', "relay-hosting.secureserver.net");
			//ini_set('smtp_port', "25");
			
			return mail($to, $subject, $body, $headers);

		} catch (Exception $e) {
			return false; //return ', Pero a ocurrido un error al enviar el correo: '.  $e->getMessage(). "\n";
		}
	}
?>