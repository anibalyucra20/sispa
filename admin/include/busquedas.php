<?php
// -------------------  FUNCIONES BUSCAR ------------------------------
function buscarDatosGenerales($conexion){
	$sql = "SELECT * FROM datos_institucionales WHERE id=1";
	return mysqli_query($conexion, $sql);
}
function buscarDatosSistema($conexion){
	$sql = "SELECT * FROM sistema WHERE id=1";
	return mysqli_query($conexion, $sql);
}

function buscarPresentePeriodoAcad($conexion){
	$sql = "SELECT * FROM presente_periodo_acad ORDER BY id LIMIT 1";
	return mysqli_query($conexion, $sql);
}
function buscarPeriodoAcademico($conexion){
	$sql = "SELECT * FROM periodo_academico";
	return mysqli_query($conexion, $sql);
}
function buscarPeriodoAcademicoInvert($conexion){
	$sql = "SELECT * FROM periodo_academico ORDER BY id DESC";
	return mysqli_query($conexion, $sql);
}
function buscarPeriodoAcadById($conexion, $id){
	$sql = "SELECT * FROM periodo_academico WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarEstudiante($conexion){
	$sql = "SELECT * FROM estudiante";
	return mysqli_query($conexion, $sql);
}
function buscarEstudianteById($conexion,$id){
	$sql = "SELECT * FROM estudiante WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarEstudianteByDni($conexion,$dni){
	$sql = "SELECT * FROM estudiante WHERE dni='$dni'";
	return mysqli_query($conexion, $sql);
}
function buscarDocente($conexion){
	$sql = "SELECT * FROM docente";
	return mysqli_query($conexion, $sql);
}
function buscarDocenteById($conexion, $id){
	$sql = "SELECT * FROM docente WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarDocenteByDni($conexion, $dni){
	$sql = "SELECT * FROM docente WHERE dni='$dni'";
	return mysqli_query($conexion, $sql);
}
function buscarCoordinadorAreaByIdPe($conexion, $id_pe){
	$sql = "SELECT * FROM docente WHERE id_programa_estudio='$id_pe' AND id_cargo='4'";
	return mysqli_query($conexion, $sql);
}



function buscarCarreras($conexion){
	$sql = "SELECT * FROM programa_estudios";
	return mysqli_query($conexion, $sql);
}
function buscarCarrerasById($conexion, $id){
	$sql = "SELECT * FROM programa_estudios WHERE id=$id";
	return mysqli_query($conexion, $sql);
}

function buscarSemestre($conexion){
	$sql = "SELECT * FROM semestre";
	return mysqli_query($conexion, $sql);
}
function buscarSemestreById($conexion, $id){
	$sql = "SELECT * FROM semestre WHERE id=$id";
	return mysqli_query($conexion, $sql);
}
function buscarUdByCarSem($conexion, $idCarrera, $idSemestre){
	$sql = "SELECT * FROM unidad_didactica WHERE id_programa_estudio = '$idCarrera' AND id_semestre= '$idSemestre' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarUdByModSem($conexion, $idModulo, $idSemestre){
	$sql = "SELECT * FROM unidad_didactica WHERE id_modulo = '$idModulo' AND id_semestre= '$idSemestre' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarUdByCarSemInCursosDocente($conexion, $idCarrera, $idSemestre){
	$sql = "SELECT * FROM cursos_docentes WHERE id_carrera = '$idCarrera' AND id_semestre= '$idSemestre' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarUnidadDidactica($conexion){
	$sql = "SELECT * FROM unidad_didactica";
	return mysqli_query($conexion, $sql);
}
function buscarUdById($conexion, $id){
	$sql = "SELECT * FROM unidad_didactica WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarUdByIdModulo($conexion, $id){
	$sql = "SELECT * FROM unidad_didactica WHERE id_modulo='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarModuloFormativo($conexion){
	$sql = "SELECT * FROM modulo_profesional";
	return mysqli_query($conexion, $sql);
}
function buscarModuloFormativoById($conexion, $id){
	$sql = "SELECT * FROM modulo_profesional WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarModuloFormativoByIdCarrera($conexion, $id){
	$sql = "SELECT * FROM modulo_profesional WHERE id_programa_estudio = '$id' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarMatricula($conexion){
	$sql = "SELECT * FROM matricula";
	return mysqli_query($conexion, $sql);
}
function buscarMatriculaById($conexion, $id){
	$sql = "SELECT * FROM matricula WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarMatriculaByEstudiantePeriodo($conexion, $id_estudiante, $id_periodo_acad){
	$sql = "SELECT * FROM matricula WHERE id_estudiante='$id_estudiante' AND id_periodo_acad = '$id_periodo_acad'";
	return mysqli_query($conexion, $sql);
}
function buscarDetalleMatriculaById($conexion, $id){
	$sql = "SELECT * FROM detalle_matricula_unidad_didactica WHERE id = '$id'";
	return mysqli_query($conexion, $sql);
}
function buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog){
	$sql = "SELECT * FROM detalle_matricula_unidad_didactica WHERE id_programacion_ud = '$id_prog' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarCalificacionById($conexion, $id){
	$sql = "SELECT * FROM calificaciones WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCalificacionByIdDetalleMatricula($conexion, $id_detalle){
	$sql = "SELECT * FROM calificaciones WHERE id_detalle_matricula = '$id_detalle' ORDER BY nro_calificacion";
	return mysqli_query($conexion, $sql);
}
function buscarCalificacionByIdDetalleMatricula_nro($conexion, $id_detalle, $nro_calificacion){
	$sql = "SELECT * FROM calificaciones WHERE id_detalle_matricula = '$id_detalle' AND nro_calificacion='$nro_calificacion'";
	return mysqli_query($conexion, $sql);
}
function buscarEvaluacionById($conexion, $id){
	$sql = "SELECT * FROM evaluacion WHERE id = '$id'";
	return mysqli_query($conexion, $sql);
}
function buscarEvaluacionByIdCalificacion($conexion, $id){
	$sql = "SELECT * FROM evaluacion WHERE id_calificacion = '$id' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarEvaluacionByIdCalificacion_detalle($conexion, $id, $detalle){
	$sql = "SELECT * FROM evaluacion WHERE id_calificacion = '$id' AND detalle='$detalle' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarCriterioEvaluacionByEvaluacion($conexion, $id){
	$sql = "SELECT * FROM criterio_evaluacion WHERE id_evaluacion = '$id' ORDER BY id";
	return mysqli_query($conexion, $sql);
}
function buscarCriterioEvaluacionByEvaluacionOrden($conexion, $id, $orden){
	$sql = "SELECT * FROM criterio_evaluacion WHERE id_evaluacion = '$id' AND orden='$orden' ORDER BY id";
	return mysqli_query($conexion, $sql);
}


function buscarProgramacion($conexion){
	$sql = "SELECT * FROM programacion_unidad_didactica";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionById($conexion, $id){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByIdDocente($conexion, $id){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_docente='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByIdDocentePeriodo($conexion, $id_docente, $id_periodo){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_docente='$id_docente' AND id_periodo_acad='$id_periodo'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByUd_Peridodo($conexion, $id_ud, $periodo){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_unidad_didactica='$id_ud' AND id_periodo_acad='$periodo'";
	return mysqli_query($conexion, $sql);
}
function buscarProgramacionByUdDocentePeriodo($conexion, $ud, $docente, $periodo){
	$sql = "SELECT * FROM programacion_unidad_didactica WHERE id_unidad_didactica='$ud' AND id_docente='$docente' AND id_periodo_acad='$periodo'";
	return mysqli_query($conexion, $sql);
}
function buscarCargo($conexion){
	$sql = "SELECT * FROM cargo";
	return mysqli_query($conexion, $sql);
}
function buscarCargoById($conexion, $id){
	$sql = "SELECT * FROM cargo WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarGenero($conexion){
	$sql = "SELECT * FROM genero";
	return mysqli_query($conexion, $sql);
}

function buscarCompetencias($conexion){
	$sql = "SELECT * FROM competencias";
	return mysqli_query($conexion, $sql);
}
function buscarCompetenciasById($conexion, $id){
	$sql = "SELECT * FROM competencias WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCompetenciasByIdModulo($conexion, $id){
	$sql = "SELECT * FROM competencias WHERE id_modulo_formativo='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCompetenciasEspecialidadByIdModulo($conexion, $id){
	$sql = "SELECT * FROM competencias WHERE id_modulo_formativo='$id' AND tipo_competencia='ESPECÍFICA'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCompetenciasById($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_competencia WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCompetenciasByIdCompetencia($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_competencia WHERE id_competencia='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarCapacidades($conexion){
	$sql = "SELECT * FROM capacidades";
	return mysqli_query($conexion, $sql);
}
function buscarCapacidadesById($conexion, $id){
	$sql = "SELECT * FROM capacidades WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarCapacidadesByIdUd($conexion, $id){
	$sql = "SELECT * FROM capacidades WHERE id_unidad_didactica='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCapacidadById($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_capacidad WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id){
	$sql = "SELECT * FROM indicador_logro_capacidad WHERE id_capacidad='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarSilaboById($conexion, $id){
	$sql = "SELECT * FROM silabo WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarSilaboByIdProgramacion($conexion, $id){
	$sql = "SELECT * FROM silabo WHERE id_programacion_unidad_didactica='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarProgActividadesSilaboById($conexion, $id){
	$sql = "SELECT * FROM programacion_actividades_silabo WHERE id='$id' ORDER BY semana";
	return mysqli_query($conexion, $sql);
}
function buscarProgActividadesSilaboByIdSilabo($conexion, $id){
	$sql = "SELECT * FROM programacion_actividades_silabo WHERE id_silabo='$id' ORDER BY semana";
	return mysqli_query($conexion, $sql);
}

function buscarSesionById($conexion, $id){
	$sql = "SELECT * FROM sesion_aprendizaje WHERE id='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarSesionByIdProgramacionActividades($conexion, $id){
	$sql = "SELECT * FROM sesion_aprendizaje WHERE id_programacion_actividad_silabo='$id'";
	return mysqli_query($conexion, $sql);
}

function buscarMomentosSesionByIdSesion($conexion, $id){
	$sql = "SELECT * FROM momentos_sesion_aprendizaje WHERE id_sesion_aprendizaje='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarActividadesEvaluacionByIdSesion($conexion, $id){
	$sql = "SELECT * FROM actividad_evaluacion_sesion_aprendizaje WHERE id_sesion_aprendizaje='$id'";
	return mysqli_query($conexion, $sql);
}
function buscarAsistenciaBySesionAndEstudiante($conexion, $id, $estudiante){
	$sql = "SELECT * FROM asistencia WHERE id_sesion_aprendizaje='$id' AND id_estudiante='$estudiante'";
	return mysqli_query($conexion, $sql);
}



// -------------------------- FUNCIONES ACTUALIZAR --------------------------








// --------------------------- FUNCIONES ELIMINAR----------------------------







?>