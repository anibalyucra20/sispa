<?php
include 'include/verificar_sesion_docente.php';
include "../include/conexion.php";
include 'include/busquedas.php';

$id_prog = $_POST['data'];
$b_prog = buscarProgramacionById($conexion, $id_prog);
$res_b_prog = mysqli_fetch_array($b_prog);
if (!($res_b_prog['id_docente']==$_SESSION['id_docente'])) {
    //echo "<h1 align='center'>No tiene acceso a la evaluacion de la Unidad Didáctica</h1>";
    //echo "<br><h2><center><a href='javascript:history.back(-1);'>Regresar</a></center></h2>";
    echo "<script>
			alert('Error Usted no cuenta con los permisos para acceder a la Página Solicitada');
			window.close();
		</script>
	";
}else {

require '../fpdf185/fpdf.php';
	
	class PDF extends FPDF
	{
		function Header()
		{
			$this->Image('silabo/cabeza.png', 5, 3, 190,);
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(120,10, '',0,0,'C');
			$this->Ln(20);
		}
		
		function Footer()
		{
			$this->SetY(-15);
			$this->Image('silabo/pie.png', 15, 278, 181);
			$this->SetFont('Arial','B', 10);
            $this->Cell(0,10, 'Pag. '.$this->PageNo().'             ',0,0,'R' );
            //$this->Cell(0,10, 'Pag. '.$this->PageNo().'/{nb}',0,0,'R' );
		}
        
        


var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}


	}


    

    // INICIAMOS A CREAR EL PDF

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

        
        //buscamos la cantidad de indicadores para definir la cantidad de calificaciones
        $b_capacidades =buscarCapacidadesByIdUd($conexion, $res_b_prog['id_unidad_didactica']);
        $total_indicadores = 0;
        while ($r_b_capacidades = mysqli_fetch_array($b_capacidades)) {
            $b_indicador_capac = buscarIndicadorLogroCapacidadByIdCapacidad($conexion, $r_b_capacidades['id']);
            $cont_indicadores = mysqli_num_rows($b_indicador_capac);
            $total_indicadores = $total_indicadores+$cont_indicadores;
        };

        //fecha de hoy


    $pdf = new PDF('L','mm','A4');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetLeftMargin(20);
	//$pdf->SetAutoPageBreak(1 , 15);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->MultiCell(170,6,utf8_decode("CATASTRO DEL PROGRAMA DE ESTUDIOS DE ".$r_b_pe['nombre']),0,'C',0);
	$pdf->Cell(180,3,'',0,1,'C',0);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(70,6,utf8_decode('       Docente'),0,0,'',0);
    $pdf->MultiCell(100,6,utf8_decode(": ".$r_b_docente['apellidos_nombres']),0,'',0);
    $pdf->Cell(70,6,utf8_decode('       Módulo Profesional'),0,0,'',0);
    $pdf->MultiCell(100,6,utf8_decode(": ".$r_b_mod['descripcion']),0,'',0);
    $pdf->Cell(70,6,utf8_decode('       Unidad Didáctica'),0,0,'',0);
    $pdf->MultiCell(100,6,utf8_decode(": ".$r_b_ud['descripcion']),0,'',0);
    $pdf->Cell(70,6,utf8_decode('       Créditos'),0,0,'',0);
    $pdf->Cell(100,6,utf8_decode(": ".$r_b_ud['creditos']),0,1,'',0);
    $pdf->Cell(70,6,utf8_decode('       Semestre Académico'),0,0,'',0);
    $pdf->Cell(100,6,utf8_decode(": ".$r_b_sem['descripcion']),0,1,'',0);
    $pdf->Cell(70,6,utf8_decode('       N° de Horas Semanal'),0,0,'',0);
    $pdf->Cell(100,6,utf8_decode(": ".$r_b_ud['horas']/16),0,1,'',0);
	
    $pdf->Cell(180,3,'',0,1,'C',0);
    $pdf->Cell(7,6,utf8_decode('No'),1,0,'',0);
    $pdf->Cell(90,6,utf8_decode('APELLIDOS Y NOMBRES'),1,0,'C',0);
    for ($i=1; $i <= $total_indicadores ; $i++) { 
        
        $pdf->Cell(15,6,utf8_decode('Calif. '.$i),1,0,'C',0);
    }
    
	
    
	$pdf->Cell(180,20,'',0,1,'C',0);
	

    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    //echo $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
	$pdf->Cell(175,6,utf8_decode($r_b_datos_insti['distrito'].', '.date('d')." de ".$meses[date('n')-1]. " del ".date('Y')),0,1,'R',0);


	$pdf->Output();
}
?>