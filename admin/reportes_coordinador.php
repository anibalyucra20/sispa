<?php
  include ("include/verificar_sesion_coordinador.php");
  include ("../include/conexion.php");
  include ("include/busquedas.php");

  
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reportes<?php include ("../include/header_title.php"); ?></title>
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
    <!-- bootstrap-progressbar -->
    <link href="../Gentella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../Gentella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../Gentella/build/css/custom.min.css" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
          <?php 
          include ("include/menu_coordinador.php"); 
          $id_pe = $res_b_u_sesion['id_programa_estudio'];
          ?>
        <!-- page content -->
        <div class="right_col" role="main">
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="" data-toggle="modal" data-target=".registrar">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-anchor"></i></div>
                        <div class="count"> Reporte</div>
                        <h3>Consolidado por Semestre</h3>
                        <p>Reporte Consolidado por Semestre</p>
                    </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-comments-o"></i></div>
                        <div class="count">Reporte</div>
                        <h3>Indivual</h3>
                        <p>Reporte Individual Por Estudiante</p>
                    </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-sort-amount-desc"></i></div>
                        <div class="count">Reporte</div>
                        <h3>Asistencia</h3>
                        <p>Reporte de Asistena por Estudiante</p>
                    </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="">
                    <div class="tile-stats">
                        <div class="icon"><i class="fa fa-check-square-o"></i></div>
                        <div class="count">Reporte</div>
                        <h3>Primeros Puestos</h3>
                        <p>Reporte de Primeros Puestos por Semestre</p>
                    </div>
                </a>
              </div>
            </div>
        </div>
        <!--MODAL REPORTE CONSOLIDADO-->
        <div class="modal fade registrar" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel" align="center">Reporte Consolidado por Semestre</h4>
                    </div>
                    <div class="modal-body">
                        <!--INICIO CONTENIDO DE MODAL-->
                        <div class="x_panel">
                            <div class="" align="center">
                                <h2></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br />
                                <form role="form" action="reporte_consolidado_semestre.php" class="form-horizontal form-label-left input_mask" method="POST" >
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Semestre : </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="hidden" name="car_consolidado" value="<?php echo $id_pe; ?>">
                                            <select class="form-control" name="sem_consolidado" id="sem_consolidado" required>
                                                <option value=""></option>
                                                <?php 
                                                $b_sem_consolidado = buscarSemestre($conexion);
                                            
                                                while ($r_b_sem_conso = mysqli_fetch_array($b_sem_consolidado)) {
                                            
                                                ?>
                                                <option value="<?php echo $r_b_sem_conso['id']; ?>"><?php echo $r_b_sem_conso['descripcion']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            
                                            </select>
                                            <br>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <center>
                                                <button type="submit" class="btn btn-success">Generar Reporte</button>
                                            </center>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--FIN DE CONTENIDO DE MODAL-->
                    </div>
                </div>
            </div>
        </div>

        <!-- FIN MODAL NUEVO-->
   
        Aún en desarrollo
          

        </div>
        <!-- /page content -->

        
         <!-- footer content -->
         <?php
        include ("../include/footer.php"); 
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
    <!-- Chart.js -->
    <script src="../Gentella/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../Gentella/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../Gentella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../Gentella/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../Gentella/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../Gentella/vendors/Flot/jquery.flot.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.time.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../Gentella/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../Gentella/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../Gentella/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../Gentella/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../Gentella/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../Gentella/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../Gentella/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../Gentella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../Gentella/vendors/moment/min/moment.min.js"></script>
    <script src="../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../Gentella/build/js/custom.min.js"></script>
	 
  </body>
</html>
