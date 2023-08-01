<?php

include("../sistema.php");

$conexion = mysqli_connect($host,$user_db,$pass_db,$db);

if ($conexion) {
	
}else{
	echo "error de conexion a la base de datos";
	
}
$conexion->set_charset("utf8");
?>