<?php
include("../include/conexion.php");
include("../include/busquedas.php");
include("../include/funciones.php");

include("include/verificar_sesion_estudiante.php");

if (!verificar_sesion($conexion)) {
    echo "<script>
                alert('Error Usted no cuenta con permiso para acceder a esta página');
                window.location.replace('index.php');
    		</script>";
} else {

    $id_estudiante_sesion = buscar_estudiante_sesion($conexion, $_SESSION['id_sesion_est'], $_SESSION['token']);
    $b_estudiante = buscarEstudianteById($conexion, $id_estudiante_sesion);
    $r_b_estudiante = mysqli_fetch_array($b_estudiante);

    $per_select = $_SESSION['periodo'];

    $b_perido = buscarPeriodoAcadById($conexion, $per_select);
    $r_b_per = mysqli_fetch_array($b_perido);

    $b_matricula = buscarMatriculaByEstudiantePeriodo($conexion, $id_estudiante_sesion, $per_select);
    $r_b_matricula = mysqli_fetch_array($b_matricula);
    $id_matricula = $r_b_matricula['id'];
    $b_det_mat = buscarDetalleMatriculaByIdMatricula($conexion, $id_matricula);
    $cont_det_mat = mysqli_num_rows($b_det_mat);

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

        <title>Tutoría<?php include("../include/header_title.php"); ?></title>
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
        <link href="../Gentella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
        <!-- bootstrap-daterangepicker -->
        <link href="../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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


                include("include/menu.php");

                ?>

                <!-- page content -->
                <div class="right_col" role="main">


                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="">
                                    <h2 align="center">Sesiones de Tutoría Programadas</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />

                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nro</th>
                                                <th>Tipo Sesion</th>
                                                <th>Docente</th>
                                                <th>Título</th>
                                                <th>Tema</th>
                                                <th>Fecha y Hora</th>
                                                <th>Link Reunión</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $b_tut_estudiante = buscarTutoria_EstudianteByIdEstudiante($conexion, $id_estudiante_sesion);
                                            $r_b_tut_estudiante = mysqli_fetch_array($b_tut_estudiante);
                                            $b_tutoria = buscarTutoriaById($conexion, $r_b_tut_estudiante['id_tutoria']);
                                            $r_b_tutoria = mysqli_fetch_array($b_tutoria);
                                            if ($r_b_tutoria['id_periodo_acad'] == $per_select) {
                                                $b_docente = buscarDocenteById($conexion, $r_b_tutoria['id_docente']);
                                                $r_b_docente = mysqli_fetch_array($b_docente);
                                                $contador = 0;

                                                // buscar sesion individual
                                                $b_sesion_individual = buscarTutoriaSesIndivByIdTutEst($conexion, $r_b_tut_estudiante['id']);
                                                while ($r_b_sesion_indiv = mysqli_fetch_array($b_sesion_individual)) {
                                                    $contador++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $contador; ?></td>
                                                        <td>Individual</td>
                                                        <td><?php echo $r_b_docente['apellidos_nombres']; ?></td>
                                                        <td><?php echo $r_b_sesion_indiv['titulo']; ?></td>
                                                        <td><?php echo $r_b_sesion_indiv['motivo']; ?></td>
                                                        <td><?php echo $r_b_sesion_indiv['fecha_hora']; ?></td>
                                                        <td><a href="<?php  echo $r_b_sesion_indiv['link_reunion']; ?>" target="_blank"><?php echo $r_b_sesion_indiv['link_reunion']; ?></a></td>
                                                    </tr>
                                                    <?php
                                                }
                                                //buscar sesiones grupales
                                                $b_sesion_grupal = buscarTutoriaSesGrupalByIdTutoria($conexion, $r_b_tutoria['id']);
                                                while ($r_b_sesion_grupal = mysqli_fetch_array($b_sesion_grupal)) {
                                                    $contador++;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $contador; ?></td>
                                                        <td>Grupal</td>
                                                        <td><?php echo $r_b_docente['apellidos_nombres']; ?></td>
                                                        <td><?php echo $r_b_sesion_grupal['titulo']; ?></td>
                                                        <td><?php echo $r_b_sesion_grupal['tema']; ?></td>
                                                        <td><?php echo $r_b_sesion_grupal['fecha_hora']; ?></td>
                                                        <td><a href="<?php echo $r_b_sesion_grupal['link_reunion']; ?>" target="_blank"><?php echo $r_b_sesion_grupal['link_reunion']; ?></a></td>
                                                    </tr>
                                                <?php
                                                }
                                                
                                            }
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
        <!-- Datatables -->
        <script src="../Gentella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="../Gentella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
        <script src="../Gentella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
        <script src="../Gentella/vendors/jszip/dist/jszip.min.js"></script>
        <script src="../Gentella/vendors/pdfmake/build/pdfmake.min.js"></script>
        <script src="../Gentella/vendors/pdfmake/build/vfs_fonts.js"></script>

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


        <?php mysqli_close($conexion); ?>
    </body>

    </html>
<?php }
