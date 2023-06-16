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
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$categoria_ope=$_GET['categoria_ope'];

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha = date('d/m/Y ');
$fecha7dias = date('d-m-Y', strtotime('-1 week')) ; // resta 1 semana

$query="SELECT (CONCAT(nombre_suc,' - ',direccion_suc,' (',nombre_depa,', ',nombre_provi,', ',nombre_dist,')')) AS SUCURSAL FROM administrador, sucursales, departamentos, provincias, distritos, movimientos WHERE movimientos.id_sucursal='$id_sucursal' AND administrador.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND provincias.id_departamento=departamentos.id_departamento AND distritos.id_provincia=provincias.id_provincia AND movimientos.id_sucursal=sucursales.id_sucursal;";

$cs=$bd->consulta($query);
$datos = $bd-> mostrar_registros($query);
$SUCURSAL = $datos ['SUCURSAL'];

class MiPDF extends FPDF {
		
	}
			
	$mipdf = new MiPDF('L','mm','A4');
	$mipdf -> addPage();

	//$mipdf->Image('../img/vcom_logo.jpg', 10 ,7, 20 , 20,'JPG');

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> cell('mm',5,utf8_decode("FECHA : $fecha"), 0 , 10, true);
	$mipdf -> cell('mm',2,utf8_decode("HORA : $hora"), 0 , 10, true);

	$mipdf -> Setfont('Arial','B',12);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE INGRESOS POR CATEGORÍA DE OPERACIÓN"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("CATEGORÍA DE OPERACIÓN: $categoria_ope."),0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell('mm',10,utf8_decode("OFICINA ACTUAL: $SUCURSAL."),0,0,'L');
	$mipdf -> Ln (10);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(18,11,utf8_decode("Código"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,utf8_decode("Fecha"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,utf8_decode("Hora"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(102,11,utf8_decode("Operación"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,utf8_decode("Monto"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(63,11,utf8_decode("Trabajador"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(27,11,utf8_decode("Estado"),1,0,'C',true);

			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

	$sql="SELECT CONCAT('I',LPAD(movimientos.id_movimiento,'6','0')) AS INGRESO, CONCAT(DATE_FORMAT(fecha_movi, '%d/%m/%Y'),' - ',hora_movi) AS REGISTRO, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, numero_movi, CONCAT(documentos.nombre_doc,' ',numero_movi) AS DOCUMENTO, descripcion_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, CONCAT(nombre,' ',apellido) AS nomape, nombre_suc, estado_movi FROM movimientos, operaciones, documentos, administrador, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND categoria_ope='$categoria_ope' AND tipo_ope='INGRESOS' AND (nombre_doc NOT LIKE '%GUIA DE REMISION%') AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND movimientos.id_sucursal='$id_sucursal' ORDER BY REGISTRO DESC";

	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$ingreso= $datos ['INGRESO'];
		$fecham= $datos ['fecha_movi'];
		$horam= $datos ['hora_movi'];
		$operacion = $datos ['descripcion_ope'];
		$monto = $datos ['monto_movi'];
		$encargado = $datos ['nomape'];
		$estado = $datos ['estado_movi'];
 
		$num++;  //264

	    $mipdf -> Cell(18,5,utf8_decode("$ingreso"),1,0,'C');
	    $mipdf -> Cell(22,5,utf8_decode("$fecham"),1,0,'C');
		$mipdf -> Cell(22,5,utf8_decode("$horam"),1,0,'C');
		$mipdf -> Cell(102,5,utf8_decode("$operacion"),1,0,'C');
		$mipdf -> Cell(22,5,utf8_decode("$monto"),1,0,'C');
		$mipdf -> Cell(63,5,utf8_decode("$encargado"),1,0,'C');
		$mipdf -> Cell(27,5,utf8_decode("$estado"),1,0,'C');
		
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