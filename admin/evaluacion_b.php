<?php
include 'include/verificar_sesion_docente_secretaria.php';
include '../include/conexion.php';
include 'include/busquedas.php';

$id_prog = $_GET['data'];
$nro_calificacion = $_GET['data2'];
$b_prog = buscarProgramacionById($conexion, $id_prog);
$res_b_prog = mysqli_fetch_array($b_prog);
$cont_res = mysqli_num_rows($b_prog);

if (isset($_SESSION['id_secretario']) || ($res_b_prog['id_docente'] == $_SESSION['id_docente'])) {
  $mostrar_archivo = 1;
} else {
  $mostrar_archivo = 0;
}

if (!($mostrar_archivo)) {
  //echo "<h1 align='center'>No tiene acceso a la evaluacion de la Unidad Didáctica</h1>";
  //echo "<br><h2><center><a href='javascript:history.back(-1);'>Regresar</a></center></h2>";
  echo "<script>
			alert('Error Usted no cuenta con los permisos para acceder a la Página Solicitada');
			window.history.back();
		</script>
	";
} else {
?>
  <!DOCTYPE html>
  <html lang="es">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="es-ES">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Evaluacion<?php include("../include/header_title.php"); ?></title>
    <!--icono en el titulo-->
    <link rel="shortcut icon" href="../img/favicon.ico">
    <!-- Bootstrap -->
    <link href="../Gentella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../Gentella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../Gentella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../Gentella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../Gentella/build/css/custom.min.css" rel="stylesheet">
    <!-- Script obtenido desde CDN jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

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

  <body class="nav-sm">
    <div class="container body">
      <div class="main_container">
        <!--menu-->
        <?php
        if (isset($_SESSION['id_docente'])) {
          include("include/menu_docente.php");
        } elseif (isset($_SESSION['id_secretario'])) {
          include("include/menu_secretaria.php");
        } else {
        }


        ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <?php

                  if ($cont_res == 0) {
                    //filtro si es que no existe el id de prog_ud 
                    echo "<h2>No Existen Registros</h2>";
                  } else {
                    $b_ud = buscarUdById($conexion, $res_b_prog['id_unidad_didactica']);
                    $r_b_ud = mysqli_fetch_array($b_ud);
                    //buscamos la cantidad de indicadores para definir la cantidad de calificaciones
                    $b_capacidades = buscarCapacidadesByIdUd($conexion, $res_b_prog['id_unidad_didactica']);
                    $total_indicadores = 0;
                    while ($r_b_capacidades = mysqli_fetch_array($b_capacidades)) {
                      $b_indicador_capac = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $r_b_capacidades['id']);
                      $cont_indicadores = mysqli_num_rows($b_indicador_capac);
                      $total_indicadores = $total_indicadores + $cont_indicadores;
                    };
                    if ($nro_calificacion < 1 ||  $nro_calificacion > $total_indicadores) {
                      //filtro si es que no existe el indicador pasado como parametro
                      echo "<h2>No Existen Registros - Indicadores</h2>";
                    } else {

                  ?>
                      <div class="">
                        <h2 align="center"><b>Evaluación - <?php echo "Calificacion " . $nro_calificacion . " - " . $r_b_ud['descripcion']; ?></b></h2>

                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">
                        <div class="table-responsive">
                          <br>
                          <form role="form" action="operaciones/actualizar_calificacion.php" class="form-horizontal form-label-left input_mask" method="POST">
                            <input type="hidden" name="id_prog" id="id_prog" value="<?php echo $id_prog; ?>">
                            <input type="hidden" name="nro_calificacion" id="nro_calificacion" value="<?php echo $nro_calificacion; ?>">
                            <input type="hidden" name="cant_calif" value="<?php echo $total_indicadores; ?>">
                            <table id="" class="table table-striped jambo_table bulk_action">

                              <tr class="headings">
                                <th rowspan="3">
                                  <center>DNI</center>
                                </th>
                                <th rowspan="3">
                                  <center>APELLIDOS Y NOMBRES</center>
                                </th>
                                <th colspan="18">
                                  <center>EVALUACIÓN</center>
                                </th>
                                <th rowspan="3" bgcolor="#D5D2D2">
                                  <center>
                                    <p class="verticalll">PROMEDIO DE CALIFICACIÓN</p>
                                  </center>
                                </th>

                              </tr>

                              <tr class="headings">
                                <?php
                                $b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
                                $r_b_det_mat = mysqli_fetch_array($b_detalle_mat);
                                $b_calificacion = buscarCalificacionByIdDetalleMatricula_nro($conexion, $r_b_det_mat['id'], $nro_calificacion);
                                $r_b_calificacion = mysqli_fetch_array($b_calificacion);
                                $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $r_b_calificacion['id']);
                                $count = 1;
                                while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
                                  $b_critt_eva = buscarCriterioEvaluacionByEvaluacion($conexion, $r_b_evaluacion['id']);
                                  $c_b_critt = mysqli_num_rows($b_critt_eva);
                                ?>
                                  <th colspan="<?php echo $c_b_critt + 1; ?>">
                                    <center><?php echo $r_b_evaluacion['detalle'] ?><br>Ponderado: <?php echo $r_b_evaluacion['ponderado']; ?>%
                                      <!--<input type="number" id="" name="" value="<?php echo $r_b_evaluacion['ponderado']; ?>" min="0" max="100" >-->
                                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".edit_eva<?php echo $r_b_evaluacion['id']; ?>"><i class="fa fa-edit"></i></button>
                                    </center>
                                  </th>
                                <?php
                                  include('include/acciones_evaluacion.php');
                                  $count += 1;
                                }
                                ?>

                              </tr>
                              <tr class="headings">
                                <?php
                                $b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
                                $r_b_det_mat = mysqli_fetch_array($b_detalle_mat);
                                $b_calificacion = buscarCalificacionByIdDetalleMatricula_nro($conexion, $r_b_det_mat['id'], $nro_calificacion);
                                $r_b_calificacion = mysqli_fetch_array($b_calificacion);
                                $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $r_b_calificacion['id']);
                                $count = 1;
                                while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
                                  $b_critt_eva = buscarCriterioEvaluacionByEvaluacion($conexion, $r_b_evaluacion['id']);
                                  while ($r_b_critt_eva = mysqli_fetch_array($b_critt_eva)) {
                                ?>
                                    <th height="auto" width="20px">
                                      <center>
                                        <button type="button" class="btn btn-default" data-toggle="modal" data-target=".edit_crit_<?php echo $r_b_critt_eva['id']; ?>"><i class="fa fa-edit"></i></button>

                                        <p class="verticalll" id=""><?php echo $r_b_critt_eva['detalle']; ?></p>
                                        <br>
                                        <!--Peso: <?php echo $r_b_critt_eva['ponderado']; ?>%-->
                                      </center>
                                    </th>
                                  <?php
                                    $count += 1;
                                    include('include/acciones_criterio.php');
                                  }
                                  ?>
                                  <th height="auto" width="20px" bgcolor="#D5D2D2">
                                    <center>
                                      <p class="verticalll">Promedio <?php echo $r_b_evaluacion['detalle']; ?></p>
                                    </center>
                                  </th>
                                <?php

                                }  ?>
                              </tr>


                              <tbody>
                                <?php
                                $b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
                                $orden = 0;
                                while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
                                  $orden++;
                                  $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
                                  $r_b_mat = mysqli_fetch_array($b_matricula);
                                  $b_estudiante = buscarEstudianteById($conexion, $r_b_mat['id_estudiante']);
                                  $r_b_est = mysqli_fetch_array($b_estudiante);
                                ?>
                                  <tr>

                                    <td><?php echo $r_b_est['dni']; ?></td>
                                    <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                                    <?php
                                    $suma_notas = 0;
                                    $cont_notas = 0;
                                    $suma_calificacion = 0;
                                    $opcion = 1;
                                    //buscamos las evaluaciones
                                    $b_calificacion = buscarCalificacionByIdDetalleMatricula_nro($conexion, $r_b_det_mat['id'], $nro_calificacion);
                                    while ($r_b_calificacion = mysqli_fetch_array($b_calificacion)) {
                                      $b_evaluacion = buscarEvaluacionByIdCalificacion($conexion, $r_b_calificacion['id']);
                                      $suma_evaluacion = 0;
                                      while ($r_b_evaluacion = mysqli_fetch_array($b_evaluacion)) {
                                        $id_evaluacion = $r_b_evaluacion['id'];

                                        //buscamos los criterios de evaluacion
                                        $b_criterio_evaluacion = buscarCriterioEvaluacionByEvaluacion($conexion, $id_evaluacion);
                                        $suma_criterios = 0;
                                        $cont_c = 0;
                                        while ($r_b_criterio_evaluacion = mysqli_fetch_array($b_criterio_evaluacion)) {
                                          if (is_numeric($r_b_criterio_evaluacion['calificacion'])) {
                                            $suma_criterios += $r_b_criterio_evaluacion['calificacion'];
                                            $cont_c += 1;
                                            //$suma_criterios += (($r_b_criterio_evaluacion['ponderado']/100)*$r_b_criterio_evaluacion['calificacion']);
                                          }
                                          if ($r_b_criterio_evaluacion['calificacion'] > 12 && $r_b_criterio_evaluacion['calificacion'] <= 20) {
                                            $colort = 'style="color:blue; "';
                                          } else {
                                            $colort = 'style="color:red; "';
                                          }
                                          echo '<td width="20px"><input class="nota_input" type="number" ' . $colort . ' id="" name="' . $r_b_est['dni'] . '_' . $r_b_criterio_evaluacion['id'] . '" value="' . $r_b_criterio_evaluacion['calificacion'] . '" min="0" max="20" size="1" maxlength="1"></td>';
                                        }

                                        //$suma_evaluacion += ($r_b_evaluacion['ponderado']/100)*$suma_criterios;
                                        if ($cont_c > 0) {
                                          $calificacion = round($suma_criterios / $cont_c);
                                        } else {
                                          $calificacion = round($suma_criterios);
                                        }
                                        //$calificacion = $suma_criterios/$cont_c;
                                        if ($calificacion == 0) {
                                          $mostrar = "";
                                        } else {
                                          $mostrar = round($calificacion);
                                        }
                                        if ($mostrar > 12) {
                                          echo '<th><center><font color="blue">' . $mostrar . '</font></center></th>';
                                        } else {
                                          echo '<th><center><font color="red">' . $mostrar . '</font></center></th>';
                                        }
                                        $suma_evaluacion += ($r_b_evaluacion['ponderado'] / 100) * $calificacion;
                                      }
                                      if ($suma_evaluacion != 0) {
                                        $calificacion_e = round($suma_evaluacion);
                                      } else {
                                        $calificacion_e = "";
                                      }
                                      if ($calificacion_e > 12) {
                                        //echo '<td><center><font color="blue">'.$calificacion.'</font></center></td>';
                                        echo '<th><center><font color="blue">' . $calificacion_e . '</font></center></th>';
                                      } else {
                                        //echo '<td><center><font color="red">'.$calificacion.'</font></center></td>';
                                        echo '<th><center><font color="red">' . $calificacion_e . '</font></center></th>';
                                      }
                                    }

                                    ?>


                                  </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                            <div align="center">
                              <br>
                              <br>
                              <a href="calificaciones.php?id=<?php echo $id_prog; ?>" class="btn btn-danger">Regresar</a>
                              <button type="submit" class="btn btn-success">Guardar</button>

                            </div>
                          </form>
                        </div>
                      </div>
                  <?php }
                  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php
        include("../include/footer.php");
        ?>
        <!-- /footer content -->
      </div>
    </div>
    <!-- jQuery -->
    <script src="../Gentella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../Gentella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../Gentella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../Gentella/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../Gentella/vendors/iCheck/icheck.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../Gentella/build/js/custom.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#example').DataTable({
          "order": [
            [1, "asc"]
          ],
          "language": {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "infoThousands": ",",
            "loadingRecords": "Cargando...",
            "paginate": {
              "first": "Primero",
              "last": "Último",
              "next": "Siguiente",
              "previous": "Anterior"
            },

          }
        });

      });
    </script>
    <script type="text/javascript">
      function lansarForm(data) {
        let detalle_eva = document.getElementById("detalle_eva_" + data).value
        let orden_crit = document.getElementById("ord_crit_" + data).value
        let detalle_crit = document.getElementById("ndetalle_" + data).value
        let peso_crit = document.getElementById("peso_crit_" + data).value
        let id_prog = document.getElementById("id_prog").value
        let nro_calificacion = document.getElementById("nro_calificacion").value
        window.location = 'operaciones/actualizar_criterio.php?id=' + data + '&id_prog=' + id_prog + '&ncalif=' + nro_calificacion + '&detalle_eva=' + detalle_eva + '&detalle_crit=' + detalle_crit + '&orden_crit=' + orden_crit + '&peso_crit=' + peso_crit;

      };

      function actualizarEvaluacion(id) {
        let peso_eva = document.getElementById("peso_evav_" + id).value
        let id_prog = document.getElementById("id_prog").value
        let nro_calificacion = document.getElementById("nro_calificacion").value
        window.location = 'operaciones/actualizar_evaluacion.php?id=' + id + '&id_prog=' + id_prog + '&ncalif=' + nro_calificacion + '&peso_eva=' + peso_eva;

      };
    </script>
    <?php mysqli_close($conexion); ?>
  </body>

  </html>
<?php
}
?>