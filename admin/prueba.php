<?php
include 'include/verificar_sesion_secretaria.php';
include '../include/conexion.php';
include 'include/busquedas.php';
$id_periodo_select = $_SESSION['periodo'];

$b_perido_act = buscarPeriodoAcadById($conexion, $id_periodo_select);
$r_b_per_act = mysqli_fetch_array($b_perido_act);
$fecha_actual = strtotime(date("d-m-Y"));
$fecha_fin_per = strtotime($r_b_per_act['fecha_fin']);
if ($fecha_fin_per >= $fecha_actual) {
    $agregar = 1;
} else {
    $agregar = 0;
}
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

    <title>Licencias <?php include("../include/header_title.php"); ?></title>
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
  <!-- Datatables -->
  <link href="../Gentella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../Gentella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../Gentella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../Gentella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../Gentella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="../Gentella/build/css/custom.min.css" rel="stylesheet">
  <!-- Script obtenido desde CDN jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!--menu-->
            <?php
            include("include/menu_secretaria.php"); ?>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">

                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="">
                                    <h2 align="center">Licencias</h2>
                                    <?php if ($agregar) { ?>
                                        <button class="btn btn-success" data-toggle="modal" data-target=".nuevo"><i class="fa fa-plus-square"></i> Nuevo</button>
                                        <!--MODAL NUEVA LICENCIA -->
                                        <div class="modal fade nuevo" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title" id="myModalLabel" align="center">Reporte Individual Calificaciones y Asistencia</h4>
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
                                                                <form role="form" action="reporte_nomina_semestre.php" class="form-horizontal form-label-left input_mask" method="POST">
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">DNI : </label>
                                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                                            <input type="text" class="form-control" name="dni_estt" id="dni_estt">
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombres y Apellidos : </label>
                                                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                                                            <input type="text" class="form-control" name="na_estt" id="na_estt">
                                                                            <br>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                                            <center>
                                                                                <button type="button" class="btn btn-info " onclick="listar_est();"><i class="fa fa-search"></i> Buscar</button>
                                                                            </center>
                                                                        </div>
                                                                    </div>
                                                                </form>

                                                                <div id="contenido_mm" class="table-responsive">
                                                                    <table class="table table-striped table-bordered" style="width:100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Nro</th>
                                                                                <th>DNI</th>
                                                                                <th>Apellidos y Nombres</th>
                                                                                <th>Programa de Estudios</th>
                                                                                <th>Semestre</th>
                                                                                <th>Acciones</th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $b_estbyperiodo = buscarMatriculaByIdPeriodo($conexion, $id_periodo_select);
                                                                            while ($r_b_mat = mysqli_fetch_array($b_estbyperiodo)) {
                                                                                $b_est = buscarEstudianteById($conexion, $r_b_mat['id_estudiante']);
                                                                                $r_b_est = mysqli_fetch_array($b_est);

                                                                                $b_pe = buscarCarrerasById($conexion, $r_b_mat['id_programa_estudio']);
                                                                                $r_b_pe = mysqli_fetch_array($b_pe);

                                                                                $b_sem = buscarSemestreById($conexion, $r_b_mat['id_semestre']);
                                                                                $r_b_sem = mysqli_fetch_array($b_sem);
                                                                                $cont += 1;
                                                                                echo '<tr>
                                      <td>' . $cont . '</td>
                                      <td>' . $r_b_est['dni'] . '</td>
                                      <td>' . $r_b_est['apellidos_nombres'] . '</td>
                                      <td>' . $r_b_pe['nombre'] . '</td>
                                      <td>' . $r_b_sem['descripcion'] . '</td>
                                      <td>
                                      <form role="form" action="reporte_individual.php" method="POST">
                                      <input type="hidden" name="id" value="' . $r_b_est['id'] . '">
                                      <button type="submit" class="btn btn-success">Ver Reporte</button>
                                      </form>
                                      </td></tr>';
                                                                            }



                                                                            ?>


                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--FIN DE CONTENIDO DE MODAL-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- FIN MODAL LICENCIA-->
                                    <?php
                                    } ?>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />

                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nro</th>
                                                <th>DNI</th>
                                                <th>Estudiante</th>
                                                <th>Programa de Estudios</th>
                                                <th>Semestre</th>
                                                <th>Nro de Resolución</th>
                                                <?php if ($agregar) {
                                                    echo '<th>Acciones</th>';
                                                } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cont_table = 0;
                                            $ejec_busc_licencia = buscarLicenciaPeriodo($conexion, $id_periodo_select);
                                            while ($res_busc_licencia = mysqli_fetch_array($ejec_busc_licencia)) {
                                                $cont_table += 1;
                                            ?>
                                                <tr>
                                                    <td><?php echo $cont_table; ?></td>
                                                    <?php
                                                    $id_estudiante = $res_busc_licencia['id_estudiante'];
                                                    $b_estu = buscarEstudianteById($conexion, $id_estudiante);
                                                    $res_b_estudiante = mysqli_fetch_array($b_estu);

                                                    $id_programa_estudio = $res_busc_licencia['id_programa_estudio'];
                                                    $id_semestre = $res_busc_licencia['id_semestre'];

                                                    $busc_semestre = buscarSemestreById($conexion, $id_semestre);
                                                    $res_b_semestre = mysqli_fetch_array($busc_semestre);

                                                    $ejec_busc_carrera = buscarCarrerasById($conexion, $id_programa_estudio);
                                                    $res_busc_carrera = mysqli_fetch_array($ejec_busc_carrera);
                                                    ?>
                                                    <td><?php echo $res_b_estudiante['dni']; ?></td>
                                                    <td><?php echo $res_b_estudiante['apellidos_nombres']; ?></td>
                                                    <td><?php echo $res_busc_carrera['nombre']; ?></td>
                                                    <?php

                                                    ?>
                                                    <td><?php echo $res_b_semestre['descripcion']; ?></td>
                                                    <td><?php echo $res_busc_licencia['licencia']; ?></td>
                                                    <?php if ($agregar) {
                                                        echo '<td>
                                                        <a class="btn btn-success" href="editar_matricula.php?id=' . $res_busc_licencia['id'] . '"><i class="fa fa-pencil-square-o"></i> </a>
                                                        </td>';
                                                    } ?>


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
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
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
        function listar_est() {
            var dni_e = $('#dni_estt').val();
            var na_e = $('#na_estt').val();
            $.ajax({
                type: "POST",
                url: "operaciones/listar_est_licencia.php",
                data: {
                    dni_es: dni_e,
                    na_es: na_e
                },
                success: function(r) {
                    $('#contenido_mm').html(r);
                }
            });
        }
    </script>

    <?php mysqli_close($conexion); ?>
</body>

</html>