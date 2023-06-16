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
(CONCAT((DATE_FORMAT(fecha_movimiento, '%d')),' DE ',(CASE MONTH(movimientos.fecha_movimiento)
                                            WHEN 1 THEN 'ENERO'
                                            WHEN 2 THEN 'FEBRERO'
                                            WHEN 3 THEN 'MARZO'
                                            WHEN 4 THEN 'ABRIL'
                                            WHEN 5 THEN 'MAYO'
                                            WHEN 6 THEN 'JUNIO'
                                            WHEN 7 THEN 'JULIO'
                                            WHEN 8 THEN 'AGOSTO'
                                            WHEN 9 THEN 'SEPTIEMBRE'
                                            WHEN 10 THEN 'OCTUBRE'
                                            WHEN 11 THEN 'NOVIEMBRE'
                                            WHEN 12 THEN 'DICIEMBRE'
                                            END),' DEL ',(DATE_FORMAT(fecha_movimiento, '%Y')))) AS FECHA,
movimientos.id_movimientos, 
(CONCAT(socios.nombres,' ',socios.apellidos)) AS SOCIO,
(CONCAT('S/',FORMAT((movimientos.monto)+((CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)*(0.01)*movimientos.cuotas
                                        WHEN '5' THEN (movimientos.monto)*(0.02)*movimientos.cuotas
                                        WHEN '6' THEN (movimientos.monto)*(0.03)*movimientos.cuotas
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END)),2))) AS MONTO,
(movimientos.garante) AS GARANTE,
(movimientos.cuotas) AS CUOTAS,
(CONCAT('S/',FORMAT((CAST(((movimientos.monto)+((CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)*(0.01)*movimientos.cuotas
                                        WHEN '5' THEN (movimientos.monto)*(0.02)*movimientos.cuotas
                                        WHEN '6' THEN (movimientos.monto)*(0.03)*movimientos.cuotas
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END)))/cuotas AS DECIMAL(8,2))),2))) AS FRACCIONADO,
(socios.codigo) AS CODIGO,
(socios.dni) AS DNI,
(socios.categoria) AS CATEGORIA,
(movimientos.operacion) AS OPERACION,
(CONCAT(documento.nombre_doc,' - ',movimientos.numero_doc)) AS DOCUMENTO,
(CONCAT(documento.nombre_doc)) AS DOCUMENTO2
FROM movimientos, socios, documento
WHERE movimientos.id_socios=socios.id_socios
AND movimientos.codigo_doc=documento.codigo_doc
AND id_movimientos=$id_movimientos;";
	
$sql2=$bd->consulta($sql);

	while ( $datos = $bd-> mostrar_registros($sql2))
	{

	$mipdf = new MiPDF();
	$mipdf -> addPage();
	
	$mipdf->Image('../img/cooperativa.png',9,12,25);
	$mipdf->Image('../img/logo.png',177,12,25);

	$socio= $datos ['SOCIO'];
	$fecha= $datos ['FECHA'];
	$monto= $datos ['MONTO'];
	$garante= $datos ['GARANTE'];
	$fraccionado= $datos ['FRACCIONADO'];
	$cuotas= $datos ['CUOTAS'];
	$codigo= $datos ['CODIGO'];
	$dni= $datos ['DNI'];
	$categoria= $datos ['CATEGORIA'];
	$operacion= $datos ['OPERACION'];
	$documento= $datos ['DOCUMENTO'];
	$documento2= $datos ['DOCUMENTO2'];


	$mipdf -> SetTextColor(125, 160, 56);
	$mipdf -> Setfont('Arial','B',12);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"COOPERATIVA DE AHORRO Y CREDITO DE LOS TRABAJADORES",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',12);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"LIMA SHERATON HOTEL LTDA N.118",0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"FUNDADA EL 27 DE NOVIEMBRE DE 1976 CONSTITUIDA EL 22 DE FEBRERO DE 1977",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"RECONOCIDA EL 28 DE DICIEMBRE DE 1977 - MODIFICADA SU OBJETIVO SOCIAL EL 4 DE NOVIEMBRE DE 1994",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"INSCRITA EN LOS REGISTROS PUBLICOS EN LA FICHA N.5064",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"ASIENTO C.I. DEL ASIENTO 3058 TOMO 48 DE LA FECHA 3 DE NOVIEMBRE DE 1977 L.T. N.9400656",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"R.P.N. 10472132 INSCRITO LA MODIFICACION DEL ESTATUTO Y OBJETIVO SOCIAL EN",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"LOS REGISTROS PUBLICOS CON EL TITULO 153006 DEL TOMO 368 DEL 7 DE DICIEMBRE DE 1994",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',7);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"R.U.C. N.13944857 CON DOMICILIO FISCAL EN GUILLERMO DANSEY N.076 OF.301 LIMA TELEFONO: 431-4620",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf->Image('../img/estrella.png',95,27,3);
	$mipdf->Image('../img/estrella.png',100,27,3);
	$mipdf->Image('../img/estrella.png',105,27,3);
	$mipdf->Image('../img/estrella.png',110,27,3);
	$mipdf->Image('../img/estrella.png',115,27,3);

	$mipdf -> SetTextColor(0, 0, 0);

	$mipdf -> Setfont('Arial','B',12);
	$mipdf -> Ln (23);
	$mipdf -> Cell(190,10,"SOLICITUD DE $documento",0,0,'C');
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (10);	
 	$mipdf->MultiCell(190,7,"          YO, $socio IDENTIFICADO CON DNI N.$dni Y REGISTRADO CON CODIGO $codigo EN LA \"COOPERATIVA DE AHORRO Y CREDITO DE LOS TRABAJADORES DE LIMA SHERATON HOTEL\" CON CATEGORIA DE TIPO $categoria, CONFIRMO QUE HE REALIZADO UNA SOLICITUD DE $documento2 CON UN MONTO TOTAL DE $monto FRACCIONADO EN $cuotas CUOTAS DE $fraccionado; SUJETO A PREVIA EVALUACION Y DE ACUERDO A LO QUE SE ESTABLECE EN LA NORMATIVA Y POLITICAS DE LA COOPERATIVA, ASI COMO SE DECRETA EN LA LEY N.15171 ARTICULO N.1 DECRETO LEY N.85 ARTICULO N.79. EN LA SOLICITUD ACTUAL NO SE INCLUYERON MONTOS DECRETADOS POR LA SUPERINTENDENCIA DE BANCA Y SEGUROS.");
	
		
	
	}
		
		$mipdf -> Ln(10);
		$mipdf -> cell(190,5,"LIMA $fecha" , 0 , 10, true);
		$mipdf -> Ln(30);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"_______________________",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"FIRMA DEL SOCIO",0,0,'C');
	$mipdf -> Ln (2);
	$mipdf -> Ln(5);
		
	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Cell(190,10,"  _______________________",0,0,'L');

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (0);
	$mipdf -> Cell(190,10,"_______________________  ",0,0,'R');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"                GERENTE",0,0,'L');


	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (0);
	$mipdf -> Cell(190,10,"PRESIDENTE             ",0,0,'R');
	$mipdf -> Ln (2);
	$mipdf -> Ln(5);
	

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"_______________________",0,0,'C');
	$mipdf -> Ln (2);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (3);
	$mipdf -> Cell(190,10,"$garante",0,0,'C');
	$mipdf -> Ln (2);
	$mipdf -> Ln(10);


	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"SOCIO N. $codigo",0,0,'L');
	$mipdf -> Ln (2);
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
