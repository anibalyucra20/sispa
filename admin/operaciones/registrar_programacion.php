<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";
include '../include/busquedas.php';
include '../include/funciones.php';

$unidad_didactica = $_POST['unidad_didactica'];
$docente = $_POST['docente'];
$hoy = date("Y-m-d");

//buscar periodo actual
$busc_per_actual = buscarPresentePeriodoAcad($conexion);
$res_b_per_actual = mysqli_fetch_array($busc_per_actual);
$periodo_actual = $res_b_per_actual['id_periodo_acad'];

//verificar que el docente no este programado en la unidad didactica
$busc_programacion_existe = buscarProgramacionByUdDocentePeriodo($conexion, $unidad_didactica, $docente, $periodo_actual);
$conteo_b_programacion_existe = mysqli_num_rows($busc_programacion_existe);

if($conteo_b_programacion_existe < 1){

    $registro_programacion = realizar_programacion($conexion, $unidad_didactica, $periodo_actual, $docente);
    
    if ($registro_programacion) {
        echo "<script>
			alert('Programacion registrado correctamente');
			window.location= '../programacion.php'
		</script>
		";
    }else {
        echo "<script>
        alert('Error, falló en el registro');
        window.history.back();
    </script>
    ";
    }
    
}else{
    echo "<script>
			alert('Error, El Docente ya está Programado en la Unidad Didactica');
			window.history.back();
		</script>
		";
    
    
}


mysqli_close($conexion);

?>