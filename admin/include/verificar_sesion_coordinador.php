<?php
session_start();
if(!isset($_SESSION['id_jefe_area'])){
    echo "<script>
			alert('Error, Acceso Denegado y/o Sesion Caducada');
			window.location= 'index.php';
		</script>
	";
}
?>