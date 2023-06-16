<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");

	$conn=mysqli_connect("localhost","root","","abarrotero");
	
	$id_cliente = $_POST['id_cliente'];
	
	$query = "SELECT id_cliente, direccion_cli1, (COALESCE(CASE direccion_cli2 WHEN '' THEN '- - - SIN SEGUNDA DIRECCIÓN REGISTRADA' ELSE direccion_cli2 END,'- - - SIN SEGUNDA DIRECCIÓN REGISTRADA')) AS direccion_cli2 FROM clientes WHERE id_cliente = '$id_cliente' ORDER BY id_cliente";
	$resultado=mysqli_query($conn, $query);
	
	$html= "<option class='btn-danger' value='0'>Seleccionar dirección . . .</option>";

	while($row = $resultado->fetch_assoc())
	{
		$html.= "<option class='btn-primary' value='1'>".$row['direccion_cli1']."</option>";
		$html.= "<option class='btn-primary' value='2'>".$row['direccion_cli2']."</option>";
	}
	echo $html;
?>