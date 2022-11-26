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
                    <<h2 align="center"><b>Evaluación - <?php echo $r_b_ud['descripcion']; ?></b></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form role="form" action="operaciones/actualizar_calificacion.php" class="form-horizontal form-label-left input_mask" method="POST" >
                    <input type="hidden" name="id_prog" value="<?php echo $id_prog; ?>">
                    <input type="hidden" name="cant_calif" value="<?php echo $total_indicadores; ?>">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                      <tr>
                          
                          <th rowspan="2"><center>DNI</center></th>
                          <th rowspan="2"><center>APELLIDOS Y NOMBRES</center></th>
                          <th colspan="<?php echo $total_indicadores; ?>"><center>CALIFICACIONES</center></th>
                          <th rowspan="2"><center>PROMEDIO</center></th>
                        </tr>
                        <tr>
                            <?php 
                            for ($i=1; $i <= $total_indicadores; $i++) { 
                                echo "<th><center>Calif.".$i."</center></th>";
                            }
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
                          <td><center><b><?php
                          if ($suma==0) {
                            echo "";
                          }else{
                          $promedio = number_format($suma_notas/$cont_notas, 0);
                          if (strlen($promedio)==1) {
                            echo "0".$promedio;
                          }else {
                            echo $promedio;
                          }
                        }
                           ?></center></b></td>
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