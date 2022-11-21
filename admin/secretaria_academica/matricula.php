<?php
include 'include/verificar_sesion.php';
include '../../include/conexion.php';
include '../include/busquedas.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="es-ES">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  
    <title>unidades didácticas<?php include ("../../include/header_title.php"); ?></title>
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
          include ("include/menu.php"); ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">



            <div class="row">
              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos de Matrícula</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form role="form" id="myform" action="operaciones/registrar_programacion.php" class="form-horizontal form-label-left input_mask" method="POST" >

                    <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">DNI estudiante: </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input class="form-control" type="number" name="dni_est" id="dni_est">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <button type="button" class="btn btn-success" onclick="recargarest();">Buscar</button>
                                
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Estudiante : </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="hidden" id="id_est" name="id_est">
                                <input type="hidden" id="id_pe" name="id_pe">
                                <input type="hidden" id="id_sem" name="id_sem">
                                <input class="form-control" type="text" name="estudiante" id="estudiante" readonly>
                                <br>
                            </div>
                        </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Programa de Estudios : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" id="carrera_m" name="carrera_m" value="" required="required">
                            <option></option>
                            <!-- datos a traer segun los datos del estudiante -->
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
                            while ($res__busc_sem = mysqli_fetch_array($ejec_busc_sem)) {
                              $id_sem = $res__busc_sem['id'];
                              $sem = $res__busc_sem['descripcion'];
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
                      
                      <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Seleccione 
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12" id="udss">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option one. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                          
                        </div>
                      </div>
                      
                      
                      
                      <div align="center">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                          
                          <button type="submit" class="btn btn-primary">Guardar</button>
                      </div>

                    </form>
                  </div>
                </div>


                


              </div>

              <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Unidades Didácticas</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left">
                      <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label">Checkboxes and radios
                          <br>
                          <small class="text-navy">Normal Bootstrap elements</small>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option one. select more than one options
                            </label>
                          </div>
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" value=""> Option two. select more than one options
                            </label>
                          </div>
                        </div>
                      </div>
   


                      <div class="ln_solid"></div>

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
    <!--script para obtener los datos dependiendo del dni-->
    <script type="text/javascript">
      $(document).ready(function(){
        
        recargar_ud();
        $('#modulo').change(function(){
        recargar_ud();
        });
        $('#semestre').change(function(){
        recargar_ud();
        });
        
      })
    </script>
    <script type="text/javascript">
         function recargarest(){
        // Creando el objeto para hacer el request
        var request = new XMLHttpRequest();
        request.responseType = 'json';

        // Objeto PHP que consultaremos
        request.open("POST", "../operaciones/obtener_estudiante.php");

        // Definiendo el listener
        request.onreadystatechange = function(){
            // Revision si fue completada la peticion y si fue exitosa
            if(this.readyState === 4 && this.status === 200) {
                // Ingresando la respuesta obtenida del PHP
                document.getElementById("id_est").value = this.response.id_est;
                document.getElementById("estudiante").value = this.response.nombre;
                document.getElementById("id_pe").value = this.response.pe;
                document.getElementById("id_sem").value = this.response.sem;
                cargarpe();
            }
        };

        // Recogiendo la data del HTML
        var myForm = document.getElementById("myform");
        var formData = new FormData(myForm);

        // Enviando la data al PHP
        request.send(formData);
    }
    </script>
    <script type="text/javascript">
     function cargarpe(){
      $.ajax({
        type:"POST",
        url:"../operaciones/obtener_pe.php",
        data:"id="+ $('#id_pe').val(),
          success:function(r){
            $('#carrera_m').html(r);
          }
      });
     }
    </script>
    <script type="text/javascript">
     function recargar_ud(){
      var carr = $('#modulo').val();
      var sem = $('#semestre').val();
      $.ajax({
        type:"POST",
        url:"../operaciones/obtener_ud_sem.php",
        data: {id_modulo: carr, id_semestre: sem},
          success:function(r){
            $('#unidad_didactica').html(r);
          }
      });
     }

    </script>
    
    
     <?php mysqli_close($conexion); ?>
  </body>
</html>
