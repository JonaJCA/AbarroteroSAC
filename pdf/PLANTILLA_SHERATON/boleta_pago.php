<?php


if(ob_get_length() > 0) {
    ob_clean();
}

include"../inc/comun.php";
include"../fpdf/fpdf.php";

ob_end_clean();    
header("Content-Encoding: None", true);


 $bd = new GestarBD;
 
 $x1=$_GET['codigo'];
 $id_movimientos = $_GET['id_movimientos'];

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha = date('d-m-Y ');
$fecha7dias = date('d-m-Y', strtotime('-1 week')) ; // resta 1 semana




class MiPDF extends FPDF {
	
	
	
	
	}
	
$sql="SELECT 
(CONCAT(LPAD(movimientos.id_movimientos, 9, '0'),' / 000000000')) AS ID_MOVIMIENTOS_2,
(LPAD(movimientos.id_movimientos, 5, '0')) AS ID_MOVIMIENTOS,
DATE_FORMAT(fecha_movimiento, '%d/%m/%Y') AS FECHA, 
socios.codigo, (CONCAT('S/',FORMAT(monto,2))) AS MONTO, 
CONCAT('01      ',movimientos.operacion) AS OPERACION, 
CONCAT(documento.nombre_doc,'-',movimientos.numero_doc) AS DOCUMENTO, 
CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO,
CONCAT(socios.nombres,' ',socios.apellidos) AS SOCIO,
(socios.codigo) AS SOCIO2,
(LPAD(movimientos.id, 3, '0')) AS ADMIN 
FROM movimientos, socios, documento, administrador 
WHERE tipo_movimiento='PRESTAMO' 
AND movimientos.operacion NOT LIKE '%ANULA%' 
AND movimientos.operacion = 'AMORTIZACION'
AND movimientos.id=administrador.id 
AND movimientos.id_socios=socios.id_socios 
AND movimientos.codigo_doc=documento.codigo_doc 
AND id_movimientos=$id_movimientos 
ORDER BY fecha ASC;
";
	$sql2=$bd->consulta($sql);

		while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
	
	$cabeceraT = array("Fecha");
		
		
		$mipdf = new MiPDF('P','mm',array(90,155));
		$mipdf -> addPage();

		$num;
		$ID_MOVIMIENTOS= $datos ['ID_MOVIMIENTOS'];
		$OPERACION= $datos ['OPERACION'];
		$FECHA= $datos ['FECHA'];
		$MONTO= $datos ['MONTO'];
		$ADMIN= $datos ['ADMIN'];
		$SOCIO= $datos ['SOCIO'];
		$SOCIO2= $datos ['SOCIO2'];
		$ENCARGADO= strtoupper($datos ['ENCARGADO']);

		$mipdf->Image('../img/mar.jpg',2,1,86);
		$mipdf->Image('../img/cooperativa.png',8,7,10);
		$mipdf->Image('../img/logo.png',72,7,10);
		$mipdf->Image('../img/linea.jpg',5,42,80);
		$mipdf->Image('../img/linea.jpg',5,80,80);
		$mipdf->Image('../img/linea.jpg',5,119,80);
		$mipdf->Image('../img/barras.png',5,128,80);
		$mipdf->Image('../img/estrella.png',54,28,3);
		$mipdf->Image('../img/estrella.png',49,28,3);
		$mipdf->Image('../img/estrella.png',44,28,3);
		$mipdf->Image('../img/estrella.png',39,28,3);
		$mipdf->Image('../img/estrella.png',34,28,3);

	$mipdf -> SetTextColor(125, 160, 56);
	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Cell(71,0,"COOPERATIVA DE AHORRO",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(71,0,"Y CREDITO DE LOS",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(71,0,"TRABAJADORES DE LIMA ",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(71,0,"SHERATON HOTEL LTDA N.118 ",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',6);
	$mipdf -> Ln (3);
	$mipdf -> Cell(71,10,"FUNDADA EL 27 DE NOVIEMBRE DE 1976, R.U.C. N.13944857 CON DOMICILIO ",0,0,'C');
	$mipdf -> Ln (1);

	$mipdf -> Setfont('Arial','B',6);
	$mipdf -> Ln (3);
	$mipdf -> Cell(71,10,"FISCAL EN GUILLERMO DANSEY N.076 OF.301 LIMA TELEFONO: 431-4620",0,0,'C');
	$mipdf -> Ln (1);	

	$mipdf -> SetTextColor(0, 0, 0);
	$mipdf -> Setfont('Arial','B',9);
	$mipdf -> Ln (8);
	$mipdf -> Cell(72,10,"BOLETA DE PAGO ELECTRONICA $ID_MOVIMIENTOS",0,0,'C');
	$mipdf -> Ln (3);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (5);
	$mipdf -> Cell(20,10,"DIRECCION    :      PASEO DE LA REPUBLICA 170",0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (2);
	$mipdf -> Cell(20,10,"LOCALIDAD   :      CERCADO DE LIMA 15001, LIMA",0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (2);
	$mipdf -> Cell(20,10,"FECHA            :      $FECHA",0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (2);
	$mipdf -> Cell(20,10,"HORA              :      $hora",0,0,'L');
	$mipdf -> Ln (2);	

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (2);
	$mipdf -> Cell(20,10,"ENCARGADO :      $ENCARGADO",0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (2);
	$mipdf -> Cell(20,10,"CODIGO          :      $ADMIN",0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (10);
	$mipdf -> Cell(20,10,"ID      DESCRIPCION                CANTIDAD                MONTO",0,0,'L');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (5);
	$mipdf -> Cell(60,5,"$OPERACION",0,0,'L');
	$mipdf -> Ln (0);
	$mipdf -> Cell(60,5,"                                                   1",0,0,'L');
	$mipdf -> Ln (0);
	$mipdf -> Cell(60,5,"                                                                                      $MONTO",0,0,'L');
	$mipdf -> Ln (4);
	$mipdf -> Cell(60,5,"                                                                                      ---------------",0,0,'L');	
	$mipdf -> Ln (4);
	$mipdf -> Cell(60,5,"                                                                       TOTAL   $MONTO",0,0,'L');
	
	$mipdf -> Ln (22);
	$mipdf -> SetTextColor(0, 0, 0);
	$mipdf -> Setfont('Arial','B',6);
	$mipdf -> Cell(20,10,"SOCIO: $SOCIO",0,0,'L');
	$mipdf -> Ln (0);
	$mipdf -> Cell(20,10,"                                                                                           CODIGO: $SOCIO2",0,0,'L');
	$mipdf -> Ln (2);

			$mipdf -> Ln (1);
	
	$mipdf -> Ln(10);
	


		
	
	
		$mipdf -> Ln(5);
		}
		
		
	
	
	 		
		$mipdf -> Ln(10);
		//$mipdf -> cell(190,5,"LIMA $FECHA2" , 0 , 10, true);
		$mipdf -> Ln(5);

		
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
