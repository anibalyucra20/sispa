<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";
include "../include/busquedas.php";


$hoy = date("Y-m-d");

$anio = $_POST['anio'];
$per = $_POST['per'];
$periodo = $anio . "-" . $per;
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$director = $_POST['director'];
$fecha_actas = $_POST['fecha_actas'];
$docente = $_SESSION['id_secretario'];


function realizar_programacion($conexion, $unidad_didactica, $id_ult_periodo, $docente){
	
	
$hoy = date("Y-m-d");

	//echo $unidad_didactica." - ".$docente;

	$consulta = "INSERT INTO programacion_unidad_didactica (id_unidad_didactica, id_docente, id_periodo_acad) VALUES ('$unidad_didactica','$docente','$id_ult_periodo')";
	mysqli_query($conexion, $consulta);
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
	mysqli_query($conexion, $reg_silabo);


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
	for ($i = 1; $i <= 16; $i++) {
		$reg_prog_act_silabo = "INSERT INTO programacion_actividades_silabo (id_silabo, semana, fecha, elemento_capacidad, actividades_aprendizaje, contenidos_basicos, tareas_previas) VALUES ('$id_silabo', '$i', '$hoy',' ',' ',' ',' ')";
		mysqli_query($conexion, $reg_prog_act_silabo);

		//buscamos el id de lo ingresado para registrar la siguiente tabla
		$id_prog_act_silabo = mysqli_insert_id($conexion);

		//procedemos a registrar la tabla sesion_aprendizaje-- 1 para cada tabla anterior
		$reg_sesion_aprendizaje = "INSERT INTO sesion_aprendizaje (id_programacion_actividad_silabo, tipo_actividad, tipo_sesion, fecha_desarrollo, id_ind_logro_competencia_vinculado, id_ind_logro_capacidad_vinculado, logro_sesion, bibliografia_obligatoria_docente, bibliografia_opcional_docente, bibliografia_obligatoria_estudiantes, bibliografia_opcional_estudiante, anexos) VALUES ('$id_prog_act_silabo',' ',' ','$hoy', '$id_ind_logro_competencia', '$id_ind_logro_capacidad',' ',' ',' ',' ',' ',' ')";
		mysqli_query($conexion, $reg_sesion_aprendizaje);

		//buscamos el id de la anterior tabla para hacer registros en las siguientes tablas
		$id_sesion = mysqli_insert_id($conexion);

		//crearemos los momentos de la sesion 3 por cada sesion Inicio, Desarrollo y cierre
		for ($j = 1; $j <= 3; $j++) {
			if ($j == 1) {
				$momento = "Inicio";
			}
			if ($j == 2) {
				$momento = "Desarrollo";
			}
			if ($j == 3) {
				$momento = "Cierre";
			}
			// momentos de la sesion
			$reg_momentos_sesion = "INSERT INTO momentos_sesion_aprendizaje (id_sesion_aprendizaje, momento, estrategia, actividad, recursos, tiempo) VALUES ('$id_sesion', '$momento',' ',' ',' ',45)";
			mysqli_query($conexion, $reg_momentos_sesion);

			// actividad de evaluacion en la sesion
			$reg_act_eva = "INSERT INTO actividad_evaluacion_sesion_aprendizaje (id_sesion_aprendizaje, indicador_logro_sesion, tecnica, instrumentos, peso, momento) VALUES ('$id_sesion',' ',' ',' ',33,'$momento')";
			mysqli_query($conexion, $reg_act_eva);
		}
	}
};










$insertar = "INSERT INTO periodo_academico (nombre, fecha_inicio, fecha_fin, director, fecha_actas) VALUES ('$periodo','$fecha_inicio','$fecha_fin', '$director', '$fecha_actas')";
$ejecutar_insetar = mysqli_query($conexion, $insertar);
if ($ejecutar_insetar) {
	//buscaremos el id del ultimo periodo creado para asignar al ultimo periodo y las fechas para impresión de nominas
	$busc_ult_periodo = "SELECT * FROM periodo_academico WHERE nombre='$periodo'";
	$ejec_busc_ult_per = mysqli_query($conexion, $busc_ult_periodo);
	$res_busc_ult_per = mysqli_fetch_array($ejec_busc_ult_per);
	$id_ult_periodo = $res_busc_ult_per['id'];

	$update_per_act = "UPDATE presente_periodo_acad SET id_periodo_acad='$id_ult_periodo' WHERE id='1'";
	$ejec_upd_per_act = mysqli_query($conexion, $update_per_act);
	if ($ejec_upd_per_act) {
		//actualizamos datos de la sesion
		$_SESSION['periodo'] = $id_ult_periodo;


		// <<<<<<<<<<<<<<<<<<<<<<< GENERAMOS LA PROGRAMACION DE TODOS LOS UDS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

		$b_pe = buscarCarreras($conexion);
		while ($r_b_pe = mysqli_fetch_array($b_pe)) {
			if (isset($_POST['pe_' . $r_b_pe['id']]) && ($_POST['pe_' . $r_b_pe['id']] == "on")) {
				echo $r_b_pe['nombre'] . "<br>";
				$b_modulo = buscarModuloFormativoByIdCarrera($conexion, $r_b_pe['id']);
				while ($r_b_modulo = mysqli_fetch_array($b_modulo)) {
					echo ">" . $r_b_modulo['descripcion'] . "<br>";
					$_b_semestre = buscarSemestre($conexion);
					while ($r_b_semestres = mysqli_fetch_array($_b_semestre)) {
						$b_uds = buscarUdByModSem($conexion, $r_b_modulo['id'], $r_b_semestres['id']);
						if (mysqli_num_rows($b_uds) > 0) {
							//validamos los semestre de periodo
							while ($r_b_uds = mysqli_fetch_array($b_uds)) {
								$unidad_didactica = $r_b_uds['id'];
								realizar_programacion($conexion,$unidad_didactica, $id_ult_periodo, $docente);
								echo ">>>>>>" . $r_b_uds['descripcion'] . "<br>";
							/*if ($per == "I") {
								if ($r_b_semestres['descripcion'] == "I" || $r_b_semestres['descripcion'] == "III" || $r_b_semestres['descripcion'] == "V" || $r_b_semestres['descripcion'] == "VII" || $r_b_semestres['descripcion'] == "IX") {
									echo ">>>" . $r_b_semestres['descripcion'] . "<br>";
									while ($r_b_uds = mysqli_fetch_array($b_uds)) {
										$unidad_didactica = $r_b_uds['id'];
										realizar_programacion($conexion,$unidad_didactica, $id_ult_periodo, $docente);
										echo ">>>>>>" . $r_b_uds['descripcion'] . "<br>";

										//>>>>>>>>>>>>>>>>>>>>> REGISTRAR PROGRAMACION <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<



										//>>>>>>>>>>>>>>>>>>>>> FIN REGISTRAR PROGRAMACION <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
									}
								}
							}else{
								if ($r_b_semestres['descripcion'] == "II" || $r_b_semestres['descripcion'] == "IV" || $r_b_semestres['descripcion'] == "VI" || $r_b_semestres['descripcion'] == "VIII" || $r_b_semestres['descripcion'] == "X") {
									//echo ">>>" . $r_b_semestres['descripcion'] . "<br>";
									while ($r_b_uds = mysqli_fetch_array($b_uds)) {
										$unidad_didactica = $r_b_uds['id'];
										realizar_programacion($conexion,$unidad_didactica, $id_ult_periodo, $docente);
										echo ">>>>>>" . $r_b_uds['descripcion'] . "<br>";
									}
								}*/
							}
						}
					}
				}
			}
		}

		// <<<<<<<<<<<<<<<<<<<<<<< FIN GENERAMOS LA PROGRAMACION DE TODOS LOS UDS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


		/*echo "<script>
                alert('Registro Existoso');
                window.location= '../periodo_academico.php'
    			</script>";*/
	} else {
		echo "<script>
			alert('Error al Actualizar periodo actual, por favor contacte al administrador');
			window.history.back();
				</script>
			";
	}
} else {
	echo "<script>
			alert('Error al registrar, por favor verifique sus datos');
			window.history.back();
				</script>
			";
};



/*echo "<script>
                
                window.location= '../programacion.php'
    			</script>";*/

mysqli_close($conexion);
