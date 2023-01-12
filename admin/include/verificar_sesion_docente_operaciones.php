<?php
session_start();
if(!isset($_SESSION['id_docente'])){
    echo "<script>
			alert('Error, Sesion Caducada');
			window.location= '../index.php';
		</script>
	";
}
?>