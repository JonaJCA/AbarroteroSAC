<?php 
include 'inc/comun.php';

//Datos de configuraci&oacute;n para header

	
	$chtitulo = "ABARROTERO EXPRESS S.R.L.";
	$chsubti = "ABARROTERO EXPRESS S.R.L.";
	$chpagant = "INICIO";
	$chpagact = "ABARROTERO EXPRESS S.R.L.";


$bd = new GestarBD;
include 'inc/head.php';
include 'inc/header.php';
include 'inc/left_sidebar.php';
include 'inc/right_side.php';
//include 'content.php'; 

include 'inc/opciones.php';

//echo $swphp_contenido;
//echo $_SESSION['autenticado'];
include 'inc/finhtml.php';
