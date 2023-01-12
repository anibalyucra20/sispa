<?php
include '../include/verificar_sesion_secretaria.php';
include "../../../include/conexion.php";

$cargo = $_POST['cargo'];

	$insertar = "INSERT INTO cargo (descripcion) VALUES ('$cargo')";
	$ejecutar_insetar = mysqli_query($conexion, $insertar);
	if ($ejecutar_insetar) {
			echo "<script>
                window.location= '../cargo.php'
    			</script>";
	}else{
		echo "<script>
			alert('Error al registrar, por favor verifique sus datos');
			window.history.back();
				</script>
			";
	};






mysqli_close($conexion);

?>