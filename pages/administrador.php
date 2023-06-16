<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");
?>	
<?php
 
		 require ('validarnum.php');

$fecha2=date("Y-m-d");  	

include './inc/config.php';
//$servidor="localhost";
//$basedatos="hwpaziid_abarrotero";
//$usuario="hwpaziid";
//$pass="OKfz43Ng+h3+L3";

$buscar_suc = "SELECT id_sucursal, nombre_suc FROM sucursales WHERE condicion_suc = 'ACTIVO' ORDER BY nombre_suc; ";
$resultado_suc = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_suc);

$buscar_imp_suc = "SELECT administrador.id_sucursal, nombre_suc FROM sucursales, administrador WHERE administrador.id_sucursal=sucursales.id_sucursal GROUP BY nombre_suc ORDER BY nombre_suc; ";
$resultado_imp_suc = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_suc);

$buscar_imp_est = "SELECT estado FROM administrador GROUP BY estado ORDER BY estado; ";
$resultado_imp_est = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_est);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {
                           

$nombre=trim(strtoupper($_POST["nombre"]));
$apellido=trim(strtoupper($_POST["apellido"]));
$correo=trim(strtoupper($_POST["correo"]));
$nivel=trim(strtoupper($_POST["nivel"]));
$pass=trim($_POST["pw"]);
$pass=md5($pass);
$usuario=trim(strtoupper($_POST["usuario"]));
$sucursal=trim(strtoupper($_POST["sucursal"]));


$sql="select * from administrador where correo='$correo'";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){


$sql2="INSERT INTO `administrador` ( `usuario`, `pass`, `nombre`, `apellido`, `correo`, `nive_usua`, `estado`, `id_sucursal`) VALUES ('$usuario', '$pass', '$nombre', '$apellido', '$correo', '$nivel', 'ACTIVO', '$sucursal')";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el usuario nuevo correctamente.';


                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=administrador&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';                                

}else{

	

//CONSULTAR SI EL CAMPO YA EXISTE

	  echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta no se registró este usuario!</b> Ya existe . . . ';



                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar encargados</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=administrador&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nombres <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir los nombres" autofocus>

                                            <label for="exampleInputFile">Apellidos <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="apellido" class="form-control faa-float animated-hover" pattern='.{2,30}' maxlength="30" id="exampleInputEmail1" placeholder="Introducir los apellidos">

                                             <label for="exampleInputFile">Usuario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (5-20) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (5-20)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="usuario" class="form-control faa-float animated-hover" id="exampleInputEmail1" autocomplete="off" pattern='.{5,20}' maxlength="20" placeholder="Introducir el nombre de usuario">

                                            <label for="exampleInputFile">Clave <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (8-32) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (8-32)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" required type="password" name="pw" class="form-control faa-float animated-hover" id="exampleInputEmail1" autocomplete="off" pattern='.{8,32}' maxlength="32" placeholder="Introducir la contraseña">

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" required type="email" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" autocomplete="off" placeholder="Introducir el correo electrónico">

                                            <label for="exampleInputFile">Sucursal <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar una sucursal</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=sucursales&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=sucursales&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione una sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>

                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="sucursal" required>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_suc)): ?>
                                                    <option class="btn-primary" value="<?php echo $SUC['id_sucursal'] ?>"><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Nivel de usuario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un nivel de usuario." onclick="Swal.fire({title:'<h2>Por favor seleccione un nivel de usuario</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='nivel' required>
                                                   <option class="btn-primary" value="1">ADMINISTRADOR  ( Acceso a todas las sucursales )</option>
                                                   <option class="btn-primary" value="2">EMPLEADO  ( Acceso a la sucursal actual )</option>
                                                </select>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar encargado</button>
                                        
                                    
                                    </div>
                                    </center>
                                </form>
                            </div><!-- /.box -->


<?php
}

	
   
   if (isset($_GET['lista'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['lista'])) {
                           


}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">ENCARGADOS | Lista de usuarios</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Nombres</th>
                                                <th class="faa-float animated-hover">Apellidos</th>
                                                <th class="faa-float animated-hover">Correo electrónico</th>
                                                <th class="faa-float animated-hover">Sucursal</th>
                                                <th class="faa-float animated-hover">Estado</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT id, CONCAT(nombre,' ',apellido) AS nomape, nombre, apellido, usuario, CONCAT(SUBSTRING_INDEX(correo,'@',1),'@...') AS correo, nive_usua, nombre_suc, estado FROM administrador, sucursales WHERE administrador.id_sucursal=sucursales.id_sucursal ORDER BY nomape ASC ";
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
                                                           
                                                              $fila[nombre]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[apellido]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                            $fila[correo]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                            $fila[nombre_suc]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                            $fila[estado]
                                                        </td>
                                                         <td><center>";

                                                         echo "
                                                            <a  href=?mod=administrador&consultar&codigo=".$fila["id"]."><img src='./img/consul.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DEL USUARIO ".$fila["usuario"]."'></a>";

if ($tipo2==1) {      
                                echo "
      
      <a  href=?mod=administrador&editar&codigo=".$fila["id"]."><img src='./img/editar.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL USUARIO ".$fila["usuario"]."'></a>";

      if ($fila['estado']=='ACTIVO') { echo"
      <a   href=?mod=administrador&eliminar&codigo=".$fila["id"]."><img src='./img/elimina.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='DARLE DE BAJA AL USUARIO ".$fila["usuario"]."'></a>
      ";}
     
     } 
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
                    
              

                          
                            <?php

                                echo '
  <div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Agregar encargado <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=administrador&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO ENCARGADO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  ';  

?>

</br>       
                                
<div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <center>
                                <div class="box-header">
                                   <h3> <center>Imprimir listado</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Estado de usuario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado de usuario para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de usuarios por estado</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_admin" onchange="if(this.value=='Seleccione un estado para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un estado para exportar</option>
                                                <?php while($EST = mysqli_fetch_assoc($resultado_imp_est)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_admin_estado.php?estado=<?php echo $EST['estado']?>'><?php echo $EST['estado'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                <label for="exampleInputFile">Nuestras sucursales <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de usuarios por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_admin" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_imp_suc)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_admin_sucursal.php?id_sucursal=<?php echo $SUC['id_sucursal']?>&nombre_suc=<?php echo $SUC['nombre_suc']?>'><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>                                            
                                 </div>
                                 <img src="./img/gif/administrador.gif" width="100%" height="200px" title="Optimize la productividad de sus trabajadores"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>

<?php
}

  
   
   if (isset($_GET['valoraciong'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['valoraciong'])) {
                           



        

}
?>
  
                            
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">VALORACIÓN GENERAL | Efectividad,  productividad y manejo de dinero por encargado             <a target='_blank' href=./js/chartJS/samples/VG.php><img src="./img/dash.png"  width="45" alt="Edicion" title="Visualizar dashboard del mes actual"></a> <a href="#" class="alert-link"></a><a target="_self"  href="?mod=administrador&valoraciond"><img src="./img/kpi.svg"  width="40" alt="Edicion" title="Ir al conteo de operaciones"></a></h3>                                                            
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th>Periodo</th>
                                                <th>Encargado</th>
                                                <th>Efectividad</th>
                                                <th>Productividad</th>
                                                <th>Entradas</th>
                                                <th>Salidas</th>
                                                <th>Anulada</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1){
                                        
                                        $consulta="SELECT 

(CONCAT((CASE MONTH(movimientos.fecha_movimiento)
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
                                            END),' ',

                                        (CASE YEAR(movimientos.fecha_movimiento)
                                            WHEN 2018 THEN '2018'
                                            WHEN 2019 THEN '2019'
                                            WHEN 2020 THEN '2020'
                                            WHEN 2021 THEN '2021'
                                            WHEN 2022 THEN '2022'
                                            WHEN 2023 THEN '2023'
                                            WHEN 2024 THEN '2024'
                                            END))) AS PERIODO,

(CONCAT(administrador.nombre,' ',administrador.apellido)) AS ENCARGADO,

CONCAT(CAST(((COUNT(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION' THEN (movimientos.id_movimientos)
                        WHEN 'APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'PAGARE' THEN (movimientos.id_movimientos)
                        WHEN 'PRESTAMO' THEN (movimientos.id_movimientos)
                        WHEN 'DEVOLUCION DE APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'OTROS' THEN (movimientos.id_movimientos) END
                                        ))/((COUNT(movimientos.id_movimientos))))*100 AS DECIMAL (8,2)),'%') AS EFECTIVIDAD,

CONCAT((CAST((COUNT(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION' THEN (movimientos.id_movimientos)
                        WHEN 'APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'PAGARE' THEN (movimientos.id_movimientos)
                        WHEN 'PRESTAMO' THEN (movimientos.id_movimientos)
                        WHEN 'DEVOLUCION DE APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'OTROS' THEN (movimientos.id_movimientos)
                                        END))/(20) AS DECIMAL(8,2))),' POR DIA') AS PRODUCTIVIDAD,

(CONCAT('S/',FORMAT(IFNULL(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN (movimientos.monto)
                                        WHEN '2' THEN 00.00
                                        WHEN '4' THEN 00.00
                                        WHEN '5' THEN 00.00
                                        WHEN '6' THEN 00.00
                                        WHEN '7' THEN (movimientos.monto)
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN (movimientos.monto)
                                        END),0),2))) TASAE,  

(CONCAT('S/',FORMAT(IFNULL(SUM(CASE documento.codigo_doc
                                        WHEN '1' THEN 00.00
                                        WHEN '2' THEN (movimientos.monto)
                                        WHEN '4' THEN (movimientos.monto)
                                        WHEN '5' THEN (movimientos.monto)
                                        WHEN '6' THEN (movimientos.monto)
                                        WHEN '7' THEN 00.00
                                        WHEN '8' THEN 00.00
                                        WHEN '9' THEN 00.00
                                        WHEN '10' THEN 00.00
                                        END),0),2))) TASAS,                                                  

(CONCAT('S/',FORMAT(IFNULL(SUM(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION ANULADO' THEN (movimientos.monto)
                        WHEN 'APORTE ANULADO' THEN (movimientos.monto)
                        WHEN 'PAGARE ANULADO' THEN (movimientos.monto)
                        WHEN 'PRESTAMO ANULADO' THEN (movimientos.monto)
                        WHEN 'DEVOLUCION DE APORTE ANULADO' THEN (movimientos.monto)
                        WHEN 'OTROS ANULADO' THEN (movimientos.monto)
                                        END),0),2))) TASAA

FROM movimientos, administrador, documento
WHERE movimientos.id=administrador.id
AND movimientos.codigo_doc=documento.codigo_doc
AND movimientos.operacion NOT LIKE 'SOLICITUD%'
AND movimientos.tipo_movimiento NOT LIKE 'CAPITAL'
AND YEAR(fecha_movimiento)!= '2010'
GROUP BY PERIODO, administrador.id;";
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
                                             //echo '<li data-icon="delete"><a href="?mod=lugares?edit='.$fila['id_tipo'].'"><img src="images/lugares/'.$fila['imagen'].'" height="350" >'.$fila['nombre'].'</a><a href="?mod=lugares?borrar='.$fila['id_tipo'].'" data-position-to="window" >Borrar</a></li>';
                                             echo "<tr>
                                                        <td>
                                                            $fila[PERIODO]
                                                        </td>
                                                        <td>
                                                            $fila[ENCARGADO]
                                                        </td>
                                                        <td>
                                                            $fila[EFECTIVIDAD]
                                                        </td>
                                                        <td>
                                                            $fila[PRODUCTIVIDAD]
                                                        </td>
                                                        <td>
                                                            $fila[TASAE]
                                                        </td>
                                                        <td>
                                                            $fila[TASAS]
                                                        </td>
                                                        <td>
                                                            $fila[TASAA]
                                                        </td>";
      
                                echo "      ";
     
     }
                                               echo "     ";
                                        
                                        
                                        
                                        
                                      
     
                                           
                                        

                                        
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
                    
              

<?php
}

  
   
   if (isset($_GET['valoraciond'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['valoraciond'])) {
                           



        

}
?>
  
                            
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">CONTEO DE OPERACIONES | Número de operaciones por encargado                    <a target='_blank' href=./js/chartJS/samples/VD.php><img src="./img/dash.png"  width="45" alt="Edicion" title="Visualizar dashboard del mes actual"></a> <a href="#" class="alert-link"></a><a target="_self"  href="?mod=administrador&valoraciong"><img src="./img/kpi.svg"  width="40" alt="Edicion" title="Ir a la valoración general"></a></h3>                                     
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Periodo</th>
                                                <th>Encargado</th>
                                                <th>Delegadas</th>
                                                <th>Realizadas</th>
                                                <th>Aportes</th>
                                                <th>Pagaré</th>
                                                <th>Devoluciones</th>
                                                <th>Amortizaciones</th>
                                                <th>Préstamos</th>
                                                <th>Anuladas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1){
                                        
                                        $consulta="SELECT 

(CONCAT((CASE MONTH(movimientos.fecha_movimiento)
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
                                            END),' ',

                                        (CASE YEAR(movimientos.fecha_movimiento)
                                            WHEN 2018 THEN '2018'
                                            WHEN 2019 THEN '2019'
                                            WHEN 2020 THEN '2020'
                                            WHEN 2021 THEN '2021'
                                            WHEN 2022 THEN '2022'
                                            WHEN 2023 THEN '2023'
                                            WHEN 2024 THEN '2024'
                                            END))) AS PERIODO,

(CONCAT(administrador.nombre,' ',administrador.apellido)) AS ENCARGADO,
                                        
(COUNT(movimientos.id_movimientos)) AS DELEGADAS,

COUNT(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION' THEN (movimientos.id_movimientos)
                        WHEN 'APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'PAGARE' THEN (movimientos.id_movimientos)
                        WHEN 'PRESTAMO' THEN (movimientos.id_movimientos)
                        WHEN 'DEVOLUCION DE APORTE' THEN (movimientos.id_movimientos)
                        WHEN 'OTROS' THEN (movimientos.id_movimientos)
                                        END) REALIZADAS,
                                        
COUNT(CASE movimientos.operacion
                        WHEN 'PAGARE' THEN (movimientos.id_movimientos)
                                        END) PAGARE,

COUNT(CASE movimientos.operacion
                        WHEN 'APORTE' THEN (movimientos.id_movimientos)
                                        END) APORTES,
                                        
COUNT(CASE movimientos.operacion
                        WHEN 'DEVOLUCION DE APORTE' THEN (movimientos.id_movimientos)
                                        END) DEVOLUCIONES,            

COUNT(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION' THEN (movimientos.id_movimientos)
                                        END) AMORTIZACIONES,
                                        
COUNT(CASE movimientos.operacion
                        WHEN 'PRESTAMO' THEN (movimientos.id_movimientos)
                                        END) PRESTAMOS,                      

COUNT(CASE movimientos.operacion
                        WHEN 'OTROS' THEN (movimientos.id_movimientos)
                                        END) OTROS,
                                        
COUNT(CASE movimientos.operacion
                                        WHEN 'AMORTIZACION ANULADO' THEN (movimientos.id_movimientos)
                        WHEN 'APORTE ANULADO' THEN (movimientos.id_movimientos)
                        WHEN 'PAGARE ANULADO' THEN (movimientos.id_movimientos)
                        WHEN 'PRESTAMO ANULADO' THEN (movimientos.id_movimientos)
                        WHEN 'DEVOLUCION DE APORTE ANULADO' THEN (movimientos.id_movimientos)
                        WHEN 'OTROS ANULADO' THEN (movimientos.id_movimientos)      
                                        END) ANULADAS
                                        
FROM movimientos, administrador
WHERE movimientos.id=administrador.id
AND movimientos.operacion NOT LIKE 'SOLICITUD%'
AND movimientos.tipo_movimiento NOT LIKE 'CAPITAL'
AND YEAR(fecha_movimiento)!= '2010'
GROUP BY PERIODO, administrador.id ";
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
                                                        <td>
                                                            $fila[PERIODO]
                                                        </td>
                                                        <td>
                                                            $fila[ENCARGADO]
                                                        </td>
                                                        <td>
                                                            $fila[DELEGADAS]
                                                        </td>
                                                        <td>
                                                            $fila[REALIZADAS]
                                                        </td>
                                                        <td>
                                                            $fila[APORTES]
                                                        </td>
                                                        <td>
                                                            $fila[PAGARE]
                                                        </td>
                                                        <td>
                                                            $fila[DEVOLUCIONES]
                                                        </td>
                                                        <td>
                                                            $fila[AMORTIZACIONES]
                                                        </td>
                                                        <td>
                                                            $fila[PRESTAMOS]
                                                        </td>
                                                        <td>
                                                            $fila[ANULADAS]
                                                        </td>
                                                         ";
      
                                echo "   ";
     
     }
                                               echo "   ";
                                        
                                        
                                        
                                        
                                      
     
                                           
                                        

                                        
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
                    
              

                          


<?php
}

     

     if (isset($_GET['editar'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['editar'])) {
                           


$nombre=trim(strtoupper($_POST["nombre"]));
$apellido=trim(strtoupper($_POST["apellido"]));
$correo=trim(strtoupper($_POST["correo"]));
$nivel=trim(strtoupper($_POST["nivel"]));
$pass=trim($_POST["pw"]);
$pass=md5($pass);
$usuario=trim(strtoupper($_POST["usuario"]));
$sucursal=trim(strtoupper($_POST["sucursal"]));

                       
if( $nombre=="" )
                {
                
                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {


$sql22=" UPDATE administrador SET 
nombre='$nombre' ,
apellido='$apellido' ,
nive_usua='$nivel' ,
correo='$correo', 
usuario='$usuario',
id_sucursal='$sucursal'
 where id='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos del usuario '$usuario' correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=administrador&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT id, sucursales.nombre_suc, sucursales.id_sucursal, usuario, nombre, apellido, correo, nive_usua, estado, nive_usua, (CONCAT('NO SE HAGA EL LISTO JOVEN')) AS pass, CASE nive_usua
                                            WHEN 1 THEN 'ADMINISTRADOR'
                                            WHEN 2 THEN 'EMPLEADO'
                                            WHEN 3 THEN 'OTRO'
                                            END nive_usuar FROM administrador, sucursales WHERE id='$x1' AND administrador.id_sucursal=sucursales.id_sucursal";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar encargados </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=administrador&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                           
                                          <label for="exampleInputFile">Nombres <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir los nombres" value="<?php echo $fila['nombre']?>">

                                            <label for="exampleInputFile">Apellidos <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="apellido" class="form-control faa-float animated-hover" pattern='.{2,30}' maxlength="30" id="exampleInputEmail1" placeholder="Introducir los apellidos" value="<?php echo $fila['apellido']?>">

                                             <label for="exampleInputFile">Usuario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (5-20) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (5-20)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="usuario" class="form-control faa-float animated-hover" id="exampleInputEmail1" autocomplete="off" pattern='.{5,20}' maxlength="20" placeholder="Introducir el nombre de usuario" value="<?php echo $fila['usuario']?>">

                                            <label for="exampleInputFile">Clave <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (8-32) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (8-32)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" required type="password" name="pw" class="form-control faa-float animated-hover" id="exampleInputEmail1" autocomplete="off" pattern='.{8,32}' maxlength="32" placeholder="Introducir la contraseña" value="<?php echo $fila['pass']?>" disabled>

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" required type="email" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" autocomplete="off" placeholder="Introducir el correo electrónico" value="<?php echo $fila['correo'] ?>">

                                            <label for="exampleInputFile">Sucursal <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar una sucursal</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=sucursales&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=sucursales&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione una sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="sucursal" required>
                                                  <option class="btn-danger" value="<?php echo $fila['id_sucursal'] ?>">SUCURSAL ACTUAL: <?php echo $fila['nombre_suc'] ?></option>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_suc)): ?>
                                                  <option class="btn-primary" value="<?php echo $SUC['id_sucursal'] ?>"><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Nivel de usuario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un nivel de usuario." onclick="Swal.fire({title:'<h2>Por favor seleccione un nivel de usuario</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='nivel' required>
                                                  <option class="btn-danger" value="<?php echo $fila['nive_usua'] ?>">NIVEL ACTUAL: <?php echo $fila['nive_usuar'] ?></option>
                                                  <option class="btn-primary" value="1">1 - ADMINISTRADOR  ( Acceso a todas las sucursales )</option>
                                                  <option class="btn-primary" value="2">2 - EMPLEADO  ( Acceso a la sucursal actual )</option>
                                                </select>
  
                                        </div>
                                       
                                                                          
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="editar" id="editar" value="Editar">Actualizar datos</button>
                                        
                                    
                                    </div></center>
                                </form>
                            </div><!-- /.box -->
<?php


}
}

 //eliminar

     if (isset($_GET['eliminar'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['eliminar'])) {
                           

$nombre=trim(strtoupper($_POST["nombre"]));
$apellido=trim(strtoupper($_POST["apellido"]));
$correo=trim(strtoupper($_POST["correo"]));
$nivel=trim(strtoupper($_POST["nivel"]));
$pass=trim($_POST["pw"]);
$pass=md5($pass);
$usuario=trim(strtoupper($_POST["usuario"]));
$sucursal=trim(strtoupper($_POST["sucursal"]));

                       
if( $nombre=="" )
                {


$sql="UPDATE administrador SET estado='INACTIVO' WHERE id='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se dio de baja al usuario correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=administrador&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

                            ?>
<?php
///////////////------////////////

}
   
}


                                        
     $consulta="SELECT id, sucursales.nombre_suc, sucursales.id_sucursal, usuario, nombre, apellido, correo, nive_usua, estado, nive_usua, (CONCAT('NO SE HAGA EL LISTO JOVEN')) AS pass, CASE nive_usua
                                            WHEN 1 THEN 'ADMINISTRADOR'
                                            WHEN 2 THEN 'EMPLEADO'
                                            WHEN 3 THEN 'OTRO'
                                            END nive_usuar FROM administrador, sucursales WHERE id='$x1' AND estado='ACTIVO' AND administrador.id_sucursal=sucursales.id_sucursal";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Está a punto de darle de baja al usuario . . .";


                                echo '   </div>'; ?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Anular encargado</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=administrador&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                           
                                            <label for="exampleInputFile">Nombres <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir los nombres" value="<?php echo $fila['nombre']?>" disabled>

                                            <label for="exampleInputFile">Apellidos <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="apellido" class="form-control faa-float animated-hover" pattern='.{2,30}' maxlength="30" id="exampleInputEmail1" placeholder="Introducir los apellidos" value="<?php echo $fila['apellido']?>" disabled>

                                             <label for="exampleInputFile">Usuario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (5-20) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (5-20)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="usuario" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,20}' maxlength="20" placeholder="Introducir el nombre de usuario" value="<?php echo $fila['usuario']?>" disabled>

                                            <label for="exampleInputFile">Clave <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (8-32) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (8-32)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" required type="password" name="pw" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{8,32}' maxlength="32" placeholder="Introducir la contraseña" value="<?php echo $fila['pass']?>" disabled>

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" required type="email" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico" value="<?php echo $fila['correo'] ?>" disabled>

                                            <label for="exampleInputFile">Sucursal <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal." onclick="Swal.fire({title:'<h2>Por favor seleccione una sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="sucursal" required>
                                                  <option class="btn-danger" value="<?php echo $fila['id_sucursal'] ?>">SUCURSAL ACTUAL: <?php echo $fila['nombre_suc'] ?></option>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_suc)): ?>
                                                  <option class="btn-primary" value="<?php echo $SUC['id_sucursal'] ?>" disabled><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Nivel de usuario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un nivel de usuario." onclick="Swal.fire({title:'<h2>Por favor seleccione un nivel de usuario</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='nivel' required>
                                                  <option class="btn-danger" value="<?php echo $fila['nive_usua'] ?>">NIVEL ACTUAL: <?php echo $fila['nive_usuar'] ?></option>
                                                  <option class="btn-primary" value="1" disabled>1 - ADMINISTRADOR  ( Acceso a todas las sucursales )</option>
                                                  <option class="btn-primary" value="2" disabled>2 - EMPLEADO  ( Acceso a la sucursal actual )</option>
                                                </select>
                                           
                                        </div>
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Anular encargado">
                                        
                                    </div></center>
                                </form>
                            </div><!-- /.box -->
<?php

}

}

if (isset($_GET['consultar'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['consultar'])) {
                           

   
}


                                        
     $consulta="SELECT usuario, (CONCAT(apellido,', ',nombre)) AS trabajador, correo, (CONCAT(nombre_suc,' (',nombre_depa,', ',nombre_provi,', ',nombre_dist,')')) AS sucursal, estado, CASE nive_usua
                                            WHEN 1 THEN 'ADMINISTRADOR'
                                            WHEN 2 THEN 'EMPLEADO'
                                            WHEN 3 THEN 'OTRO'
                                            END nive_usua FROM administrador, sucursales, departamentos, provincias, distritos WHERE id='$x1' AND administrador.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND provincias.id_departamento=departamentos.id_departamento AND distritos.id_provincia=provincias.id_provincia";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta de encargados</h3>
                                </div>
                                <?php  

                                  if($fila['estado']=='ACTIVO')
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/activo.png' width='50%' height='80'></img></td></center>";
                                    } 
                                  else
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/inactivo.png' width='45%' height='60'></img></td></center>";
                                    } ?>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=administrador&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                           
                                            <center>
                                             <table id="example1" class="table table-bordered table-striped">
                                            <tr><td>
                                            <h3 class='faa-float animated-hover'> Nombre de usuario</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['usuario'] ?></td></tr>
                                          <tr>
                                          <td>
                                            <h3 class='faa-float animated-hover'> Apellidos y nombres</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['trabajador'] ?></td>
                                          </tr>
                                          <tr>
                                          <td>
                                            <h3 class='faa-float animated-hover'> Correo electrónico</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['correo'] ?></td></tr>
                                          <tr>
                                          <td>
                                            <h3 class='faa-float animated-hover'> Nivel de usuario</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['nive_usua'] ?></td></tr>
                                           <tr>
                                          <td>
                                            <h3 class='faa-float animated-hover'> Sucursal (Ubicación)</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['sucursal'] ?></td></tr>
                                          
                                            
                                                </table>
               
  </center>
                                        </div>
                                       
                                     
                                        
                                    </div><!-- /.box-body -->

                                </form>
                            </div><!-- /.box -->
                            </center>



<?php



                                echo '
  <div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=administrador&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  ';  ?>
                            
    
<?php

}

}
?>