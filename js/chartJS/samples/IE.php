<?php
require_once('..\connection\connection.php');
?>

<div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3><center>
                                    	<div class="inner">
                                    		Indicador: Índice de endeudamiento
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
		<title>Dashboard - Endeudamiento</title>
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
			$sql= "SELECT month(fecha_movimiento) as fecha1,
                                            CASE MONTH(fecha_movimiento)
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

FROM movimientos, documento
WHERE movimientos.codigo_doc=documento.codigo_doc
AND (documento.codigo_doc = '4' OR documento.codigo_doc = '5' OR documento.codigo_doc = '6')
AND movimientos.estado='REALIZADO'
AND movimientos.operacion='PRESTAMO'

GROUP BY month(fecha_movimiento)
order by year(movimientos.fecha_movimiento) asc, month(movimientos.fecha_movimiento) asc";

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
				fillColor : "#2B6FB8",
				strokeColor : "#FFFFFF",
				highlightFill: "#418DD9",
				highlightStroke: "#FFFFFF",
				data :
				<?php
				$sql="SELECT              MONTH(fecha_movimiento) AS fecha1,
                                          CASE MONTH(fecha_movimiento)
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
(CAST(((SUM(CASE documento.codigo_doc         
                                          WHEN '4' THEN (movimientos.monto)
                                        WHEN '5' THEN (movimientos.monto)
                                        WHEN '6' THEN (movimientos.monto)
                                        ELSE 00.00
                                        END)) - (SUM(CASE documento.codigo_doc
                                        WHEN '4' THEN (movimientos.pasivos)
                                        WHEN '5' THEN (movimientos.pasivos)
                                        WHEN '6' THEN (movimientos.pasivos)
                                        ELSE 00.00
                                        END)))/(SUM(CASE documento.codigo_doc                               
                                     WHEN '4' THEN (movimientos.monto)+(movimientos.pasivos)+(movimientos.capital)
                                     WHEN '5' THEN (movimientos.monto)+(movimientos.pasivos)+(movimientos.capital)
                                     WHEN '6' THEN (movimientos.monto)+(movimientos.pasivos)+(movimientos.capital)
                                     ELSE 00.00
                                     END)) AS DECIMAL (8,2))) AS ENDEUDAMIENTO

FROM movimientos, documento
WHERE movimientos.codigo_doc=documento.codigo_doc
AND (documento.codigo_doc = '4' OR documento.codigo_doc = '5' OR documento.codigo_doc = '6')
AND movimientos.estado='REALIZADO'
AND movimientos.operacion='PRESTAMO'
GROUP BY CONCAT(fecha1)

order by year(movimientos.fecha_movimiento) asc, month(movimientos.fecha_movimiento) asc";

				$result= mysqli_query($connection,$sql);
			?>
				 [<?php while ($registros=mysqli_fetch_array($result)){?><?php echo $registros ["ENDEUDAMIENTO"]?>, <?php }?>]
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
