<?php
require_once('..\connection\connection.php');
?>

<div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3><center>
                                    	<div class="inner">
                                    		Número de operaciones por encargado durante el mes actual
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
		<title>Dashboard - Productividad</title>
		<script src="../Chart.js"></script>
	</head>
	<body bgcolor="#E0FFF2">

		<div style="width: 100%">
			<canvas id="canvas" height="650" width="1500"></canvas>
		</div>



	<script>
	var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

	var barChartData = {
		labels : [
		<?php
			$sql= "
SELECT              
(CONCAT(administrador.nombre,' ',administrador.apellido)) AS ENCARGADO,        
COUNT(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION' THEN (movimientos.id_movimientos)
                        WHEN 'APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'PRESTAMO' THEN (movimientos.id_movimientos)
                        WHEN 'DEVOLUCION DE APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'OTROS' THEN (movimientos.id_movimientos)
                                        END) REALIZADAS

FROM movimientos, administrador
WHERE movimientos.id=administrador.id
AND movimientos.operacion NOT LIKE 'SOLICITUD%'
AND movimientos.tipo_movimiento NOT LIKE 'CAPITAL'
AND MONTH(fecha_movimiento)=MONTH(CURDATE())
GROUP BY CONCAT(ENCARGADO)
ORDER BY ENCARGADO ASC;";

			$result= mysqli_query($connection,$sql);

			while($registros =mysqli_fetch_array($result)){
		
		?>

			'<?php echo $registros ["ENCARGADO"] ?>',

			<?php

			}
		?>
		],
		datasets : [
			{
				fillColor : "#2B6FB8",
				strokeColor : "#FFFFFF",
				highlightFill: "#418DD9",
				highlightStroke: "#FFFFFF",
				data :
				<?php
				$sql="
SELECT              
(CONCAT(administrador.nombre,' ',administrador.apellido)) AS ENCARGADO,        
COUNT(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION' THEN (movimientos.id_movimientos)
                        WHEN 'APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'PAGARE' THEN (movimientos.id_movimientos)
                        WHEN 'PRESTAMO' THEN (movimientos.id_movimientos)
                        WHEN 'DEVOLUCION DE APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'OTROS' THEN (movimientos.id_movimientos)
                                        END) REALIZADAS

FROM movimientos, administrador
WHERE movimientos.id=administrador.id
AND movimientos.operacion NOT LIKE 'SOLICITUD%'
AND movimientos.tipo_movimiento NOT LIKE 'CAPITAL'
AND MONTH(fecha_movimiento)=MONTH(CURDATE())

GROUP BY CONCAT(ENCARGADO)
ORDER BY ENCARGADO ASC;";

				$result= mysqli_query($connection,$sql);
			?>
				 [<?php while ($registros=mysqli_fetch_array($result)){?><?php echo $registros ["REALIZADAS"]?>, <?php }?>]
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
