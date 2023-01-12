<?php
session_start();
if(isset($_SESSION['id_director'])){
    header("location: direccion/");
}elseif(isset($_SESSION['id_secretario'])){
    header("location: secretaria.php");
}elseif(isset($_SESSION['id_coordinador_academico'])){
    header("location: unidad_academica/");
}elseif(isset($_SESSION['id_jefe_area'])){
    header("location: coordinador_pe/");
}elseif(isset($_SESSION['id_docente'])){
    header("location: docente.php");
}else{
    header("location: login/");
}
?>