<?php
include 'include/verificar_sesion_docente_secretaria.php';
include '../include/conexion.php';
include 'include/busquedas.php';

$id_prog = $_POST['data'];
$b_prog = buscarProgramacionById($conexion, $id_prog);
$res_b_prog = mysqli_fetch_array($b_prog);
if (isset($_SESSION['id_secretario']) || ($res_b_prog['id_docente'] == $_SESSION['id_docente'])) {
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
                    while ($r_b_calif = mysqli_fetch_array($b_calif)) {

                        $b_eva = buscarEvaluacionByIdCalificacion($conexion, $r_b_calif['id']);
                        $suma_evaluacion = 0;
                        while ($r_b_eva = mysqli_fetch_array($b_eva)) {
                            $b_crit_eva = buscarCriterioEvaluacionByEvaluacion($conexion, $r_b_eva['id']);
                            $suma_criterios = 0;
                            $cont_crit = 0;
                            while ($r_b_crit = mysqli_fetch_array($b_crit_eva)) {
                                if (is_numeric($r_b_crit['calificacion'])) {
                                    $suma_criterios += $r_b_crit['calificacion'];
                                    $cont_crit += 1;
                                }
                            }
                            if ($cont_crit > 0) {
                                $suma_criterios = round($suma_criterios / $cont_crit);
                            } else {
                                $suma_criterios = round($suma_criterios);
                            }
                            $suma_evaluacion += ($r_b_eva['ponderado'] / 100) * $suma_criterios;
                        }
                        $suma_calificacion += ($r_b_calif['ponderado'] / 100) * $suma_evaluacion;
                    }
                    if ($suma_calificacion != 0) {
                        $calificacion = round($suma_calificacion);
                    } else {
                        $calificacion = "";
                    }
                ?>
                    <tr>
                        <td><?php echo $ord; ?></td>
                        <td><?php echo $r_b_est['dni']; ?></td>
                        <td><?php echo $r_b_est['apellidos_nombres']; ?></td>
                        <td><?php echo $calificacion; ?></td>
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
        const $tabla = document.querySelector("#tabla");
            window.addEventListener("load", function() {
            let tableExport = new TableExport($tabla, {
                exportButtons: false, // No queremos botones
                filename: "Reporte de prueba", //Nombre del archivo de Excel
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