
<!--MODAL EDITAR-->
<div class="modal fade edit_<?php echo $res_busc_est['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel" align="center">Editar Datos de Docente</h4>
                        </div>
                        <div class="modal-body">
                          <!--INICIO CONTENIDO DE MODAL-->
                  <div class="x_panel">
                    
                  
                  <div class="x_content">
                    <br />
                    <form role="form" action="operaciones/actualizar_docente.php" class="form-horizontal form-label-left input_mask" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="id" value="<?php echo $res_busc_est['id']; ?>">
                      <input type="hidden" name="dni_a" value="<?php echo $res_busc_est['dni']; ?>">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dni : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="dni" required="" maxlength="8" value="<?php echo $res_busc_est['dni']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Apellidos y Nombres : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="ap_nom" required="" value="<?php echo $res_busc_est['apellidos_nombre']; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Condición Laboral : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="cond_laboral" value="" required="required">
                            <option></option>
                            <option value="CONTRATADO" <?php if ("CONTRATADO"==$res_busc_est['cond_laboral']): 
                            echo 'selected="selected"';
                             endif ?>>CONTRATADO</option>
                            <option value="NOMBRADO" <?php if ("NOMBRADO"==$res_busc_est['cond_laboral']): 
                            echo 'selected="selected"';
                             endif ?>>NOMBRADO</option>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de Nacimiento : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" name="fecha_nac" required="" value="<?php echo $res_busc_est['fecha_nac']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nivel de Formación : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="niv_form" required="" value="<?php echo $res_busc_est['nivel_educacion']; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">2da Especialidad : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="seg_espec" value="" required="required">
                            <option></option>
                            <option value="SI" <?php if ("SI"==$res_busc_est['2da_especialidad']): 
                            echo 'selected="selected"';
                             endif ?>>SI</option>
                            <option value="NO" <?php if ("NO"==$res_busc_est['2da_especialidad']): 
                            echo 'selected="selected"';
                             endif ?>>NO</option>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="number" class="form-control" name="telefono" required="" maxlength="15" value="<?php echo $res_busc_est['telefono']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo Electrónico : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="email" class="form-control" name="email" required="required" value="<?php echo $res_busc_est['correo']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cargo : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" id="carrera_m" name="cargo" value="" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_carg = buscarCargo($conexion);
                            while ($res_busc_carg = mysqli_fetch_array($ejec_busc_carg)) {
                              $id_carg = $res_busc_carg['id'];
                              $carg = $res_busc_carg['cargo'];
                              ?>
                              <option value="<?php echo $id_carg;
                              ?>"
                              <?php if ($id_carg==$id_cargo):
                                echo 'selected="selected"';
                               endif ?>
                              ><?php echo $carg; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                          <br>
                        </div>
                      </div>
                      
                      <div align="center">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button class="btn btn-primary" type="reset">Deshacer Cambios</button>
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
