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
$tipo_vehi=$_GET['tipo_vehi'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE VEHÍCULOS POR TIPO"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("TIPO DE VEHÍCULO: $tipo_vehi."),0,0,'L');
	$mipdf -> Ln (10);
	
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(8,11,utf8_decode("ID"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(80,11,utf8_decode("Propietario"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(34,11,utf8_decode("Placa del vehículo"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(34,11,utf8_decode("Placa de carreta"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,11,utf8_decode("Constancia"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(31,11,utf8_decode("Marca"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(29,11,utf8_decode("Color"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(37,11,utf8_decode("Condición"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

    $sql="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden, id_vehiculo, nombre_prop, tipo_vehi, placa_vehi, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE placa_carreta END,'SIN PLACA')) AS placa_carreta, constancia_vehi, marca_vehi, color_vehi, condicion_vehi FROM propietarios, vehiculos, (SELECT @s:=0) AS s WHERE vehiculos.id_propietario=propietarios.id_propietario AND tipo_vehi='$tipo_vehi' ORDER BY orden, nombre_prop, placa_vehi ASC";
		
	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$orden= $datos ['orden'];
		$propietario= $datos ['nombre_prop'];
		$placa= $datos ['placa_vehi'];
		$carreta = $datos ['placa_carreta'];
		$constancia = $datos ['constancia_vehi'];
		$marca = $datos ['marca_vehi'];
		$color = $datos ['color_vehi'];
		$condicion = $datos ['condicion_vehi'];
 
		$num++;  //264

		$mipdf -> Cell(8,5,utf8_decode("$orden"),1,0,'C');
	    $mipdf -> Cell(80,5,utf8_decode("$propietario"),1,0,'C');
		$mipdf -> Cell(34,5,utf8_decode("$placa"),1,0,'C');
		$mipdf -> Cell(34,5,utf8_decode("$carreta"),1,0,'C');
		$mipdf -> Cell(25,5,utf8_decode("$constancia"),1,0,'C');
		$mipdf -> Cell(31,5,utf8_decode("$marca"),1,0,'C');
		$mipdf -> Cell(29,5,utf8_decode("$color"),1,0,'C');
		$mipdf -> Cell(37,5,utf8_decode("$condicion"),1,0,'C');
			
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