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
function buscarDatosSesion(){

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
	$sql = "SELECT * FROM unidad_didactica WHERE id_carrera = '$idCarrera' AND id_semestre= '$idSemestre' ORDER BY id";
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

function buscarCursosDocentes($conexion){
	$sql = "SELECT * FROM cursos_docentes";
	return mysqli_query($conexion, $sql);
}
function buscarCursosDocentesById($conexion, $id){
	$sql = "SELECT * FROM cursos_docentes WHERE id='$id'";
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
function buscarUsuarioDocente($conexion){
	$sql = "SELECT * FROM usuarios_docentes";
	return mysqli_query($conexion, $sql);
}
function buscarUsuarioDocenteById($conexion, $id){
	$sql = "SELECT * FROM usuarios_docentes WHERE id_docente='$id' ORDER BY id LIMIT 1";
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




// -------------------------- FUNCIONES ACTUALIZAR --------------------------








// --------------------------- FUNCIONES ELIMINAR----------------------------







?>