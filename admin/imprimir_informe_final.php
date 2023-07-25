<?php
include_once('include/verificar_sesion_docente_coordinador_secretaria.php');
require_once('../tcpdf/tcpdf.php');
include_once('../include/conexion.php');
include_once('include/busquedas.php');
include_once('include/funciones.php');
setlocale(LC_ALL, "es_ES");
$id_prog = $_GET['id'];
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

    // Extend the TCPDF class to create custom Header and Footer
    class MYPDF extends TCPDF
    {



        // Page footer
        public function Footer()
        {
            // Position at 15 mm from bottom
            $this->SetY(-15);
            // Set font
            $this->SetFont('helvetica', 'I', 8);
            // Page number
            $this->Cell(0, 10, '´Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }

    //buscamos los datos para imprimir

    //buscar datos de institucion
    $b_datos_insti = buscarDatosGenerales($conexion);
    $r_b_datos_insti = mysqli_fetch_array($b_datos_insti);

    //buscar periodo 
    $b_perio = buscarPeriodoAcadById($conexion, $res_b_prog['id_periodo_acad']);
    $r_b_perio = mysqli_fetch_array($b_perio);
    //buscar unidad didactica
    $b_ud = buscarUdById($conexion, $res_b_prog['id_unidad_didactica']);
    $r_b_ud = mysqli_fetch_array($b_ud);
    //buscar programa de estudio
    $b_pe = buscarCarrerasById($conexion, $r_b_ud['id_programa_estudio']);
    $r_b_pe = mysqli_fetch_array($b_pe);
    //buscar modulo profesional
    $b_mod = buscarModuloFormativoById($conexion, $r_b_ud['id_modulo']);
    $r_b_mod = mysqli_fetch_array($b_mod);
    //buscar semestre
    $b_sem = buscarSemestreById($conexion, $r_b_ud['id_semestre']);
    $r_b_sem = mysqli_fetch_array($b_sem);
    //buscamos el silabo y sus datos
    $b_silabo = buscarSilaboByIdProgramacion($conexion, $id_prog);
    $r_b_silabo = mysqli_fetch_array($b_silabo);
    $id_silabo = $r_b_silabo['id'];
    //buscar datos de docente
    $b_docente = buscarDocenteById($conexion, $res_b_prog['id_docente']);
    $r_b_docente = mysqli_fetch_array($b_docente);
    //buscar datos de coordinador de area
    $b_coordinador = buscarCoordinadorAreaByIdPe($conexion, $r_b_ud['id_programa_estudio']);
    $r_b_coordinador = mysqli_fetch_array($b_coordinador);
    //buscar datos de director
    $b_director = buscarDocenteById($conexion, $r_b_perio['director']);
    $r_b_director = mysqli_fetch_array($b_director);


    //funcion para cambia numeros a romanos
    function a_romano($integer, $upcase = true)
    {
        $table = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100,
            'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9,
            'V' => 5, 'IV' => 4, 'I' => 1
        );
        $return = '';
        while ($integer > 0) {
            foreach ($table as $rom => $arb) {
                if ($integer >= $arb) {
                    $integer -= $arb;
                    $return .= $rom;
                    break;
                }
            }
        }
        return $return;
    }

    $n_modulo = a_romano($r_b_mod['nro_modulo']);



    $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle("Informe Final - " . $r_b_ud['descripcion']);
    $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont('helvetica');
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(true);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->SetFont('helvetica', '', 11);
    $pdf->AddPage('P', 'A4');


    $text_size = 8;

    //crear el contenido 
    $contenido = '';

    $content_one = '';
    $content_one .= '
    
        <table border="0" width="100%" cellspacing="0" cellpadding="0.1">
        <tr>
            <td width="40%"><img src="../img/logo_minedu.jpeg" alt="" height="40px"></td>
            <td width="10%"></td>
            <td width="50%" align="right"><img src="../img/logo.jpeg" alt="" height="40px"></td>
        </tr>
        <tr>
            <td colspan="3" align="center" ><font size="' . $text_size . '"><b>AÑO DE LA UNIDAD, LA PAZ Y EL DESARROLLO</b></font></td>
        </tr>
        <tr>
            <td colspan="3" align="center"><b>INFORME TÉCNICO - PEDAGÓGICO DEL SEMESTRE - '.$r_b_perio['nombre'].'</b></td>
        </tr>
        <br>
        <tr>
            <td colspan="3"><b>I.          DATOS INFORMATIVOS:</b></td>
        </tr>
        <tr>
            <td width="30%"><font size="' . $text_size . '"><b>       1. INSTITUCIÓN EDUCATIVA</b></font></td>
            <td width="5%">:</td>
            <td width="65%"><font size="' . $text_size . '">'.$r_b_datos_insti['nombre_institucion'].'</font></td>
        </tr>
        <tr>
            <td width="30%"><font size="' . $text_size . '"><b>       2. PROGRAMA DE ESTUDIOS</b></font></td>
            <td width="5%">:</td>
            <td width="65%"><font size="' . $text_size . '">' . $r_b_pe['nombre'] . '</font></td>
        </tr>
        <tr>
            <td width="30%"><font size="' . $text_size . '"><b>       3. MÓDULO FORMATIVO</b></font></td>
            <td width="5%">:</td>
            <td width="65%"><font size="' . $text_size . '">' . $r_b_mod['descripcion'] . '</font></td>
        </tr>
        <tr>
            <td width="30%"><font size="' . $text_size . '"><b>       4. UNIDAD DIDÁCTICA</b></font></td>
            <td width="5%">:</td>
            <td width="65%"><font size="' . $text_size . '">' . $r_b_ud['descripcion'] . '</font></td>
        </tr>
        <tr>
            <td width="30%"><font size="' . $text_size . '"><b>       5. SEMESTRE ACADÉMICO</b></font></td>
            <td width="5%">:</td>
            <td width="65%"><font size="' . $text_size . '">' . $r_b_sem['descripcion'] .'</font></td>
        </tr>
        <tr>
            <td width="30%"><font size="' . $text_size . '"><b>       6. DOCENTE</b></font></td>
            <td width="5%">:</td>
            <td width="65%"><font size="' . $text_size . '">' . $r_b_docente['apellidos_nombres'].'</font></td>
        </tr>
        <br>
        <tr>
            <td colspan="3"><b>II.        ASPECTOS TECNICO - PEDAGÓGICOS:</b></td>
        </tr>
        <tr>
            <td width="50%"><font size="' . $text_size . '"><b>       7. PORCENTAJE TOTAL DE AVANCE CURRICULAR:</b></font></td>
            <td width="50%"><font size="' . $text_size . '">100%</font></td>
        </tr>
        <tr>
            <td colspan="3"><font size="' . $text_size . '"><b>       8. U.F. Y TEMA DE LA ULTIMA CLASE DESARROLLADA:</b></font></td>
        </tr>
        <tr>
            <td colspan="3"><font size="' . $text_size . '">      Ultimo Tema Desarrollada</font></td>
        </tr>
        <tr>
            <td colspan="3"><font size="' . $text_size . '"><b>       9. TITULO(S) Y Nro DE LA(S) SESIÓN(ES) NO DESARROLLADAS:</b></font></td>
        </tr>
        <tr>
            <td colspan="3"><font size="' . $text_size . '">      sesiones no desarrolladas</font></td>
        </tr>
        <tr>
            <td colspan="3"><font size="' . $text_size . '"><b>       10. RESUMEN ESTADÍSTICO:</b></font></td>
        </tr>
        <tr>
            <table border="0.2" cellspacing="0" cellpadding="0.5">
                <tr bgcolor="#CCCCCC">
                    <td width="40%" align="center"><font size="' . $text_size . '"><b>DESCRIPCIÓN</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b>H</b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b>M</b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b>T</b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                </tr>
                <tr>
                    <td width="40%" align="center"><font size="' . $text_size . '"><b>TOTAL MATRICULADOS</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                </tr>
                <tr>
                    <td width="40%" align="center"><font size="' . $text_size . '"><b>RETIRADOS(LICENCIA)</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                </tr>
                <tr>
                    <td width="40%" align="center"><font size="' . $text_size . '"><b>APROBADOS</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                </tr>
                <tr>
                    <td width="40%" align="center"><font size="' . $text_size . '"><b>DESAPROBADOS</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                    <td width="10%" align="center"><font size="' . $text_size . '"><b></b></font></td>
                    <td width="10%"  align="center"><font size="' . $text_size . '"><b>%</b></font></td>
                </tr>
            </table>
        </tr>
        <tr>
        <br>
            <table  cellspacing="0" cellpadding="0.5">
                <tr>
                    <td width="60%"><font size="' . $text_size . '"><b>11. FUE SUPERVISADO:</b></font></td>
                    <td width="5%">:</td>
                    <td width="5%"><font size="' . $text_size . '">SI</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="5%"></td>
                    <td width="5%"><font size="' . $text_size . '">NO</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="10%"></td>
                </tr>
            </table>
            
        </tr>
        <tr>
            <table  cellspacing="0" cellpadding="0.5">
                <tr>
                <td colspan="3"><font size="' . $text_size . '"><b>12. DOCUMENTOS DE EVALUACIÓN UTILIZADAS:</b></font></td>
                </tr>
            </table>
        </tr>
        <tr>
            <table  cellspacing="0" cellpadding="0.5">
                <tr>
                    <td width="2%"></td>
                    <td width="58%"><font size="' . $text_size . '">Registro de Evaluación</font></td>
                    <td width="5%">:</td>
                    <td width="5%"><font size="' . $text_size . '">SI</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="5%"></td>
                    <td width="5%"><font size="' . $text_size . '">NO</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="10%"></td>
                </tr>
            </table>
        </tr>
        <tr>
            <table  cellspacing="0" cellpadding="0.5">
                <tr>
                    <td width="2%"></td>
                    <td width="58%"><font size="' . $text_size . '">Registro Auxiliar</font></td>
                    <td width="5%">:</td>
                    <td width="5%"><font size="' . $text_size . '">SI</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="5%"></td>
                    <td width="5%"><font size="' . $text_size . '">NO</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="10%"></td>
                </tr>
            </table>
        </tr>
        <tr>
            <table  cellspacing="0" cellpadding="0.5">
                <tr>
                    <td width="2%"></td>
                    <td width="58%"><font size="' . $text_size . '">Programación Curricular</font></td>
                    <td width="5%">:</td>
                    <td width="5%"><font size="' . $text_size . '">SI</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="5%"></td>
                    <td width="5%"><font size="' . $text_size . '">NO</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="10%"></td>
                </tr>
            </table>
        </tr>
        <tr>
            <table  cellspacing="0" cellpadding="0.5">
                <tr>
                    <td width="2%"></td>
                    <td width="58%"><font size="' . $text_size . '">Otros</font></td>
                    <td width="5%">:</td>
                    <td width="5%"><font size="' . $text_size . '">SI</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="5%"></td>
                    <td width="5%"><font size="' . $text_size . '">NO</font></td>
                    <td width="5%" border="0.2"><font size="' . $text_size . '"></font></td>
                    <td width="10%"></td>
                </tr>
            </table>
        </tr>
        <br>
        <tr>
            <td colspan="3"><b>III.        LOGROS OBTENIDOS:</b></td>
        </tr>
        
        <br>
        <tr>
            <td colspan="3"><b>III.        DIFICULTADES:</b></td>
        </tr>
        <br>
        <br>
        <tr>
            <td colspan="3"><b>III.        SUGERENCIAS:</b></td>
        </tr>
        <br>




                
          ';

    $content_one .= $contenido;
    $content_one .= '</table>';
    $pdf->writeHTML($content_one);



    $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    $fechaaa = date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y');
    $footer = '

        <table border="0" cellspacing="0" cellpadding="0.5">  
        <tr>
            <th width="50%"></th>
            <th align="right">Huanta, ' . $fechaaa . '</th>
        </tr>
        <tr>
            <td colspan="2" align="center"><br><br><br><br><br><br><br><br>...............................................<br>Docente</td>
        </tr>
        </table>

      ';
    $pdf->writeHTML($footer);








    $pdf->Output('Informe Final - ' . $r_b_ud['descripcion'] . '.pdf', 'I');
}
