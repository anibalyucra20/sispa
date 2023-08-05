<?php
include '../include/verificar_sesion_coordinador_operaciones.php';
include '../../include/conexion.php';
include '../include/busquedas.php';



$dni_es = $_POST['dni_es'];
$na_es = $_POST['na_es'];
$pe_es = $_POST['pe_es'];

$cadena = '<table  class="table table-striped table-bordered" style="width:100%">
<thead>
  <tr>
    <th>Nro</th>
    <th>DNI</th>
    <th>Apellidos y Nombres</th>
    <th>Semestre</th>
    <th>Acciones</th>
  </tr>
</thead>
<tbody>
';
function b_semestre($conexion, $id_semm){
    $b_sem = buscarSemestreById($conexion, $id_semm);
    $r_b_sem = mysqli_fetch_array($b_sem);
    return $r_b_sem['descripcion'];
}
$cont = 0;
$cont_t = strlen($dni_es);
if($cont_t > 0) {
    $b_estby_dni = buscarEstudianteByDniPe($conexion,$pe_es,$dni_es);
    while ($r_b_est = mysqli_fetch_array($b_estby_dni)) {
        $sem = b_semestre($conexion,$r_b_est['id_semestre']);
        $cont += 1;
        $cadena = $cadena.'<tr><td>'.$cont.'</td><td>'.$r_b_est['dni'].'</td><td>'.$r_b_est['apellidos_nombres'].'</td><td>'.$sem.'</td><td>
        <form role="form" action="reporte_individual.php" method="POST">
        <input type="hidden" name="id" value="'.$r_b_est['id'].'">
        <button type="submit" class="btn btn-success">Ver Reporte</button>
        </form>
        </td></tr>';
    }
}else{
    $b_est_by_nom_ap = buscarEstudianteByApellidosNombres_like($conexion,$pe_es,$na_es);
    while ($r_b_est = mysqli_fetch_array($b_est_by_nom_ap)) {
        $sem = b_semestre($conexion,$r_b_est['id_semestre']);
        $cont += 1;
        $cadena = $cadena.'<tr><td>'.$cont.'</td><td>'.$r_b_est['dni'].'</td><td>'.$r_b_est['apellidos_nombres'].'</td><td>'.$sem.'</td><td>
        <form role="form" action="reporte_individual.php" method="POST">
        <input type="hidden" name="id" value="'.$r_b_est['id'].'">
        <button type="submit" class="btn btn-success">Ver Reporte</button>
        </form>
        </td></tr>';
    }
}

    $cadena = $cadena.'</tbody></table>';
		echo $cadena;
