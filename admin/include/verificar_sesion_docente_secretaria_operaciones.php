<?php
session_start();
if(isset($_SESSION['id_secretario']) || isset($_SESSION['id_docente'])){
}else {
    echo "<script>
			alert('Error, Acceso Denegado y/o Sesion Caducada');
			window.location= '../index.php';
		</script>
	";
}
?>