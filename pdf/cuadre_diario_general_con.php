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

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha = date('d/m/Y ');

class MiPDF extends FPDF {
	
	public function header()
		{

		}
	
	}
	
	$mipdf = new MiPDF('L','mm','A4');

	$dias="SELECT CONCAT('DEL ',(DATE_FORMAT((DATE_ADD(CURDATE(), INTERVAL (-7) DAY)), '%d/%m/%Y')),' AL ', (DATE_FORMAT(CURDATE(), '%d/%m/%Y'))) AS LAPSO, (DATE_FORMAT(CURDATE(), '%d/%m/%Y')) AS TOPE FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND sucursales.id_sucursal='2' AND (movimientos.fecha_movi BETWEEN (DATE_ADD(CURDATE(), INTERVAL (-7) DAY)) AND CURDATE()) GROUP BY movimientos.id_sucursal, movimientos.fecha_movi ORDER BY movimientos.fecha_movi;";

	$query="SELECT (CONCAT(nombre_suc,' - ',direccion_suc,' (',nombre_depa,', ',nombre_provi,', ',nombre_dist,')')) AS SUCURSAL FROM administrador, sucursales, departamentos, provincias, distritos, movimientos WHERE movimientos.id_sucursal='$id_sucursal' AND administrador.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND provincias.id_departamento=departamentos.id_departamento AND distritos.id_provincia=provincias.id_provincia AND movimientos.id_sucursal=sucursales.id_sucursal;";

		$cs=$bd->consulta($query);
		$datos_suc = $bd-> mostrar_registros($query);
		$SUCURSAL = $datos_suc ['SUCURSAL'];

		$cs=$bd->consulta($dias);
		$datos_dias = $bd-> mostrar_registros($dias);
		$LAPSO = $datos_dias ['LAPSO'];
		$TOPE = $datos_dias ['TOPE'];

		$mipdf -> addPage();

			$mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> cell('mm',5,utf8_decode("ABARROTERO EXPRESS S.R.L."), 0 , 0, 'L');
			$mipdf -> cell('mm',5,utf8_decode("FECHA : $fecha"), 0 , 10, true);
			$mipdf -> cell('mm',2,utf8_decode("HORA : $hora"), 0 , 10, true);

			$mipdf -> Setfont('Arial','B',12);
			$mipdf -> Ln (2);
			$mipdf -> Cell('mm',10,utf8_decode("CUADRE DE CAJA CONSOLIDADO: MOVIMIENTOS DE LA ÚLTIMA SEMANA"),0,0,'C');
			$mipdf -> Ln (10);

			$mipdf -> Setfont('Arial','B',10);
			$mipdf -> Ln (2);
			$mipdf -> Cell('mm',10,utf8_decode("PERIODO: $LAPSO."),0,0,'L');
			$mipdf -> Ln (2);

			$mipdf -> Setfont('Arial','B',10);
			$mipdf -> Ln (2);
			$mipdf -> Cell('mm',10,utf8_decode("OFICINA: $SUCURSAL."),0,0,'L');
			$mipdf -> Ln (10);

        	$mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(46,11,utf8_decode("Periodo"),1,0,'C',true);
			
			$mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(40,11,utf8_decode("Evaluación"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(40,11,utf8_decode("Operaciones"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(28,11,utf8_decode("Ingresos"),1,0,'C',true);

		    $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(28,11,utf8_decode("Egresos"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,11,utf8_decode("Saldo total"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(28,11,utf8_decode("Vales"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,11,utf8_decode("Saldo efectivo"),1,0,'C',true);
				
			$mipdf -> Ln (1);
		
	$mipdf -> Ln(10);
	
$consulta_principal="SELECT movimientos.id_sucursal, movimientos.fecha_movi, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND sucursales.id_sucursal='$id_sucursal' AND (movimientos.fecha_movi BETWEEN (DATE_ADD(CURDATE(), INTERVAL (-7) DAY)) AND CURDATE()) GROUP BY movimientos.id_sucursal, movimientos.fecha_movi ORDER BY movimientos.fecha_movi DESC;";

$sql2=$bd->consulta($consulta_principal);

$oye=0;
$num = 0; 


	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$PERIODO= $datos ['FECHA'];	
		$EVALUACION = $datos ['EVALUADOS'];
		$OPERACIONES = $datos ['OPERACIONES'];
		$INGRESOS = $datos ['INGRESOS'];
		$EGRESOS = $datos ['EGRESOS'];
		$SALDO = $datos ['SUBTOTAL'];
		$VALES = $datos ['VALES'];
		$SALDO_EFECTIVO = $datos ['SALDO'];
		
		$cabeceraS = array("$id");
		
  		$num++;  
		
		$mipdf -> SetFont('ARIAL','B',9);
		$mipdf -> Cell(46,5,utf8_decode("$PERIODO"),1,0,'C');
		$mipdf -> Cell(40,5,utf8_decode("$EVALUACION"),1,0,'C');  
		$mipdf -> Cell(40,5,utf8_decode("$OPERACIONES"),1,0,'C');
		$mipdf -> Cell(28,5,utf8_decode("$INGRESOS"),1,0,'C');
		$mipdf -> Cell(28,5,utf8_decode("$EGRESOS"),1,0,'C');
		$mipdf -> Cell(35,5,utf8_decode("$SALDO"),1,0,'C'); 
		$mipdf -> Cell(28,5,utf8_decode("$VALES"),1,0,'C');
		$mipdf -> Cell(35,5,utf8_decode("$SALDO_EFECTIVO"),1,0,'C');

		$mipdf -> Ln(5);
	}	
	
		$mipdf -> Output();
		class PDF extends FPDF
{
function Footer()
{
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered page number
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');

}

}
?>