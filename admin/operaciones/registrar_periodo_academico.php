<?php
include '../include/verificar_sesion_secretaria_operaciones.php';
include "../../include/conexion.php";
session_start();
$periodo = $_POST['per_acad'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$director = $_POST['director'];
$fecha_actas = $_POST['fecha_actas'];

	$insertar = "INSERT INTO periodo_academico (nombre, fecha_inicio, fecha_fin, director, fecha_actas) VALUES ('$periodo','$fecha_inicio','$fecha_fin', '$director', '$fecha_actas')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
		//buscaremos el id del ultimo periodo creado para asignar al ultimo periodo y las fechas para impresión de nominas
		$busc_ult_periodo = "SELECT * FROM periodo_academico WHERE nombre='$periodo'";
		$ejec_busc_ult_per = mysqli_query($conexion, $busc_ult_periodo);
		$res_busc_ult_per = mysqli_fetch_array($ejec_busc_ult_per);
		$id_ult_periodo = $res_busc_ult_per['id'];

		$update_per_act = "UPDATE presente_periodo_acad SET id_periodo_acad='$id_ult_periodo' WHERE id='1'";
		$ejec_upd_per_act = mysqli_query($conexion, $update_per_act);
		if ($ejec_upd_per_act) {
            //actualizamos datos de la sesion
            $_SESSION['periodo'] = $id_ult_periodo;
			echo "<script>
                alert('Registro Existoso');
                window.location= '../periodo_academico.php'
    			</script>";
		}else{
			echo "<script>
			alert('Error al Actualizar periodo actual, por favor contacte al administrador');
			window.history.back();
				</script>
			";
		}
			
	}else{
		echo "<script>
			alert('Error al registrar, por favor verifique sus datos');
			window.history.back();
				</script>
			";
	};






mysqli_close($conexion);

?>