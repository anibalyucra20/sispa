<?php
$id_per = $_GET['dato'];
session_start();
if(!isset($_SESSION['id_secretario'])){
    header("location: ../../login/");
}
$_SESSION['periodo'] = $id_per;
echo "<script>
                window.location= window.history.back();
    			</script>";
?>