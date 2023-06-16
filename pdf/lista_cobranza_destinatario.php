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
$destinatario=$_GET['destinatario'];

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
	$mipdf -> Cell('mm',10,utf8_decode("LISTA DE COBROS POR DESTINATARIO"),0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (2);
	$mipdf -> Cell('mm',10,utf8_decode("DESTINATARIO DE COBROS: $destinatario."),0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell('mm',10,utf8_decode("OFICINA ACTUAL: $SUCURSAL."),0,0,'L');
	$mipdf -> Ln (10);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(20,11,utf8_decode("Código"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(51,11,utf8_decode("Remitente"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(51,11,utf8_decode("Destinatario"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(26,11,utf8_decode("Cobro"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(26,11,utf8_decode("Pago"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(26,11,utf8_decode("Flete"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(26,11,utf8_decode("Pagado"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(26,11,utf8_decode("Deuda"),1,0,'C',true);

	$mipdf -> SetFont('ARIAL','B', 9);
	$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(27,11,utf8_decode("Estado"),1,0,'C',true);

			
	$mipdf -> Ln (1);
	$mipdf -> Ln(10);

	$sql="SELECT cobranza.id_cobro, manifiestos.id_manifiesto, movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND movimientos.id_sucursal='$id_sucursal' AND manifiestos.nombre_dest_mani='$destinatario' ORDER BY SALIDA DESC;";

	$sql2=$bd->consulta($sql);
	$num = 0; 

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$manifiesto= $datos ['MANIFIESTO'];
		$remitente= $datos ['REMITENTE'];
		$destinatario = $datos ['DESTINATARIO'];
		$cobro = $datos ['FECHA_COBRO'];
		$pago = $datos ['FECHA_PAGO'];
		$flete = $datos ['FLETE'];
		$pagado = $datos ['PAGO'];
		$deuda = $datos ['DEUDA'];
		$estado = $datos ['estado_cobro'];
 
		$num++;  //264

	    $mipdf -> Cell(20,5,utf8_decode("$manifiesto"),1,0,'C');
		$mipdf -> Cell(51,5,utf8_decode("$remitente"),1,0,'C');
		$mipdf -> Cell(51,5,utf8_decode("$destinatario"),1,0,'C');
		$mipdf -> Cell(26,5,utf8_decode("$cobro"),1,0,'C');
		$mipdf -> Cell(26,5,utf8_decode("$pago"),1,0,'C');
		$mipdf -> Cell(26,5,utf8_decode("$flete"),1,0,'C');
		$mipdf -> Cell(26,5,utf8_decode("$pagado"),1,0,'C');
		$mipdf -> Cell(26,5,utf8_decode("$deuda"),1,0,'C');
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