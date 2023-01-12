<?php
include '../include/verificar_sesion_secretaria.php';
include "../../include/conexion.php";
$id = 1;
$cod_modular = $_POST['cod_modular'];
$ruc = $_POST['ruc'];
$nombre = $_POST['nombre'];
$dep = $_POST['dep'];
$provincia = $_POST['provincia'];
$distrito = $_POST['distrito'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$resolucion = $_POST['resolucion'];

$consulta = "UPDATE datos_institucionales SET cod_modular='$cod_modular', ruc='$ruc', nombre_institucion='$nombre', departamento='$dep', provincia='$provincia', distrito='$distrito', direccion='$direccion', telefono='$telefono', correo='$email', nro_resolucion='$resolucion' WHERE id=$id";
$ejec_consulta = mysqli_query($conexion, $consulta);
	if ($ejec_consulta) {
			echo "<script>
					alert('Datos actualizados de manera Correcta');
					window.location= '../datos.php';
				</script>
			";
	}else {
			echo "<script>
					alert('Error al Actualizar Registro, por favor contacte con el administrador');
					window.history.back();
				</script>
			";
	}

mysqli_close($conexion);


?>

