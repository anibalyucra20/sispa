<?php
include "../../../include/conexion.php";
include '../../include/busquedas.php';

$unidad_didactica = $_POST['unidad_didactica'];
$docente = $_POST['docente'];
$cantidad = $_POST['cantidad'];

//buscar periodo actual
$busc_per_actual = buscarPresentePeriodoAcad($conexion);
$res_b_per_actual = mysqli_fetch_array($busc_per_actual);
$periodo_actual = $res_b_per_actual['id_periodo_acad'];

//verificar que el docente no este programado en la unidad didactica
$busc_programacion_existe = buscarProgramacionByUdDocentePeriodo($conexion, $unidad_didactica, $docente, $periodo_actual);
$conteo_b_programacion_existe = mysqli_num_rows($busc_programacion_existe);

if($conteo_b_programacion_existe > 0){
    echo "<script>
			alert('Error, El Docente ya está Programado en la Unidad Didactica');
			window.history.back();
				</script>
			";
}else{
    $consulta = "INSERT INTO programacion_unidad_didactica (id_unidad_didactica, id_docente, id_periodo_acad, cant_calificacion) VALUES ('$unidad_didactica','$docente','$periodo_actual','$cantidad')";
    $ejecutar_insertar = mysqli_query($conexion, $consulta);

    
    //buscamos el id de la programacion hecha
    $busc_ult_prog = buscarProgramacionByUdDocentePeriodo($conexion, $unidad_didactica, $docente, $periodo_actual);
    $res_b_ult_prog = mysqli_fetch_array($busc_ult_prog);
    $id_programacion = $res_b_ult_prog['id'];

    //crear silabo de la programacion hecha
    $reg_silabo = "INSERT INTO silabo (id_programacion_unidad_didactica) VALUES ('$id_programacion')";
    $ejec_reg_silabo = mysqli_fetch_array($reg_silabo);







    if ($ejec_reg_silabo) {
        echo "<script>
        
            window.location= '../programacion.php'
            </script>";
    }else{
    echo "<script>
        alert('Error al registrar, por favor verifique sus datos');
        window.history.back();
            </script>
        ";
    };
}



mysqli_close($conexion);

?>