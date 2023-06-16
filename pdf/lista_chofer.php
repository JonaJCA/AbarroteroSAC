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
$estado_cho=$_GET['estado_cho'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE CHOFERES POR ESTADO DE BREVETE"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("ESTADO DE BREVETE: $estado_cho."),0,0,'L');
	$mipdf -> Ln (10);
		
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(21,11,utf8_decode("Registro"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(80,11,utf8_decode("Conductor"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,11,utf8_decode("Brevete"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(21,11,utf8_decode("DNI"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(30,11,utf8_decode("Teléfono"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(101,11,utf8_decode("Dirección"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

	$sql="SELECT id_chofer, (CONCAT(nombre_cho,' ',apellido_cho)) AS chofer, brevete_cho, dni_cho, 
	(COALESCE(CASE direccion_cho 
    WHEN '' THEN 'SIN DIRECCIÓN' 
    ELSE direccion_cho 
    END,'SIN DIRECCIÓN')) AS direccion_cho, 
    (COALESCE(CASE telefono_cho 
    WHEN '0' THEN 'SIN TELÉFONO' 
    ELSE telefono_cho 
    END,'SIN TELÉFONO')) AS telefono_cho, estado_cho, (DATE_FORMAT(registro_cho,'%d/%m/%Y')) AS registro_cho FROM choferes WHERE estado_cho='$estado_cho' ORDER BY registro_cho DESC";

	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$registro= $datos ['registro_cho'];
		$chofer= $datos ['chofer'];
		$brevete = $datos ['brevete_cho'];
		$dni = $datos ['dni_cho'];
		$telefono = $datos ['telefono_cho'];
		$direccion = $datos ['direccion_cho'];
 
		$num++;  //264

	    $mipdf -> Cell(21,5,utf8_decode("$registro"),1,0,'C');
		$mipdf -> Cell(80,5,utf8_decode("$chofer"),1,0,'C');
		$mipdf -> Cell(25,5,utf8_decode("$brevete"),1,0,'C');
		$mipdf -> Cell(21,5,utf8_decode("$dni"),1,0,'C');
		$mipdf -> Cell(30,5,utf8_decode("$telefono"),1,0,'C');
		$mipdf -> Cell(101,5,utf8_decode("$direccion"),1,0,'C');
			
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