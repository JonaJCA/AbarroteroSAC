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
$estado=$_GET['estado'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE USUARIOS POR ESTADO"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("ESTADO DE USUARIO: $estado."),0,0,'L');
	$mipdf -> Ln (10);
		
	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(8,11,utf8_decode("ID"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(75,11,utf8_decode("Encargado"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(38,11,utf8_decode("Usuario"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(72,11,utf8_decode("Correo electrónico"),1,0,'C',true);	

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(31,11,utf8_decode("Nivel"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(53,11,utf8_decode("Sucursal"),1,0,'C',true);
			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);
	
	$sql="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden, id, CONCAT(nombre,' ',apellido) AS nomape, nombre, apellido, usuario, correo, CASE nive_usua
                                            WHEN 1 THEN 'ADMINISTRADOR'
                                            WHEN 2 THEN 'EMPLEADO'
                                            WHEN 3 THEN 'OTRO'
                                            END nive_usua, nombre_suc, estado FROM administrador, sucursales, (SELECT @s:=0) AS s WHERE administrador.id_sucursal=sucursales.id_sucursal AND administrador.estado='$estado' ORDER BY orden, nive_usua, nomape ASC;";
	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$orden= $datos ['orden'];
		$encargado= $datos ['nomape'];
		$usuario = $datos ['usuario'];
		$correo = $datos ['correo'];
		$nivel = $datos ['nive_usua'];
		$sucursal = $datos ['nombre_suc'];
 
		$num++;  

	    $mipdf -> Cell(8,5,utf8_decode("$orden"),1,0,'C');
		$mipdf -> Cell(75,5,utf8_decode("$encargado"),1,0,'C');
		$mipdf -> Cell(38,5,utf8_decode("$usuario"),1,0,'C');	
		$mipdf -> Cell(72,5,utf8_decode("$correo"),1,0,'C');
		$mipdf -> Cell(31,5,utf8_decode("$nivel"),1,0,'C');
		$mipdf -> Cell(53,5,utf8_decode("$sucursal"),1,0,'C');
			
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