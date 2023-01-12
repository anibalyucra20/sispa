<?php
session_start();
if(!isset($_SESSION['id_docente'])){
    header("location: ../index.php");
}
?>