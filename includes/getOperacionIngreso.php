<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");

	$conn=mysqli_connect("localhost","root","","abarrotero");
	
	$categoria_ope = $_POST['categoria_ope'];
	
	$query = "SELECT id_operacion, descripcion_ope, tipo_ope, categoria_ope FROM operaciones WHERE categoria_ope = '$categoria_ope' AND tipo_ope='INGRESOS' AND descripcion_ope NOT LIKE '%FLETE%' ORDER BY descripcion_ope";
	$resultado=mysqli_query($conn, $query);
	
	$html= "<option class='btn-danger' value='0'>Seleccionar operación . . .</option>";

	while($row = $resultado->fetch_assoc())
	{
		$html.= "<option class='btn-primary' value='".$row['id_operacion']."'>".$row['descripcion_ope']."</option>";
	}
	echo $html;
?>