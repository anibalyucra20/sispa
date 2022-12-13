<?php
include "../../../include/conexion.php";
include '../../include/busquedas.php';
$id_prog = $_POST['id_prog'];
$cant_as = $_POST['cant_as'];

$b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
    while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
        $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
        $r_b_matricula = mysqli_fetch_array($b_matricula);

        $b_estudiante = buscarEstudianteById($conexion,$r_b_matricula['id_estudiante']);
        $r_b_estudiante = mysqli_fetch_array($b_estudiante);

        $b_silabo = buscarSilaboByIdProgramacion($conexion, $id_prog);
        $r_b_silabo = mysqli_fetch_array($b_silabo);
        $b_prog_act = buscarProgActividadesSilaboByIdSilabo($conexion, $r_b_silabo['id']);
        while ($res_b_prog_act=mysqli_fetch_array($b_prog_act)) {
            // buscamos la sesion que corresponde
            $id_act = $res_b_prog_act['id'];
            $b_sesion = buscarSesionByIdProgramacionActividades($conexion, $id_act);
            $r_b_sesion = mysqli_fetch_array($b_sesion);
            $b_asistencia = buscarAsistenciaBySesionAndEstudiante($conexion, $r_b_sesion['id'], $r_b_matricula['id_estudiante']);
            $r_b_asistencia = mysqli_fetch_array($b_asistencia);
            $id_ass = $r_b_asistencia['id'];
            $asistencia = $_POST[$r_b_estudiante['dni']."_".$r_b_asistencia['id']];
            $consulta = "UPDATE asistencia SET asistencia='$asistencia' WHERE id='$id_ass'";   
            $ejec_consulta = mysqli_query($conexion, $consulta);                
                
        }
     
    }

echo "<script>
			window.location= '../asistencias.php?id=".$id_prog."';
		</script>
	";








?>

