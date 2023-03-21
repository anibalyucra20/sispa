<?php
include ("../../include/conexion.php");
include ("../include/busquedas.php");
$usuario = $_POST['usuario'];
$pass = $_POST['password'];

$ejec_busc = buscarDocenteByDni($conexion, $usuario);
$res_busc = mysqli_fetch_array($ejec_busc);
$cont = mysqli_num_rows($ejec_busc);

if(($cont == 1)&&(password_verify($pass,$res_busc['password']))){
	$id_docente = $res_busc['id'];
	$cargo_docente = $res_busc['id_cargo'];
	$buscar_periodo = buscarPresentePeriodoAcad($conexion);
	$res_b_periodo = mysqli_fetch_array($buscar_periodo);
	$presente_periodo = $res_b_periodo['id_periodo_acad'];
	if ($res_busc['activo']!=1) {
		echo "<script>
                alert('Error, Usted no se encuentra activo en el sistema, Por Favor Contacte con el Administrador');
                window.location= '../login/'
    		</script>";
	}else{
	session_start();

	if($cargo_docente == 1){//director
		$_SESSION['id_director'] = $id_docente;
		$_SESSION['periodo'] = $presente_periodo;
		header("location: ../index.php");
	}elseif($cargo_docente == 2){//secretario academico
		$_SESSION['id_secretario'] = $id_docente;
		$_SESSION['periodo'] = $presente_periodo;
		header("location: ../index.php");
	}elseif($cargo_docente == 3){//jefe de unidad academica
		$_SESSION['id_coordinador_academico'] = $id_docente;
		$_SESSION['periodo'] = $presente_periodo;
		header("location: ../index.php");
	}elseif($cargo_docente == 4){//jefe de area/coordinador
		$_SESSION['id_docente'] = $id_docente;
			$_SESSION['periodo'] = $presente_periodo;
			header("location: ../index.php");
			/*$_SESSION['id_jefe_area'] = $id_docente;
			$_SESSION['periodo'] = $presente_periodo;
			header("location: ../index.php");*/
	}elseif($cargo_docente == 5){//docente
			$_SESSION['id_docente'] = $id_docente;
			$_SESSION['periodo'] = $presente_periodo;
			header("location: ../index.php");
	}else{//cargo invalido
		echo "<script>
                alert('Error en cargo, contacte administrador');
                window.location= '../login/'
    		</script>";
	}

}


}else{
	echo "<script>
                alert('Usuario o Contraseña incorrecto');
                window.location= '../login/'
    		</script>";
}
mysqli_close($conexion);
?>