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
		$mipdf -> Cell(200,10,"Lista de pagares, $fecha",0,0,'C');
		$mipdf -> Ln (10);
		


	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(10,11,"N",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(23,11,"Fecha",1,0,'C',true);
		
	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(14,11,"Socio",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(20,11,"Monto",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(28,11,"Operacion",1,0,'C',true);
		
			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(58,11,"Documento",1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(38,11,"Encargado",1,0,'C',true);
	
		

			
			$mipdf -> Ln (1);
		
		//$mipdf -> Image("../webcam/fotos/$imagen",10,43,30,"JPG");
		
		
	
		

	
	

	
	$mipdf -> Ln(10);
	
$sql="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden, DATE_FORMAT(fecha_movimiento, '%d/%m/%Y') AS fecham, socios.codigo, (CONCAT('S/',FORMAT(monto,2))) AS monto, case movimientos.operacion when 'DEVOLUCION DE APORTE' THEN 'DEVOLUCION' ELSE movimientos.operacion end operacion, CONCAT(documento.nombre_doc,'-',movimientos.numero_doc) AS Documento, CONCAT(administrador.nombre,' ',administrador.apellido) AS Encargado from movimientos, socios, documento, administrador,(SELECT @s:=0) AS s WHERE movimientos.operacion NOT LIKE '%ANULADO' AND operacion='PAGARE' AND movimientos.id=administrador.id AND movimientos.id_socios=socios.id_socios AND movimientos.codigo_doc=documento.codigo_doc ORDER BY orden, fecha_movimiento DESC;";
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
		$orden = $datos ['orden'];
		$nombre = $datos ['codigo'];
		$apellido = $datos ['monto'];
		
		$apellidos = $datos ['operacion'];
		$p= $datos ['Documento'];
		$am= $datos ['Encargado'];
	
		
		
		
		$cabeceraS = array("$id");
		

 
  $num++;  

	   	  $mipdf -> Cell(10,5,"$orden",1,0,'C');
		  $mipdf -> Cell(23,5,"$id",1,0,'C');	
		  $mipdf -> Cell(14,5,"$nombre",1,0,'C');
     	  $mipdf -> Cell(20,5,"$apellido",1,0,'C');	
		  $mipdf -> Cell(28,5,"$apellidos",1,0,'C');
		  $mipdf -> Cell(58,5,"$p",1,0,'C');
		  $mipdf -> Cell(38,5,"$am",1,0,'C');
		 
		 
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
