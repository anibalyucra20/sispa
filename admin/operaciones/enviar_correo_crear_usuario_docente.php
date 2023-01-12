<?php 
include '../include/verificar_sesion_secretaria.php';
include "../../include/conexion.php";
include '../include/busquedas.php';
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;

		//enviar correo
		require '../../PHPMailer/Exception.php';
		require '../../PHPMailer/PHPMailer.php';
		require '../../PHPMailer/SMTP.php';

$id_docente = $_GET['docente'];
$ejec_busc_doc = buscarDocenteById($conexion, $id_docente);
$res_busc_doc = mysqli_fetch_array($ejec_busc_doc);
$correo = $res_busc_doc['correo'];
$docente = $res_busc_doc['apellidos_nombres'];


//buscar datos de sistema  para aplicar datos generales
$buscar_sistema = buscarDatosSistema($conexion);
$datos_sistema = mysqli_fetch_array($buscar_sistema);
$buscar_datos_generales = buscarDatosGenerales($conexion);
$datos_iest = mysqli_fetch_array($buscar_datos_generales);
	
		//enviamos correo
		$asunto = "Actualiza contraseña para Sistema de Portafolio Docente";
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
            //Server settings
            $mail->SMTPDebug = 1;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $datos_sistema['host_email'];                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $datos_sistema['email_email'];                     //SMTP username
            $mail->Password   = $datos_sistema['password_email'];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = $datos_sistema['puerto_email'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($datos_sistema['email_email'], 'SISPA');
            $mail->addAddress($correo, $docente);     //Add a recipient
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
                                    <img src="'.$datos_sistema['pagina']."/".$datos_sistema['logo'].'" alt="'.$datos_sistema["pagina"].'" style="padding: 0.5em; text-align: center;" height="90%">
                                </div>
                                <div style="background-color:rgb(17,17,29); border-radius: 0px 0px 0px 0px; height: 60px; margin-top: 0px; padding-top: 2px; padding-bottom: 10px;">
                                    <p style="text-align: center; font-size: 1.0rem; color: #f1f1f1; text-shadow: 2px 2px 2px #cfcfcf; ">'.$datos_iest["nombre_institucion"].'</p>
                                </div>
                                <div>
                                    <h1 style="text-align:center;">SISTEMA DE PORTAFOLIO DOCENTE</h1>
                                    <h3 style="text-align:center; color: #3c4858;">GENERAR CONTRASEÑA</h3>
                                    <p style="font-size:1.0rem; color: #2A2C2B; margin-top: 2em; margin-bottom: 2em; margin-left: 1.5em;">
                            
                                        Hola '.$docente.', para poder generar tu contraseña, Haz click <a href="'.$datos_sistema['dominio_sistema'].'/admin/login/generar_acceso.php?data='.$id_docente.'">Aquí</a>.<br>
                                        
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
                                            <br> '. $datos_iest['nombre_institucion'].'
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
			alert('Correo enviado correctamente');
			window.location= '../usuarios_docentes.php'
			</script>
			";
        } catch (Exception $e) {
            echo "Error correo: {$mail->ErrorInfo}";
        }



?>