<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");
?>
<?php 

$fecha2=date("Y-m-d");  
$admin=$_SESSION['dondequeda_id'];
$id_sucursal=$_SESSION['dondequeda_sucursal'];

include './inc/config.php';
//$servidor="localhost";
//$basedatos="abarrotero";
//$usuario="root";
//$pass="";


$nombre_sucursal = "SELECT (nombre_suc) AS SUCURSAL, (COALESCE(CASE telefono_suc 
    WHEN '0' THEN 'SIN TELÉFONO' 
    ELSE telefono_suc 
    END,'SIN TELÉFONO')) AS telefono_suc, email_suc, direccion_suc FROM administrador, sucursales WHERE administrador.id_sucursal=sucursales.id_sucursal AND id='$admin'";
$resultado_sucursal = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$nombre_sucursal);

$contar_vehi = "SELECT COUNT(id_vehiculo) AS CONTEO FROM vehiculos WHERE condicion_vehi='OPERATIVO'";
$resultado_vehiculo = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$contar_vehi);

$contar_cho = "SELECT COUNT(id_chofer) AS CONTEO FROM choferes WHERE estado_cho='HABILITADO'";
$resultado_chofer = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$contar_cho);

$contar_prop = "SELECT COUNT(id_propietario) AS CONTEO FROM vehiculos";
$resultado_propietario = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$contar_prop);

$contar_cli = "SELECT COUNT(id_cliente) AS CONTEO FROM clientes WHERE id_sucursal='$id_sucursal'";
$resultado_cliente = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$contar_cli);

$contar_suc = "SELECT COUNT(id_sucursal) AS CONTEO FROM sucursales WHERE condicion_suc='ACTIVO'";
$resultado_sucursal2 = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$contar_suc);

$contar_prov = "SELECT COUNT(id_proveedor) AS CONTEO FROM proveedores";
$resultado_proveedor = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$contar_prov);

$cs=$bd->consulta($nombre_sucursal);
$datos = $bd-> mostrar_registros($nombre_sucursal);
$SUCURSAL = $datos ['SUCURSAL'];
$EMAILSUC = $datos ['email_suc'];
$TELEFONOSUC = $datos ['telefono_suc'];
$DIRECCIONSUC = $datos ['direccion_suc'];

?>
 
                <h4 class="page-header faa-float animated">ABARROTERO EXPRESS ( <?php echo $DIRECCIONSUC?> )
                    <small class="faa-horizontal animated-hover"><code class="faa-horizontal animated">BIENVENIDO A NUESTRA SUCURSAL DE <?php echo "$SUCURSAL!";?></code> Escoja la opción deseada.
                        <br><?php if($tipo2==1){ echo "<br2><h5>  Disponible el acceso a la información de todas las sucursales.</h5>";} ?></small>
                </h4>
                  
				<div class="row">					  
					<?php 
					if($tipo2==1 || $tipo2==2){
					echo '
                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            
                            <div class="small-box bg-maroon">
                                <div class="inner"> '?>
                                <h3 style="font-size: 25px;" onclick="Swal.fire({title:'<h2>VEHÍCULOS QUE SE ENCUENTREN OPERATIVOS</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})">
                                    <span class="blue faa-flash animated-hover"><?php while ($fila=mysqli_fetch_assoc($resultado_vehiculo)): ?>
                                            <?php echo "$fila[CONTEO]" ?><?php endwhile; ?></span> Vehículos 
                                         <?php echo'
                                    </h3>
                                    <div class="icon">
                                       <i class="fa fa-road faa-pulse animated faa-slow"></i>
                                    </div>
                                </div>
                                
                                <div class="icon">
                                    <a href="?mod=vehiculos&nuevo" class="small-box-footer"></a>
                                </div>
                                <a href="?mod=vehiculos&nuevo" class="small-box-footer">
                                    REGISTRAR NUEVO VEHÍCULO <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        
                        <!-- ./col -->
                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner">
                                    '?>
                                <h3 style="font-size: 25px;" onclick="Swal.fire({title:'<h2>CHOFERES QUE CUENTEN CON BREVETE HABILITADO</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})">
                                    <span class="blue faa-flash animated-hover"><?php while ($fila=mysqli_fetch_assoc($resultado_chofer)): ?>
                                            <?php echo "$fila[CONTEO]" ?><?php endwhile; ?></span> Choferes
                                         <?php echo'
                                    </h3>
                                    <div class="icon">
                                       <i class="fa fa-group faa-pulse animated faa-slow"></i>
                                    </div>
                                </div>
                                <div class="icon">
                                	<a href="?mod=choferes&nuevo" class="small-box-footer"></a>
                                </div>
                                <a href="?mod=choferes&nuevo" class="small-box-footer">
                                    REGISTRAR NUEVO CHOFER <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->'?>

                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner"><?php echo''?>
                                <h3 style="font-size: 25px;" onclick="Swal.fire({title:'<h2>PROPIETARIOS QUE TENGAN VEHÍCULOS A SU NOMBRE</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})">
                                    <span class="blue faa-flash animated-hover"><?php while ($fila=mysqli_fetch_assoc($resultado_propietario)): ?>
                                            <?php echo "$fila[CONTEO]" ?><?php endwhile; ?></span> Propietarios 
                                         <?php echo'
                                    </h3>
                                </div>
                                    <div class="icon">
                                       <i class="fa fa-cogs faa-pulse animated faa-slow"></i>
                                    </div>
                                <div class="icon">
                                    <a href="?mod=propietarios&nuevo" class="small-box-footer"></a>
                                </div>
                                <a href="?mod=propietarios&nuevo" class="small-box-footer">
                                    REGISTRAR NUEVO PROPIETARIO <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner">'?>
                                <h3 style="font-size: 25px;" onclick="Swal.fire({title:'<h2>CLIENTES REGISTRADOS EN LA SUCURSAL DE <?php echo "$SUCURSAL";?></h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})">
                                    <span class="blue faa-flash animated-hover"><?php while ($fila=mysqli_fetch_assoc($resultado_cliente)): ?>
                                            <?php echo "$fila[CONTEO]" ?><?php endwhile; ?></span> Clientes 
                                         <?php echo'
                                    </h3>
                                    <div class="icon">
                                       <i class="fa fa-usd faa-pulse animated faa-slow"></i>
                                    </div>
                                </div>
                                <div class="icon">
                                    <a href="?mod=clientes&nuevo" class="small-box-footer"></a>
                                </div>
                                <a href="?mod=clientes&nuevo" class="small-box-footer">
                                    REGISTRAR NUEVO CLIENTE <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                   
                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner">'?>
                                <h3 style="font-size: 25px;" onclick="Swal.fire({title:'<h2>TODAS LAS SUCURSALES QUE SE ENCUENTREN ACTIVAS<br><br>ACTUAL: <?PHP echo $SUCURSAL?></h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})">
                                    <span class="blue faa-flash animated-hover"><?php while ($fila=mysqli_fetch_assoc($resultado_sucursal2)): ?>
                                            <?php echo "$fila[CONTEO]" ?><?php endwhile; ?></span> Sucursales 
                                         <?php echo'
                                    </h3>
                                </div>
                                    <div class="icon">
                                       <i class="fa fa-sitemap faa-pulse animated faa-slow"></i>
                                    </div>
                                <a class="small-box-footer">
                                    SUCURSAL ACTUAL: '?><?php echo "$SUCURSAL";?>
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner"><?php echo''?>
                                <h3 style="font-size: 25px;" onclick="Swal.fire({title:'<h2>TODOS LOS PROVEEDORES REGISTRADOS</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})">
                                    <span class="blue faa-flash animated-hover"><?php while ($fila=mysqli_fetch_assoc($resultado_proveedor)): ?>
                                            <?php echo "$fila[CONTEO]" ?><?php endwhile; ?></span> Proveedores 
                                         <?php echo'
                                    </h3>
                                </div>
                                    <div class="icon">
                                       <i class="fa fa-gift faa-pulse animated faa-slow"></i>
                                    </div>
                                <div class="icon">
                                    <a href="?mod=proveedores&nuevo" class="small-box-footer"></a>
                                </div>
                                <a href="?mod=proveedores&nuevo" class="small-box-footer">
                                    REGISTRAR NUEVO PROVEEDOR <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner">'?>
                                <h3 style="font-size: 25px;">
                                    <span class="blue faa-flash animated-hover">40</span> OPE 1 
                                         <?php echo'
                                    </h3>
                                </div>
                                    <div class="icon">
                                       <i class="fa fa-sign-in faa-pulse animated faa-slow"></i>
                                    </div>
                                <a href="?mod=registroadmin&valoraciong" class="small-box-footer">
                                    REGISTRAR NUEVA OPE 1 <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->

                        <div class="col-lg-3 col-xs-6 faa-float animated-hover faa-flash">
                            <!-- small box -->
                            <div class="small-box bg-maroon">
                                <div class="inner">'?>
                                <h3 style="font-size: 25px;">
                                    <span class="blue faa-flash animated-hover">40</span> OPE 2 
                                         <?php echo'
                                    </h3>
                                </div>
                                    <div class="icon">
                                       <i class="fa fa-sign-out faa-pulse animated faa-slow"></i>
                                    </div>
                                <a href="?mod=registroadmin&valoraciong" class="small-box-footer">
                                    REGISTRAR NUEVA OPE 2 <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div><!-- /.row --> ';	
                } ?>

                  
                      <div class="col-md-6">
                       
                            <div class="box">
                                <ul class="nav nav-tabs" style="font-weight: bold; font-size: 11px;">
                                  <li class="active"><a data-toggle="tab" href="#vehiculos">Vehículos</a></li>
                                  <li><a data-toggle="tab" href="#choferes">Choferes</a></li>
                                  <li><a data-toggle="tab" href="#propietarios">Propietarios</a></li>
                                  <li><a data-toggle="tab" href="#clientes">Clientes</a></li>
                                  <li><a data-toggle="tab" href="#sucursales">Sucursales</a></li>
                                  <li><a data-toggle="tab" href="#proveedores">Proveedores</a></li> 
                                </ul>

                                <div class="tab-content">
                                <div id="vehiculos" class="tab-pane fade in active">

                                <div class="box-header">
                                    <h3 class="box-title">NUESTROS VEHÍCULOS | Cartera de medios</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Placa</th>
                                                <th class="faa-float animated-hover">Tipo</th>
                                                <th class="faa-float animated-hover">Marca</th>
                                                <th class="faa-float animated-hover">Color</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        $consulta="SELECT nombre_prop, placa_vehi, tipo_vehi, marca_vehi, color_vehi FROM vehiculos, propietarios WHERE condicion_vehi='OPERATIVO' AND vehiculos.id_propietario=propietarios.id_propietario ORDER BY placa_vehi;";

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
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL VEHÍCULO ".$fila["tipo_vehi"]." CON PLACA ".$fila["placa_vehi"]." TIENE COMO PROPIETARIO A ".$fila["nombre_prop"]."' ";?> onclick='Swal.fire({title:"<h4><?php echo "EL VEHÍCULO ".$fila["tipo_vehi"]." CON PLACA ".$fila["placa_vehi"]." TIENE COMO PROPIETARIO A ".$fila["nombre_prop"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[placa_vehi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[tipo_vehi]                                                        </td>
                                                         <td class='faa-float animated-hover'>
                                                            $fila[marca_vehi]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                            $fila[color_vehi]
                                                        </td>
                                                    </tr>"; } ?>  
                                                                                                                    
                                        </tbody>
                                        <tfoot>
                                            <tr></tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                              <div id="choferes" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">NUESTROS CHOFERES | Cartera de transportistas</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Conductor</th>
                                                <th class="faa-float animated-hover">Brevete</th>
                                                <th class="faa-float animated-hover">DNI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        $consulta="SELECT id_chofer, (DATE_FORMAT(registro_cho, '%d/%m/%Y')) AS REGISTRO, (CONCAT(nombre_cho,' ', apellido_cho)) AS CONDUCTOR, brevete_cho, dni_cho, (COALESCE(CASE telefono_cho 
    WHEN '0' THEN 'SIN TELÉFONO' 
    ELSE telefono_cho 
    END,'SIN TELÉFONO')) AS telefono_cho FROM choferes WHERE estado_cho='HABILITADO' ORDER BY registro_cho, CONDUCTOR ASC";

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
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL CHOFER ".$fila["CONDUCTOR"]." FUE REGISTRADO EL ".$fila["REGISTRO"]." (CONTACTO: ".$fila["telefono_cho"].")'";?> onclick='Swal.fire({title:"<h4><?php echo "EL CHOFER ".$fila["CONDUCTOR"]." FUE REGISTRADO EL ".$fila["REGISTRO"]." <br><br>(CONTACTO: ".$fila["telefono_cho"].")";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[CONDUCTOR]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[brevete_cho]                                                        </td>
                                                         <td class='faa-float animated-hover'>
                                                            $fila[dni_cho]
                                                        </td>
                                                    </tr>"; } ?>  
                                                                                                                    
                                        </tbody>
                                        <tfoot>
                                            <tr></tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                              </div>
                              <div id="propietarios" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">NUESTROS PROPIETARIOS | Cartera de titulares</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example3" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Dueño</th>
                                                <th class="faa-float animated-hover">RUC</th>
                                                <th class="faa-float animated-hover">Teléfono</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        $consulta="SELECT vehiculos.id_propietario, nombre_prop, ruc_prop, (COALESCE(CASE telefono_prop 
    WHEN '0' THEN 'SIN TELÉFONO' 
    ELSE telefono_prop 
    END,'SIN TELÉFONO')) AS telefono_prop, COUNT(vehiculos.id_vehiculo) AS vehi FROM propietarios, vehiculos WHERE vehiculos.id_propietario=propietarios.id_propietario GROUP BY nombre_prop ORDER BY nombre_prop ASC";

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
                                                        <td><center>
                                                        "; if($fila['vehi']=='1'){
                                                              echo "<a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL PROPIETARIO ".$fila["nombre_prop"]." TIENE A SU NOMBRE ".$fila["vehi"]." VEHÍCULO.'";?> onclick='Swal.fire({title:"<h4><?php echo "EL PROPIETARIO ".$fila["nombre_prop"]." TIENE A SU NOMBRE ".$fila["vehi"]." VEHÍCULO";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>";
                                                           } else { echo "<a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL PROPIETARIO ".$fila["nombre_prop"]." TIENE A SU NOMBRE ".$fila["vehi"]." VEHÍCULOS.'";?> onclick='Swal.fire({title:"<h4><?php echo "EL PROPIETARIO ".$fila["nombre_prop"]." TIENE A SU NOMBRE ".$fila["vehi"]." VEHÍCULOS";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>";}
                                                           echo "
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_prop]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[ruc_prop]                                                        </td>
                                                         <td class='faa-float animated-hover'>
                                                            $fila[telefono_prop]
                                                        </td>
                                                    </tr>"; } ?>  
                                                                                                                    
                                        </tbody>
                                        <tfoot>
                                            <tr></tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                              </div>
                              <div id="clientes" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">NUESTRA FUENTE DE INGRESOS | Cartera de clientes</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example4" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Cliente</th>
                                                <th class="faa-float animated-hover">RUC</th>
                                                <th class="faa-float animated-hover">DNI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        $consulta="SELECT id_cliente, DATE_FORMAT(registro_cli, '%d/%m/%Y') AS REGISTRO, CONCAT(nombre_cli,' ',apellido_cli) AS CLIENTE, ruc_cli, (COALESCE(CASE dni_cli WHEN '0' THEN 'SIN REGISTRO'  ELSE dni_cli END,'SIN REGISTRO')) AS dni_cli, (COALESCE(CASE telefono_cli WHEN '0' THEN 'SIN TELÉFONO' ELSE telefono_cli END,'SIN TELÉFONO')) AS telefono_cli, nombre_suc FROM clientes, sucursales WHERE clientes.id_sucursal=sucursales.id_sucursal ORDER BY REGISTRO ASC";

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
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL CLIENTE ".$fila["CLIENTE"]." FUE REGISTRADO EL ".$fila["REGISTRO"]." (CONTACTO: ".$fila["telefono_cli"].")'";?> onclick='Swal.fire({title:"<h4><?php echo "EL CLIENTE ".$fila["CLIENTE"]." FUE REGISTRADO EL ".$fila["REGISTRO"]." <br><br>(CONTACTO: ".$fila["telefono_cli"].")";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[CLIENTE]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[ruc_cli]                                                        </td>
                                                         <td class='faa-float animated-hover'>
                                                            $fila[dni_cli]
                                                        </td>
                                                    </tr>"; } ?>  
                                                                                                                    
                                        </tbody>
                                        <tfoot>
                                            <tr></tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                        </div>
                        <div id="sucursales" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">NUESTRAS SUCURSALES | Cartera de sedes</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example5" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Base</th>
                                                <th class="faa-float animated-hover">Departamento</th>
                                                <th class="faa-float animated-hover">Provincia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        $consulta="SELECT id_sucursal, nombre_suc, nombre_depa, nombre_provi, nombre_dist, (COALESCE(CASE telefono_suc 
    WHEN '0' THEN 'SIN TELÉFONO' 
    ELSE telefono_suc 
    END,'SIN TELÉFONO')) AS telefono_suc FROM sucursales, departamentos, provincias, distritos WHERE condicion_suc='ACTIVO' AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito";

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
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' LA SUCURSAL ESTÁ UBICADA EN LA LOCALIDAD DE ".$fila["nombre_dist"]." (CONTACTO: ".$fila["telefono_suc"].")'";?> onclick='Swal.fire({title:"<h4><?php echo "LA SUCURSAL ESTÁ UBICADA EN LA LOCALIDAD DE ".$fila["nombre_dist"]." <br><br>(CONTACTO: ".$fila["telefono_suc"].")";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                              $fila[nombre_suc]
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[nombre_depa]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                            $fila[nombre_provi]
                                                        </td>
                                                    </tr>"; } ?>  
                                                                                                                    
                                        </tbody>
                                        <tfoot>
                                            <tr></tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                        </div>
                        <div id="proveedores" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">NUESTROS PROVEEDORES | Cartera de abastecedores</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example6" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Proveedor</th>
                                                <th class="faa-float animated-hover">RUC</th>
                                                <th class="faa-float animated-hover">Teléfono</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        
                                        $consulta="SELECT id_proveedor, nombre_prov, ruc_prov, telefono_prov, (COALESCE(CASE observacion_prov 
    WHEN '' THEN 'SIN OBSERVACIONES' 
    ELSE observacion_prov 
    END,'SIN OBSERVACIONES')) AS observacion FROM proveedores ORDER BY nombre_prov;";

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
                                                        <td><center>
                                                        "; if($fila['observacion']=='SIN OBSERVACIONES'){
                                                              echo "<a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' EL PROVEEDOR ".$fila["nombre_prov"]." NO CUENTA CON OBSERVACIONES.'";?> onclick='Swal.fire({title:"<h4><?php echo "EL PROVEEDOR ".$fila["nombre_prov"]." NO CUENTA CON OBSERVACIONES";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>";
                                                           } else { echo "<a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title=' OBSERVACIONES: ".$fila["observacion"]."'";?> onclick='Swal.fire({title:"<h4><?php echo "OBSERVACIONES: ".$fila["observacion"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>";}
                                                           echo "
                                                        </td></center>
                                                        <td class='faa-float animated-hover'> $fila[nombre_prov]
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[ruc_prov]
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[telefono_prov]
                                                        </td>
                                                    </tr>"; } ?>  
                                                                                                                    
                                        </tbody>
                                        <tfoot>
                                            <tr></tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                        </div></div>

  
                    </div>
                </div><!-- /.col -->

                        <div class="col-md-6 faa-bounce animated-hover">
                            <div class="box box-solid">
                                <div class="box-header">
                                   
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                                            <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
                                            <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                                            <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <div class="item">
                                                <img src="img/slider1.jpg" alt="First slide">
                                                <div class="carousel-caption">
                                                    
                                                </div>
                                            </div>
                                            <div class="item active">
                                                <img src="img/slider2.jpg" alt="Second slide">
                                                <div class="carousel-caption">
                                                    
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img src="img/slider3.jpg" alt="Third slide">
                                                <div class="carousel-caption">
                                                    
                                                </div>
                                            </div>
                                            <div class="item">
                                                <img src="img/slider4.jpg" alt="Third slide">
                                                <div class="carousel-caption">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                        </a>
                                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                        </a>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    
                    </div><!-- /.row -->
                    <!-- END ACCORDION & CAROUSEL-->



