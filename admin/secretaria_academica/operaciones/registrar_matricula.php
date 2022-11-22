<?php
session_start();
include "../../../include/conexion.php";
include '../../include/busquedas.php';

$id_periodo_acad = $_SESSION['periodo'];
$id_est = $_POST['id_est'];
$carrera = $_POST['carrera_m'];
$semestre = $_POST['semestre'];
$hoy = date("Y-m-d");
$detalle_matricula = explode(",", $_POST['mat_relacion']);

//VERIFICAMOS QUE EL ESTUDIANTE NO ESTE MATRICULADO EN ESTE PERIODO
$busc_matricula = buscarMatriculaByEstudiantePeriodo($conexion, $id_est, $id_periodo_acad);
$cont_b_matricula = mysqli_num_rows($busc_matricula);

if ($cont_b_matricula>0) {
    echo "<script>
			alert('El estudiante ya esta matriculado en este periodo Académico');
			window.history.back();
		</script>
		";
}else{

//REGISTRAMOS LA MATRICULA
$reg_matricula = "INSERT INTO matricula (id_periodo_acad, id_programa_estudio, id_semestre, id_estudiante, fecha_reg) VALUES ('$id_periodo_acad','$carrera','$semestre','$id_est','$hoy')";
$ejecutar_reg_matricula = mysqli_query($conexion, $reg_matricula);

//buscamos el ultimo registro de la matricula
$id_matricula = mysqli_insert_id($conexion);

//recorremos el array del detalle para buscar datos complementarios y registrar el detalle y las calificaciones
foreach ($detalle_matricula as $valor) {
    //buscaremos el id de la unidad didactica en la programacion de unidades didacticas
    $busc_prog = buscarProgramacionById($conexion, $valor);
    $res_b_prog = mysqli_fetch_array($busc_prog);
    $id_ud = $res_b_prog['id_unidad_didactica'];

    //REGISTRAMOS EL DETALLE DE LA MATRICULA
    $reg_det_mat =  "INSERT INTO detalle_matricula_unidad_didactica (id_matricula, id_programacion_ud) VALUES ('$id_matricula','$valor')";
    $ejecutar_reg_det_mat = mysqli_query($conexion, $reg_det_mat);

    //buscamos el ultimo registro de detalle matricula
    $id_detalle_matricula = mysqli_insert_id($conexion);

    //creamos array para almacenar las capacidades de las unidades didacticas
    $list_capacidades = array();
    //buscamos la capacidad de la unidad didactica
    $busc_capacidad = buscarCapacidadesByIdUd($conexion, $id_ud);
    
    $orden = 1; //orden en el que inicia las calificaciones
    while ($res_b_capacidad = mysqli_fetch_array($busc_capacidad)) {
        $id_capacidad = $res_b_capacidad['id'];
        $list_capacidades[] = $id_capacidad;
        
        // buscar indicadores de logro de capacidad para saber cuantos calificaciones crearemos
        $b_indicador = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id_capacidad);
        $cont_ind = mysqli_num_rows($b_indicador);
        
        while ($res_b_capacidad = mysqli_fetch_array($b_indicador)) {
            //REGISTRAMOS LAS CALIFICACION SEGUN LA CANTIDAD DE INDICADORES DE LOGRO
            $reg_calificacion = "INSERT INTO calificaciones (id_detalle_matricula, nro_calificacion) VALUES ('$id_detalle_matricula','$orden')";
            $ejecutar_reg_calificacion = mysqli_query($conexion, $reg_calificacion);
            $orden = $orden+1;
        }
    }
    if (!$ejecutar_reg_det_mat) {
        echo "<script>
			alert('El estudiante ya esta matriculado en este periodo Académico');
			window.history.back();
		</script>
		";
    }
    

    echo "<script>
                window.location= '../matricula.php'
    			</script>";

    
}

}




?>