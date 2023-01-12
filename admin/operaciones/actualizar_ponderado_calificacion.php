<?php
include '../include/verificar_sesion_docente_operaciones.php';
include "../../include/conexion.php";
include '../include/busquedas.php';

$id_prog = $_POST['id_prog'];



$b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
    $b_calificacion = buscarCalificacionByIdDetalleMatricula($conexion, $r_b_det_mat['id']);
    $count = 1;
    while ($r_b_calificacion = mysqli_fetch_array($b_calificacion)) {
        $id = $r_b_calificacion['id'];
        $dato = $_POST['ponderad_'.$count];
        if (is_numeric($dato)) {
            $consulta = "UPDATE calificaciones SET ponderado='$dato' WHERE id='$id'";
            $ejec_consulta = mysqli_query($conexion, $consulta);
            $count +=1;
        }
    }
    if (isset($_POST['recuperacion_'.$r_b_det_mat['id']])) {
        $recuperacion = $_POST['recuperacion_'.$r_b_det_mat['id']];
        
            $id_det_mat = $r_b_det_mat['id'];
            $act_recuperacion = "UPDATE detalle_matricula_unidad_didactica SET recuperacion='$recuperacion' WHERE id='$id_det_mat'";
            $ejec_act_recuperacion = mysqli_query($conexion, $act_recuperacion);
        
        
    }

}


echo "<script>
			window.location= '../calificaciones.php?id=".$id_prog."';
		</script>
	";
    ?>