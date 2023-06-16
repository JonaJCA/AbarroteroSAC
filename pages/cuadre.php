<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");

include './inc/config.php';
//$servidor="localhost";
//$basedatos="hwpaziid_abarrotero";
//$usuario="hwpaziid";
//$pass="OKfz43Ng+h3+L3";

$conn=mysqli_connect("$servidor","$usuario","$pass","$basedatos");
$id_sucursal=$_SESSION['dondequeda_sucursal'];

if ($tipo2=='1') {

$buscar_imp_sucursal_diario = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='PAGADO') AND (movimientos.fecha_movi BETWEEN (DATE_ADD(CURDATE(), INTERVAL (-7) DAY)) AND CURDATE()) GROUP BY nombre_suc ORDER BY nombre_suc";
$resultado_imp_sucursal_diario = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_diario);
$resultado_imp_sucursal_diario_c = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_diario);

$buscar_imp_sucursal_mensual = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='PAGADO') AND MONTH(movimientos.fecha_movi)=MONTH(CURDATE()) AND YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) GROUP BY nombre_suc ORDER BY nombre_suc";
$resultado_imp_sucursal_mensual = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_mensual);
$resultado_imp_sucursal_mensual_c = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_mensual);

$buscar_imp_sucursal_anual = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='PAGADO') AND YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) GROUP BY nombre_suc ORDER BY nombre_suc";
$resultado_imp_sucursal_anual = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_anual);
$resultado_imp_sucursal_anual_c = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_anual);

}

else {

$buscar_imp_sucursal_diario = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='PAGADO') AND (movimientos.fecha_movi BETWEEN (DATE_ADD(CURDATE(), INTERVAL (-7) DAY)) AND CURDATE()) AND sucursales.id_sucursal='$id_sucursal' GROUP BY nombre_suc ORDER BY nombre_suc";
$resultado_imp_sucursal_diario = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_diario);
$resultado_imp_sucursal_diario_c = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_diario);

$buscar_imp_sucursal_mensual = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='PAGADO') AND MONTH(movimientos.fecha_movi)=MONTH(CURDATE()) AND YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND sucursales.id_sucursal='$id_sucursal' GROUP BY nombre_suc ORDER BY nombre_suc";
$resultado_imp_sucursal_mensual = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_mensual);
$resultado_imp_sucursal_mensual_c = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_mensual);

$buscar_imp_sucursal_anual = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='PAGADO') AND YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND sucursales.id_sucursal='$id_sucursal' GROUP BY nombre_suc ORDER BY nombre_suc";
$resultado_imp_sucursal_anual = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_anual);
$resultado_imp_sucursal_anual_c = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal_anual);

}

require ('validarnum.php');
$fecha2=date("Y-m-d");



if (isset($_GET['caja'])) { 

                        if (isset($_POST['caja'])) {
     
}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                              <ul class="nav nav-tabs" style="font-weight: bold; font-size: 15px;">
                                  <li class="active"><a data-toggle="tab" href="#diario">Diario</a></li>
                                  <li><a data-toggle="tab" href="#mensual">Mensual</a></li>
                                  <li><a data-toggle="tab" href="#anual">Anual</a></li>
                                </ul>

                                <div class="tab-content">
                                <div id="diario" class="tab-pane fade in active">
                                <div class="box-header">
                                    <h3 class="box-title">CUADRE | Relación de caja por día</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Periodo</th>
                                                <th class="faa-float animated-hover">Evaluación</th>
                                                <th class="faa-float animated-hover">Operaciones</th>
                                                <th class="faa-float animated-hover">Ingresos</th>
                                                <th class="faa-float animated-hover">Egresos</th>
                                                <th class="faa-float animated-hover">Saldo total</th>
                                                <th class="faa-float animated-hover">Vales</th>
                                                <th class="faa-float animated-hover">Saldo efectivo</th>
                                                <?php if($tipo2==1){ ?>
                                                <th class="faa-float animated-hover">Sucursal</th>  
                                                <?php }?>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT movimientos.id_sucursal, movimientos.fecha_movi, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND sucursales.id_sucursal='$id_sucursal' GROUP BY movimientos.id_sucursal, movimientos.fecha_movi ORDER BY movimientos.fecha_movi";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT movimientos.id_sucursal, movimientos.fecha_movi, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') GROUP BY movimientos.id_sucursal, movimientos.fecha_movi ORDER BY movimientos.fecha_movi";
                                                }

                                        $bd->consulta($consulta);
                                        while ($fila=$bd->mostrar_registros()) {
                                            switch ($fila['status']) {
                                                case 1:
                                                    $btn_st = "danger";
                                                    $txtFuncion = "Desactivar";
                                                    break;
                                                
                                                case 0:
                                                    $btn_st = "primary";
                                                    $txtFuncion = "Activar";
                                                    break;
                                            }
                                            
                                             echo "<tr>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FECHA]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[EVALUADOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[OPERACIONES]
                                                            
                                                        </td>       
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[INGRESOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[EGRESOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[SUBTOTAL]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[VALES]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[SALDO]
                                                            
                                                        </td>";
                                                        if($tipo2==1){
                                                        echo "<td class='faa-float animated-hover'>
                                                           
                                                              $fila[SUCURSAL]
                                                            
                                                        </td>";
                                                        }
                                                        echo "
                                                        <td><center>";
                                                        echo "
                                                            <a  target='_blank' href='./pdf/cuadre_diario_personalizado.php?periodo=".$fila["fecha_movi"]."&id_sucursal=".$fila["id_sucursal"]."'><img src='./img/ficha.png' class='faa-float animated-hover' width='25' alt='Edicion' title='EXPORTAR PDF DE CUADRE DE CAJA DE LA ÚLTIMA SEMANA A LA FECHA ".$fila["FECHA"]."'></a>";         
   } 
                                               echo "    </center>     </td>
                                                    </tr>";
                                        

                                        } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="mensual" class="tab-pane fade">
                              <div class="box-header">
                                    <h3 class="box-title">CUADRE | Relación de caja por mes</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Periodo</th>
                                                <th class="faa-float animated-hover">Evaluación</th>
                                                <th class="faa-float animated-hover">Operaciones</th>
                                                <th class="faa-float animated-hover">Ingresos</th>
                                                <th class="faa-float animated-hover">Egresos</th>
                                                <th class="faa-float animated-hover">Saldo total</th>
                                                <th class="faa-float animated-hover">Vales</th>
                                                <th class="faa-float animated-hover">Saldo efectivo</th>
                                                <?php if($tipo2==1){ ?>
                                                <th class="faa-float animated-hover">Sucursal</th>  
                                                <?php }?>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1  || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT movimientos.id_sucursal, (CASE MONTH(movimientos.fecha_movi) WHEN 1 THEN 'ENERO' WHEN 2 THEN 'FEBRERO' WHEN 3 THEN 'MARZO' WHEN 4 THEN 'ABRIL' WHEN 5 THEN 'MAYO' WHEN 6 THEN 'JUNIO' WHEN 7 THEN 'JULIO' WHEN 8 THEN 'AGOSTO' WHEN 9 THEN 'SEPTIEMBRE' WHEN 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE' WHEN 12 THEN 'DICIEMBRE' END) AS MES, YEAR(movimientos.fecha_movi) AS ANHO, CONCAT((CASE MONTH(movimientos.fecha_movi) WHEN 1 THEN 'ENERO' WHEN 2 THEN 'FEBRERO' WHEN 3 THEN 'MARZO' WHEN 4 THEN 'ABRIL' WHEN 5 THEN 'MAYO' WHEN 6 THEN 'JUNIO' WHEN 7 THEN 'JULIO' WHEN 8 THEN 'AGOSTO' WHEN 9 THEN 'SEPTIEMBRE' WHEN 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE' WHEN 12 THEN 'DICIEMBRE' END),' ', YEAR(movimientos.fecha_movi)) AS PERIODO, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND sucursales.id_sucursal='$id_sucursal' GROUP BY movimientos.id_sucursal, PERIODO ORDER BY PERIODO;";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT movimientos.id_sucursal, (CASE MONTH(movimientos.fecha_movi) WHEN 1 THEN 'ENERO' WHEN 2 THEN 'FEBRERO' WHEN 3 THEN 'MARZO' WHEN 4 THEN 'ABRIL' WHEN 5 THEN 'MAYO' WHEN 6 THEN 'JUNIO' WHEN 7 THEN 'JULIO' WHEN 8 THEN 'AGOSTO' WHEN 9 THEN 'SEPTIEMBRE' WHEN 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE' WHEN 12 THEN 'DICIEMBRE' END) AS MES, YEAR(movimientos.fecha_movi) AS ANHO, CONCAT((CASE MONTH(movimientos.fecha_movi) WHEN 1 THEN 'ENERO' WHEN 2 THEN 'FEBRERO' WHEN 3 THEN 'MARZO' WHEN 4 THEN 'ABRIL' WHEN 5 THEN 'MAYO' WHEN 6 THEN 'JUNIO' WHEN 7 THEN 'JULIO' WHEN 8 THEN 'AGOSTO' WHEN 9 THEN 'SEPTIEMBRE' WHEN 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE' WHEN 12 THEN 'DICIEMBRE' END),' ', YEAR(movimientos.fecha_movi)) AS PERIODO, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') GROUP BY movimientos.id_sucursal, PERIODO ORDER BY PERIODO";
                                                }

                                        $bd->consulta($consulta);
                                        while ($fila=$bd->mostrar_registros()) {
                                            switch ($fila['status']) {
                                                case 1:
                                                    $btn_st = "danger";
                                                    $txtFuncion = "Desactivar";
                                                    break;
                                                
                                                case 0:
                                                    $btn_st = "primary";
                                                    $txtFuncion = "Activar";
                                                    break;
                                            }
                                            
                                             echo "<tr>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[PERIODO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[EVALUADOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[OPERACIONES]
                                                            
                                                        </td>       
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[INGRESOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[EGRESOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[SUBTOTAL]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[VALES]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[SALDO]
                                                            
                                                        </td>";
                                                        if($tipo2==1){
                                                        echo "<td class='faa-float animated-hover'>
                                                           
                                                              $fila[SUCURSAL]
                                                            
                                                        </td>";
                                                        }
                                                        echo "
                                                        <td><center>";
                                                        echo "
                                                            <a  target='_blank' href='./pdf/cuadre_mensual_personalizado.php?periodo=".$fila["MES"]."&anho=".$fila["ANHO"]."&id_sucursal=".$fila["id_sucursal"]."'><img src='./img/ficha.png' class='faa-float animated-hover' width='25' alt='Edicion' title='EXPORTAR PDF DE CUADRE DE CAJA DE ".$fila["MES"]." DEL ".$fila["ANHO"]."'></a>";         
   } 
                                               echo "    </center>     </td>
                                                    </tr>";
                                        

                                        } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            <div id="anual" class="tab-pane fade">
                              <div class="box-header">
                                    <h3 class="box-title">CUADRE | Relación de caja por año</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Periodo</th>
                                                <th class="faa-float animated-hover">Evaluación</th>
                                                <th class="faa-float animated-hover">Operaciones</th>
                                                <th class="faa-float animated-hover">Ingresos</th>
                                                <th class="faa-float animated-hover">Egresos</th>
                                                <th class="faa-float animated-hover">Saldo total</th>
                                                <th class="faa-float animated-hover">Vales</th>
                                                <th class="faa-float animated-hover">Saldo efectivo</th>
                                                <?php if($tipo2==1){ ?>
                                                <th class="faa-float animated-hover">Sucursal</th>  
                                                <?php }?>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT movimientos.id_sucursal, (YEAR(movimientos.fecha_movi)) AS PERIODO, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') AND sucursales.id_sucursal='$id_sucursal' GROUP BY movimientos.id_sucursal, PERIODO ORDER BY PERIODO";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT movimientos.id_sucursal, (YEAR(movimientos.fecha_movi)) AS PERIODO, CASE WHEN COUNT(DISTINCT movimientos.fecha_movi)=1 THEN CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍA') ELSE CONCAT(COUNT(DISTINCT movimientos.fecha_movi),' DÍAS') END AS EVALUADOS, CASE WHEN COUNT(movimientos.id_movimiento)=1 THEN CONCAT(COUNT( movimientos.id_movimiento),' MOVIMIENTO') ELSE CONCAT(COUNT(movimientos.id_movimiento),' MOVIMIENTOS') END AS OPERACIONES, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END), 2)) AS INGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END), 2)) AS EGRESOS, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi)-(monto_sub_movi) WHEN 'EGRESOS' THEN ((monto_movi)*(-1)) ELSE '0' END), 2)) AS SALDO, sucursales.nombre_suc AS SUCURSAL, CONCAT('S/', FORMAT(SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN (monto_movi) ELSE '0' END) ELSE '0' END), 2)) AS VALES, CONCAT('S/', FORMAT((SUM(CASE operaciones.tipo_ope WHEN 'INGRESOS' THEN (monto_movi) ELSE '0' END))-((SUM(CASE operaciones.tipo_ope WHEN 'EGRESOS' THEN (CASE movimientos.estado_movi WHEN 'POR CANJEAR' THEN '0' ELSE (monto_movi) END) ELSE (monto_sub_movi) END))), 2)) AS SUBTOTAL, sucursales.nombre_suc AS SUCURSAL FROM movimientos, operaciones, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal=sucursales.id_sucursal AND (movimientos.estado_movi='REALIZADO' OR movimientos.estado_movi='LIQUIDADO' OR movimientos.estado_movi='COBRO' OR movimientos.estado_movi='POR CANJEAR') GROUP BY movimientos.id_sucursal, PERIODO ORDER BY PERIODO";
                                                }

                                        $bd->consulta($consulta);
                                        while ($fila=$bd->mostrar_registros()) {
                                            switch ($fila['status']) {
                                                case 1:
                                                    $btn_st = "danger";
                                                    $txtFuncion = "Desactivar";
                                                    break;
                                                
                                                case 0:
                                                    $btn_st = "primary";
                                                    $txtFuncion = "Activar";
                                                    break;
                                            }
                                            
                                             echo "<tr>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[PERIODO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[EVALUADOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[OPERACIONES]
                                                            
                                                        </td>       
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[INGRESOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[EGRESOS]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[SUBTOTAL]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[VALES]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[SALDO]
                                                            
                                                        </td>";
                                                        if($tipo2==1){
                                                        echo "<td class='faa-float animated-hover'>
                                                           
                                                              $fila[SUCURSAL]
                                                            
                                                        </td>";
                                                        }
                                                        echo "
                                                        <td><center>";
                                                        echo "
                                                            <a  target='_blank' href='./pdf/cuadre_anual_personalizado.php?periodo=".$fila["PERIODO"]."&id_sucursal=".$fila["id_sucursal"]."'><img src='./img/ficha.png' class='faa-float animated-hover' width='25' alt='Edicion' title='EXPORTAR PDF DE CUADRE DE CAJA DE TODO EL ".$fila["PERIODO"]."'></a>";         
   } 
                                               echo "    </center>     </td>
                                                    </tr>";
                                        

                                        } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div></div>

<div class="col-md-3">
  <div class="box">
    <ul class="nav nav-tabs" style="font-weight: bold; font-size: 15px;">
                                  <li class="active"><a data-toggle="tab" href="#actual">Actual</a></li>
                                  <li><a data-toggle="tab" href="#consolidado">Consolidado</a></li>
                                </ul>

                                <div class="tab-content">
                                <div id="actual" class="tab-pane fade in active">
                                <div class="box-header">
                                <center>
                                <div class="box-header">
                                   <h3> <center>Imprimir listado</center><br2>ACTUAL</h3>
                                </div>
                                
                                <label for="exampleInputFile">Última semana  <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cuadre de caja de la última semana por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($CCD = mysqli_fetch_assoc($resultado_imp_sucursal_diario)): ?>
                                                    <option class="btn-primary" value='./pdf/cuadre_diario_general.php?id_sucursal=<?php echo $CCD['id_sucursal']?>'><?php echo $CCD['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 

                                    <label for="exampleInputFile">Mes actual <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cuadre de caja del mes actual por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($CCM = mysqli_fetch_assoc($resultado_imp_sucursal_mensual)): ?>
                                                    <option class="btn-primary" value='./pdf/cuadre_mensual_general.php?id_sucursal=<?php echo $CCM['id_sucursal']?>'><?php echo $CCM['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 

                                    <label for="exampleInputFile">Año actual <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cuadre de caja del año actual por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($CCA = mysqli_fetch_assoc($resultado_imp_sucursal_anual)): ?>
                                                    <option class="btn-primary" value='./pdf/cuadre_anual_general.php?id_sucursal=<?php echo $CCA['id_sucursal']?>'><?php echo $CCA['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 
                                            
                                 </div>
                                 <img src="./img/gif/cuadre.gif" width="100%" height="200px" title="Mantenga el control de todos sus movimientos"><br><br>

                                </center>
                                </div>
                                <div id="consolidado" class="tab-pane fade">
                                    <div class="box-header">
                                <center>
                                <div class="box-header">
                                   <h3> <center>Imprimir listado</center><br2>CONSOLIDADO</h3>
                                </div>
                                
                                <label for="exampleInputFile">Última semana  <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cuadre de caja de la última semana por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($CCD = mysqli_fetch_assoc($resultado_imp_sucursal_diario_c)): ?>
                                                    <option class="btn-primary" value='./pdf/cuadre_diario_general_con.php?id_sucursal=<?php echo $CCD['id_sucursal']?>'><?php echo $CCD['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 

                                    <label for="exampleInputFile">Mes actual <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cuadre de caja agrupado por mes y por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($CCM = mysqli_fetch_assoc($resultado_imp_sucursal_mensual_c)): ?>
                                                    <option class="btn-primary" value='./pdf/cuadre_mensual_general_con.php?id_sucursal=<?php echo $CCM['id_sucursal']?>'><?php echo $CCM['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 

                                    <label for="exampleInputFile">Año actual <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cuadre de caja agrupado por año y por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($CCA = mysqli_fetch_assoc($resultado_imp_sucursal_anual_c)): ?>
                                                    <option class="btn-primary" value='./pdf/cuadre_anual_general_con.php?id_sucursal=<?php echo $CCA['id_sucursal']?>'><?php echo $CCA['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 
                                            
                                 </div>
                                 <img src="./img/gif/cuadre.gif" width="100%" height="200px" title="Mantenga el control de todos sus movimientos"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>
<?php
}
?>