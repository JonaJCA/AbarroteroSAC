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
$tipo_prop=$_GET['tipo_prop'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE PROPIETARIOS POR TIPO DE CONTRIBUYENTE"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("TIPO DE CONTRIBUYENTE: $tipo_prop."),0,0,'L');
	$mipdf -> Ln (10);
	
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(12,11,utf8_decode("ID"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(85,11,utf8_decode("Dueño"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,utf8_decode("RUC"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,utf8_decode("Teléfono"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(110,11,utf8_decode("Dirección"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

	$sql="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden, id_propietario, tipo_prop, nombre_prop, ruc_prop, (COALESCE(CASE telefono_prop WHEN '0' THEN 'SIN TELÉFONO' ELSE telefono_prop END,'SIN TELÉFONO')) AS telefono_prop, (COALESCE(CASE direccion_prop WHEN '' THEN 'SIN DIRECCIÓN' ELSE direccion_prop END,'SIN DIRECCIÓN')) AS direccion_prop FROM propietarios, (SELECT @s:=0) AS s WHERE tipo_prop='$tipo_prop' ORDER BY orden, nombre_prop ASC";
	
	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$orden= $datos ['orden'];
		$nombre= $datos ['nombre_prop'];
		$ruc = $datos ['ruc_prop'];
		$telefono = $datos ['telefono_prop'];
		$direccion = $datos ['direccion_prop'];
 
		$num++;  //264

		$mipdf -> Cell(12,5,utf8_decode("$orden"),1,0,'C');
	    $mipdf -> Cell(85,5,utf8_decode("$nombre"),1,0,'C');
		$mipdf -> Cell(35,5,utf8_decode("$ruc"),1,0,'C');
		$mipdf -> Cell(35,5,utf8_decode("$telefono"),1,0,'C');
		$mipdf -> Cell(110,5,utf8_decode("$direccion"),1,0,'C');
			
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