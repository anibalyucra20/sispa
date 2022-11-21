<?php
include '../../include/conexion.php';
include '../include/busquedas.php';


$id_pe = $_POST['id_pe'];
$id_sem = $_POST['id_sem'];

	$ejec_cons = buscarUdByCarSem($conexion, $id_pe, $id_sem);

		$cadena = '';
		while ($mostrar=mysqli_fetch_array($ejec_cons)) {
			$cadena=$cadena.'<div class="checkbox"><label><input type="checkbox" name="unidades_didacticas" onchange="gen_arr_uds();" value="'.$mostrar["id"].'">'.$mostrar["descripcion"].'</label></div>';
		}
		echo $cadena;

?>