<?php
include "../../include/conexion.php";
include "../include/busquedas.php";

$id = $_POST['data'];
$password = $_POST['password'];
$dni = $_POST['dni'];
// validar si el docente ya tiene usuario
$busc_usu_doc = buscarUsuarioDocenteById($conexion, $id);
$cont_busc_usu_doc = mysqli_num_rows($busc_usu_doc);

if ($cont_busc_usu_doc == 0) {
	$busc_doc = buscarDocenteByDni($conexion, $dni);
	$cont_b_doc = mysqli_num_rows($busc_doc);
	if ($cont_b_doc > 0) {
		$pass_secure = password_hash($password, PASSWORD_DEFAULT);
		$crear_user = "INSERT INTO usuarios_docentes (id_docente, usuario, password) VALUES ('$id', '$dni', '$pass_secure')";
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
}else{
	echo "<script>
                alert('Ud. Ya cuenta con una cuenta, por favor contacte con el administrador');
                window.location= '../login/'
    </script>";
}


?>