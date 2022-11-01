<?php
include 'include/verificar_sesion.php';
include '../../include/conexion.php';
include '../include/busquedas.php';
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="es-ES">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>Estudiantes <?php include ("../../include/header_title.php"); ?></title>
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
    <!-- bootstrap-wysiwyg -->
    <link href="../../Gentella/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../../Gentella/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="../../Gentella/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="../../Gentella/vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    
    <!-- Custom Theme Style -->
    <link href="../../Gentella/build/css/custom.min.css" rel="stylesheet">

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!--menu-->
          <?php 
          include ("include/menu.php"); ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
           
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="">
                    <h2 align="center">Estudiantes</h2>
                    <button class="btn btn-success" data-toggle="modal" data-target=".registrar"><i class="fa fa-plus-square"></i> Nuevo</button>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          <th>Identificador</th>
                          <th>DNI</th>
                          <th>Apellidos y Nombres</th>
                          <th>Telefono</th>
                          <th>Programa de Estudios</th>
                          <th>Semestre</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $ejec_busc_est = buscarEstudiante($conexion); 
                          while ($res_busc_est=mysqli_fetch_array($ejec_busc_est)){
                        ?>
                        <tr>
                          <td><?php echo $res_busc_est['id']; ?></td>
                          <td><?php echo $res_busc_est['dni']; ?></td>
                          <td><?php echo $res_busc_est['apellidos_nombres']; ?></td>
                          <td><?php echo $res_busc_est['telefono']; ?></td>
                          <?php
                            $id_p_e = $res_busc_est['id_programa_estudios'];
                            $ejec_busc_p_e = buscarCarrerasById($conexion, $id_p_e);
                            $res_busc_p_e=mysqli_fetch_array($ejec_busc_p_e);
                          ?>
                          <td><?php echo $res_busc_p_e['nombre']; ?></td>
                          <?php
                            $id_sem = $res_busc_est['id_semestre'];
                            $ejec_busc_sem = buscarSemestreById($conexion, $id_sem);
                            $res_busc_sem=mysqli_fetch_array($ejec_busc_sem);
                          ?>
                          <td><?php echo $res_busc_sem['descripcion']; ?></td>
                          <td>
                          <a class="btn btn-success" href="editar_estudiante.php?id=<?php echo $res_busc_est['id']; ?>"><i class="fa fa-pencil-square-o"></i> Editar</a></td>
                        </tr>  
                        <?php
                          };
                        ?>

                      </tbody>
                    </table>
                    

                    <!--MODAL REGISTRAR-->
  <div class="modal fade registrar" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel" align="center">Registrar Estudiante</h4>
                        </div>
                        <div class="modal-body">
                          <!--INICIO CONTENIDO DE MODAL-->
                  <div class="x_panel">
                    
                  <div class="" align="center">
                    <h2 ></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form role="form" action="operaciones/registrar_docente.php" class="form-horizontal form-label-left input_mask" method="POST" >
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">DNI : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="dni" required="required" maxlength="8">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Apellidos y Nombres : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="nom_ap" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Género : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" id="genero" name="genero" value="" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_gen = buscarGenero($conexion);
                            while ($res_busc_gen = mysqli_fetch_array($ejec_busc_gen)) {
                              $id_gen = $res_busc_gen['id'];
                              $gen = $res_busc_gen['genero'];
                              ?>
                              <option value="<?php echo $id_gen;
                              ?>"><?php echo $gen; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Condición Laboral : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="cond_laboral" value="" required="required">
                            <option></option>
                            <option value="CONTRATADO">CONTRATADO</option>
                            <option value="NOMBRADO">NOMBRADO</option>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Nacimiento : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" name="fecha_nac" required="required">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dirección : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="direccion" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo Electrónico : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="email" class="form-control" name="email" required="required">
                          <br>
                          
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="Number" class="form-control" name="telefono" required="required" maxlength="15">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Año de Ingreso : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" name="anio_ingreso" required="required">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Carrera Profesional : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control"  id="carrera" name="carrera" value="" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_carr = buscarCarreras($conexion);
                            while ($res__busc_carr = mysqli_fetch_array($ejec_busc_carr)) {
                              $id_carr = $res__busc_carr['id'];
                              $carr = $res__busc_carr['nombre'];
                              ?>
                              <option value="<?php echo $id_carr;
                              ?>"><?php echo $carr; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Semestre : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" id="semestre" name="semestre" value="" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_sem = buscarSemestre($conexion);
                            while ($res_busc_sem = mysqli_fetch_array($ejec_busc_sem)) {
                              $id_sem = $res_busc_sem['id'];
                              $sem = $res_busc_sem['descripcion'];
                              ?>
                              <option value="<?php echo $id_sem;
                              ?>"><?php echo $sem; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sección : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="seccion" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="1">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Turno : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="turno" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" value="MAÑANA">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Observación : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="observacion" value="" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_obs = buscarCondicion($conexion);
                            while ($res_busc_obs = mysqli_fetch_array($ejec_busc_obs)) {
                              $id_obs = $res_busc_obs['id'];
                              $obs = $res_busc_obs['descripcion'];
                              ?>
                              <option value="<?php echo $id_obs;
                              ?>"><?php echo $obs; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div align="center">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          
                          <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>
                    </form>
                  </div>
                </div>
                          <!--FIN DE CONTENIDO DE MODAL-->
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL REGISTRAR-->

                  </div>
                </div>
              </div>
            </div>


          </div>
        </div>
        <!-- /page content -->

        <!-- footer content 
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
         /footer content -->
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
    <!-- bootstrap-progressbar -->
    <script src="../../Gentella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../../Gentella/vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../../Gentella/vendors/moment/min/moment.min.js"></script>
    <script src="../../Gentella/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="../../Gentella/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="../../Gentella/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="../../Gentella/vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="../../Gentella/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="../../Gentella/vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="../../Gentella/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="../../Gentella/vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="../../Gentella/vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="../../Gentella/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="../../Gentella/vendors/starrr/dist/starrr.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../../Gentella/build/js/custom.min.js"></script>


	  <!--prueba tabla-->
    
    <script src="../../include/tabla/jquery.dataTables.min.js"></script>
    <script src="../../include/tabla/dataTables.bootstrap.min.js"></script>
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
