<?php
include 'include/verificar_sesion.php';
include '../../include/conexion.php';
include '../include/busquedas.php';
$id_prog = $_GET['id'];
$b_prog = buscarProgramacionById($conexion, $id_prog);
$res_b_prog = mysqli_fetch_array($b_prog);
if (!($res_b_prog['id_docente']==$_SESSION['id_docente'])) {
    //echo "<h1 align='center'>No tiene acceso a la evaluacion de la Unidad Didáctica</h1>";
    //echo "<br><h2><center><a href='javascript:history.back(-1);'>Regresar</a></center></h2>";
    echo "<script>
			alert('Error Usted no cuenta con los permisos para acceder a la Página Solicitada');
			window.history.back();
		</script>
	";
}else {
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
	  
    <title>Calificaciones<?php include ("../../include/header_title.php"); ?></title>
    <!--icono en el titulo-->
    <link rel="shortcut icon" href="../../img/favicon.ico">
    <!-- Bootstrap -->
    <link href="../../Gentella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../../Gentella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../../Gentella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../Gentella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../../Gentella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../../Gentella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../../Gentella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../../Gentella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../../Gentella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../../Gentella/build/css/custom.min.css" rel="stylesheet">
    <!-- Script obtenido desde CDN jquery -->
    <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>

  <style>
    p.verticalll{
  /* idéntico a rotateZ(45deg); */

  writing-mode: vertical-lr;
transform: rotate(180deg);

  
}
  </style>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!--menu-->
          <?php 
          include ("include/menu.php"); 
          $b_ud = buscarUdById($conexion, $res_b_prog['id_unidad_didactica']);
        $r_b_ud = mysqli_fetch_array($b_ud);
        //buscamos la cantidad de indicadores para definir la cantidad de calificaciones
        $b_capacidades =buscarCapacidadesByIdUd($conexion, $res_b_prog['id_unidad_didactica']);
        $total_indicadores = 0;
        while ($r_b_capacidades = mysqli_fetch_array($b_capacidades)) {
            $b_indicador_capac = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $r_b_capacidades['id']);
            $cont_indicadores = mysqli_num_rows($b_indicador_capac);
            $total_indicadores = $total_indicadores+$cont_indicadores;
        };
          ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
           
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="">
                    <h2 align="center"><b>Calificaciones - <?php echo $r_b_ud['descripcion']; ?></b></h2>
                    <form action="prueba_tcpdf.php" method="POST" target="_blank">
                      <input type="hidden" name="data" value="<?php echo $id_prog; ?>" >
                    <button type="submit" class="btn btn-info">Imprimir</button>
                    </form>
                    <form action="generar_excel.php" method="POST" target="_blank">
                      <input type="hidden" name="data" value="<?php echo $id_prog; ?>" >
                    <button type="submit" class="btn btn-warning">Reporte Registra</button>
                    </form>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>
                    <form role="form" action="operaciones/actualizar_ponderado_calificacion.php" class="form-horizontal form-label-left input_mask" method="POST" >
                    <input type="hidden" name="id_prog" value="<?php echo $id_prog; ?>">
                    
                    <table id="" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                      <tr>
                          
                          <th rowspan="2"><center>DNI</center></th>
                          <th rowspan="2"><center>APELLIDOS Y NOMBRES</center></th>
                          <th colspan="<?php echo $total_indicadores; ?>"><center>INDICADORES DE LOGRO</center></th>
                          <th rowspan="2"><center><p class="verticalll">RECUPERACION</p></center></th>
                          <th rowspan="2"><center><p class="verticalll">PROMEDIO FINAL</p></center></th>
                        </tr>
                        <tr>
                            <?php
                            $b_capacidades =buscarCapacidadesByIdUd($conexion, $res_b_prog['id_unidad_didactica']);
                            $cont_ind = 1;
                            
                                  $b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
                                  $r_b_det_mat = mysqli_fetch_array($b_detalle_mat);
                                  $b_calificacion = buscarCalificacionByIdDetalleMatricula($conexion, $r_b_det_mat['id']);
                                  
                                  while ($r_b_calificacion = mysqli_fetch_array($b_calificacion)) {
                                    ?>
                                    <th><center>Indicador - <?php echo $cont_ind; ?> <a class="btn btn-primary" href="evaluacion_b.php?data=<?php echo $id_prog;?>&data2=<?php echo $cont_ind; ?>"><i class="fa fa-edit"></i> Evaluar</a><br>Ponderado: 
                                    <input type="number" name="ponderad_<?php echo $cont_ind; ?>" value="<?php echo $r_b_calificacion['ponderado']; ?>" min="0" max="100" >%</center></th>
                                    <?php
                                    $cont_ind +=1;
                                  }
                                  ?>

                                  <?php
                                  
                                
                                
                            
                            
                            
                            ?>
                            
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
                        $orden = 0;
                        while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
                            $orden++;
                            $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
                            $r_b_mat = mysqli_fetch_array($b_matricula);
                            $b_estudiante = buscarEstudianteById($conexion,$r_b_mat['id_estudiante']);
                            $r_b_est = mysqli_fetch_array($b_estudiante);
                        ?>
                        <tr>
                         
                          <td><?php echo $r_b_est['dni']; ?></td>
                          <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                          <?php 
                          //buscar las calificaciones
                          $b_calificaciones = buscarCalificacionByIdDetalleMatricula($conexion, $r_b_det_mat['id']);
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
                              if ($cont_crit>0) {
                                $suma_criterios = round($suma_criterios/$cont_crit);
                              }else {
                                $suma_criterios = round($suma_criterios);
                              }
                              
                              $suma_evaluacion += ($r_b_evaluacion['ponderado']/100)*$suma_criterios;
                            }
                              $suma_calificacion += ($r_b_calificacion['ponderado']/100)*$suma_evaluacion;
                              
                            if ($suma_evaluacion != 0) {
                              $calificacion = round($suma_evaluacion);
                            }else {
                              $calificacion = "";
                            }
                            if ($calificacion>12) {
                              //echo '<td><center><font color="blue">'.$calificacion.'</font></center></td>';
                              echo '<td><center><input type="number" style="color:blue;" value="'.$calificacion.'" min="0" max="20" disabled></center></td>';
                            }else{
                              //echo '<td><center><font color="red">'.$calificacion.'</font></center></td>';
                              echo '<td><center><input type="number" style="color:red;" value="'.$calificacion.'" min="0" max="20" disabled></center></td>';
                            }
                          }
                          ?>
                          
                          
                            <?php
                            if ($suma_calificacion != 0) {
                              $calificacion_final = round($suma_calificacion);
                            }else {
                              $calificacion_final = "";
                            }
                            if ($calificacion_final<=12 && $calificacion_final>=10) {
                              if ($r_b_det_mat['recuperacion']>12) {
                                echo'<td><input type="number" style="color:blue;" name="recuperacion_'.$r_b_det_mat['id'].'" value="'.$r_b_det_mat['recuperacion'].'" min="0" max="20" ></td>';
                              }else{
                                echo'<td><input type="number" style="color:red;" name="recuperacion_'.$r_b_det_mat['id'].'" value="'.$r_b_det_mat['recuperacion'].'" min="0" max="20" ></td>';
                              }

                            }else{
                              echo'<td></td>';
                            }
                            if ($r_b_det_mat['recuperacion']!='') {
                                $calificacion_final = $r_b_det_mat['recuperacion'];
                            }
                            if ($calificacion_final>12) {
                              //echo '<th><center><font color="blue">'.$calificacion_final.'</font></center></th>';
                              echo '<th><center><input type="number" style="color:blue;" value="'.$calificacion_final.'" min="0" max="20" disabled></center></th>';
                            }else{
                              
                              //echo '<th><center><font color="red">'.$calificacion_final.'</font></center></th>';
                              echo '<th><center><input type="number" style="color:red;" value="'.$calificacion_final.'" min="0" max="20" disabled></center></th>';
                            }
                           ?>
                            
                           
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <div align="center">
                        <br>
                        <br>
                        <a href="unidades_didacticas.php" class="btn btn-danger">Regresar</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                        
                    </div>
                  </form>


          </div>
          </div>
          </div>
          </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php
        include ("../../include/footer.php"); 
        ?>
        <!-- /footer content -->
      </div>
    </div>
   <!-- jQuery -->
   <script src="../../Gentella/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../../Gentella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../../Gentella/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../../Gentella/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../../Gentella/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../../Gentella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../Gentella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../../Gentella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../../Gentella/vendors/jszip/dist/jszip.min.js"></script>
    <script src="../../Gentella/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../../Gentella/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../../Gentella/build/js/custom.min.js"></script>
    <script>
    $(document).ready(function() {
    $('#example').DataTable({
      "order": [[ 1, "asc"]],
      "language":{
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

    } );
    </script>
    


    
     <?php mysqli_close($conexion); ?>
  </body>
</html>
<?php
}
?>