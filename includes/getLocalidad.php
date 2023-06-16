<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");

	$conn=mysqli_connect("localhost","root","","abarrotero");
	
	$id_provincia = $_POST['id_provincia'];
	
	$query = "SELECT id_distrito, nombre_dist FROM distritos WHERE id_provincia = '$id_provincia' ORDER BY nombre_dist";
	$resultado=mysqli_query($conn, $query);
	
	$html= "<option class='btn-danger' value='0'>Seleccionar distrito . . .</option>";

	while($row = $resultado->fetch_assoc())
	{
		$html.= "<option class='btn-primary' value='".$row['id_distrito']."'>".$row['nombre_dist']."</option>";
	}
	echo $html;
?>