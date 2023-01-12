<?php
session_start();
if(!isset($_SESSION['id_secretario'])){
    header("location: index.php");
}
?>