<?php 
include ("../../include/conexion.php");
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;

		//enviar correo
		require '../../PHPMailer/Exception.php';
		require '../../PHPMailer/PHPMailer.php';
		require '../../PHPMailer/SMTP.php';


$correo = $_POST['email'];
$dni = $_POST['dni'];

//buscar si correo existe
$busc_user = "SELECT * FROM docente WHERE dni='$dni' AND correo='$correo'";
$ejec_busc_user = mysqli_query($conexion, $busc_user);
$cont_user = mysqli_num_rows($ejec_busc_user);
if ($cont_user > 0) {
	$res_busc_user = mysqli_fetch_array($ejec_busc_user);
	$id_persona = $res_busc_user['id'];
    $ap_nom = $res_busc_user['apellidos_nombres'];
	
		//enviamos correo
		

		$asunto = "Recuperacion de acceso a SISPA (Sistema de Portafolio Academico)";
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'sispa.iestphuanta.edu.pe';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'admin@sispa.iestphuanta.edu.pe';                     //SMTP username
            $mail->Password   = 'admin@sispa';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('admin@sispa.iestphuanta.edu.pe', 'SISPA IESTP HUANTA');
            $mail->addAddress($correo, $ap_nom);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $asunto;
            $mail->Body = '<!DOCTYPE html>
                            <html lang="es">
                            <head>
                                <meta charset="UTF-8">
                            </head>
                            <body>
                            <div style="width: 100%; font-family: Roboto; font-size: 0.8em; display: inline;">
                                <div style="background-color:rgb(17,17,29); border-radius: 10px 10px 0px 0px; height: 60px; text-align: center;">
                                    <img src="https://sispa.iestphuanta.edu.pe/img/logo.png" alt="www.iestphuanta.edu.pe" style="padding: 0.5em; text-align: center;">
                                </div>
                                <div style="background-color:rgb(17,17,29); border-radius: 0px 0px 0px 0px; height: 60px; margin-top: 0px; padding-top: 2px; padding-bottom: 10px;">
                                    <p style="text-align: center; font-size: 1.0rem; color: #f1f1f1; text-shadow: 2px 2px 2px #cfcfcf; ">INSTITUTO DE EDUCACIÓN SUPERIOR TECNOLÓGICO PÚBLICO HUANTA</p>
                                </div>
                                <div>
                                    <h2 style="text-align:center;">SISPA (Sistema de Portafolio Académico)</h2>
                                    <h3 style="text-align:center; color: #3c4858;">RECUPERACION DE ACCESO</h3>
                                    <p style="font-size:1.0rem; color: #2A2C2B; margin-top: 2em; margin-bottom: 2em; margin-left: 1.5em;">
                            
                                        Hola '.$ap_nom.', para poder recuperar tu contraseña, Haz click <a href="https://sispa.iestphuanta.edu.pe/admin/login/recuperar_password.php?id='.$id_persona.'">Aquí</a>.<br>
                                        
                                        
                                        <br>
                                        <br>
                                        Por favor, no responda sobre este correo.
                                        <br><br><br>
                            
                                    </p>
                                </div>
                                <div style="color: #f1f1f1; width: 100%; height: 120px; background:rgb(17,17,29); text-align: center;  border-radius: 0px 0px 10px 10px; ">
                                    <br>
                                    <p style="margin: 0px;">
                                        <strong>
                                            <a href="tel:(066) 322296"
                                               style="text-decoration: none; color: #f1f1f1; ">Jr. Córdova 650 Huanta - Ayacucho - Perú
                                                &nbsp;|&nbsp; Teléfono: (066) 322296</a>
                                            <br> Instituto de Educación Superior Tecnológico Público Huanta
                                        </strong>
                                    </p>
                                </div>
                            </div>
                            </body>
                            </html>';
            //$mail->AltBody = '';

            $mail->send();
            //echo 'Correo enviado';
            echo "<script>
			alert('Verifique su correo, sino encuentra en su bandeja de entrada. Verifique en Seccion de Spam');
			window.location= '../login/'
			</script>
			";
        } catch (Exception $e) {
            echo "Error correo: {$mail->ErrorInfo}";
        }

}else{
	echo "<script>
			alert('El correo o dni no esta registrado en nuestro sistema');
			window.history.back();
		</script>
	";
}


?>