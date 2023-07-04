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
    return $suma_evaluacion;
}

//funcion para calcular el promedio final

function calc_calificacion($conexion, $id_det_mat)
{
}

/// FIN DE FUNCIONES DE CALIFICACIONES ------------------------------------------------------------