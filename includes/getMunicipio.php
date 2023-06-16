<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");
	
	$conn=mysqli_connect("localhost","root","","abarrotero");
	
	$id_departamento = $_POST['id_departamento'];
	
	$queryM = "SELECT id_provincia, nombre_provi FROM provincias WHERE id_departamento = '$id_departamento' ORDER BY nombre_provi";
	$resultadoM = mysqli_query($conn, $queryM);
	
	$html= "<option class='btn-danger' value='0'>Seleccionar provincia . . .</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option class='btn-primary' data-subtext='".$rowM['id_provincia']."' value='".$rowM['id_provincia']."'>".$rowM['nombre_provi']."</option>";
	}
	
	echo $html;
?>		