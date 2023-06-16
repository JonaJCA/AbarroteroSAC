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
 $mes=$_GET['mes'];
 $anho=$_GET['anho'];
 $nombre=$_GET['nombre'];

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha = date('d/m/Y ');
$fecha7dias = date('d-m-Y', strtotime('-1 week')) ; // resta 1 semana




class MiPDF extends FPDF {
	
	
	
	
	}
	
	$cabeceraT = array("Fecha");
		
		
		$mipdf = new MiPDF('L','mm','A4');
		$mipdf -> addPage();

		$mipdf -> Setfont('Arial','B',10);
		$mipdf -> Ln (2);
		$mipdf -> Cell('mm',10,"INDICE DE CUENTAS POR COBRAR",0,0,'C');
		$mipdf -> Ln (2);
		$mipdf -> Setfont('Arial','B',10);
		$mipdf -> Ln (3);
		$mipdf -> Cell('mm',10,"PERIODO: MAYO-JUNIO 2019",0,0,'C');
		$mipdf -> Ln (12);

	//$mipdf -> SetFont('ARIAL','B', 9);
//$mipdf -> SetFillColor(0, 191, 255);
	//$mipdf -> Cell(10,11,"N",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,"Fecha",1,0,'C',true);
		
	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(60,11,"Documento",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,"Numero",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,"Ventas totales",1,0,'C',true);
		
			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,"Periodo de ventas",1,0,'C',true);

			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,"Dias de cobro",1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(35,11,"Cuentas por cobrar",1,0,'C',true);
	
		

			
			$mipdf -> Ln (1);
		
		//$mipdf -> Image("../webcam/fotos/$imagen",10,43,30,"JPG");
		
		
	
		

	
	

	
	$mipdf -> Ln(10);
	
$sql="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden,
                                           (DATE_FORMAT(movimientos.fecha_movimiento, '%d/%m/%Y' )) AS FECHAM,
                                            MONTH(movimientos.fecha_movimiento) AS fecha2,
                                          CASE MONTH(movimientos.fecha_movimiento)
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
                                            END fecha3,
                                          CASE YEAR(movimientos.fecha_movimiento)
                                            WHEN 2018 THEN '2018'
                                            WHEN 2019 THEN '2019'
                                            WHEN 2020 THEN '2020'
                                            WHEN 2021 THEN '2021'
                                            WHEN 2022 THEN '2022'
                                            WHEN 2023 THEN '2023'
                                            END fecha4,   
(DATE_FORMAT(movimientos.fecha_movimiento, '%d/%m/%Y' )) AS FECHAM,
(movimientos.operacion) AS TIPO,
(COUNT(movimientos.id_movimientos)) AS DOCUMENTOS,

(CONCAT('S/',FORMAT(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                        				WHEN '7' THEN (movimientos.monto)
                                        WHEN '10' THEN (movimientos.monto)
                                		ELSE 00.00
                                        END),2))) VENTAS_TOTALES,
                                        
(CASE documento.codigo_doc
                         				WHEN '1' THEN '30'
                                        WHEN '7' THEN 
 											

	(CASE  movimientos.cuotas 
                                                 WHEN '1'  THEN '30' 
                                                 WHEN '2'  THEN '60' 
                                                 WHEN '3'  THEN '90' 
                                                 WHEN '4'  THEN '120' 
                                                 WHEN '5'  THEN '150' 
                                                 WHEN '6'  THEN '180' 
                                                 WHEN '7'  THEN '210' 
                                                 WHEN '8'  THEN '240' 
                                                 WHEN '9'  THEN '270' 
                                                 WHEN '10'  THEN '300' 
                                                 WHEN '11'  THEN '330' 
                                                 WHEN '12' THEN '365' END) 
                                        WHEN '10' THEN '30'
                                		ELSE 0
                                        END) PERIODO_VENTAS,    
                                        
(movimientos.cuotas) AS DIAS_COBRO,
                                        
(CONCAT(CAST((((FORMAT(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                        				WHEN '7' THEN (movimientos.monto)
                                        WHEN '10' THEN (movimientos.monto)
                                		ELSE 00.00
                                        END),2)))/((CASE documento.codigo_doc
                         				WHEN '1' THEN '30'
                                        WHEN '7' THEN 
 											

	(CASE  movimientos.cuotas 
                                                 WHEN '1'  THEN '30' 
                                                 WHEN '2'  THEN '60' 
                                                 WHEN '3'  THEN '90' 
                                                 WHEN '4'  THEN '120' 
                                                 WHEN '5'  THEN '150' 
                                                 WHEN '6'  THEN '180' 
                                                 WHEN '7'  THEN '210' 
                                                 WHEN '8'  THEN '240' 
                                                 WHEN '9'  THEN '270' 
                                                 WHEN '10'  THEN '300' 
                                                 WHEN '11'  THEN '330' 
                                                 WHEN '12' THEN '365' END) 
                                        WHEN '10' THEN '30'
                                		ELSE 0
                                        END)))*((movimientos.cuotas)) AS DECIMAL(8,2)),'%')) AS CUENTAS_COBRAR

FROM movimientos, documento
WHERE movimientos.codigo_doc=documento.codigo_doc
AND (documento.codigo_doc = '1' OR documento.codigo_doc = '7' OR documento.codigo_doc = '10')
AND movimientos.fecha_movimiento BETWEEN '2019-05-10' AND '2019-06-06' 
GROUP BY FECHAM, movimientos.operacion
ORDER BY MONTH(fecha_movimiento) ASC ,FECHAM ASC
";
	
$sql2=$bd->consulta($sql);

//$resultado=$bd -> consulta($sql);
//$fila=$bd -> mostrar_registros($resultado); 

		//$t_numero = $fila ['TOTAL_NUMERO'];
		//$t_activos = $fila ['TOTAL_ACTIVOS'];
		//$t_netos= $fila ['TOTAL_NETOS'];
		//$t_pasivos= $fila ['TOTAL_PASIVOS'];
		//$t_recursos= $fila ['TOTAL_RECURSOS'];
		//$t_patrimonio= $fila ['TOTAL_PATRIMONIO'];
		//$t_endeudamiento= $fila ['TOTAL_ENDEUDAMIENTO'];

$oye=0;

$num = 0;

	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
	
		$num;


		$id= $datos ['FECHAM'];
		//$orden= $datos ['orden'];
		
		$documento = $datos ['TIPO'];
		$numero = $datos ['DOCUMENTOS'];
		$activos = $datos ['VENTAS_TOTALES'];
		$netos= $datos ['PERIODO_VENTAS'];
		$pasivos= $datos ['DIAS_COBRO'];
		$recursos= $datos ['CUENTAS_COBRAR'];
	
		
		
		
		$cabeceraS = array("$id");
		

 
  $num++;  

	   

		  //$mipdf -> Cell(10,5,"$orden",1,0,'C');
		  $mipdf -> Cell(35,5,"$id",1,0,'C');
		  $mipdf -> Cell(60,5,"$documento",1,0,'C');
		  $mipdf -> Cell(35,5,"$numero",1,0,'C');
		  $mipdf -> Cell(35,5,"$activos",1,0,'C');
     	  $mipdf -> Cell(35,5,"$netos",1,0,'C');	
		  $mipdf -> Cell(35,5,"$pasivos",1,0,'C');
		  $mipdf -> Cell(35,5,"$recursos",1,0,'C');
		 
		 
		$mipdf -> Ln(5);
		}
		
		
	
	/* $mipdf -> Cell(140,5,"",0,0,'C');
	$regu="select sum(horalec)+sum(potelec)-0.5
  from dlec";
$regu2=mysql_query($conexion,$regu);
$fila3 = mysqli_fetch_row($regu2);
$regu3 = $fila3[0];

$r="SELECT  count(horalec) FROM dlec";
$re=mysqli_query($conexion,$r);
$fil = mysqli_fetch_row($re);
$reg = $fil[0];


$pro=$reg/$oye;
	

	

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(95,5,"Total",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,5,$t_numero,1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,5,$t_activos,1,0,'C',true);
		
			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,5,$t_netos,1,0,'C',true);

			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,5,$t_pasivos,1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,5,$t_recursos,1,0,'C',true);

			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,5,$t_patrimonio,1,0,'C',true);

			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(31,5,$t_endeudamiento,1,0,'C',true);
	
*/	 

	 

	

	
		
		$mipdf -> Ln(20);
		$mipdf -> cell('mm',5,"fecha : $fecha" , 0 , 10, true);
		$mipdf -> cell('mm',1,"hora : $hora" , 0 , 10, true);
		

		
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
