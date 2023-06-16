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
$fecha = date('d-m-Y ');
$fecha7dias = date('d-m-Y', strtotime('-1 week')) ; // resta 1 semana




class MiPDF extends FPDF {
	
	
	
	
	}
	
	$cabeceraT = array("Fecha");
		
		
		$mipdf = new MiPDF();
		$mipdf -> addPage();

		$mipdf -> Setfont('Arial','B',10);
		$mipdf -> Ln (2);
		$mipdf -> Cell(200,10,"Saldo de prestamos, $fecha",0,0,'C');
		$mipdf -> Ln (10);
		

		$mipdf -> Cell(10,12,"N",0,0,'C');
		for ($i = 0; $i < count($cabeceraT); $i++)
		{
			
		
			$mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell ( 23, 11 , $cabeceraT[$i],1,0,'C',true);
		}
		
	$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(17,11,"Socio",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(20,11,"Monto",1,0,'C',true);

$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(25,11,"Operacion",1,0,'C',true);
		
			$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(50,11,"Documento",1,0,'C',true);

		$mipdf -> SetFont('ARIAL','B', 9);
$mipdf -> SetFillColor(0, 191, 255);
	$mipdf -> Cell(45,11,"Encargado",1,0,'C',true);
	
		

			
			$mipdf -> Ln (1);
		
		//$mipdf -> Image("../webcam/fotos/$imagen",10,43,30,"JPG");
		
		
	
		

	
	

	
	$mipdf -> Ln(10);
	
$sql="SELECT DATE_FORMAT(fecha_movimiento, '%d/%m/%Y') AS fecha, socios.codigo, (CONCAT('S/',FORMAT(monto,2))) AS monto, movimientos.operacion, CONCAT(documento.nombre_doc,'-',movimientos.numero_doc) AS Documento, CONCAT(administrador.nombre,' ',administrador.apellido) AS Encargado from movimientos, socios, documento, administrador WHERE tipo_movimiento='PRESTAMO' AND movimientos.id=administrador.id AND movimientos.id_socios=socios.id_socios AND movimientos.codigo_doc=documento.codigo_doc ORDER BY fecha_movimiento DESC;";
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


		$id= $datos ['fecha'];
		
		$nombre = $datos ['codigo'];
		$apellido = $datos ['monto'];
		
		$apellidos = $datos ['operacion'];
		$p= $datos ['Documento'];
		$am= $datos ['Encargado'];
	
		
		
		$fec=date('d-m-y',$fechai);
		$d=date('d',$fec);
		$m=date('m',$fec);
		$y=date('Y',$fec);
		
$dia=date(d);
$mes=date(m);
$ano=date(Y);

//fecha de nacimiento

$dianaz=4;
$mesnaz=2;
$anonaz=2005;

//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual

if (($mesnaz == $mes) && ($dianaz > $dia)) {
$ano=($ano-1); }

//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual

if ($mesnaz > $mes) {
$ano=($ano-1);}

//ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad

$edad=($ano-$anonaz);

		$fec=strtotime($parto);
		$fec=date('d-m-Y ',$fec);
		$d=date('d',$fec);
		$m=date('m',$fec);
		$y=date('Y',$fec);
		
		
		
		$cabeceraS = array("$id");
		

 
  $num++;  

	   $mipdf -> Cell(10,5,"$num",1,0,'C');
		for ($i = 0; $i < count($cabeceraS); $i++)
		{
			$mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(1000,1000,255); 
			$mipdf -> Cell ( 23, 5 , $cabeceraS[$i],1,0,'C',true);
			}
			
		  $mipdf -> Cell(17,5,"$nombre",1,0,'C');
     	  $mipdf -> Cell(20,5,"$apellido",1,0,'C');	
		  $mipdf -> Cell(25,5,"$apellidos",1,0,'C');
		  $mipdf -> Cell(50,5,"$p",1,0,'C');
		  $mipdf -> Cell(45,5,"$am",1,0,'C');
		 
		 
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
