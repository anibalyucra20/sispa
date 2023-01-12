<?php
session_start();
if(!isset($_SESSION['id_secretario'])){
    echo "<script>
			alert('Error, Sesion Caducada');
			window.location= '../index.php';
		</script>
	";
}
?>