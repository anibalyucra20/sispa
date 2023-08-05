<?php

$mifecha= date('Y-m-d H:i:s'); 
echo $mifecha."<br>";
$NuevaFecha = strtotime ('+1 hour' , strtotime ($mifecha) ) ; 
//$NuevaFecha = strtotime ( '+20 minute' , strtotime ($mifecha) ) ; 
//$NuevaFecha = strtotime ( '+30 second' , strtotime ($mifecha) ) ; 
$NuevaFecha = date ( 'Y-m-d H:i:s' , $NuevaFecha); 
echo $NuevaFecha;


?>