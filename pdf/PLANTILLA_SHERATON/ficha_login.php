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
 $id = $_GET['id'];
 $id_socios = $_GET['id_socios'];

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha7dias = date('d-m-Y', strtotime('-1 week')) ; // resta 1 semana




class MiPDF extends FPDF {
	
	
	
	
	}

$sql="SELECT id, 
(CONCAT(apellido,', ',nombre)) AS NOMAPE,
(CONCAT(socios.dni,' (',socios.vigente,')')) AS DNI,
(socios.telefono) AS TELEFONO,
(DATE_FORMAT(socios.fecha, '%d/%m/%Y')) AS REGISTRO,
(DATE_FORMAT(socios.termino, '%d/%m/%Y')) AS TERMINO,
(socios.categoria) AS CATEGORIA,
(socios.codigo) AS CODIGO,
(socios.SEGURO) AS SEGURO,
(socios.ESTADO) AS ESTADO,
(USUARIO) AS USUARIO,
(CONCAT(socios.codigo,'@SHERATONCOOP.COM')) AS CORREO,
(socios.dni) AS CLAVE,
CONCAT(DAY(CURDATE()),' DE ', CASE MONTH(CURDATE())
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
                                            END,' DEL ', YEAR(CURDATE())) AS FECHAM
FROM administrador, socios 
WHERE administrador.pass=md5(socios.dni)
AND id=$id
ORDER BY id ASC;";
	
$sql2=$bd->consulta($sql);

	while ( $datos = $bd-> mostrar_registros($sql2))
	{

	$mipdf = new MiPDF();
	$mipdf -> addPage();
	
	$mipdf->Image('../img/cooperativa.png',9,12,25);
	$mipdf->Image('../img/logo.png',177,12,25);

	$NOMAPE= $datos ['NOMAPE'];
	$DNI= $datos ['DNI'];
	$TELEFONO= $datos ['TELEFONO'];
	$REGISTRO= $datos ['REGISTRO'];
	$TERMINO= $datos ['TERMINO'];
	$CATEGORIA= $datos ['CATEGORIA'];
	$CODIGO= $datos ['CODIGO'];
	$SEGURO= $datos ['SEGURO'];
	$ESTADO= $datos ['ESTADO'];
	$USUARIO= $datos ['USUARIO'];
	$CORREO= $datos ['CORREO'];
	$CLAVE= $datos ['CLAVE'];
	$FECHAM= $datos ['FECHAM'];


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
	$mipdf -> Ln (18);
	$mipdf -> Cell(190,10,"FICHA DE DATOS DEL SOCIO $CODIGO",0,0,'C');
	$mipdf -> Ln (12);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> SetFillColor(39, 181, 70);
	$mipdf -> Cell(190,10,"DATOS DEL SOCIO",1,0,'C', true);
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',9);
	$mipdf -> Cell(190,10,"APELLIDOS Y NOMBRES: $NOMAPE.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"DNI (VIGENTE): $DNI.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"TELEFONO / CELULAR: $TELEFONO.",1,0,'L');
	$mipdf -> Ln (18);

	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Cell(190,10,"DATOS REFERENTES A LA COOPERATIVA",1,0,'C', true);
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',9);
	$mipdf -> Cell(190,10,"FECHA DE REGISTRO: $REGISTRO.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"FECHA DE CADUCIDAD: $TERMINO.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"CATEGORIA DEL TRABAJADOR: $CATEGORIA.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"CODIGO DEL TRABAJADOR: $CODIGO.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"SEGURO: $SEGURO.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"ESTADO: $ESTADO.",1,0,'L');
	$mipdf -> Ln (18);
	
	$mipdf -> Setfont('Arial','B',10);
	$mipdf -> Cell(190,10,"DATOS DE ACCESO AL SISTEMA",1,0,'C', true);
	$mipdf -> Ln (10);

	$mipdf -> Setfont('Arial','B',9);
	$mipdf -> Cell(190,10,"NOMBRE DE USUARIO: $USUARIO.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"CORREO CORPORATIVO: $CORREO.",1,0,'L');
	$mipdf -> Ln (10);
	$mipdf -> Cell(190,10,"CLAVE DE ACCESO: $CLAVE.",1,0,'L');

	
	}
		
		$mipdf -> Setfont('Arial','B',10);
		$mipdf -> Ln(18);
		$mipdf -> cell(190,5,"LIMA, $FECHAM" , 0 , 10, true);


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
