<?php
    date_default_timezone_set('America/Lima');
    header("Content-Type: text/html;charset=utf-8");

$admin=$_SESSION['dondequeda_id'];
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$servidor="localhost";
$basedatos="abarrotero";
$usuario="root";
$pass="";
//$servidor="localhost";
//$basedatos="hwpaziid_abarrotero";
//$usuario="hwpaziid";
//$pass="OKfz43Ng+h3+L3";

$nombre_sucursal = "SELECT (CONCAT(nombre_suc,' - ',direccion_suc,' (',nombre_depa,', ',nombre_provi,', ',nombre_dist,')')) AS SUCURSAL FROM administrador, sucursales, departamentos, provincias, distritos, movimientos WHERE movimientos.id_sucursal='$id_sucursal' AND administrador.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND provincias.id_departamento=departamentos.id_departamento AND distritos.id_provincia=provincias.id_provincia AND movimientos.id_sucursal=sucursales.id_sucursal;";
$resultado_sucursal = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$nombre_sucursal);

$cs=$bd->consulta($nombre_sucursal);
$datos = $bd-> mostrar_registros($nombre_sucursal);
$SUCURSAL = $datos ['SUCURSAL'];

?>
<script src="http://www.google.com/jsapi?key=AIzaSyCNEzVhPccz6d0swqde4xfYunbIre7Zax4"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<link rel="icon" type="image/png" href="./img/sheraton.png" />
<!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php?mod=index" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <span class="faa-flash animated-hover">Abarrotero Express</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a> </a>
                <a href="#" class="fa fa-expand faa-pulse animated fa-2x" data-toggle="offcanvas" role="button" data-collapsed-nav-tooltip="true" aria-expanded="true" title="Minimizar/expandir la barra vertical">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a> </a>
                <a class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o faa-wrench animated fa-2x" title="Recordatorio de las cuentas por cobrar"></i>
                            </a>
                            <ul class="dropdown-menu faa-float animated-hover">
                            <div class="col-md-12">
                            <div class="box2">
                                <div class="box-header">
                                    <h3 class="box-title">RECORDATORIO | Cuentas por cobrar</h3>
                                </div>                                        
                                    
                                    <div class="box-body table-responsive">
                                        <div style="overflow: auto; font-size: 13px;">
                                          <span style="float: left;">
                                            <b>OFICINA ( ACTUAL ):</b> <?php echo $SUCURSAL."."?>
                                          </span>
                                        </div><br>
                                    <table id="example0" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>   
                                                <th class="faa-float animated-hover">Info</th>  
                                                <th class="faa-float animated-hover">Código</th>
                                                <th class="faa-float animated-hover">Remitente</th>
                                                <th class="faa-float animated-hover">Destinatario</th>
                                                <th class="faa-float animated-hover">Flete</th>
                                                <th class="faa-float animated-hover">Pagado</th>
                                                <th class="faa-float animated-hover">Deuda</th>
                                                <th class="faa-float animated-hover">Cobro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 

                                        $consulta="SELECT CONCAT('M',LPAD(movimientos.id_movimiento,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO,(CONCAT('S/',FORMAT(cobranza.monto_cobro,2))) AS MONTO_COBRO, (cobranza.fecha_cobro) AS FECHA_COBRO, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, (CASE WHEN (cobranza.estado_cobro = 'PENDIENTE') THEN TIMESTAMPDIFF(DAY, CURDATE(),cobranza.fecha_cobro) ELSE 'MÁS DE UNA SEMANA' END) AS DIAS FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND movimientos.id_sucursal='$id_sucursal' AND estado_movi='DEUDA' ORDER BY DIAS DESC LIMIT 15;";
                                        $bd->consulta($consulta);
                                        while ($fila=$bd->mostrar_registros()) {
                                            echo "<tr>
                                                        ";
                                                        if($fila['DIAS']<"0"){?>
                                                            <?php echo"<td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL ".$fila["MANIFIESTO"]." DE ".$fila["MONTO_COBRO"]." DEBIÓ COBRARSE EL ".$fila["FECHA_COBRO"]."  '></a>
                                                            </td></center>";?><?php }else{ ?>

                                                          <?php echo"
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL ".$fila["MANIFIESTO"]." DE ".$fila["MONTO_COBRO"]." DEBE COBRARSE EL ".$fila["FECHA_COBRO"]."  '></a>
                                                            </td></center>"; ?>

                                                        <?php  } ?> <?php echo"
                                                        <td class='faa-float animated-hover'>
                                                            $fila[MANIFIESTO]
                                                        </td>
                                                        <td class='faa-float animated-hover'> 
                                                            $fila[REMITENTE]
                                                        </td>
                                                        <td class='faa-float animated-hover'> 
                                                            $fila[DESTINATARIO]
                                                        </td>
                                                        <td class='faa-float animated-hover'> 
                                                            $fila[MONTO_COBRO]
                                                        </td>
                                                        <td class='faa-float animated-hover'> 
                                                            $fila[PAGO]
                                                        </td>
                                                        <td class='faa-float animated-hover'> 
                                                            $fila[DEUDA]
                                                        </td>";
                                                        if($fila['DIAS']=="0"){?>
                                                            <td>HOY</td>
                                                        <?php }elseif($fila['DIAS']<"0"){?>
                                                            <td>EXPIRADO</td><?php }elseif($fila['DIAS']=="1"){?><td>MAÑANA</td><?php }else{ ?>

                                                          <?php echo"
                                                        <td class='faa-float animated-hover'> 
                                                            EN $fila[DIAS] DÍAS
                                                        </td>"; ?>

                                                        <?php  } ?> <?php echo"
                                                   </tr>";

                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </ul>
                </a>
                <a> </a>
                <a href="#" class="fa fa-mail-reply-all faa-pulse animated fa-2x faa-slow" onclick="window.location.href = document.referrer; return false;" title="Regresar a la página anterior"></a>
            <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->
                        <?php /* <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../img/avatar3.png" class="img-circle" alt="User Image"/>
                                                </div>
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    AdminLTE Design Team
                                                    <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Developers
                                                    <small><i class="fa fa-clock-o"></i> Today</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../img/avatar2.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Sales Department
                                                    <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <div class="pull-left">
                                                    <img src="../img/avatar.png" class="img-circle" alt="user image"/>
                                                </div>
                                                <h4>
                                                    Reviewers
                                                    <small><i class="fa fa-clock-o"></i> 2 days</small>
                                                </h4>
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                       
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li> 
						*/ 
                        $admin=$_SESSION['dondequeda_id'];
                        $nombre_sucursal = "SELECT (nombre_suc) AS SUCURSAL FROM administrador, sucursales WHERE administrador.id_sucursal=sucursales.id_sucursal AND id='$admin'";
                        $resultado_sucursal = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$nombre_sucursal);

                        $cs=$bd->consulta($nombre_sucursal);
                        $datos = $bd-> mostrar_registros($nombre_sucursal);
                        $SUCURSAL = $datos ['SUCURSAL']; ?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $_SESSION['dondequeda_usuario'] ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu faa-float animated-hover">
                                <!-- User image -->
                                <li class="user-header bg-maroon">
                                    <img src="img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p class="faa-pulse animated fa-2x faa-slow">
                                        <?php echo $_SESSION['dondequeda_nombre']." ".$_SESSION['dondequeda_apellido'];
                                        echo "\n".$tipo;
                                        echo "\n <br>".$tipo;
                                        echo "Nivel de usuario: ".$tipo;
                                        echo $_SESSION['dondequeda_nive_usua'];
                                        echo "\n <br>".$tipo;
                                        echo "Sucursal: ".$tipo;
                                        echo $SUCURSAL;?>
										
                                    </p>
                                </li>
                                <!-- Menu Body 
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Registros</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Ventas</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Ediciones</a>
                                    </div>
                                </li>
                                Menu Footer-->
                                <li class="user-footer">
                                   
                                    <div class="pull-right faa-tada animated-hover">
                                        <a href="#" onclick="window.location = './logout.php'" class="btn btn-default btn-lg">Cerrar sesión</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        