<?php



// funciones para calificaciones --------------------------------------------------------

//funcion para calcular promedio de los criterios de evaluacion
function calc_criterios($conexion, $id_evaluacion)
{
}

//funcion para calcular la la evaluacion(criterio de evaluacion) por ponderado
function calc_evaluacion($conexion, $id_calificacion)
{
}

//funcion para calcular el promedio final

function calc_calificacion($conexion, $id_det_mat)
{
    $b_calificaciones = buscarCalificacionByIdDetalleMatricula($conexion, $id_det_mat);
    $suma_calificacion = 0;
    $cont_calif = 0;
    while ($r_b_calificacion = mysqli_fetch_array($b_calificaciones)) {
        $id_calificacion = $r_b_calificacion['id'];
        //buscamos las evaluaciones
        $suma_evaluacion = 0;

        $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $id_calificacion);
        while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
            $id_evaluacion = $r_b_evaluacion['id'];
            //buscamos los criterios de evaluacion
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

            if (is_numeric($r_b_evaluacion['ponderado'])) {
                $suma_evaluacion += ($r_b_evaluacion['ponderado'] / 100) * $suma_criterios;
            }
        }
        $suma_calificacion += $suma_evaluacion;
        if ($suma_evaluacion > 0) {
            $cont_calif += 1;
        }



        if ($suma_evaluacion != 0) {
            $calificacion = round($suma_evaluacion);
        } else {
            $calificacion = "";
        }
        if ($calificacion > 12) {
            echo '<td><center><font color="blue">' . $calificacion . '</font></center></td>';
            //echo '<td><center><input type="number" class="nota_input" style="color:blue;" value="' . $calificacion . '" min="0" max="20" disabled></center></td>';
        } else {
            echo '<td><center><font color="red">' . $calificacion . '</font></center></td>';
            //echo '<td><center><input type="number" class="nota_input" style="color:red;" value="' . $calificacion . '" min="0" max="20" disabled></center></td>';
        }
    }
    if ($cont_calif > 0) {
        $suma_calificacion = round($suma_calificacion / $cont_calif);
    } else {
        $suma_calificacion = round($suma_calificacion);
    }
    return $suma_calificacion;
}

/// FIN DE FUNCIONES DE CALIFICACIONES ------------------------------------------------------------