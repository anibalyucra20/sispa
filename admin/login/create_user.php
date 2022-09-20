<?php
include ("../include/conexion.php");

$email = $_GET['email'];
$password = $_GET['pass'];
$dni = $_GET['dni'];
$hoy = date("Y-m-d");

$lectura = "SELECT * FROM personas ORDER BY id DESC LIMIT 1";
$ejecutar = mysqli_query($conexion, $lectura);

while ($dato=mysqli_fetch_array($ejecutar)) {
	$dato_id = $dato['id'];
	$dato_dni = $dato['dni'];
	$dato_f_reg = $dato['fecha_registro'];
};
if ($dni == $dato_dni and $dato_f_reg == $hoy) {
	$reg_user = "INSERT INTO usuarios (correo, password, id_persona, fecha_registro) VALUES ('$email','$password','$dato_id','$hoy')";
	$ejecutar_reg_user = mysqli_query($conexion, $reg_user);
	if ($ejecutar_reg_user) {
		echo "<script>
                alert('Registro correcto, Por favor Inicie Sesion');
                window.location= '../login/'
    </script>";
	}else{
		echo "<script>
                alert('Fallo al Registrar usuario, contacte al administrador');
                window.location= '../login/'
    </script>";
	};
}else{
	echo "<script>
                alert('Error al registrar usuario, contacte al administrador');
                window.location= '../login/'
    </script>";
};
?>