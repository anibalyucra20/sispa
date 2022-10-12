<?php
include "../../include/conexion.php";

$email = $_POST['email'];
$password = $_POST['password'];
$dni = $_POST['dni'];
$nom_ap = $_POST['nombres'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$hoy = date("Y-m-d");
$sexo = 3; //se coloca 3 por que es un sexo sin especificar en la base de datos
$tipo_persona = 4; //se coloca 4 porque es el tipo invitado en la base de datos

$consulta_validacion = "SELECT * FROM personas WHERE dni='$dni'";
$resultado_con_valid = mysqli_query($conexion, $consulta_validacion);
$total_res = mysqli_num_rows($resultado_con_valid);
if ($total_res > 0) {
	echo "<script>
                alert('Ya existe un Usuario Registrado con los datos Ingresados');
                window.location= '../login/'
    </script>";
}else{
	$consulta_validacion_email = "SELECT * FROM usuarios WHERE correo='$email'";
	$resultado_con_valid_email = mysqli_query($conexion, $consulta_validacion_email);
	$total_res_email = mysqli_num_rows($resultado_con_valid_email);
	if ($total_res_email > 0) {
		echo "<script>
                alert('Ya existe un Usuario Registrado el Correo Ingresado');
                window.location= '../login/'
    </script>";
	}else{
	$sql = "INSERT INTO personas (dni, apellidos_nombres, direccion, telefono, fecha_nac, id_sexo, id_tipo_persona, fecha_registro)
	VALUES ('$dni','$nom_ap','$direccion','$telefono','','$sexo','$tipo_persona','$hoy')";

	$ejecutar = mysqli_query($conexion, $sql);
		if ($ejecutar) {
			header('Location: create_user.php?email='.$email."&pass=".$password."&dni=".$dni."");
		}else{
			echo "<script>
                alert('Error al registrar usuario, Intente Nuevamente');
                window.location= 'crearcuenta.php'
    		</script>";
		};
	};
};


?>