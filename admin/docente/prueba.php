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
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Evaluación<?php include ("../../include/header_title.php"); ?></title>
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

    <!-- Custom Theme Style -->
    <link href="../../Gentella/build/css/custom.min.css" rel="stylesheet">
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
            

            <div class="row">
              <div class="clearfix"></div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <div class="">
                    <h2 align="center"><b>Evaluación - <?php echo $r_b_ud['descripcion']; ?></b></h2>
                    
                    <div class="clearfix"></div>
                  </div>    
                  <br>
                  <div class="x_content">
                    <form role="form" action="operaciones/actualizar_calificacion.php" class="form-horizontal form-label-left input_mask" method="POST" >
                    <input type="hidden" name="id_prog" value="<?php echo $id_prog; ?>">
                    <input type="hidden" name="cant_calif" value="<?php echo $total_indicadores; ?>">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th rowspan="2">Nro</th>
                          <th rowspan="2">DNI</th>
                          <th rowspan="2">APELLIDOS Y NOMBRES</th>
                          <th colspan="<?php echo $total_indicadores; ?>">CALIFICACIONES</th>
                          <th rowspan="2"><center>PROMEDIO</center></th>
                        </tr>
                        <tr>
                            <?php 
                            for ($i=1; $i <= $total_indicadores; $i++) { 
                                echo "<th>Calif.".$i."</th>";
                            }
                            ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $b_detalle_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
                        while ($r_b_det_mat = mysqli_fetch_array($b_detalle_mat)) {
                            $b_matricula = buscarMatriculaById($conexion, $r_b_det_mat['id_matricula']);
                            $r_b_mat = mysqli_fetch_array($b_matricula);
                            $b_estudiante = buscarEstudianteById($conexion,$r_b_mat['id_estudiante']);
                            $r_b_est = mysqli_fetch_array($b_estudiante);
                        ?>
                        <tr>
                          <th scope="row">1</th>
                          <td><?php echo $r_b_est['dni']; ?></td>
                          <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                          <?php 
                          //buscar las calificaciones
                          $b_calificaciones = buscarCalificacionByIdDetalleMatricula($conexion, $r_b_det_mat['id']);
                          $suma_notas = 0;
                          $cont_notas = 0;
                          while ($r_b_calificacion = mysqli_fetch_array($b_calificaciones)) {
                            if ($r_b_calificacion['calificacion']!="") {
                                $cont_notas++;
                                $suma_notas = $suma_notas + $r_b_calificacion['calificacion'];
                            }
                            echo '<td><input type="number" id="'.$r_b_est['dni']."_".$r_b_calificacion['nro_calificacion'].'" name="'.$r_b_est['dni']."_".$r_b_calificacion['nro_calificacion'].'" value="'.$r_b_calificacion['calificacion'].'" min="0" max="20"></td>';
                          }
                          ?>
                          <td><center><b><?php echo number_format($suma_notas/$cont_notas, 0); ?></center></b></td>
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
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
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

    <!-- Custom Theme Scripts -->
    <script src="../../Gentella/build/js/custom.min.js"></script>
  </body>
</html>
<?php
}
?>