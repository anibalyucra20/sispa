<?php
include "../../../include/conexion.php";
include '../../include/busquedas.php';

$id_prog = $_POST['id_prog'];



$b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
    $b_calificacion = buscarCalificacionByIdDetalleMatricula($conexion, $r_b_det_mat['id']);
    $count = 1;
while ($r_b_calificacion = mysqli_fetch_array($b_calificacion)) {
        $id = $r_b_calificacion['id'];
        $dato = $_POST['ponderad_'.$count];
        $consulta = "UPDATE calificaciones SET ponderado='$dato' WHERE id='$id'";
        $ejec_consulta = mysqli_query($conexion, $consulta);
        $count +=1;
    
}
}


echo "<script>
			window.location= '../calificaciones.php?id=".$id_prog."';
		</script>
	";




?>