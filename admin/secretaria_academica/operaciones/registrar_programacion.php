<?php
include "../../../include/conexion.php";
include '../../include/busquedas.php';

$unidad_didactica = $_POST['unidad_didactica'];
$docente = $_POST['docente'];
$cantidad = $_POST['cantidad'];

//buscar periodo actual
$busc_per_actual = buscarPresentePeriodoAcad($conexion);
$res_b_per_actual = mysqli_fetch_array($busc_per_actual);
$periodo_actual = $res_b_per_actual['id_periodo_acad'];

//verificar que el docente no este programado en la unidad didactica
$busc_programacion_existe = buscarProgramacionByUdDocentePeriodo($conexion, $unidad_didactica, $docente, $periodo_actual);
$conteo_b_programacion_existe = mysqli_num_rows($busc_programacion_existe);

if($conteo_b_programacion_existe > 0){
    echo "<script>
			alert('Error, El Docente ya está Programado en la Unidad Didactica');
			window.history.back();
				</script>
			";
}else{
    $consulta = "INSERT INTO programacion_unidad_didactica (id_unidad_didactica, id_docente, id_periodo_acad, cant_calificacion) VALUES ('$unidad_didactica','$docente','$periodo_actual','$cantidad')";
    $ejecutar_insertar = mysqli_query($conexion, $consulta);

    
    //buscamos el id de la programacion hecha
    $busc_ult_prog = buscarProgramacionByUdDocentePeriodo($conexion, $unidad_didactica, $docente, $periodo_actual);
    $res_b_ult_prog = mysqli_fetch_array($busc_ult_prog);
    $id_programacion = $res_b_ult_prog['id'];
    //crear silabo de la programacion hecha
    $reg_silabo = "INSERT INTO silabo (id_programacion_unidad_didactica) VALUES ('$id_programacion')";
    $ejec_reg_silabo = mysqli_query($conexion, $reg_silabo);



    //buscamos el id del silabo registrado mediante el id de la programacion
    $busc_silabo = buscarSilaboByIdProgramacion($conexion, $id_programacion);
    $res_b_ult_silabo = mysqli_fetch_array($busc_silabo);
    $id_silabo = $res_b_ult_silabo['id'];

    //buscamos los indicadores de logro de la unidad didactica para evitar hacer 16 busquedas lo hacemos antes del loop for
    $busc_logro_capacidad = buscarCapacidadesByIdUd($conexion, $unidad_didactica);
    $res_b_logro_capacidad = mysqli_fetch_array($busc_logro_capacidad);
    $id_capacidad = $res_b_logro_capacidad['id'];
    $id_competencia = $res_b_logro_capacidad['id_competencia'];
    $busc_ind_logro_capacidad = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id_capacidad);
    $res_b_i_logro_capacidad = mysqli_fetch_array($busc_ind_logro_capacidad);
    $id_ind_logro_capacidad = $res_b_i_logro_capacidad['id']; // id indicador logro de capacidad
    $busc_ind_logro_competencia = buscarIndicadorLogroCompetenciasByIdCompetencia($conexion, $id_competencia);
    $res_b_i_logro_competencia = mysqli_fetch_array($busc_ind_logro_competencia);
    $id_ind_logro_competencia = $res_b_i_logro_competencia['id']; // id indicador logro competencia
    //crear la programacion del silabo por 16 semanas de clase - 16 sesiones
    for ($i=1; $i <=16 ; $i++) { 
        $reg_prog_act_silabo = "INSERT INTO programacion_actividades_silabo (id_silabo, semana) VALUES ('$id_programacion', '$i')";
        $ejec_reg_prog_act_silabo = mysqli_query($conexion, $reg_prog_act_silabo);
        //buscamos el id de lo ingresado para registrar la siguiente tabla
        $busc_prog_act_silabo = buscarProgActividadesSilaboByIdSilabo($conexion, $id_silabo);
        $res_b_prog_act_silabo = mysqli_fetch_array($busc_prog_act_silabo);
        $id_prog_act_silabo = $res_b_prog_act_silabo['id'];
        //procedemos a registrar la tabla sesion_aprendizaje-- 1 para cada tabla anterior
        $reg_sesion_aprendizaje = "INSERT INTO sesion_aprendizaje (id_programacion_actividad_silabo, id_ind_logro_competencia_vinculado, id_ind_logro_capacidad_vinculado) VALUES ('$id_prog_act_silabo', '$id_ind_logro_competencia', '$id_ind_logro_capacidad')";
        $ejec_reg_prog_act_silabo = mysqli_query($conexion, $reg_prog_act_silabo);

        //buscamos el id de la anterior tabla para hacer registros en las siguientes tablas
        $busc_sesion = buscarSesionByIdProgramacionActividades($conexion, $id_prog_act_silabo);
        $res_busc_sesion = mysqli_fetch_array($busc_sesion);
        $id_sesion = $res_busc_sesion['id'];

        //crearemos los momentos de la sesion 3 por cada sesion Inicio, Desarrollo y cierre
        for ($i=1; $i <= 3; $i++) { 
            if($i==1){$momento="Inicio";}
            if($i==2){$momento="Desarrollo";}
            if($i==3){$momento="Cierre";}
            // momentos de la sesion
            $reg_momentos_sesion = "INSERT INTO momentos_sesion_aprendizaje (id_sesion_aprendizaje, momento) VALUES ('$id_sesion', '$momento')";
            $ejec_reg_momentos_sesion = mysqli_query($conexion, $reg_momentos_sesion);
            // actividad de evaluacion en la sesion
            $reg_act_eva = "INSERT INTO actividad_evaluacion_sesion_aprendizaje (id_sesion_aprendizaje, momento) VALUES ('$id_sesion', '$momento')";
            $ejec_reg_act_eva = mysqli_query($conexion, $reg_act_eva);
        }
        if ($ejec_reg_act_eva) {
            echo "<script>
            
                window.location= '../programacion.php'
                </script>";
        }else{
        echo "<script>
            alert('Error al registrar, por favor verifique sus datos');
            window.history.back();
                </script>
            ";
        };
    }





    
}



mysqli_close($conexion);

?>