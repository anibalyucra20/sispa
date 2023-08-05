<?php

function verificar_sesion($conexion){
	session_start();
	if (isset($_SESSION['id_sesion'])) {
		$id_docente = buscar_docente_sesion($conexion, $_SESSION['id_sesion'], $_SESSION['token']);
		$b_docente = buscarDocenteById($conexion, $id_docente);
		$r_b_docente = mysqli_fetch_array($b_docente);
		$id_cargo = $r_b_docente['id_cargo'];
		if ($id_cargo == 4 || $id_cargo == 5) {
			return 1;
		}else {
			return 0;
		}
	}else {
		return 0;
	}
}

/*
session_start();
if(isset($_SESSION['id_jefe_area']) || isset($_SESSION['id_docente'])){
}else {
    echo "<script>
			alert('Error, Acceso Denegado y/o Sesion Caducada');
			window.location= 'index.php';
		</script>
	";
}*/
?>