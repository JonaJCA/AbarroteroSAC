<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");
?>
<?php 
//Configuración general
$config = array(
	"titulo"=>"abarrotero?",
	"subtitulo"=>"Inicio",
	"url"=>"http://{$_SERVER['HTTP_HOST']}/ABARROTERO/", //Con / al final
	//"url" => "http://localhost/simpleCMS/",
	"charset"=>"utf-8",

	"friendlyurls"=>false,

	//Datos para la configuracion del envio de correo
	"emailadmin"=>"",
	"emailenvios"=>"",
	"nombreenvios"=>"abarrotero?",
	"servidor"=>"localhost",
	"basedatos"=>"abarrotero",
	"usuario"=>"root",
	"pass"=>"",
	//"servidor"=>"localhost",
	//"basedatos"=>"hwpaziid_abarrotero",
	//"usuario"=>"hwpaziid",
	//"pass"=>"OKfz43Ng+h3+L3",

	"googleanalytics"=>false,//Codigo UA- usado en las analiticas de Google
	"googlesiteverification"=>false,
	"mssiteverification"=>false
	); ?>