<?php



// funciones para calificaciones --------------------------------------------------------

//funcion para calcular promedio de los criterios de evaluacion
function calc_criterios($conexion, $id_evaluacion)
{
    $b_criterio_evaluacion = buscarCriterioEvaluacionByEvaluacion($conexion, $id_evaluacion);
    $suma_criterios = 0;
    $cont_crit = 0;
    while ($r_b_criterio_evaluacion = mysqli_fetch_array($b_criterio_evaluacion)) {
        if (is_numeric($r_b_criterio_evaluacion['calificacion'])) {
            $suma_criterios += $r_b_criterio_evaluacion['calificacion'];
            $cont_crit += 1;
            //$suma_criterios += (($r_b_criterio_evaluacion['ponderado']/100)*$r_b_criterio_evaluacion['calificacion']);
        }
    }
    if ($cont_crit > 0) {
        $suma_criterios = round($suma_criterios / $cont_crit);
    } else {
        $suma_criterios = round($suma_criterios);
    }
    return $suma_criterios;
}

//funcion para calcular la la evaluacion(criterio de evaluacion) por ponderado
function calc_evaluacion($conexion, $id_calificacion)
{
    $suma_evaluacion = 0;

    $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $id_calificacion);
    while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
        $id_evaluacion = $r_b_evaluacion['id'];
        //buscamos los criterios de evaluacion
        $suma_criterios = calc_criterios($conexion, $id_evaluacion);

        if (is_numeric($r_b_evaluacion['ponderado'])) {
            $suma_evaluacion += ($r_b_evaluacion['ponderado'] / 100) * $suma_criterios;
        }
    }
    return round($suma_evaluacion);
}


//funcion para calcular la cantidad de ud desaprobadas de esrudiantes

function calc_ud_desaprobado($conexion, $id_est, $per_select, $id_pe, $id_sem)
{

    //buscar si estudiante esta matriculado en una unidad didactica
    $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);

    $cont_ud_desaprobadas = 0;
    while ($r_bb_ud = mysqli_fetch_array($b_ud_pe_sem)) {
        $id_udd = $r_bb_ud['id'];

        $b_prog_ud = buscarProgramacionByUd_Peridodo($conexion, $id_udd, $per_select);
        $r_b_prog_ud = mysqli_fetch_array($b_prog_ud);
        $id_prog = $r_b_prog_ud['id'];

        //buscar matricula de estudiante
        $b_mat_est = buscarMatriculaByEstudiantePeriodo($conexion, $id_est, $per_select);
        $r_b_mat_est = mysqli_fetch_array($b_mat_est);
        $id_mat_est = $r_b_mat_est['id'];
        //buscar detalle de matricula
        $b_det_mat_est = buscarDetalleMatriculaByIdMatriculaProgramacion($conexion, $id_mat_est, $id_prog);
        $r_b_det_mat_est = mysqli_fetch_array($b_det_mat_est);
        $cont_r_b_det_mat = mysqli_num_rows($b_det_mat_est);
        $id_det_mat = $r_b_det_mat_est['id'];
        if ($cont_r_b_det_mat > 0) {
            //echo "<td>SI</td>";

            //buscar las calificaciones
            $b_calificaciones = buscarCalificacionByIdDetalleMatricula($conexion, $id_det_mat);

            $suma_calificacion = 0;
            $cont_calif = 0;
            while ($r_b_calificacion = mysqli_fetch_array($b_calificaciones)) {

                $id_calificacion = $r_b_calificacion['id'];
                //buscamos las evaluaciones
                $suma_evaluacion = calc_evaluacion($conexion, $id_calificacion);

                $suma_calificacion += $suma_evaluacion;
                if ($suma_evaluacion > 0) {
                    $cont_calif += 1;
                }
            }
            if ($cont_calif > 0) {
                $calificacion = round($suma_calificacion / $cont_calif);
            } else {
                $calificacion = round($suma_calificacion);
            }
            if ($calificacion != 0) {
                $calificacion = round($calificacion);
            } else {
                $calificacion = "";
            }
            //buscamos si tiene recuperacion
            if ($r_b_det_mat_est['recuperacion'] != '') {
                $calificacion = $r_b_det_mat_est['recuperacion'];
            }

            if ($calificacion > 12) {
                //echo '<td align="center" ><font color="blue">' . $calificacion . '</font></td>';
            } else {
                //echo '<td align="center" ><font color="red">' . $calificacion . '</font></td>';
                $cont_ud_desaprobadas += 1;
            }
        } else {
            $calificacion = 0;
            //echo '<td></td>';
        }
    }
    return $cont_ud_desaprobadas;
}



// funcion para calcular si estudiante se matriculo a todas las ud del semestre (en caso de repitencia)

function calcular_mat_ud($conexion, $id_est, $per_select, $id_pe, $id_sem)
{
    //buscar si estudiante esta matriculado en una unidad didactica
    $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);
    $cant_ud_sem = mysqli_num_rows($b_ud_pe_sem);

    $cant_matt = 0;

    while ($r_bb_ud = mysqli_fetch_array($b_ud_pe_sem)) {
        $id_udd = $r_bb_ud['id'];

        $b_prog_ud = buscarProgramacionByUd_Peridodo($conexion, $id_udd, $per_select);
        $r_b_prog_ud = mysqli_fetch_array($b_prog_ud);
        $id_prog = $r_b_prog_ud['id'];

        //buscar matricula de estudiante
        $b_mat_est = buscarMatriculaByEstudiantePeriodo($conexion, $id_est, $per_select);
        $r_b_mat_est = mysqli_fetch_array($b_mat_est);
        $id_mat_est = $r_b_mat_est['id'];
        //buscar detalle de matricula
        $b_det_mat_est = buscarDetalleMatriculaByIdMatriculaProgramacion($conexion, $id_mat_est, $id_prog);
        $cont_r_b_det_mat = mysqli_num_rows($b_det_mat_est);
        
        if ($cont_r_b_det_mat > 0) {
            $cant_matt += 1;
        } else {
            
        }
        
    }

    if ($cant_ud_sem === $cant_matt) {
        return 1;
    }
    return 0;
   
   
}


/// FIN DE FUNCIONES DE CALIFICACIONES ------------------------------------------------------------
