<?php
include '../include/verificar_sesion_docente_secretaria_operaciones.php';
$id_per = $_GET['dato'];
$_SESSION['periodo'] = $id_per;
echo "<script>
                window.location= window.history.back();
    			</script>";
?>