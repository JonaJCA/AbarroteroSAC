<?php
require_once('..\connection\connection.php');
?>

<div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3><center>
                                    	<div class="inner">
                                    		Indicador: Cuentas por cobrar
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

AND (documento.codigo_doc = '1' OR documento.codigo_doc = '7' OR documento.codigo_doc = '10')
and year(movimientos.fecha_movimiento)!='2010'


GROUP BY CONCAT(fecha1,' ',fecha2)
ORDER BY  fecha1 ASC;";


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
((CAST((((FORMAT(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                                WHEN '7' THEN (movimientos.monto)
                                        WHEN '10' THEN (movimientos.monto)
                                    ELSE 00.00
                                        END),2)))/((CASE documento.codigo_doc
                                WHEN '1' THEN '30'
                                        WHEN '7' THEN 
                      

  (CASE  movimientos.cuotas 
                                                 WHEN '1'  THEN '30' 
                                                 WHEN '2'  THEN '60' 
                                                 WHEN '3'  THEN '90' 
                                                 WHEN '4'  THEN '120' 
                                                 WHEN '5'  THEN '150' 
                                                 WHEN '6'  THEN '180' 
                                                 WHEN '7'  THEN '210' 
                                                 WHEN '8'  THEN '240' 
                                                 WHEN '9'  THEN '270' 
                                                 WHEN '10'  THEN '300' 
                                                 WHEN '11'  THEN '330' 
                                                 WHEN '12' THEN '365' END) 
                                        WHEN '10' THEN '30'
                                    ELSE 0
                                        END)))*((movimientos.cuotas)) AS DECIMAL(8,2)))) AS CUENTAS_COBRAR

FROM movimientos, documento
WHERE movimientos.codigo_doc=documento.codigo_doc
AND (documento.codigo_doc = '1' OR documento.codigo_doc = '7' OR documento.codigo_doc = '10')
and year(movimientos.fecha_movimiento)!='2010'
GROUP BY CONCAT(fecha1,' ',fecha2)
ORDER BY fecha1 ASC;";

				$result= mysqli_query($connection,$sql);
			?>
				 [<?php while ($registros=mysqli_fetch_array($result)){?><?php echo $registros ["CUENTAS_COBRAR"]?>, <?php }?>]
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
