<?php
header("location: admin/");

/*

$ud="ud"; //variable para nombre de arrays de uds
$nud = "ud"; //variable para crear objetos en array
$unidades_did = array(); //array para guardar uds con sus notas
for ($i=1; $i <= 2; $i++) { // bucle para generar los array para cada ud
	$nom_ud = $ud.$i;
	$nud = $ud.$i;
	$nom_ud= array();
	for ($j=1; $j <= 5; $j++) {  // bucle para generar las notas de la ud
		$nom_ud["nota".$j] = "".$j;
	}
	$unidades_did[$nud] = $nom_ud;  // agregamos el array de ud al array de uds
}

foreach ($unidades_did as $key => $value) { // codigo para mostrar el array de uds
	echo "$key: <br>";
	//if ($key == "ud2") {
			foreach ($value as $llave => $valor) {
		echo "$llave es $valor <br>";
		
	}
	//	}
	
}
$sarray = json_encode($unidades_did);
$dd = strval($sarray);
echo $dd;
$ssql = "INSERT INTO prueba (array_bid) VALUES ('$dd')";

if (mysqli_query($con, $ssql)) {
      echo "New record created successfully";
} else {
      echo "Error: " . $ssql . "<br>" . mysqli_error($con);
}
print_r($unidades_did);



$persona1 = array();
$apellido1 = "yucra";
$apellido2 = "curo";
$nombre = "anibal";
$persona1["ap1"]=$apellido1;
$persona1["ap2"]=$apellido2;
$persona1["nom"]=$nombre;
foreach ($persona1 as $key => $value) {
		echo "$key is $value <br>";
}


$persona2 = array();
$apel1 = "torres";
$apel2 = "lozano";
$nomb = "juan carlos";
$persona2["ap1"]=$apel1;
$persona2["ap2"]=$apel2;
$persona2["nom"]=$nomb;
foreach ($persona2 as $key => $value) {
		echo "$key is $value <br>";
}

$personas = array();
$personas["per1"] = $persona1;
$personas["per2"] = $persona2;
foreach ($personas as $key_per => $per) {
		$person = "$key_per";
		echo "$key_per: <br>";
		foreach ($per as $dato => $valor) {
			echo "$dato = $valor <br>";
		}
}
*/
?>