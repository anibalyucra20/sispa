<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
   <!-- <div class="navbar nav_title" style="border: 0;">
      <a href="index.php" class=""><i class=""></i> <span>Biblioteca</span></a>
    </div>-->

    <div class="clearfix"></div>

      <!-- menu profile quick info -->
      <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../../img/logo.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo "admin"; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu de Navegación</h3>
                <ul class="nav side-menu">
                  <li><a href="../../admin"><i class="fa fa-home"></i>Inicio</a>
                  </li>
                  <li><a><i class="fa fa-pencil-square-o"></i>Mantenimiento<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="PeriodoAcademico.php">Datos Institucionales</a></li>
                      <li><a href="PresentePeriodo.php">Programas de estudio</a></li>
                      <li><a href="ProgramacionClases.php">Módulos Formativos</a></li>
                      <li><a href="semestre.php">Semestre</a></li>
                      <li><a href="unidad_didactica.php">Unidades Didacticas</a></li>
                      <li><a href="obervacion.php">Observaciones</a></li>
                      <li><a href="cargo.php">Cargos</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-pencil-square-o"></i>Módulo Académico<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a>Planificación<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="periodo_academico.php">Periodos Academicos</a></li>
                            <li><a href="presente_periodo.php">Datos del Presente Academico</a></li>
                            <li><a href="programacion.php">Programacion de Clases</a></li>
                          </ul>
                      </li>
                      <li><a>Matrículas<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="matricula.php">Registro de Matrícula</a></li>
                          </ul>
                      </li>
                      <li><a>Docentes<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="docente.php">Relación de Docentes</a></li>
                            <li class="sub_menu"><a href="usuario_docente.php">Usuarios Docentes</a></li>
                          </ul>
                      </li>
                      <li><a>Estudiantes<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="estudiante.php">Relación de Estudiantes</a></li>
                            <li class="sub_menu"><a href="usuario_estudiante.php">Usuarios Estudiantes</a></li>
                          </ul>
                      </li>
                      <li><a>Evaluación<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="evaluacion.php">Registro de Evaluación</a></li>
                          </ul>
                      </li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-pencil-square-o"></i>Módulo Portafolio<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a>Competencias de Programa de estudios<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="p">otros</a></li>
                            <li><a href="#level2_1">otros</a></li>
                            <li><a href="#level2_2">otros</a></li>
                          </ul>
                      </li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bar-chart"></i>Reportes<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="reportes.php">reportes</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
              

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!--<div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Configuración">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Pantalla Completa">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Bloquear">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Cerrar Sesión" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>-->
            <!-- /menu footer buttons -->
  </div>
</div>
<!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <ul class="nav navbar-nav navbar-right">
              
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../../img_perfil/no_imagen.jpg" alt=""><?php echo "admin"; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href=""> Mi perfil</a></li>
                    <li><a href="">Ayuda</a></li>
                    <li><a href=""><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
                  </ul>
                </li>
                
<!--
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              -->
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->