<?php
require_once('..\connection\connection.php');
?>

<div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3><center>
                                    	<div class="inner">
                                    		Indicador: Índice de cuentas por cobrar
                                    	</div>  
                                    </h3></center>
<?php {
                                    echo '                                
                                </div>
                                </div>
                            </div>
                            </div>  '; 
                            } ?>
<!doctype html>
<html>
	<head>
		<title>Dashboard - Cuentas por cobrar</title>
		<script src="../Chart.js"></script>
	</head>
	<body bgcolor="#C5D1E1">

		<div style="width: 100%">
			<canvas id="canvas" height="650" width="1500"></canvas>
		</div>



	<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : [
		<?php
			$sql= "SELECT month(fecha) as fecha1,
                                            CASE MONTH(fecha)
                                            WHEN 1 THEN 'ENERO'
                                            WHEN 2 THEN 'FEBRERO'
                                            WHEN 3 THEN 'MARZO'
                                            WHEN 4 THEN 'ABRIL'
                                            WHEN 5 THEN 'MAYO'
                                            WHEN 6 THEN 'JUNIO'
                                            WHEN 7 THEN 'JULIO'
                                            WHEN 8 THEN 'AGOSTO'
                                            WHEN 9 THEN 'SEPTIEMBRE'
                                            WHEN 10 THEN 'OCTUBRE'
                                            WHEN 11 THEN 'NOVIEMBRE'
                                            WHEN 12 THEN 'DICIEMBRE'
                                            END fecha2
                                            FROM exactitud, productos 
                                         	WHERE exactitud.id_productos=productos.id_productos 
                                         	AND exactitud.estado='REALIZADO' 
                                         	AND p_publico < 100.00
                                          GROUP BY month(fecha)";
			$result= mysqli_query($connection,$sql);

			while($registros =mysqli_fetch_array($result)){
		
		?>

			'<?php echo $registros ["fecha2"] ?>',

			<?php

			}
		?>
		],
		datasets : [
			{
				fillColor : "#b00000",
				strokeColor : "#FFFFFF",
				highlightFill: "#0D2251",
				highlightStroke: "#FFFFFF",
				data :
				<?php
				$sql="SELECT              MONTH(fecha) AS fecha1,
                                          CASE MONTH(fecha)
                                            WHEN 1 THEN 'ENERO'
                                            WHEN 2 THEN 'FEBRERO'
                                            WHEN 3 THEN 'MARZO'
                                            WHEN 4 THEN 'ABRIL'
                                            WHEN 5 THEN 'MAYO'
                                            WHEN 6 THEN 'JUNIO'
                                            WHEN 7 THEN 'JULIO'
                                            WHEN 8 THEN 'AGOSTO'
                                            WHEN 9 THEN 'SEPTIEMBRE'
                                            WHEN 10 THEN 'OCTUBRE'
                                            WHEN 11 THEN 'NOVIEMBRE'
                                            WHEN 12 THEN 'DICIEMBRE'
                                            END FECHA2,

                                          CONCAT( (CAST((SUM(INVENTARIADO*p_publico)/SUM(FISICO*p_publico))*100 
                                          AS DECIMAL(8,2)))) AS EXACTITUD
                                          FROM exactitud, productos 
                                          WHERE exactitud.id_productos=productos.id_productos 
                                          AND exactitud.estado='REALIZADO' 
                                          AND p_publico < 100.00
                                          GROUP BY CONCAT(fecha1)
                                          ORDER BY fecha1 ASC;";
				$result= mysqli_query($connection,$sql);
			?>
				 [<?php while ($registros=mysqli_fetch_array($result)){?><?php echo $registros ["EXACTITUD"]?>, <?php }?>]
			}
			
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}

	</script>
	</body>
</html>
