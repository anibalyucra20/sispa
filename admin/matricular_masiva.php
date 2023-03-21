<?php 
$archivo = $_FILES['my_file_input'];
$archivo = file_get_contents($archivo['tmp_name']);
$archivo = explode("/n", $archivo);
$archivo = array_filter($archivo);

foreach ($estudiantes as $key => $value) {
    $ests[] = explode(",", $key);
}

print_r($ests);



?>