<?php
  date_default_timezone_set('America/Lima');
  header("Content-Type: text/html;charset=utf-8");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ABARROTERO EXPRESS S.R.L.</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="icon" type="image/png" href="./img/sheraton.png" />
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- Animaciones 
        <link href="css/font-awesome-animation-master/src/font-awesome-animation.css" rel="stylesheet" href="css/font-awesome-animation.min.css">-->
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/select2.min.css" rel="stylesheet" type="text/css" />
        <!-- fileinput -->
        <link href="css/fileinput.css" rel="stylesheet" type="text/css" />

        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="sweetalert2.all.min.js"></script>
        <!-- Optional: include a polyfill for ES6 Promises for IE11 and Android browser -->
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
        <script src="sweetalert2.min.js"></script>
        <link rel="stylesheet" href="sweetalert2.min.css">

        <link type="text/css" rel="stylesheet" href="/css/tail.datetime.css" />
        <link href="css/pytesNET-tail.DateTime-09ca0b8/css/tail.datetime-default-blue.min.css" rel="stylesheet" type="text/css" />
        <script src="css/pytesNET-tail.DateTime-09ca0b8/js/tail.datetime.js"></script>
        <script type="text/javascript" src="/js/tail.datetime.js"></script>

        <!--<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>-->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
		  <!--mapa de coordenadas-->
		<style type="text/css">


   
 
                #map_canvas { height: 300px }
              .controls {
                  margin-top: 10px;
                  border: 1px solid transparent;
                  border-radius: 2px 0 0 2px;
                  box-sizing: border-box;
                  -moz-box-sizing: border-box;
                  height: 32px;
                  outline: none;
                  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
              }

              #pac-input {
                  background-color: #fff;
                  font-family: Roboto;
                  font-size: 15px;
                  font-weight: 300;
                  margin-left: 12px;
                  padding: 0 11px 0 13px;
                  text-overflow: ellipsis;
                  width: 300px;
              }

              #pac-input:focus {
                  border-color: #4d90fe;
              }

              .pac-container {
                  font-family: Roboto;
              }

              #type-selector {
                  color: #fff;
                  background-color: #4d90fe;
                  padding: 5px 11px 0px 11px;
              }

              #type-selector label {
                  font-family: Roboto;
                  font-size: 13px;
                  font-weight: 300;
              }


        </style>
 <!--<script src="  https://maps.googleapis.com/maps/api/js?key=AIzaSyBv_4PnC_epGYVtqbL9MvXNstytHPsKB5A&callback=initMap"></script>-->


  <!--  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script> -->
        <script language="javascript" src="js/jquery-1.7.2.min.js"></script>
        <script language="javascript" src="js/fancywebsocket.js"></script>

    </head>
    <body class="skin-black fixed">

<script type="text/javascript" src="/js/tail.datetime.js"></script>

<script language="JavaScript">
function pregunta(){
    if (confirm('¿Estás seguro que deseas eliminar?')){
       document.tuformulario.submit()
    }
}
</script> 




	<?php  
	if($_SESSION['dondequeda_tipo'] ==1){
	
	$tipo2=1; 
	} 

  else if($_SESSION['dondequeda_tipo'] ==2){ 
  $tipo2=2;

  }
  else{
	$tipo2=3;
	}
	
	?>