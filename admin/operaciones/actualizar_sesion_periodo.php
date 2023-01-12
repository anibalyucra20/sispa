<?php
include '../include/verificar_sesion_secretaria.php';
$id_per = $_GET['dato'];
if(!isset($_SESSION['id_secretario'])){
    header("location: ../index.php");
}
$_SESSION['periodo'] = $id_per;
echo "<script>
                window.location= window.history.back();
    			</script>";
?>