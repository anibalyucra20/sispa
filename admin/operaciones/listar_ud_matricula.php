<?php
include '../../include/conexion.php';
include '../include/busquedas.php';

if (isset($_POST['datos'])) {
    $arr_uds = $_POST['datos'];
    $cadena = '';
	foreach ($arr_uds as $id) {
		$ejec_cons = buscarUdById($conexion, $id);
		$mostrar=mysqli_fetch_array($ejec_cons);
		$cadena=$cadena.'<div class="checkbox"><label><input type="checkbox" name="uds_matri" value="'.$id.'" onchange="gen_arr_mat();" checked>'.$mostrar['descripcion'].'</label></div>';
	}
		echo $cadena;
}else{
    echo "Aún no hay Unidades Didácticas Agregadas para la Matrícula";
}


?>