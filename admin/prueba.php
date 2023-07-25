<?php
include 'include/verificar_sesion_docente_coordinador_secretaria.php';
include '../include/conexion.php';
include 'include/busquedas.php';
include 'include/funciones.php';

$id_prog = $_POST['data'];
$b_prog = buscarProgramacionById($conexion, $id_prog);
$res_b_prog = mysqli_fetch_array($b_prog);
if (isset($_SESSION['id_secretario']) || ($res_b_prog['id_docente'] == $_SESSION['id_docente']) || ($res_b_prog['id_docente'] == $_SESSION['id_jefe_area'])) {
    $mostrar_archivo = 1;
} else {
    $mostrar_archivo = 0;
}


if (!($mostrar_archivo)) {
    //echo "<h1 align='center'>No tiene acceso a la evaluacion de la Unidad Didáctica</h1>";
    //echo "<br><h2><center><a href='javascript:history.back(-1);'>Regresar</a></center></h2>";
    echo "<script>
			alert('Error Usted no cuenta con los permisos para acceder a la Página Solicitada');
			window.close();
		</script>
	";
} else {
    /*header ("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
    header ("Content-Disposition: attachment; filename=plantilla.xls");*/

    $b_ud = buscarUdById($conexion, $res_b_prog['id_unidad_didactica']);
    $r_b_ud = mysqli_fetch_array($b_ud);
    $titulo_archivo = "Reporte_".$r_b_ud['descripcion']."_".date("d")."_".date("m")."_".date("Y");
    
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title></title>
        <!--<script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
        <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
        <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>-->
        <script src="../include/excel_generador/xlsx.full.min.js"></script>
        <script src="../include/excel_generador/FileSaver.min.js"></script>
        <script src="../include/excel_generador/tableexport.min.js"></script>
    </head>

    <body>
        <?php echo $titulo_archivo; ?>
        <input type="hidden" id="nombre_archivo" value="<?php echo $titulo_archivo; ?>">
        <table border="1" id="tabla">
            <thead>
                <tr>
                    <th>NRO</th>
                    <th>CÓDIGO ALUMNO</th>
                    <th>ALUMNO</th>
                    <th>NOTA</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $b_det_mat = buscarDetalleMatriculaByIdProgramacion($conexion, $id_prog);
                $ord = 1;
                while ($r_b_det_mat = mysqli_fetch_array($b_det_mat)) {
                    $id_mat = $r_b_det_mat['id_matricula'];
                    $b_mat = buscarMatriculaById($conexion, $id_mat);
                    $r_b_mat = mysqli_fetch_array($b_mat);
                    $id_est = $r_b_mat['id_estudiante'];
                    $b_est = buscarEstudianteById($conexion, $id_est);
                    $r_b_est = mysqli_fetch_array($b_est);

                    $b_calif = buscarCalificacionByIdDetalleMatricula($conexion, $r_b_det_mat['id']);
                    $suma_calificacion = 0;
                    $cont_calif = 0;
                    while ($r_b_calif = mysqli_fetch_array($b_calif)) {

                        $id_calificacion = $r_b_calif['id'];
                                    //buscamos las evaluaciones
                                    $suma_evaluacion = calc_evaluacion($conexion, $id_calificacion);
                                    $suma_calificacion += $suma_evaluacion;
                                    if ($suma_evaluacion > 0) {
                                      $cont_calif += 1;
                                    }
                                    
                                    
                    }

                    if ($cont_calif > 0) {
                        $suma_calificacion = round($suma_calificacion / $cont_calif);
                      } else {
                        $suma_calificacion = round($suma_calificacion);
                      }
                      if ($suma_calificacion != 0) {
                        $calificacion_final = round($suma_calificacion);
                      } else {
                        $calificacion_final = "";
                      }
                    if ($r_b_det_mat['recuperacion'] != '') {
                        $calificacion_final = $r_b_det_mat['recuperacion'];
                      }
                ?>
                    <tr>
                        <td><?php echo $ord; ?></td>
                        <td><?php echo $r_b_est['dni']; ?></td>
                        <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                        <td><?php echo $calificacion_final; ?></td>
                    </tr>
                <?php
                    $ord += 1;
                }

                ?>
            </tbody>
        </table>
    </body>
    <!-- script para exportar a excel -->
    <script>
        let nombre = document.getElementById("nombre_archivo");
        const $tabla = document.querySelector("#tabla");
            window.addEventListener("load", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false, // No queremos botones
                filename: nombre.value, //Nombre del archivo de Excel
                sheetname: "Plantilla", //Título de la hoja
            });
            let datos = tableExport.getExportData();
            let preferenciasDocumento = datos.tabla.xlsx;
            tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
            window.close()
        });
    </script>
    

    </html>



<?php
}
?>