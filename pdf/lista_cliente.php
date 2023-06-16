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
$id_sucursal=$_GET['id_sucursal'];
$nombre_suc=$_GET['nombre_suc'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE CLIENTES POR LUGAR DE COBRANZA"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("LUGAR DE COBRANZA ( SUCURSAL ): $nombre_suc."),0,0,'L');
	$mipdf -> Ln (10);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(24,11,utf8_decode("Registro"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(80,11,utf8_decode("Razón social"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(32,11,utf8_decode("RUC"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(32,11,utf8_decode("DNI"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(34,11,utf8_decode("Teléfono"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(75,11,utf8_decode("Correo electrónico"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

	$sql="SELECT DATE_FORMAT(registro_cli, '%d/%m/%Y') AS REGISTRO, (clientes.id_cliente) AS CODIGO, clientes.id_departamento, clientes.id_provincia, clientes.id_distrito, nombre_depa, nombre_provi, nombre_dist, (CONCAT(nombre_cli)) AS CLIENTE, (clientes.ruc_cli) AS RUC, (COALESCE(CASE direccion_cli1 
        WHEN '' THEN 'SIN DIRECCIÓN' 
        ELSE direccion_cli1 
        END,'SIN DIRECCIÓN')) AS direccion_cli1, (clientes.telefono_cli) AS TELEFONO, (sucursales.nombre_suc) AS LUGAR2, (COALESCE(CASE email_cli 
        WHEN '' THEN 'SIN CORREO' 
        ELSE email_cli 
        END,'SIN CORREO')) AS CORREO, (sucursales.nombre_suc) AS LUGAR, (CONCAT(nombre_depa,', ',nombre_provi,', ',nombre_dist)) AS ubicacion, (COALESCE(CASE dni_cli 
        WHEN '0' THEN 'SIN REGISTRO' 
        ELSE dni_cli 
        END,'SIN REGISTRO')) AS DNI FROM clientes, sucursales, departamentos, provincias, distritos WHERE clientes.id_sucursal=sucursales.id_sucursal AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND sucursales.nombre_suc='$nombre_suc' ORDER BY REGISTRO DESC, CLIENTE ASC";

	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$registro= $datos ['REGISTRO'];
		$cliente= $datos ['CLIENTE'];
		$ruc = $datos ['RUC'];
		$dni = $datos ['DNI'];
		$telefono = $datos ['TELEFONO'];
		$correo = $datos ['CORREO'];
 
		$num++;  //264

	    $mipdf -> Cell(24,5,utf8_decode("$registro"),1,0,'C');
		$mipdf -> Cell(80,5,utf8_decode("$cliente"),1,0,'C');
		$mipdf -> Cell(32,5,utf8_decode("$ruc"),1,0,'C');
		$mipdf -> Cell(32,5,utf8_decode("$dni"),1,0,'C');
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