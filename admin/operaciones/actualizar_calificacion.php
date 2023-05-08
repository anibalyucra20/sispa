<?php
include '../include/verificar_sesion_docente_coordinador_secretaria_operaciones.php';
include "../../include/conexion.php";
include '../include/busquedas.php';
$id_prog = $_POST['id_prog'];
$nro_calificacion = $_POST['nro_calificacion'];


$b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
    $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
    $r_b_mat = mysqli_fetch_array($b_matricula);
    $b_estudiante = buscarEstudianteById($conexion,$r_b_mat['id_estudiante']);
    $r_b_est = mysqli_fetch_array($b_estudiante);

    $b_calificacion = buscarCalificacionByIdDetalleMatricula_nro($conexion, $r_b_det_mat['id'], $nro_calificacion);
    while ($r_b_calificacion = mysqli_fetch_array($b_calificacion)) {
        $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $r_b_calificacion['id']);
        while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
            $b_criterio_evaluacion = buscarCriterioEvaluacionByEvaluacion($conexion, $r_b_evaluacion['id']);
            
         
            while ($r_b_criterio_evaluacion = mysqli_fetch_array($b_criterio_evaluacion)) {
                $nota =  $_POST[$r_b_est['dni'].'_'.$r_b_criterio_evaluacion['id']];
                if ((is_numeric($nota))&&($nota>=0 && $nota<=20)) {
                    if (($nota>=0 && $nota<10) && strlen($nota)==1) {
                    $calificacion = "0".$nota;
                    }else {
                    $calificacion = $nota;
                    }
                }else{
                    $calificacion = "";
                }
                $id_crit = $r_b_criterio_evaluacion['id'];
                $consulta = "UPDATE criterio_evaluacion SET calificacion='$calificacion' WHERE id='$id_crit'";
                $ejec_consulta = mysqli_query($conexion, $consulta);
              
            }
        }
    }
    
}

echo "<script>
			window.location= '../evaluacion_b.php?data=".$id_prog."&data2=".$nro_calificacion."';
		</script>
	";








?>

