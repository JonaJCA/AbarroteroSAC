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

	$mes="SELECT CONCAT((CASE MONTH(movimientos.fecha_movi) WHEN 1 THEN 'ENERO' WHEN 2 THEN 'FEBRERO' WHEN 3 THEN 'MARZO' WHEN 4 THEN 'ABRIL' WHEN 5 THEN 'MAYO' WHEN 6 THEN 'JUNIO' WHEN 7 THEN 'JULIO' WHEN 8 THEN 'AGOSTO' WHEN 9 THEN 'SEPTIEMBRE' WHEN 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE' WHEN 12 THEN 'DICIEMBRE' END),' ', YEAR(movimientos.fecha_movi)) AS PERIODO FROM movimientos, operaciones, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND MONTH(movimientos.fecha_movi)=MONTH(CURDATE()) AND YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) GROUP BY movimientos.id_sucursal, PERIODO ORDER BY PERIODO";

	$query="SELECT (CONCAT(nombre_suc,' - ',direccion_suc,' (',nombre_depa,', ',nombre_provi,', ',nombre_dist,')')) AS SUCURSAL FROM administrador, sucursales, departamentos, provincias, distritos, movimientos WHERE movimientos.id_sucursal='$id_sucursal' AND administrador.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND provincias.id_departamento=departamentos.id_departamento AND distritos.id_provincia=provincias.id_provincia AND movimientos.id_sucursal=sucursales.id_sucursal;";

		$cs=$bd->consulta($query);
		$datos_suc = $bd-> mostrar_registros($query);
		$SUCURSAL = $datos_suc ['SUCURSAL'];

		$cs=$bd->consulta($mes);
		$datos_mes = $bd-> mostrar_registros($mes);
		$PERIODO = $datos_mes ['PERIODO'];

		$mipdf -> addPage();

			$mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> cell('mm',5,utf8_decode("ABARROTERO EXPRESS S.R.L."), 0 , 0, 'L');
			$mipdf -> cell('mm',5,utf8_decode("FECHA : $fecha"), 0 , 10, true);
			$mipdf -> cell('mm',2,utf8_decode("HORA : $hora"), 0 , 10, true);

			$mipdf -> Setfont('Arial','B',12);
			$mipdf -> Ln (2);
			$mipdf -> Cell('mm',10,utf8_decode("CUADRE DE CAJA ACTUAL: MOVIMIENTOS DEL MES ACTUAL"),0,0,'C');
			$mipdf -> Ln (10);

			$mipdf -> Setfont('Arial','B',10);
			$mipdf -> Ln (2);
			$mipdf -> Cell('mm',10,utf8_decode("PERIODO: $PERIODO."),0,0,'L');
			$mipdf -> Ln (2);

			$mipdf -> Setfont('Arial','B',10);
			$mipdf -> Ln (2);
			$mipdf -> Cell('mm',10,utf8_decode("OFICINA: $SUCURSAL."),0,0,'L');
			$mipdf -> Ln (10);

        	$mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(20,11,utf8_decode("Fecha"),1,0,'C',true);
			
			$mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(20,11,utf8_decode("Tipo"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(85,11,utf8_decode("Operación"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(105,11,utf8_decode("Descripción"),1,0,'C',true);

		    $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(25,11,utf8_decode("Ingresos"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(25,11,utf8_decode("Egresos"),1,0,'C',true);
				
			$mipdf -> Ln (1);
		
	$mipdf -> Ln(10);
	
$consulta_principal="SELECT movimientos.id_sucursal, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, operaciones.tipo_ope AS TIPO, operaciones.descripcion_ope AS OPERACION, movimientos.descripcion_movi AS DESCRIPCION, CONCAT('S/', FORMAT((CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT((CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (monto_movi) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN 'INGRESOS' WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN 'VALES' ELSE 'EGRESOS' END) END AS TIPO FROM movimientos, operaciones, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND sucursales.id_sucursal='$id_sucursal' AND MONTH(movimientos.fecha_movi)=MONTH(movimientos.fecha_movi) AND YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) ORDER BY operaciones.tipo_ope DESC, TIPO ASC, movimientos.fecha_movi DESC;";


$sql2=$bd->consulta($consulta_principal);

$oye=0;
$num = 0; 


	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$FECHA= $datos ['FECHA'];	
		$TIPO = $datos ['TIPO'];
		$OPERACION = $datos ['OPERACION'];
		$DESCRIPCION = $datos ['DESCRIPCION'];
		$INGRESOS = $datos ['INGRESOS'];
		$EGRESOS = $datos ['EGRESOS'];
		
		$cabeceraS = array("$id");
		
  		$num++;  
		
		$mipdf -> SetFont('ARIAL','B',8);
		$mipdf -> Cell(20,5,utf8_decode("$FECHA"),1,0,'C');
		$mipdf -> Cell(20,5,utf8_decode("$TIPO"),1,0,'C');	
		$mipdf -> SetFont('ARIAL','B',7);  
		$mipdf -> Cell(85,5,utf8_decode("$OPERACION"),1,0,'C');
		$mipdf -> Cell(105,5,utf8_decode("$DESCRIPCION"),1,0,'C');
		$mipdf -> SetFont('ARIAL','B',8);
		$mipdf -> Cell(25,5,utf8_decode("$INGRESOS"),1,0,'C');
		$mipdf -> Cell(25,5,utf8_decode("$EGRESOS"),1,0,'C');		 

		$mipdf -> Ln(5);
	}	

	$TOTALES="SELECT movimientos.id_sucursal, movimientos.fecha_movi, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND MONTH(movimientos.fecha_movi)=MONTH(movimientos.fecha_movi) AND YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND sucursales.id_sucursal='$id_sucursal' GROUP BY movimientos.id_sucursal ORDER BY movimientos.fecha_movi";

	$cs=$bd->consulta($TOTALES);
	$final = $bd-> mostrar_registros($TOTALES);
    $INGRESOS = $final ['INGRESOS'];
	$EGRESOS = $final ['EGRESOS'];
	$SALDO = $final ['SUBTOTAL'];
	$VALES = $final ['VALES'];
	$SALDO_EFECTIVO = $final ['SALDO'];

	        $mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(230,5,utf8_decode("SUBTOTAL  "),1,0,'R',true);

		    $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(25,5,utf8_decode("$INGRESOS"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(25,5,utf8_decode("$EGRESOS"),1,0,'C',true);

	        $mipdf -> Ln(5);

	        $mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(230,5,utf8_decode("SALDO TOTAL  "),1,0,'R',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(50,5,utf8_decode("$SALDO"),1,0,'C',true);

	        $mipdf -> Ln(5);

	        $mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(230,5,utf8_decode("SUBTOTAL ( VALES ) "),1,0,'R',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(50,5,utf8_decode("$VALES"),1,0,'C',true);

	        $mipdf -> Ln(5);

	        $mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(230,5,utf8_decode("SALDO EFECTIVO  "),1,0,'R',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(50,5,utf8_decode("$SALDO_EFECTIVO"),1,0,'C',true);
		
		$mipdf -> Ln(10);
	
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