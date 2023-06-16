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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA COMPLETA DE PROVEEDORES"),0,0,'C');
	$mipdf -> Ln (10);
	
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,11,utf8_decode("Fecha"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(75,11,utf8_decode("Proveedor"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(34,11,utf8_decode("RUC"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(34,11,utf8_decode("DNI"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(34,11,utf8_decode("Teléfono"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(75,11,utf8_decode("Correo electrónico"),1,0,'C',true);	
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

	$sql="SELECT proveedores.id_proveedor, (CONCAT(nombre_depa,', ',nombre_provi,', ',nombre_dist)) AS ubicacion, ruc_prov, nombre_prov, telefono_prov, email_prov, ruc_prov, nombre_provi, nombre_depa, nombre_dist, proveedores.id_departamento, proveedores.id_provincia, proveedores.id_distrito, (COALESCE(CASE email_prov 
        WHEN '' THEN 'SIN CORREO' 
        ELSE email_prov 
        END,'SIN CORREO')) AS email_prov, (COALESCE(CASE dni_prov 
        WHEN '0' THEN 'SIN REGISTRO' 
        ELSE dni_prov 
        END,'SIN REGISTRO')) AS dni_prov, (COALESCE(CASE direccion_prov 
        WHEN '' THEN 'SIN DIRECCIÓN' 
        ELSE direccion_prov 
        END,'SIN DIRECCIÓN')) AS direccion_prov, (COALESCE(CASE observacion_prov 
        WHEN '' THEN 'SIN OBSERVACIONES' 
        ELSE observacion_prov 
        END,'SIN OBSERVACIONES')) AS observacion_prov, DATE_FORMAT(registro_prov, '%d/%m/%Y') AS REGISTRO FROM proveedores, departamentos, provincias, distritos WHERE proveedores.id_departamento=departamentos.id_departamento AND proveedores.id_provincia=provincias.id_provincia AND proveedores.id_distrito=distritos.id_distrito ORDER BY REGISTRO DESC, nombre_prov ASC";
	
	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$registro= $datos ['REGISTRO'];
		$nombre= $datos ['nombre_prov'];
		$ruc = $datos ['ruc_prov'];
		$dni = $datos ['dni_prov'];
		$telefono = $datos ['telefono_prov'];
		$correo = $datos ['email_prov'];
 
		$num++;  //264

		$mipdf -> Cell(25,5,utf8_decode("$registro"),1,0,'C');
	    $mipdf -> Cell(75,5,utf8_decode("$nombre"),1,0,'C');
		$mipdf -> Cell(34,5,utf8_decode("$ruc"),1,0,'C');
		$mipdf -> Cell(34,5,utf8_decode("$dni"),1,0,'C');
		$mipdf -> Cell(34,5,utf8_decode("$telefono"),1,0,'C');
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