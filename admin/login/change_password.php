<?php
include ("../../include/conexion.php");
$id_persona = $_POST['id'];
$pass = $_POST['new_password'];
$pass_secure = password_hash($pass, PASSWORD_DEFAULT);
//procedemos a actualizar el password utilizando el id de usuario
$update_pass = "UPDATE docente SET password='$pass_secure', reset_password='0' WHERE id='$id_persona'";
$ejec_update_pass = mysqli_query($conexion, $update_pass);
if ($ejec_update_pass) {
	echo "<script>
			alert('Contraseña actualizado correctamente, Por favor Inicie Sesión');
			window.location= '../login/';
		</script>
	";
}else{
	echo "<script>
			alert('Error al actualizar contraseña, Intente de Nuevo');
			window.history.back();
		</script>
	";
}
?>