<?php
include "../../../include/conexion.php";

$dni = $_POST['dni'];
$nom_ap = $_POST['nom_ap'];
$genero = $_POST['genero'];
$fecha_nac = $_POST['fecha_nac'];
$direccion = $_POST['direccion'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$anio_ingreso = $_POST['anio_ingreso'];
$carrera = $_POST['carrera'];
$semestre = $_POST['semestre'];
$seccion = $_POST['seccion'];
$turno = $_POST['turno'];
$condicion = $_POST['condicion'];
$discapacidad = $_POST['discapacidad'];

//verificar si el estudiante ya esta registrado
	$busc_est_car = "SELECT * FROM estudiante WHERE dni='$dni' AND id_programa_estudios='$carrera'";
	$ejec_busc_est_car = mysqli_query($conexion, $busc_est_car);
	$conteo = mysqli_num_rows($ejec_busc_est_car);
if ($conteo > 0) {
		echo "<script>
			alert('El estudiante, ya esta registrado para esta carrera');
			window.history.back();
				</script>
			";
	}else{

	$insertar = "INSERT INTO estudiante (dni, apellidos_nombres, id_genero, fecha_nac, direccion, correo, telefono, anio_ingreso, id_programa_estudios, id_semestre, seccion, turno, id_condicion, discapacidad) VALUES ('$dni','$nom_ap','$genero', '$fecha_nac', '$direccion', '$email', '$telefono', '$anio_ingreso', '$carrera', '$semestre', '$seccion', '$turno', '$condicion', '$discapacidad')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
		//buscaremos el id del ultimo estudiante registrado para poder crear su usuario y contraseña
		$busc_ult_est = "SELECT * FROM estudiante WHERE dni='$dni' AND id_programa_estudios='$carrera'";
		$ejec_busc_ult_est = mysqli_query($conexion, $busc_ult_est);
		$res_busc_ult_est = mysqli_fetch_array($ejec_busc_ult_est);
		$id_ult_est = $res_busc_ult_est['id'];

		$pass = $dni."@huanta";
		$pass_secure = password_hash($pass, PASSWORD_DEFAULT);
		$crear_user = "INSERT INTO usuarios_estudiante (id_estudiante, usuario, password) VALUES ('$id_ult_est', '$dni', '$pass_secure')";
		$ejec_crear_user = mysqli_query($conexion, $crear_user);
		if ($ejec_crear_user) {
			echo "<script>
                alert('Registro Existoso');
                window.location= '../estudiante.php'
    			</script>";
		}else{
			echo "<script>
			alert('Error al Registrar estudiante, por favor contacte al administrador');
			window.history.back();
				</script>
			";
		}
			
	}else{
		echo "<script>
			alert('Error al registrar estudiante, por favor verifique sus datos');
			window.history.back();
				</script>
			";
	};

};




mysqli_close($conexion);

?>