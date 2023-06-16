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
		$mipdf -> Cell(200,10,"Lista de egresos",0,0,'C');
		$mipdf -> Ln (10);
		

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(62,11,"Periodo",1,0,'C',true);
		
			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(62,11,"Monto de pasivos",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(62,11,"Monto de capital",1,0,'C',true);


	
		

			
			$mipdf -> Ln (1);
		
		//$mipdf -> Image("../webcam/fotos/$imagen",10,43,30,"JPG");
		
		
	
		

	
	

	
	$mipdf -> Ln(10);
	
$sql="SELECT 
                                          MONTH(movimientos.fecha_movimiento) AS fecha2,
                                          CASE YEAR(movimientos.fecha_movimiento)
                                            WHEN 2018 THEN '2018'
                                            WHEN 2019 THEN '2019'
                                            WHEN 2020 THEN '2020'
                                            WHEN 2021 THEN '2021'
                                            WHEN 2022 THEN '2022'
                                            WHEN 2023 THEN '2023'
                                            END fecha3,
                                          CONCAT(CASE MONTH(movimientos.fecha_movimiento)
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
                                            END,' ',
                                          CASE YEAR(movimientos.fecha_movimiento)
                                            WHEN 2018 THEN '2018'
                                            WHEN 2019 THEN '2019'
                                            WHEN 2020 THEN '2020'
                                            WHEN 2021 THEN '2021'
                                            WHEN 2022 THEN '2022'
                                            WHEN 2023 THEN '2023'
                                            END) PERIODO, 
CONCAT('S/',FORMAT(SUM(movimientos.pasivos),2)) AS PASIVOS,
CONCAT('S/',FORMAT(SUM(movimientos.capital),2)) AS CAPITAL
FROM movimientos
WHERE movimientos.operacion='PRESTAMO'
GROUP BY PERIODO
ORDER BY fecha3, fecha2";
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


		$id= $datos ['PERIODO'];
		$orden= $datos ['PASIVOS'];
		$nombre = $datos ['CAPITAL'];
	
		
		
		
		$cabeceraS = array("$id");
		

 
  $num++;  

	   

		  $mipdf -> Cell(62,5,"$id",1,0,'C');
		  $mipdf -> Cell(62,5,"$orden",1,0,'C');
		  $mipdf -> Cell(62,5,"$nombre",1,0,'C');

		  
		 
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
