<?php
include 'include/verificar_sesion_docente.php';
include '../include/conexion.php';
include 'include/busquedas.php';

$id_prog = $_POST['data'];
$b_prog = buscarProgramacionById($conexion, $id_prog);
$res_b_prog = mysqli_fetch_array($b_prog);
if (!($res_b_prog['id_docente']==$_SESSION['id_docente'])) {
    //echo "<h1 align='center'>No tiene acceso a la evaluacion de la Unidad Didáctica</h1>";
    //echo "<br><h2><center><a href='javascript:history.back(-1);'>Regresar</a></center></h2>";
    echo "<script>
			alert('Error Usted no cuenta con los permisos para acceder a la Página Solicitada');
			window.close();
		</script>
	";
}else {
    header ("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
    header ("Content-Disposition: attachment; filename=plantilla.xls");
?>
<table border="1">
    <tr>
        <th>NRO</th>
        <th>CÓDIGO ALUMNO</th>
        <th>ALUMNO</th>
        <th>NOTA</th>
    </tr>
    <?php
        $b_det_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
        $ord = 1;
        while ($r_b_det_mat = mysqli_fetch_array($b_det_mat)) {
            $id_mat = $r_b_det_mat['id_matricula'];
            $b_mat = buscarMatriculaById($conexion, $id_mat);
            $r_b_mat = mysqli_fetch_array($b_mat);
            $id_est = $r_b_mat['id_estudiante'];
            $b_est = buscarEstudianteById($conexion,$id_est);
            $r_b_est = mysqli_fetch_array($b_est);
            
            $b_calif = buscarCalificacionByIdDetalleMatricula($conexion, $r_b_det_mat['id']);
            $suma_calificacion = 0;
            while ($r_b_calif = mysqli_fetch_array($b_calif)) {
                
                $b_eva = buscarEvaluacionByIdCalificacion($conexion, $r_b_calif['id']);
                $suma_evaluacion = 0;
                while ($r_b_eva = mysqli_fetch_array($b_eva )) {
                    $b_crit_eva = buscarCriterioEvaluacionByEvaluacion($conexion, $r_b_eva['id']);
                    $suma_criterios = 0;
                    $cont_crit = 0;
                    while ($r_b_crit = mysqli_fetch_array($b_crit_eva)) {
                        if (is_numeric($r_b_crit['calificacion'])) {
                            $suma_criterios += $r_b_crit['calificacion'];
                            $cont_crit += 1;
                        }
                    }
                    if ($cont_crit>0) {
                        $suma_criterios = round($suma_criterios/$cont_crit);
                    }else {
                        $suma_criterios = round($suma_criterios);
                    }
                    $suma_evaluacion += ($r_b_eva['ponderado']/100)*$suma_criterios;
                }
                $suma_calificacion += ($r_b_calif['ponderado']/100)*$suma_evaluacion;
                
            }
            if ($suma_calificacion != 0) {
                $calificacion = round($suma_calificacion);
            }else {
                $calificacion = "";
            }
                ?>
                <tr>
                    <td><?php echo $ord; ?></td>
                    <td><?php echo $r_b_est['dni']; ?></td>
                    <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                    <td><?php echo $calificacion; ?></td>
                </tr>
                <?php
            $ord+=1;
        }
        
        ?>
    
</table>

<?php
}
?>
