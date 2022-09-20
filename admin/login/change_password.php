<?php
include ("../include/conexion.php");
$id_persona = $_POST['id'];
$new_password = $_POST['new_password'];
//procedemos a actualizar el password utilizando el id de usuario
$update_pass = "UPDATE usuarios SET password='$new_password' WHERE id_persona='$id_persona'";
$ejec_update_pass = mysqli_query($conexion, $update_pass);
if ($ejec_update_pass) {
	echo "<script>
			alert('Contraseña actualizado correctamente, Por favor Inicie Sesión');
			window.location= '../login/'
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