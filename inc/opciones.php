<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");
?>
<link rel="icon" type="image/png" href="../img/sheraton.png" />
<?php 
$mod = isset($_GET['mod']) ? str_replace('.', '', $_GET['mod']) : '';


if($mod) {
	$dir = "pages/{$mod}.php";
	
	if($dir) {	
			include($dir);
		
	} else {
		echo('El módulo solicitado no existe');
	}
	
} else {
	echo 'Selecciona una opción del menú.';
}                                                    