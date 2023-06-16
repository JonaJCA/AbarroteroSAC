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
$condicion_suc=$_GET['condicion_suc'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE SUCURSALES POR CONDICIÓN"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("CONDICIÓN: $condicion_suc."),0,0,'L');
	$mipdf -> Ln (10);
		
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(8,11,utf8_decode("ID"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(45,11,utf8_decode("Base"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(30,11,utf8_decode("Departamento"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(45,11,utf8_decode("Provincia"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(45,11,utf8_decode("Distrito"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(30,11,utf8_decode("Teléfono"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(75,11,utf8_decode("Correo electrónico"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

	$sql="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden, id_sucursal, nombre_suc, nombre_depa, CAST(nombre_provi AS VARCHAR(20)) AS nombre_provi, CAST(nombre_dist AS VARCHAR(20)) AS nombre_dist, condicion_suc, direccion_suc, 

	(COALESCE(CASE telefono_suc 
	WHEN '0' THEN 'SIN TELÉFONO' 
	ELSE telefono_suc 
	END,'SIN TELÉFONO')) AS telefono_suc,

	(COALESCE(CASE email_suc 
	WHEN '' THEN 'SIN CORREO' 
	ELSE email_suc 
	END,'SIN CORREO')) AS email_suc

    FROM sucursales, departamentos, provincias, distritos, (SELECT @s:=0) AS s WHERE condicion_suc='$condicion_suc' AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito ORDER BY orden, nombre_suc ASC";

	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$orden= $datos ['orden'];
		$nombre= $datos ['nombre_suc'];
		$departamento = $datos ['nombre_depa'];
		$provincia = $datos ['nombre_provi'];
		$distrito = $datos ['nombre_dist'];
		$direccion = $datos ['direccion_suc'];
		$telefono = $datos ['telefono_suc'];
		$correo = $datos ['email_suc'];
 
		$num++;  //264

	    $mipdf -> Cell(8,5,utf8_decode("$orden"),1,0,'C');
		$mipdf -> Cell(45,5,utf8_decode("$nombre"),1,0,'C');
		$mipdf -> Cell(30,5,utf8_decode("$departamento"),1,0,'C');
		$mipdf -> Cell(45,5,utf8_decode("$provincia"),1,0,'C');
		$mipdf -> Cell(45,5,utf8_decode("$distrito"),1,0,'C');
		$mipdf -> Cell(30,5,utf8_decode("$telefono"),1,0,'C');
		$mipdf -> Cell(75,5,utf8_decode("$correo"),1,0,'C');
			
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