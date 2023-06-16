<?php
header("Content-Type: text/html;charset=utf-8");
$host = "localhost";
$dbuser = "root";
$dbpwd = "";
$db = "abarrotero";
//$host="localhost";
//$db="hwpaziid_abarrotero";
//$dbuser="hwpaziid";
//$dbpwd="OKfz43Ng+h3+L3";

$connect = mysqli_connect ($host, $dbuser, $dbpwd, $db);
	if(!$connect)
		echo ("No se ha conectado a la base de datos");
	else
		$select = mysqli_select_db ($connect, $db);
?>