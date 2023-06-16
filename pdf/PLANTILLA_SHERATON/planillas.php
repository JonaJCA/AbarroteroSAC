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
 $id_socios=$_GET['id_socios'];
 $id=$_GET['id'];

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha = date('d/m/Y ');
$fecha7dias = date('d-m-Y', strtotime('-1 week')) ; // resta 1 semana




class MiPDF extends FPDF {
	
	
	
	
	}
	
	$cabeceraT = array("Fecha");
		
		
		$mipdf = new MiPDF();
		$mipdf -> addPage();

		$mipdf -> Setfont('Arial','B',10);
		$mipdf -> Ln (2);
		$mipdf -> Cell(200,10,"Planila de pagos - Lista de descuentos, $fecha",0,0,'C');
		$mipdf -> Ln (10);
		

	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(33,11,"Periodo",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(17,11,"Socio",1,0,'C',true);
		
	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(23,11,"Aporte",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,11,"Amortizacion",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(20,11,"Cargos",1,0,'C',true);
		
			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(30,11,"Fondo social",1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(20,11,"Seguro",1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,11,"Total",1,0,'C',true);	


			
			$mipdf -> Ln (1);
		
		//$mipdf -> Image("../webcam/fotos/$imagen",10,43,30,"JPG");
		
		
	
		

	
	

	
	$mipdf -> Ln(10);
	
$sql="SELECT socios.codigo AS CODIGO,

(CONCAT((CASE MONTH(movimientos.fecha_movimiento)
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
                                            END),' ',

                                        (CASE YEAR(movimientos.fecha_movimiento)
                                            WHEN 2018 THEN '2018'
                                            WHEN 2019 THEN '2019'
                                            WHEN 2020 THEN '2020'
                                            WHEN 2021 THEN '2021'
                                            WHEN 2022 THEN '2022'
                                            WHEN 2023 THEN '2023'
                                            WHEN 2024 THEN '2024'
                                            END))) AS PERIODO,

                                        (CONCAT('S/',FORMAT(CASE(socios.seguro)
                                            WHEN 'SI' THEN '10'
                                            WHEN 'NO' THEN '0'
                                            END,2))) SEGURO,   

                                        (CONCAT('S/',FORMAT(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END),2))) APORTE,
                                        
                                        (CONCAT('S/',FORMAT(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN (movimientos.monto)
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END),2))) AMORTIZACION,

                                        (CONCAT('S/',FORMAT(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)*(0.01)
                                        WHEN '5' THEN (movimientos.monto)*(0.01)+(movimientos.monto)*(0.01)
                                        WHEN '6' THEN (movimientos.monto)*(0.02)+(movimientos.monto)*(0.01)
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END),2))) INTERES,

                                        (CONCAT('S/',FORMAT(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN (movimientos.monto)*(0.01)
                                        WHEN '6' THEN (movimientos.monto)*(0.01)
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END),2))) FONDO,
                                        
                                        (CONCAT('S/',FORMAT(((CASE(socios.seguro)
                                            WHEN 'SI' THEN '10'
                                            WHEN 'NO' THEN '0'
                                            END) +  (SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END)) +   (SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN (movimientos.monto)
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END)) +   (SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)*(0.01)
                                        WHEN '5' THEN (movimientos.monto)*(0.01)+(movimientos.monto)*(0.01)
                                        WHEN '6' THEN (movimientos.monto)*(0.02)+(movimientos.monto)*(0.01)
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END)) + (SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN (movimientos.monto)*(0.01)
                                        WHEN '6' THEN (movimientos.monto)*(0.01)
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        END))),2))) AS TOTAL

                                        
FROM movimientos, socios, documento
WHERE movimientos.id_socios=socios.id_socios
AND movimientos.codigo_doc=documento.codigo_doc
AND movimientos.operacion NOT LIKE '%ANULAD%'
AND movimientos.operacion NOT LIKE 'SOLICITUD%'
AND (documento.tipo_doc='APORTES' OR documento.tipo_doc='PRESTAMOS')
and year(fecha_movimiento)!='2010'
GROUP BY PERIODO, socios.codigo
ORDER BY MONTH(movimientos.fecha_movimiento), socios.codigo;";
	//$consulta=mysql_query($conexion,$sql); 
$sql2=$bd->consulta($sql);

		//$fecha55=$fecha7dias;
	//$consulta55=mysql_query($conexion,$fecha55); 
	//$result=mysql_query($fecha55,$link) or die("Error: ".mysql_error());
$oye=0;

$num = 0; 


	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
	
		$num;


		
          $CODIGO= $datos ['CODIGO'];
          $PERIODO= $datos ['PERIODO'];
          $SOCIO = $datos ['SOCIO'];
          $APORTE= $datos ['APORTE'];
          $AMORTIZACION= $datos ['AMORTIZACION'];
          $INTERES= $datos ['INTERES'];
          $FONDO= $datos ['FONDO'];
          $SEGURO= $datos ['SEGURO'];
          $TOTAL= $datos ['TOTAL'];
	
		
		
		
		

 
  $num++;  

	   

		  $mipdf -> Cell(33,5,"$PERIODO",1,0,'C');
		  $mipdf -> Cell(17,5,"$CODIGO",1,0,'C');
     	  $mipdf -> Cell(23,5,"$APORTE",1,0,'C');	
		  $mipdf -> Cell(25,5,"$AMORTIZACION",1,0,'C');
		  $mipdf -> Cell(20,5,"$INTERES",1,0,'C');
		  $mipdf -> Cell(30,5,"$FONDO",1,0,'C');
            $mipdf -> Cell(20,5,"$SEGURO",1,0,'C');
		  $mipdf -> Cell(25,5,"$TOTAL",1,0,'C');
		 
		 
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
*/	

	
	
	 

	 

	

	
		
		$mipdf -> Ln(10);
		$mipdf -> cell(178,5,"fecha : $fecha" , 0 , 10, true);
		$mipdf -> cell(178,1,"hora : $hora" , 0 , 10, true);
		

		
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
