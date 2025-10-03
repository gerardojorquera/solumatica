<?php
	// Check for empty fields
	if(empty($_POST['subject'])      ||
		empty($_POST['email'])     ||
		empty($_POST['message'])   ||
		!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
		{
		   //echo "No arguments Provided!";
		   $response_array['status'] = 'error';
		   echo json_encode($response_array);
		   return;
		}
	
	//$area = $_POST['area'];
	//$tipo = $_POST['tipo'];
	$formSubject = strip_tags(htmlspecialchars($_POST['subject']));
	$formEmail = strip_tags(htmlspecialchars($_POST['email']));
	$formMessage = strip_tags(htmlspecialchars($_POST['message']));
	
	// Create the email and send the message
	/*$to = 'yourname@yourdomain.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
	$email_subject = "Website Contact Form:  $name";
	$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
	$headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
	$headers .= "Reply-To: $email_address";   
	mail($to,$email_subject,$email_body,$headers);*/

	// 2018-09-24 Se comenta porque aun no he creado las bases de datos
	//Parametros de conexion a la base de datos.
	include_once('../include/connect_data.php');
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		//die("Connection failed: " . $conn->connect_error);
		$response_array['status'] = 'error';
		echo json_encode($response_array);
		return;
	} /*else {
		$response_array['status'] = 'success';
		echo json_encode($response_array);
		return;
	}*/

	//Funciones para obtener informacion del usuario (cliente).
	include_once('../include/user_info.php');
	
	$ip = getIP();
	$browser = getBrowser();
	$so = getOS();
	$area = "0";
	$tipo = "0";
	$name = "S/N";
	$sql = "INSERT INTO contactenos(con_area, con_tipo, con_nombre, con_email, con_comentario, con_ip, con_browser, con_so, con_asunto) ";
	$sql .= "VALUES (".$area.",".$tipo.",'".$name. "','".$formEmail."','".$formMessage."','".$ip."','".$browser."','".$so."','".$formSubject."')";
	
	/*if (!mysqli_query($conn, $sql)) { 
		//echo "Error: " . mysqli_error($conn); 
		$response_array['status'] = 'error'; //echo "Error: " . $sql . "<br>" . $conn->error;
		$response_array['status_error'] = "Error: " . mysqli_error($conn);
	} else { 
		$response_array['status'] = 'success';
	}
	echo json_encode($response_array);
	return;*/

	if ($conn->query($sql) === TRUE) {
		/*//Area
		switch ($area) {
			case 1:
				$area_desc = "Capacitación";
				break;
			case 2:
				$area_desc = "Desarrollo";
				break;
			case 3:
				$area_desc = "Asesorías";
				break;
			default:
				$area_desc = "Soporte";
		}
		
		//Tipo
		switch ($tipo) {
			case 1:
				$tipo_desc = "Consulta";
				break;
			case 2:
				$tipo_desc = "Mejora";
				break;
			case 3:
				$tipo_desc = "Reclamo";
				break;
			default:
				$tipo_desc = "Felicitación";
		}*/

		$d = new DateTime('', new DateTimeZone('America/Santiago')); 
		//echo $d->format('Y-m-d H:i:s');
		$subject = 'Solumática - Formulario Web de contacto v2 - Fecha: '.$d->format('Y/m/d H:i:s');
		$newline = "<br>";
		$email_body = "Ha recibido un nuevo mensaje de su formulario del sitio Web.". $newline . $newline ;
		$table="<table style='width:100%' table border='1' cellpadding='10px' cellspacing='0' >".
		  "<tr>".
		  "  <td>Asunto:</td>".
		  "  <td>$formSubject</td>".
		  "</tr>".
		  "<tr>".
		  "  <td>Dirección de correo:</td>".
		  "  <td>$formEmail</td>".
		  "</tr>".
		  "<tr>".
		  "  <td>Mensaje:</td>".
		  "  <td>$formMessage</td>".
		  "</tr>".
		"</table>";
		
		include '../include/sendmail.php';
		//sendmail($from, $to, $cco, $subject, $body);
		//sendmail('info@solumatica.cl','info@solumatica.cl','gerardo.jorquera.reyes@gmail.com',$subject,$email_body.$table);
        $send = sendmail('info@solumatica.cl','info@solumatica.cl','gerardo.jorquera.reyes@gmail.com',$subject,$email_body.$table);
		if($send){
			$response_array['status'] = 'success';
		} else {
			$response_array['status'] = 'error';
			$response_array['status_error'] = "Error: sendmail" ;
		}
		//echo "New record created successfully";
		//$response_array['status'] = 'success';
	} else {
		$response_array['status'] = 'error'; //echo "Error: " . $sql . "<br>" . $conn->error;
		$response_array['status_error'] = "Error: " . mysqli_error($conn);
	}
	echo json_encode($response_array);
	return;
?>