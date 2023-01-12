<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";
include '../include/busquedas.php';

$unidad_didactica = $_POST['unidad_didactica'];
$docente = $_POST['docente'];
$hoy = date("Y-m-d");

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
    $consulta = "INSERT INTO programacion_unidad_didactica (id_unidad_didactica, id_docente, id_periodo_acad) VALUES ('$unidad_didactica','$docente','$periodo_actual')";
    $ejecutar_insertar = mysqli_query($conexion, $consulta);
    //buscamos el id de la programacion hecha
    $id_programacion = mysqli_insert_id($conexion);
    //crear silabo de la programacion hecha
    $metodologia = "Deductivo,Analítico,Aprendizaje basado en competencias";
    $recursos_didacticos = "Libros digitales,Foros,Chats,Video Tutoriales,Wikis,Videos explicativos";
    $sistema_evaluacion = "* La escala de calificación es vigesimal y el calificativo mínimo aprobatorio es trece (13). En todos los casos la fracción 0.5 o más se considera como una unidad a favor del estudiante.
    * El estudiante que en la evaluación de una o más Capacidades Terminales programadas en la Unidad Didáctica (Asignaturas), obtenga nota desaprobatoria entre diez (10) y doce (12), tiene derecho a participar en el proceso de recuperación programado.
    * El estudiante que después de realizado el proceso de recuperación obtuviera nota menor a trece (13), en una o más capacidades terminales de una Unidad Didáctica, desaprueba la misma, por tanto, repite la Unidad Didáctica.
    * El estudiante que acumulará inasistencias injustificadas en número igual o mayor al 30% del total de horas programadas en la Unidad Didáctica, será desaprobado en forma automática, sin derecho a recuperación.";
    $indicadores_evaluacion = "Identificación o reconocimiento del tema tratado, Valoración del dominio de los nuevos temas tratados, Capacidad de Resumen, Participación y contribución en clase, Capacidad para el trabajo en equipo";
    $tecnicas_evaluacion = "Observación,Exposición,Pruebas escritas,Estudio de caso,El debate,Exposición oral,Guías";

    $reg_silabo = "INSERT INTO silabo (id_programacion_unidad_didactica, horario, metodologia, recursos_didacticos, sistema_evaluacion, estrategia_evaluacion_indicadores, estrategia_evaluacion_tecnica, promedio_indicadores_logro, recursos_bibliograficos_impresos, recursos_bibliograficos_digitales) VALUES ('$id_programacion',' ','$metodologia','$recursos_didacticos','$sistema_evaluacion','$indicadores_evaluacion','$tecnicas_evaluacion',' ',' ',' ')";
    $ejec_reg_silabo = mysqli_query($conexion, $reg_silabo);
    if (!$ejec_reg_silabo) {
        echo "<script>
			alert('Error al Registrar Silabo');
			window.history.back();
		</script>
		";
    }

    //buscamos el id del silabo registrado mediante el id de la programacion
    $id_silabo = mysqli_insert_id($conexion);

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
        $reg_prog_act_silabo = "INSERT INTO programacion_actividades_silabo (id_silabo, semana, fecha, elemento_capacidad, actividades_aprendizaje, contenidos_basicos, tareas_previas) VALUES ('$id_silabo', '$i', '$hoy',' ',' ',' ',' ')";
        $ejec_reg_prog_act_silabo = mysqli_query($conexion, $reg_prog_act_silabo);
        
        //buscamos el id de lo ingresado para registrar la siguiente tabla
        $id_prog_act_silabo = mysqli_insert_id($conexion);
        
        //procedemos a registrar la tabla sesion_aprendizaje-- 1 para cada tabla anterior
        $reg_sesion_aprendizaje = "INSERT INTO sesion_aprendizaje (id_programacion_actividad_silabo, tipo_actividad, tipo_sesion, fecha_desarrollo, id_ind_logro_competencia_vinculado, id_ind_logro_capacidad_vinculado, logro_sesion, bibliografia_obligatoria_docente, bibliografia_opcional_docente, bibliografia_obligatoria_estudiantes, bibliografia_opcional_estudiante, anexos) VALUES ('$id_prog_act_silabo',' ',' ','$hoy', '$id_ind_logro_competencia', '$id_ind_logro_capacidad',' ',' ',' ',' ',' ',' ')";
        $ejec_reg_sesion = mysqli_query($conexion, $reg_sesion_aprendizaje);
        
        //buscamos el id de la anterior tabla para hacer registros en las siguientes tablas
        $id_sesion = mysqli_insert_id($conexion);

        //crearemos los momentos de la sesion 3 por cada sesion Inicio, Desarrollo y cierre
        for ($j=1; $j <= 3; $j++) { 
            if($j==1){$momento="Inicio";}
            if($j==2){$momento="Desarrollo";}
            if($j==3){$momento="Cierre";}
            // momentos de la sesion
            $reg_momentos_sesion = "INSERT INTO momentos_sesion_aprendizaje (id_sesion_aprendizaje, momento, estrategia, actividad, recursos, tiempo) VALUES ('$id_sesion', '$momento',' ',' ',' ',45)";
            $ejec_reg_momentos_sesion = mysqli_query($conexion, $reg_momentos_sesion);
            
            // actividad de evaluacion en la sesion
            $reg_act_eva = "INSERT INTO actividad_evaluacion_sesion_aprendizaje (id_sesion_aprendizaje, indicador_logro_sesion, tecnica, instrumentos, peso, momento) VALUES ('$id_sesion',' ',' ',' ',33,'$momento')";
            $ejec_reg_act_eva = mysqli_query($conexion, $reg_act_eva);
            
        }
    }
    if (!$ejec_reg_prog_act_silabo) {
            echo "<script>
			alert('Error al Generar las programacion para el silabo');
			window.history.back();
		</script>
		";
        }
    if (!$ejec_reg_sesion) {
            echo "<script>
			alert('Error al Registrar las sesiones de aprendizaje');
			window.history.back();
		</script>
		";
        }
    if (!$ejec_reg_momentos_sesion) {
                echo "<script>
			        alert('Error al Registrar Momentos de la sesion M1');
			        window.history.back();
		        </script>
		        ";
            }
    if (!$ejec_reg_act_eva) {
                echo "<script>
			        alert('Error al Registrar Momentos de la sesion M2');
			        window.history.back();
		        </script>
		        ";
            }
    echo "<script>
                
                window.location= '../programacion.php'
    			</script>";
    
}


mysqli_close($conexion);

?>