<?php
include "../../../include/conexion.php";
include '../../include/busquedas.php';
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
/*

$b_calificacionn = buscarCalificacionById($conexion, $id_calificacionn);
$r_b_calificacionn = mysqli_fetch_array($b_calificacionn);
$b_det_matrr = buscarDetalleMatriculaById($conexion, $r_b_calificacionn['id_detalle_matricula']);
$r_b_det_matrr = mysqli_fetch_array($b_det_matrr);
$id_prog = $r_b_det_matrr['id_programacion_ud'];


$b_detalle_matricula = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
while ($r_b_det_mat = mysqli_fetch_array($b_detalle_matricula)) {
    $id_detalle_mat = $r_b_det_mat['id'];
    $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
    $r_b_mat = mysqli_fetch_array($b_matricula);
    $b_estudiante = buscarEstudianteById($conexion,$r_b_mat['id_estudiante']);
    $r_b_est = mysqli_fetch_array($b_estudiante);
    //echo $r_b_est['dni']." - ".$r_b_est['apellidos_nombres'];
    $b_calif = buscarCalificacionByIdDetalleMatricula($conexion, $id_detalle_mat);
    while ($r_b_calif = mysqli_fetch_array($b_calif)) {
        $id_calif = $r_b_calif['id'];
        $b_eva = buscarEvaluacionByIdCalificacion_detalle($conexion, $id_calif, $r_b_evaluacionn['detalle']);
        while ($r_b_eva = mysqli_fetch_array($b_eva)) {
            $id_eva = $r_b_eva['id'];
            $b_criterio_eva = buscarCriterioEvaluacionByEvaluacion($conexion, $id_eva);
            while ($r_b_criterio_eva = mysqli_fetch_array($b_criterio_eva)) {
                $id_criterio = $r_b_criterio_eva['id'];

                //recopilamos las calificaciones del formulario
                $res_nota = $_POST[$r_b_est['dni']."_".$id_criterio];
                if ((is_numeric($res_nota))&&($res_nota>=0 && $res_nota<=20)) {
                    if (($res_nota>=0 && $res_nota<10) && strlen($res_nota)==1) {
                    $calificacion = "0".$res_nota;
                    }else {
                    $calificacion = $res_nota;
                    }
                }else{
                    $calificacion = "";
                }
                //actualizamos las calificaciones
                echo $calificacion;
                echo $r_b_eva['detalle'];
                //$consulta = "UPDATE criterio_evaluacion SET calificacion='$calificacion' WHERE id_detalle_matricula='$id_detalle_mat' AND nro_calificacion='$i'";
            }
        }
    }



/*
    for ($i=1; $i <= $cant_calif ; $i++) {
        $res_nota = $_POST[$r_b_est['dni']."_".$i];
        if ((is_numeric($res_nota))&&($res_nota>=0 && $res_nota<=20)) {
            if (($res_nota>=0 && $res_nota<10) && strlen($res_nota)==1) {
                $calificacion = "0".$res_nota;
            }else {
                $calificacion = $res_nota;
            }
            //echo " - ".$calificacion;
        }else{
            $calificacion = "";
        }
        $consulta = "UPDATE calificaciones SET calificacion='$calificacion' WHERE id_detalle_matricula='$id_detalle_mat' AND nro_calificacion='$i'";
        $ejec_consulta = mysqli_query($conexion, $consulta);
        
    }
   
}
*/
echo "<script>
			window.location= '../evaluacion_b.php?data=".$id_prog."&data2=".$nro_calificacion."';
		</script>
	";








?>

