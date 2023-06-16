<?php
if(ob_get_length() > 0) {
    ob_clean();
}
?>
<?php
include"../inc/comun.php";
include"../fpdf/fpdf.php";

ob_end_clean();    
header("Content-Encoding: None", true);

$bd = new GestarBD; 
$descripcion_med=$_GET['descripcion_med'];

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha = date('d/m/Y ');
$fecha7dias = date('d-m-Y', strtotime('-1 week')) ; // resta 1 semana

class MiPDF extends FPDF {
		
	}
			
	$mipdf = new MiPDF('L','mm','A4');
	$mipdf -> addPage();

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> cell('mm',5,utf8_decode("FECHA : $fecha"), 0 , 10, true);
	$mipdf -> cell('mm',2,utf8_decode("HORA : $hora"), 0 , 10, true);

	$mipdf -> Setfont('Arial','B',12);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE HERRAMIENTAS POR UNIDAD DE MEDIDA"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("UNIDAD DE MEDIDA: $descripcion_med."),0,0,'L');
	$mipdf -> Ln (10);
		
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(30,11,utf8_decode("Registro"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(122,11,utf8_decode("Descripción"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(50,11,utf8_decode("Costo (S/)"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(75,11,utf8_decode("Unidad de medida"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);
	
	$sql="SELECT DATE_FORMAT(fecha_herra, '%d/%m/%Y') AS REGISTRO, herramientas.id_herramienta, descripcion_herra, CONCAT('S/', FORMAT(costo_herra,2)) AS costo_herra, (CONCAT(medidas.descripcion_med,' ( ' ,medidas.abreviatura_med,' )')) AS UNIDAD FROM herramientas, medidas WHERE descripcion_med='$descripcion_med' and herramientas.id_medida = medidas.id_medida ORDER BY REGISTRO DESC, descripcion_herra ASC";

	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$registro= $datos['REGISTRO'];
		$nombre= $datos ['descripcion_herra'];
		$costo = $datos ['costo_herra'];
		$unidad = $datos ['UNIDAD'];
 
		$num++;  

	    $mipdf -> Cell(30,5,utf8_decode("$registro"),1,0,'C');
		$mipdf -> Cell(122,5,utf8_decode("$nombre"),1,0,'C');
		$mipdf -> Cell(50,5,utf8_decode("$costo"),1,0,'C');
		$mipdf -> Cell(75,5,utf8_decode("$unidad"),1,0,'C');
			
		$mipdf -> Ln(5);
	}
		
	$mipdf -> Output();

	class PDF extends FPDF
	{
		function Footer()
		{
    		$this->SetY(-15);
		    $this->SetFont('Arial','I',8);
		    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
		}
	}
?>