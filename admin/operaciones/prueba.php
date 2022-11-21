<?php
include '../../include/conexion.php';
include '../include/busquedas.php';


$id_ud = $_POST['id_ud'];

	$ejec_cons = buscarUdById($conexion, $id_ud);

		$mostrar=mysqli_fetch_array($ejec_cons);
		echo $mostrar['descripcion'];

?>