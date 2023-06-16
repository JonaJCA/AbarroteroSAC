<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");

	$conn=mysqli_connect("localhost","root","","abarrotero");
	
	$tipo_doc = $_POST['tipo_doc'];
	
	$query = "SELECT id_documento, nombre_doc, tipo_doc FROM documentos WHERE tipo_doc = '$tipo_doc' AND nombre_doc NOT LIKE '%GUIA DE REMISION%' ORDER BY nombre_doc";
	$resultado=mysqli_query($conn, $query);
	
	$html= "<option class='btn-danger' value='0'>Seleccionar documento . . .</option>";

	while($row = $resultado->fetch_assoc())
	{
		$html.= "<option class='btn-primary' value='".$row['id_documento']."'>".$row['nombre_doc']."</option>";
	}
	echo $html;
?>