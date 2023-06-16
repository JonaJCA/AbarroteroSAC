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
$tipo_doc=$_GET['tipo_doc'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE DOCUMENTOS POR TIPO"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("TIPO: $tipo_doc."),0,0,'L');
	$mipdf -> Ln (10);
		
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(13,11,utf8_decode("ID"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(174,11,utf8_decode("Nombre"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(90,11,utf8_decode("Tipo"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);
	
	$sql="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden, documentos.id_documento, nombre_doc, tipo_doc FROM documentos, (SELECT @s:=0) AS s WHERE tipo_doc='$tipo_doc' ORDER BY orden, nombre_doc ASC";

	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$orden= $datos ['orden'];
		$nombre= $datos ['nombre_doc'];
		$tipo = $datos ['tipo_doc'];
 
		$num++;  

	    $mipdf -> Cell(13,5,utf8_decode("$orden"),1,0,'C');
		$mipdf -> Cell(174,5,utf8_decode("$nombre"),1,0,'C');
		$mipdf -> Cell(90,5,utf8_decode("$tipo"),1,0,'C');
			
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