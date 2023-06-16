<?php
    date_default_timezone_set('America/Lima');
    header("Content-Type: text/html;charset=utf-8");

$fecha2=date("Y-m-d");
$consulta="SELECT * FROM movimientos;";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

        if(1 > 2){
            
        } else {

            // Código autoejecutable

        }
     }

?>

<?php 

$mi_codigo=$_SESSION['dondequeda_id'];
$mis_datos="SELECT usuario, apellido, nombre, (CONCAT(apellido,', ',nombre)) AS trabajador, (CONCAT(nombre,' ',apellido)) AS trabajador2, correo, (CONCAT(nombre_suc,' (',nombre_depa,', ',nombre_provi,', ',nombre_dist,')')) AS sucursal, estado, CASE nive_usua
                                            WHEN 1 THEN 'ADMINISTRADOR'
                                            WHEN 2 THEN 'EMPLEADO'
                                            WHEN 3 THEN 'OTRO'
                                            END nive_usua FROM administrador, sucursales, departamentos, provincias, distritos WHERE id='$mi_codigo' AND administrador.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND provincias.id_departamento=departamentos.id_departamento AND distritos.id_provincia=provincias.id_provincia;";

$cs=$bd->consulta($mis_datos);
$datos_M = $bd-> mostrar_registros($mis_datos);
//DATOS DEL USUARIO
$MI_USUARIO = $datos_M ['usuario'];
$TRABAJADOR2 = $datos_M ['trabajador2'];
$MI_CORREO = $datos_M ['correo'];
$MI_ESTADO = $datos_M ['estado'];
$MI_NIVEL = $datos_M ['nive_usua'];

$productividad_hoy="SELECT COUNT(movimientos.id) AS HOY FROM movimientos WHERE movimientos.estado_movi != 'ANULADO' AND movimientos.fecha_movi=CURDATE() AND id='$mi_codigo' AND estado_movi != 'ANULADO';";

$cs=$bd->consulta($productividad_hoy);
$datos_PH = $bd-> mostrar_registros($productividad_hoy);
//DATOS DEL USUARIO
$HOY_P = $datos_PH ['HOY'];
if ($HOY_P=='1') {
    $HOY = "(".$datos_PH ['HOY'].") OPERACIÓN";
} else {
    $HOY = "(".$datos_PH ['HOY'].") OPERACIONES";
}

$productividad_mes="SELECT COUNT(movimientos.id) AS MES FROM movimientos WHERE MONTH(movimientos.fecha_movi)=MONTH(CURDATE()) AND id='$mi_codigo' AND estado_movi != 'ANULADO';";

$cs=$bd->consulta($productividad_mes);
$datos_PM = $bd-> mostrar_registros($productividad_mes);
//DATOS DEL USUARIO
$MES_P = $datos_PM ['MES'];
if ($MES_P=='1') {
    $MES = "(".$datos_PM ['MES'].") OPERACIÓN";
} else {
    $MES = "(".$datos_PM ['MES'].") OPERACIONES";
}

$productividad_anho="SELECT COUNT(movimientos.id) AS ANHO FROM movimientos WHERE YEAR(movimientos.fecha_movi)=YEAR(CURDATE()) AND id='$mi_codigo' AND estado_movi != 'ANULADO';";

$cs=$bd->consulta($productividad_anho);
$datos_PA = $bd-> mostrar_registros($productividad_anho);
//DATOS DEL USUARIO
$ANHO_P = $datos_PA ['ANHO'];
if ($ANHO_P=='1') {
    $ANHO = "(".$datos_PA ['ANHO'].") OPERACIÓN";
} else {
    $ANHO = "(".$datos_PA ['ANHO'].") OPERACIONES";
}

?>


    <div class="wrapper row-offcanvas row-offcanvas-left">
        <aside class="left-side sidebar-offcanvas">
            <section class="sidebar">
                <div class="user-panel" title="PRESIONE ACA PARA VER SUS DATOS" onclick="Swal.mixin({  progressSteps: ['1', '2'], width: 400,}).queue([{title: '<h3><?php echo "<b><i>$TRABAJADOR2";?></i></b></h3>', confirmButtonText: '<h5>VER MI DESEMPEÑO</h5>', showCloseButton:true,   html: '<h4><?php echo "<b>USUARIO:</b> ".$MI_USUARIO." <br><br><b>CORREO:</b> ".$MI_CORREO.""."<br><br><b>NIVEL:</b> ".$MI_NIVEL.""."<br><br><b>ESTADO:</b> ".$MI_ESTADO."";?>'}, {title: '<h3><b><i>MI DESEMPEÑO</i></b></h3>', confirmButtonText: '<h5>ENTENDIDO</h5>', showCloseButton:true, html: '<h4><?php echo "<b>DÍA ACTUAL:</b> ".$HOY." <br><br><b>MES ACTUAL:</b> ".$MES.""."<br><br><b>AÑO ACTUAL:</b> ".$ANHO."";?></h4>'}])">
                    <div class="pull-left image"> 
                        <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>Hola, <?php echo $_SESSION['dondequeda_nombre']; ?></p>
                        <a href="#">
                            <i class="fa fa-circle text-success" onkeypress=class="fa fa-circle text-danger">
                        </i> En línea</a>
                    </div>
                </div>
                    <ul class="sidebar-menu">
                    <li class="active">
                        <a href="?mod=index">
                            <i class="glyphicon glyphicon-home faa-pulse animated fa-1x"></i>
                            <span> Principal</span>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-edit faa-pulse animated"></i>
                                <span> Mantenimiento </span>
                            <i class="ion-arrow-down-b"></i>
                            
                        </a>
                        <ul class="treeview-menu">
                            <li class="treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-euro faa-pulse animated"></i>
                                    <span>Externos </span>
                                <i class="ion-arrow-down-b"></i>
                            </a>
                            <ul class="treeview-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-usd faa-pulse animated"></i>
                                        <span>Clientes </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=clientes&nuevo"><i class="fa fa-usd faa-bounce animated"></i>Registrar cliente</a></li>
                                    <li><a href="?mod=clientes&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de clientes</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-gift faa-pulse animated"></i>
                                        <span>Proveedores </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=proveedores&nuevo"><i class="fa fa-gift faa-bounce animated"></i>Registrar proveedor</a></li>
                                    <li><a href="?mod=proveedores&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de proveedores</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>                            
                            </ul>
                            </li>
                            <li class="treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-italic faa-pulse animated"></i>
                                    <span>Internos </span>
                                <i class="ion-arrow-down-b"></i>
                            </a>
                            <ul class="treeview-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-file faa-pulse animated"></i>
                                        <span>Documentos </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=documentos&nuevo"><i class="fa fa-copy faa-bounce animated"></i>Registrar documento</a></li>
                                    <li><a href="?mod=documentos&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de documentos</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <?php  if ($tipo2=='1') { ?>
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-tags faa-pulse animated"></i>
                                        <span>Encargados </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=administrador&nuevo"><i class="glyphicon glyphicon-tag faa-bounce animated"></i>Registrar encargado</a></li>
                                    <li><a href="?mod=administrador&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de encargados</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <?php  } ?>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-sign-in faa-pulse animated"></i>
                                        <span>Operaciones </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=operaciones&nuevo"><i class="fa fa-sign-out faa-bounce animated"></i>Registrar operación</a></li>
                                    <li><a href="?mod=operaciones&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de operaciones</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-sitemap faa-pulse animated"></i>
                                        <span>Sucursales </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=sucursales&nuevo"><i class="fa fa-home faa-bounce animated"></i>Registrar sucursal</a></li>
                                    <li><a href="?mod=sucursales&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de sucursales</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-text-height faa-pulse animated"></i>
                                    <span>Transporte </span>
                                <i class="ion-arrow-down-b"></i>
                            </a>
                            <ul class="treeview-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-group faa-pulse animated"></i>
                                        <span>Choferes </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=choferes&nuevo"><i class="glyphicon glyphicon-user faa-bounce animated"></i>Registrar chofer</a></li>
                                    <li><a href="?mod=choferes&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de choferes</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-cogs faa-pulse animated"></i>
                                        <span>Propietarios </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=propietarios&nuevo"><i class="glyphicon glyphicon-cog faa-bounce animated"></i>Registrar propietario</a></li>
                                    <li><a href="?mod=propietarios&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de propietarios</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-road faa-pulse animated"></i>
                                        <span>Vehículos </span>
                                    <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=vehiculos&nuevo"><i class="fa fa-shopping-cart faa-bounce animated"></i>Registrar vehículo</a></li>
                                    <li><a href="?mod=vehiculos&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de vehículos</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                           </ul>
                        </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-compressed faa-pulse animated"></i>
                                <span> Procesos </span>
                            <i class="ion-arrow-down-b"></i>
                        </a>
                        <ul class="treeview-menu">
                    <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-credit-card faa-pulse animated"></i>
                                        <span>Guías de remisión </span>
                                    <i class="ion-arrow-down-b"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=movimientos&nuevoremito"><i class="fa fa-credit-card faa-bounce animated"></i>Registrar rémito</a></li>
                                    <li><a href="?mod=movimientos&listaremito=listaremito"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de rémitos</a></li>
                                </ul>
                            </li>

                    <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-folder-close faa-pulse animated"></i>
                                        <span>Manifiestos </span>
                                    <i class="ion-arrow-down-b"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=manifiestos&nuevomanifiesto=nuevomanifiesto"><i class="glyphicon glyphicon-folder-open faa-pulse animated"></i>Registrar manifiesto</a></li>
                                    <li><a href="?mod=manifiestos&listamanifiestos=listamanifiestos"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de manifiestos</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="glyphicon glyphicon-calendar faa-pulse animated"></i>
                                <span> Caja </span>
                            <i class="ion-arrow-down-b"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-fire faa-pulse animated"></i>
                                        <span>Cobranzas </span>
                                    <i class="ion-arrow-down-b"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=cobranzas&listacobranza=listacobranza"><i class="fa fa-fire faa-bounce animated"></i>Listado de cobros</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-minus-sign faa-pulse animated"></i>
                                        <span>Egresos </span>
                                    <i class="ion-arrow-down-b"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=movimientos&nuevoegreso"><i class="glyphicon glyphicon-log-out faa-bounce animated"></i>Registrar egreso</a></li>
                                    <li><a href="?mod=movimientos&listaegreso=listaegreso"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de egresos</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-plus-sign faa-pulse animated"></i>
                                        <span>Ingresos </span>
                                    <i class="ion-arrow-down-b"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=movimientos&nuevoingreso"><i class="glyphicon glyphicon-log-in faa-bounce animated"></i>Registrar ingreso</a></li>
                                    <li><a href="?mod=movimientos&listaingreso=listaingreso"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de ingresos</a></li>
                                    <li class="treeview"></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-signal faa-pulse animated"></i>
                                    <span> Cuadre </span>
                                <i class="ion-arrow-down-b"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="?mod=cuadre&caja=caja"><i class="glyphicon glyphicon-stats faa-pulse animated"></i>Cuadre por caja</a></li>
                            </ul>
                    </li>
                                    
                            <!--<li class="treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-font faa-pulse animated"></i>
                                    <span>Abastecimiento </span>
                                <i class="fa fa-unsorted fa-spin fa-1x fa-fw"></i>
                                <i class="ion-arrow-down-b"></i>
                            </a>
                             <ul class="treeview-menu">
                               <li class="treeview">
                                <a href="#">
                                    <i class="glyphicon glyphicon-wrench faa-pulse animated"></i>
                                        <span>Herramientas </span>
                                    <i class="ion-arrow-down-b"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="?mod=herramientas&nuevo"><i class="fa fa-wrench faa-bounce animated"></i>Registrar herramienta</a></li>
                                    <li><a href="?mod=herramientas&lista=lista"><i class="glyphicon glyphicon-list faa-pulse animated"></i>Lista de herramientas</a></li>
                                    <li class="treeview"></li>
                                </ul>
                               </li>
                             </ul>
                            </li>-->    
                    </ul></li>
                </ul>
                <div><br></br></div>
                    <center>
                        <!--<div>
                            <iframe src="https://www.zeitverschiebung.net/clock-widget-iframe-v2?language=es&size=small&timezone=America%2FLima" width="100%" height="90" frameborder="0" seamless></iframe> 
                        </div>-->
                        <img width="100%" height="490" class="faa-float animated" frameborder="0" src="img/fondo3.png"></p>
                    </center>
            </section>
        </aside>