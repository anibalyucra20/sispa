<?php
include "../../include/conexion.php";
include "../include/busquedas.php";

$id = $_POST['data'];
$password = $_POST['password'];
$dni = $_POST['dni'];

	$busc_doc = buscarDocenteById($conexion, $id);
	$cont_b_doc = mysqli_num_rows($busc_doc);
	$res_b_docc = mysqli_fetch_array($busc_doc);
	if ($res_b_docc['dni']==$dni) {
		$pass_secure = password_hash($password, PASSWORD_DEFAULT);
		$crear_user = "UPDATE docente SET password='$pass_secure' WHERE id=$id";
		$ejec_crear_user = mysqli_query($conexion, $crear_user);
		if ($ejec_crear_user) {
			echo "<script>
				alert('Registro exitoso, por favor Inicie Sesión');
				window.location= '../login/'
				</script>";
		}else{
			echo "<script>
				alert('Error al Registrar Usuario, por favor contacte al administrador');
				window.history.back();
				</script>
			";
	}
	}else{
		echo "<script>
				alert('Error, el DNI no coincide con el registro');
				window.history.back();
				</script>
			";
	}


?>