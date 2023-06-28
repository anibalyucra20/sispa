<?php
  include ("include/verificar_sesion_coordinador.php");
  include ("../include/conexion.php");
  include ("include/busquedas.php");
  $id_pe = $_POST['car_consolidado'];
  $id_sem = $_POST['sem_consolidado'];

  $per_select = $_SESSION['periodo'];
  $array_estudiantes = [];
  // armar la nomina de estudiantes para poder mostrar todos los estudiantes del semestre
    $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);
    $cont_ud_sem = mysqli_num_rows($b_ud_pe_sem);
    $cont_ind_capp = 0;
    while ($r_b_ud = mysqli_fetch_array($b_ud_pe_sem)) {
      $id_ud = $r_b_ud['id'];

      //buscar capacidades
        $b_capp = buscarCapacidadesByIdUd($conexion, $id_ud);
        while ($r_b_capp = mysqli_fetch_array($b_capp)) {
          $id_capp = $r_b_capp['id'];
          //buscar indicadores de logro de capacidad
          $b_ind_l_capp = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id_capp);
          $cont_ind_capp += mysqli_num_rows($b_ind_l_capp);
        }
      


      //buscar si la unidad didactica esta programado en el presente periodo
      $b_ud_prog = buscarProgramacionByUd_Peridodo($conexion, $id_ud, $per_select);
      $r_b_ud_prog = mysqli_fetch_array($b_ud_prog);
      $cont_res = mysqli_num_rows($b_ud_prog);
      if ($cont_res > 0) {
        $id_prog_ud = $r_b_ud_prog['id'];
        //buscar detalle de matricula matriculas a la programacion de la unidad didactica
        $b_det_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog_ud);
        while ($r_b_det_mat = mysqli_fetch_array($b_det_mat)) {
          // buscar matricula para obtener datos del estudiante
          $id_mat = $r_b_det_mat['id_matricula'];
          $b_mat = buscarMatriculaById($conexion, $id_mat);
          $r_b_mat = mysqli_fetch_array($b_mat);
          $id_estudiante = $r_b_mat['id_estudiante'];
          // buscar estudiante
          $b_estudiante = buscarEstudianteById($conexion,$id_estudiante);
          $r_b_estudiante = mysqli_fetch_array($b_estudiante);
          $array_estudiantes[] = $r_b_estudiante['apellidos_nombres'];
        }
        $aa = "SI";
      }else{
        $aa = "NO";
      }
      //echo $r_b_ud['descripcion']." - ".$aa."<br>";
    }
    $n_array_estudiantes = array_unique($array_estudiantes);
    $collator = collator_create("es");
    $collator->sort($n_array_estudiantes);
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reportes<?php include ("../include/header_title.php"); ?></title>
  <!--icono en el titulo-->
  <link rel="shortcut icon" href="../img/favicon.ico">

  <style>
      p.verticalll {
        /* idéntico a rotateZ(45deg); */

        writing-mode: vertical-lr;
        transform: rotate(180deg);
        
      }

      .nota_input {
        width: 3em;
      }
    </style>
</head>
<body>
  <span Style="color:red;">REPORTE DE NOTAS</span>
  <table BORDER="1" CELLPADDING="3" CELLSPACING="0" style="width:100%">
    <thead>
    <tr>
                          <th rowspan="2">  
                            <center>Nro Orden</center>
                          </th>
                          <th rowspan="2">
                            <center>DNI</center>
                          </th>
                          <th rowspan="2">
                            <center>APELLIDOS Y NOMBRES</center>
                          </th>
                          <th colspan="<?php echo $cont_ind_capp; ?>">
                            <center>UNIDADES DIDÁCTICAS</center>
                          </th>
                        </tr>
                        
                        <tr>
                          <?php
                          $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);
                          while ($r_bb_ud = mysqli_fetch_array($b_ud_pe_sem)) {
                            $id_udd = $r_bb_ud['id'];
                            //BUSCAR UD
                            $b_uddd = buscarUdById($conexion, $id_udd);
                            $r_b_udd = mysqli_fetch_array($b_uddd);
                            //buscar capacidad
                            $cont_ind_logro_cap_ud = 0;
                            $b_cap_ud = buscarCapacidadesByIdUd($conexion, $id_udd);
                            while ($r_b_cap_ud = mysqli_fetch_array($b_cap_ud)) {
                              $id_cap_ud = $r_b_cap_ud['id'];
                              // buscar indicadores de capacidad
                              $b_ind_l_cap_ud = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $id_cap_ud);
                              $cant_id_cap_ud = mysqli_num_rows($b_ind_l_cap_ud);
                              $cont_ind_logro_cap_ud += $cant_id_cap_ud;
                            }
                            
                            ?>
                            <th colspan="<?php echo $cont_ind_logro_cap_ud; ?>">
                              <p class="verticalll"><?php echo $r_b_udd['descripcion']; ?></p>
                            </th>
                            <?php
                          }
                          ?>

                        </tr>
    </thead>
    <tbody>
    <?php
                        foreach($n_array_estudiantes as $key => $val){
                          $key+=1;
                          //buscar estudiante para su id
                          $b_est = buscarEstudianteByApellidosNombres($conexion,$val);
                          $r_b_est = mysqli_fetch_array($b_est);
                          $id_est = $r_b_est['id'];
                          ?>
                          <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $r_b_est['dni']; ?></td>
                            <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                            <?php
                            //buscar si estudiante esta matriculado en una unidad didactica
                            $b_ud_pe_sem = buscarUdByCarSem($conexion, $id_pe, $id_sem);
                            while ($r_bb_ud = mysqli_fetch_array($b_ud_pe_sem)) {
                              $id_udd = $r_bb_ud['id'];
                              $b_prog_ud = buscarProgramacionByUd_Peridodo($conexion, $id_udd, $per_select);
                              $r_b_prog_ud = mysqli_fetch_array($b_prog_ud);
                              $id_prog = $r_b_prog_ud['id'];

                              //buscar matricula de estudiante
                              $b_mat_est = buscarMatriculaByEstudiantePeriodo($conexion, $id_est, $per_select);
                              $r_b_mat_est = mysqli_fetch_array($b_mat_est);
                              $id_mat_est = $r_b_mat_est['id'];
                              //buscar detalle de matricula
                              $b_det_mat_est = buscarDetalleMatriculaByIdMatriculaProgramacion($conexion, $id_mat_est, $id_prog);
                              $r_b_det_mat_est = mysqli_fetch_array($b_det_mat_est);
                              $cont_r_b_det_mat = mysqli_num_rows($b_det_mat_est);
                              $id_det_mat = $r_b_det_mat_est['id'];
                              if ($cont_r_b_det_mat > 0) {
                                //echo "<td>SI</td>";

                                //buscar las calificaciones
                                $b_calificaciones = buscarCalificacionByIdDetalleMatricula($conexion, $id_det_mat);
                                
                                $suma_calificacion = 0;
                                while ($r_b_calificacion = mysqli_fetch_array($b_calificaciones)) {

                                  $id_calificacion = $r_b_calificacion['id'];
                                  //buscamos las evaluaciones
                                  $suma_evaluacion = 0;
                                  $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $id_calificacion);

                                  while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
                                    $id_evaluacion = $r_b_evaluacion['id'];
                                    //buscamos los criterios de evaluacion
                                    $b_criterio_evaluacion = buscarCriterioEvaluacionByEvaluacion($conexion, $id_evaluacion);
                                    $suma_criterios = 0;
                                    $cont_crit = 0;
                                    while ($r_b_criterio_evaluacion = mysqli_fetch_array($b_criterio_evaluacion)) {
                                      if (is_numeric($r_b_criterio_evaluacion['calificacion'])) {
                                        $suma_criterios += $r_b_criterio_evaluacion['calificacion'];
                                        $cont_crit += 1;
                                        //$suma_criterios += (($r_b_criterio_evaluacion['ponderado']/100)*$r_b_criterio_evaluacion['calificacion']);
                                      }
                                    }
                                    if ($cont_crit > 0) {
                                      $suma_criterios = round($suma_criterios / $cont_crit);
                                    } else {
                                      $suma_criterios = round($suma_criterios);
                                    }

                                    $suma_evaluacion += ($r_b_evaluacion['ponderado'] / 100) * $suma_criterios;
                                  }

                                  if ($suma_evaluacion != 0) {
                                    $suma_evaluacion = round($suma_evaluacion);

                                    if ($suma_evaluacion > 12) {
                                      echo '<th><center><font color="blue">'.$suma_evaluacion.'</font></center></th>';
                                      //echo '<th><center><input type="number" class="nota_input" style="color:blue;" value="' . $calificacion_final . '" min="0" max="20" disabled></center></th>';
                                    } else {
                                      echo '<th><center><font color="red">'.$suma_evaluacion.'</font></center></th>';
                                      //echo 
                                    }

                                  } else {
                                    $suma_evaluacion = "";
                                    echo '<th></th>';
                                  }

                                }



                              }else {
                                //buscar los indicadores
                                $total_ind = 0;
                                $b_capacidad = buscarCapacidadesByIdUd($conexion, $id_udd);
                                while ($r_b_cap = mysqli_fetch_array($b_capacidad)) {
                                  $b_ind_log_cap = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $r_b_cap['id']);
                                  $cont_ind = mysqli_num_rows($b_ind_log_cap);
                                  $total_ind += $cont_ind;
                                }
                                  
                                  

                                echo '<td colspan="'.$total_ind.'"></td>';
                              }
                              
                            }
                            ?>
                          </tr>
                        <?php
                        }
                        ?>
                        
    </tbody>
  </table>
  <?php echo "<script>
			window.print();
      setTimeout(function(){ 
        window.close();
    }, 3000);
		</script>
	";?>
</body>
</html>
