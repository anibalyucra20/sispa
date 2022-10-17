<?php
$conexion = mysqli_connect("localhost","","","");
if ($conexion) {
	
}else{
	echo "error de conexion a la base de datos";
}
$conexion->set_charset("utf8");
?>