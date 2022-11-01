
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
                    <form role="form" action="operaciones/actualizar_estudiante.php" class="form-horizontal form-label-left input_mask" method="POST" enctype="multipart/form-data">
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
                          <input type="text" class="form-control" name="ap_nom" required="" value="<?php echo $res_busc_est['apellidos_nombres']; ?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Género : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" id="genero" name="genero" value="<?php echo $res_busc_est['id_genero']; ?>" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_gen = buscarGenero($conexion);
                            while ($res_busc_gen = mysqli_fetch_array($ejec_busc_gen)) {
                              $id_gen = $res_busc_gen['id'];
                              $gen = $res_busc_gen['genero'];
                              ?>
                              <option value="<?php echo $id_gen;
                              ?>"<?php if($res_busc_est['id_genero']== $id_gen){ echo "selected";} ?>><?php echo $gen; ?></option>
                            <?php
                            }
                            ?>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Dirección : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="direccion" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $res_busc_est['direccion']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Correo Electrónico : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="email" class="form-control" name="email" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" value="<?php echo $res_busc_est['correo']; ?>">
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Año de Ingreso : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="date" class="form-control" name="anio_ingreso" required="" value="<?php echo $res_busc_est['anio_ingreso']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Carrera Profesional : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control"  id="carrera" name="carrera" value="<?php echo $res_busc_est['id_programa_estudios']; ?>" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_carr = buscarCarreras($conexion);
                            while ($res__busc_carr = mysqli_fetch_array($ejec_busc_carr)) {
                              $id_carr = $res__busc_carr['id'];
                              $carr = $res__busc_carr['nombre'];
                              ?>
                              <option value="<?php echo $id_carr;
                              ?>" <?php if($res_busc_est['id_programa_estudios']== $id_carr){ echo "selected";} ?>><?php echo $carr; ?></option>
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
                          <select class="form-control" id="semestre" name="semestre" value="<?php echo $res_busc_est['id_semestre']; ?>" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_sem = buscarSemestre($conexion);
                            while ($res_busc_sem = mysqli_fetch_array($ejec_busc_sem)) {
                              $id_sem = $res_busc_sem['id'];
                              $sem = $res_busc_sem['descripcion'];
                              ?>
                              <option value="<?php echo $id_sem;
                              ?>" <?php if($res_busc_est['id_semestre']== $id_sem){ echo "selected";} ?>><?php echo $sem; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Sección : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="seccion" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="1" value="<?php echo $res_busc_est['seccion']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Turno : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input type="text" class="form-control" name="turno" required="required" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="20" value="<?php echo $res_busc_est['turno']; ?>">
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Condición : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="condicion" value="<?php echo $res_busc_est['id_condicion']; ?>" required="required">
                            <option></option>
                          <?php 
                            $ejec_busc_obs = buscarCondicion($conexion);
                            while ($res_busc_obs = mysqli_fetch_array($ejec_busc_obs)) {
                              $id_obs = $res_busc_obs['id'];
                              $obs = $res_busc_obs['descripcion'];
                              ?>
                              <option value="<?php echo $id_obs;
                              ?>" <?php if($res_busc_est['id_condicion']== $id_obs){ echo "selected";} ?>><?php echo $obs; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                          <br>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Discapacidad : </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <select class="form-control" name="discapacidad" value="" required="required">
                            <option></option>
                            <option value="SI" <?php if ("SI"==$res_busc_est['discapacidad']): 
                            echo 'selected';
                             endif ?>>SI</option>
                            <option value="NO" <?php if ("NO"==$res_busc_est['discapacidad']): 
                            echo 'selected';
                             endif ?>>NO</option>
                          </select>
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
