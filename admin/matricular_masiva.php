<?php 
$archivo = $_FILES['my_file_input'];
$archivo = file_get_contents($archivo['tmp_name']);

print_r($archivo);



?>