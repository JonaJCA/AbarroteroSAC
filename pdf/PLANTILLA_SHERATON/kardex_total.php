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
		$mipdf -> Cell(200,10,"Kardex completo del socio $id, $fecha",0,0,'C');
		$mipdf -> Ln (10);
		

	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(10,11,"N",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(23,11,"Fecha",1,0,'C',true);
		
	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,"Aporte",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,"Devolucion",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,"Pagare",1,0,'C',true);
		
			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,"Saldo A.",1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(23,11,"Amortizacion",1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,"Prestamo",1,0,'C',true);	

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(22,11,"Saldo P.",1,0,'C',true);	
		

			
			$mipdf -> Ln (1);
		
		//$mipdf -> Image("../webcam/fotos/$imagen",10,43,30,"JPG");
		
		
	
		

	
	

	
	$mipdf -> Ln(10);
	
$sql="SELECT CAST(@o:=@o+1 AS UNSIGNED) AS orden, DATE_FORMAT(movimientos.fecha_movimiento, '%d/%m/%Y') AS fecham, socios.codigo, CONCAT(socios.nombres,' ',socios.apellidos) AS SOCIO,

                                        CONCAT('S/',FORMAT(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END,2)) APORTE,
                                        
                                        CONCAT('S/',FORMAT(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN (movimientos.monto)
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END,2)) DEVOLUCION,
                                        
                                        CONCAT('S/',FORMAT(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN (movimientos.monto)
                                        END,2)) PAGARE,

                                        (CONCAT('S/',FORMAT(@a:=@a+(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                                        WHEN '2' THEN (movimientos.monto)*(-1)
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN (movimientos.monto)
                                        END),2))) SA,

                                        CONCAT('S/',FORMAT(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN (movimientos.monto)
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END,2)) AMORTIZACION,
                                        
                                        (CONCAT('S/',FORMAT(((CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)
                                        WHEN '5' THEN (movimientos.monto)
                                        WHEN '6' THEN (movimientos.monto)
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END))+

                                        ((CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)*(0.01)*movimientos.cuotas
                                        WHEN '5' THEN (movimientos.monto)*(0.02)*movimientos.cuotas
                                        WHEN '6' THEN (movimientos.monto)*(0.03)*movimientos.cuotas
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END)) ,2))) AS PRESTAMO,

                                        (CONCAT('S/',FORMAT((@p:=@p+(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)
                                        WHEN '5' THEN (movimientos.monto)
                                        WHEN '6' THEN (movimientos.monto)
                                        WHEN '7' THEN (movimientos.monto)*(-1)
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END))+

                                        ((CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN (movimientos.monto)*(0.01)*movimientos.cuotas
                                        WHEN '5' THEN (movimientos.monto)*(0.02)*movimientos.cuotas
                                        WHEN '6' THEN (movimientos.monto)*(0.03)*movimientos.cuotas
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END)) ,2))) AS SP

FROM movimientos, socios, documento, (SELECT @o:=0) AS o, (SELECT @a:=0) AS a, (SELECT @p:=0) AS p
WHERE movimientos.id_socios=socios.id_socios
AND movimientos.codigo_doc=documento.codigo_doc
AND movimientos.operacion NOT LIKE '%ANULAD%'
AND movimientos.operacion NOT LIKE 'SOLICITUD%'
AND (documento.tipo_doc='APORTES' OR documento.tipo_doc='PRESTAMOS')
and year(movimientos.fecha_movimiento)!='2010'
AND movimientos.id_socios='$id_socios;'
ORDER BY YEAR(movimientos.fecha_movimiento) DESC, MONTH(movimientos.fecha_movimiento) DESC";
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


		$id= $datos ['fecham'];
		$orden= $datos ['orden'];
		
		$nombre = $datos ['APORTE'];
		$apellido = $datos ['DEVOLUCION'];
		
		$apellidos = $datos ['PAGARE'];
		$p= $datos ['SA'];
		$am= $datos ['AMORTIZACION'];
		$PRESTAMO= $datos ['PRESTAMO'];
		$SP= $datos ['SP'];
	
		
		
		
		$cabeceraS = array("$id");
		

 
  $num++;  

	   

		  $mipdf -> Cell(10,5,"$orden",1,0,'C');
		  $mipdf -> Cell(23,5,"$id",1,0,'C');
		  $mipdf -> Cell(22,5,"$nombre",1,0,'C');
     	  $mipdf -> Cell(22,5,"$apellido",1,0,'C');	
		  $mipdf -> Cell(22,5,"$apellidos",1,0,'C');
		  $mipdf -> Cell(22,5,"$p",1,0,'C');
		  $mipdf -> Cell(23,5,"$am",1,0,'C');
		  $mipdf -> Cell(22,5,"$PRESTAMO",1,0,'C');
		  $mipdf -> Cell(22,5,"$SP",1,0,'C');
		 
		 
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
