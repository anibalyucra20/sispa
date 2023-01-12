<?php
session_start();
if(isset($_SESSION['id_secretario']) || isset($_SESSION['id_docente'])){
}else {
    header("location: index.php");
}
?>