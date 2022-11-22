<?php
session_start();
include '../../include/conexion.php';
include '../include/busquedas.php';



$id_pe = $_POST['id_pe'];
$id_sem = $_POST['id_sem'];

	$ejec_cons = buscarUdByCarSem($conexion, $id_pe, $id_sem);
	
		$cadena = '<div class="checkbox">
		<label>
		  <input type="checkbox" onchange="select_all();" id="all_check"> <b> SELECCIONAR TODAS LAS UNIDADES DIDÁCTICAS *</b>
		</label>
		</div>';
		
		while ($mostrar=mysqli_fetch_array($ejec_cons)) {
			$id_unidad_didactica = $mostrar["id"];
			$busc_progr = buscarProgramacionByUd_Peridodo($conexion, $id_unidad_didactica, $_SESSION['periodo']);
			$cont = mysqli_num_rows($busc_progr);
			if($cont>0){
				$res_ud = mysqli_fetch_array($busc_progr);
				$cadena=$cadena.'<div class="checkbox"><label><input type="checkbox" name="unidades_didacticas" onchange="gen_arr_uds();" value="'.$res_ud["id"].'">'.$mostrar["descripcion"].'</label></div>';
			}
			
		}
		echo $cadena;

?>