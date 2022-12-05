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
	  
    <title>Sesiones de Aprendizaje<?php include ("../../include/header_title.php"); ?></title>
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
    <!-- bootstrap-progressbar -->
    <link href="../../Gentella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../../Gentella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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
        //buscar programa de estudio
        $b_pe = buscarCarrerasById($conexion, $r_b_ud['id_programa_estudio']);
        $r_b_pe = mysqli_fetch_array($b_pe);
        //buscar modulo profesional
        $b_mod = buscarModuloFormativoById($conexion, $r_b_ud['id_modulo']);
        $r_b_mod = mysqli_fetch_array($b_mod);
        //buscar semestre
        $b_sem = buscarSemestreById($conexion, $r_b_ud['id_semestre']);
        $r_b_sem = mysqli_fetch_array($b_sem);
        //buscamos el silabo y sus datos
        $b_silabo = buscarSilaboByIdProgramacion($conexion, $id_prog);
        $r_b_silabo = mysqli_fetch_array($b_silabo);
        $id_silabo = $r_b_silabo['id'];
        
        ?>

        <!-- page content -->
        <div class="right_col" role="main">
          
           
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="">
                    <h2 align="center">Sesiones de Aprendizaje - <?php echo $r_b_ud['descripcion']; ?></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Semana</th>
                          <th>Unidad Didactica</th>
                          <th>Docente</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          //buscamos las programaciones de actividades
                            $b_prog_act = buscarProgActividadesSilaboByIdSilabo($conexion, $id_silabo);
                            while ($res_b_prog_act=mysqli_fetch_array($b_prog_act)){
                                // buscamos la sesion que corresponde
                                $id_act = $res_b_prog_act['id'];
                                $b_sesion = buscarSesionByIdProgramacionActividades($conexion, $id_act);
                                $r_b_sesion = mysqli_fetch_array($b_sesion);
                                $id_sesion = $r_b_sesion['id'];
                                $id_docente = $res_b_prog['id_docente'];
                        ?>
                        <tr>
                          <td><?php echo $res_b_prog_act['semana']; ?></td>
                          <td><?php echo $r_b_ud['descripcion']; ?></td>
                          <?php 
                          $ejec_busc_docente= buscarDocenteById($conexion, $id_docente);
                          $res_busc_docente =mysqli_fetch_array($ejec_busc_docente);
                          ?>
                          <td><?php echo $res_busc_docente['apellidos_nombres']; ?></td>
                          <td>
                            <a title="Ver / Editar" class="btn btn-success" href="sesion_de_aprendizaje.php?id=<?php echo $r_b_sesion['id']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                            <a title="Imprimir" class="btn btn-info" target="_blank" href="imprimir_sesion.php?data=<?php echo $r_b_sesion['id']; ?>"><i class="fa fa-print"></i></a>
                          </td>
                        </tr>  
                        <?php
                          };
                        ?>

                      </tbody>
                    </table>
                    
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
<?php } ?>
