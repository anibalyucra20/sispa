<?php
include "../../../include/conexion.php";
$id = $_POST['id'];
$dni_a = $_POST['dni_a'];
$dni = $_POST['dni'];
$nom_ap = $_POST['ap_nom'];
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

//verificar que el dni solo este registrado en 1 carrera
$busc_est_car = "SELECT * FROM estudiante WHERE dni='$dni' AND id_programa_estudios='$carrera'";
$ejec_busc_est_car = mysqli_query($conexion, $busc_est_car);
$conteo = mysqli_num_rows($ejec_busc_est_car);
if(($dni_a <> $dni) && ($conteo == 0)){
    $sql = "UPDATE estudiante SET dni='$dni', apellidos_nombres='$nom_ap', id_genero='$genero', fecha_nac='$fecha_nac', direccion='$direccion', correo='$email', telefono='$telefono', anio_ingreso='$anio_ingreso', id_programa_estudios='$carrera', id_semestre='$semestre', seccion='$seccion', turno='$turno', id_condicion='$condicion', discapacidad='$discapacidad' WHERE id=$id";
    $ejec_consulta = mysqli_query($conexion, $sql);
    if ($ejec_consulta) {
        echo "<script>
			alert('Registro Actualizado de manera Correcta');
			window.location= '../estudiante.php';
		</script>
	";
    }else {
        echo "<script>
			alert('Error al Actualizar Registro, por favor contacte con el administrador');
			window.history.back();
		</script>
	";
    }

}elseif (($dni_a == $dni)) {
    $sql = "UPDATE estudiante SET dni='$dni', apellidos_nombres='$nom_ap', id_genero='$genero', fecha_nac='$fecha_nac', direccion='$direccion', correo='$email', telefono='$telefono', anio_ingreso='$anio_ingreso', id_programa_estudios='$carrera', id_semestre='$semestre', seccion='$seccion', turno='$turno', id_condicion='$condicion', discapacidad='$discapacidad' WHERE id=$id";
    $ejec_consulta = mysqli_query($conexion, $sql);
    if ($ejec_consulta) {
        echo "<script>
			alert('Registro Actualizado de manera Correcta');
			window.location= '../estudiante.php';
		</script>
	";
    }else {
        echo "<script>
			alert('Error al Actualizar Registro, por favor contacte con el administrador');
			window.history.back();
		</script>
	";
    }

}else{
    echo "<script>
    alert('Error, no se puede registrar el mismo estudiante mas de 1 vez');
    window.history.back();
</script>
";
}

mysqli_close($conexion);


?>

