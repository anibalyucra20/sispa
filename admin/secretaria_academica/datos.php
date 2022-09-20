<?php
  include ("include/verificar_sesion.php");
  include ("../../include/conexion.php");
  include ("../include/busquedas.php");
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
	  
    <title>Datos Institucionales<?php include ("../../include/header_title.php"); ?></title>
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
    <!-- Script obtenido desde CDN jquery -->
    <script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
  </head>

  <body class="nav-md" onload="desactivar_controles();">
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
                    <h2 align="center">Datos Institucionales</h2>
                   

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                  <div class="x_panel">
                    <?php
                    $buscar = buscarDatosGenerales($conexion);
                    $res = mysqli_fetch_array($buscar);
                    ?>
                  <div class="x_content">
                    <br />
                    <form role="form" id="myform" action="operaciones/actualizar_datos_institucion.php" class="form-horizontal form-label-left input_mask" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="id" value="<?php echo $res['id']; ?>">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Código Modular : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="cod_modular" id="cod_modular" required="" value="<?php echo $res['cod_modular']; ?>"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Ruc : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="number" class="form-control" name="ruc" id="ruc" required="" value="<?php echo $res['ruc']; ?>"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nombre de Institución : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="nombre" id="nombre" required="" value="<?php echo $res['nombre_institucion']; ?>"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Departamento : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <input type="text" class="form-control" name="dep" id="dep" required="" value="<?php echo $res['departamento']; ?>"  style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Provincia : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="provincia" id="provincia" required="" value="<?php echo $res['provincia']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Distrito : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="distrito" id="distrito" required="" value="<?php echo $res['distrito']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dirección : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="direccion" id="direccion" required="" value="<?php echo $res['direccion']; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="telefono" id="telefono" required="" value="<?php echo $res['telefono']; ?>" >
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="email" id="email" required="" value="<?php echo $res['correo']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Resulución : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="resolucion" id="resolucion" required="" value="<?php echo $res['nro_resolucion']; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                          <br>
                        </div>
                      </div>
                      <div align="center">
                        <button type="submit" class="btn btn-primary" id="btn_guardar">Guardar</button> 
                        <button type="button" class="btn btn-warning" id="btn_cancelar" onclick="desactivar_controles(); cancelar();">Cancelar</button>
                    </div>
                      </div>
                    </form>
                    <div align="center">
                    <button type="button" class="btn btn-success" id="btn_editar" onclick="activar_controles();">Editar Datos</button>
                  </div>
                </div>
                          <!--FIN DE CONTENIDO DE MODAL-->
                 
            


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
    <script type="text/javascript">
        function desactivar_controles(){
            document.getElementById('cod_modular').disabled = true
            document.getElementById('ruc').disabled = true
            document.getElementById('nombre').disabled = true
            document.getElementById('dep').disabled = true
            document.getElementById('provincia').disabled = true
            document.getElementById('distrito').disabled = true
            document.getElementById('direccion').disabled = true
            document.getElementById('telefono').disabled = true
            document.getElementById('email').disabled = true
            document.getElementById('resolucion').disabled = true
            document.getElementById('btn_cancelar').style.display = 'none'
            document.getElementById('btn_guardar').style.display = 'none'
            document.getElementById('btn_editar').style.display = ''
        };
        function activar_controles(){
            document.getElementById('cod_modular').disabled = false
            document.getElementById('ruc').disabled = false
            document.getElementById('nombre').disabled = false
            document.getElementById('dep').disabled = false
            document.getElementById('provincia').disabled = false
            document.getElementById('distrito').disabled = false
            document.getElementById('direccion').disabled = false
            document.getElementById('telefono').disabled = false
            document.getElementById('email').disabled = false
            document.getElementById('resolucion').disabled = false
            document.getElementById('btn_cancelar').removeAttribute('style')
            document.getElementById('btn_guardar').removeAttribute('style')
            document.getElementById('btn_editar').style.display = 'none'
        };
        function cancelar(){
            document.getElementById('myform').reset();
        }
    </script>
    
     <?php mysqli_close($conexion); ?>
  </body>
</html>
