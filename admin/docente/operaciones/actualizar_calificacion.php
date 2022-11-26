<?php
include "../../../include/conexion.php";
include '../../include/busquedas.php';
$id_prog = $_POST['id_prog'];
$cant_calif = $_POST['cant_calif'];

$b_detalle_matricula = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
while ($r_b_det_mat = mysqli_fetch_array($b_detalle_matricula)) {
    $id_detalle_mat = $r_b_det_mat['id'];
    $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
    $r_b_mat = mysqli_fetch_array($b_matricula);
    $b_estudiante = buscarEstudianteById($conexion,$r_b_mat['id_estudiante']);
    $r_b_est = mysqli_fetch_array($b_estudiante);
    //echo $r_b_est['dni']." - ".$r_b_est['apellidos_nombres'];
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
echo "<script>
			
			window.location= '../calificaciones.php?id=".$id_prog."';
		</script>
	";








?>

