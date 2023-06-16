<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");
?>

<script language="javascript" src="js/jquery-3.1.1.min.js"></script>
        
        <script language="javascript">
            $(document).ready(function(){
                $("#cbx_departamento").change(function () {

                    $('#cbx_distrito').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
                    
                    $("#cbx_departamento option:selected").each(function () {
                        id_departamento = $(this).val();
                        $.post("includes/getMunicipio.php", { id_departamento: id_departamento }, function(data){
                            $("#cbx_provincia").html(data);
                        });            
                    });
                })
            });
            
            $(document).ready(function(){
                $("#cbx_provincia").change(function () {
                    $("#cbx_provincia option:selected").each(function () {
                        id_provincia = $(this).val();
                        $.post("includes/getLocalidad.php", { id_provincia: id_provincia }, function(data){
                            $("#cbx_distrito").html(data);
                        });            
                    });
                })
            });
</script>

<?php

include './inc/config.php';
//$servidor="localhost";
//$basedatos="hwpaziid_abarrotero";
//$usuario="hwpaziid";
//$pass="OKfz43Ng+h3+L3";

require ('validarnum.php');

$conn=mysqli_connect("$servidor","$usuario","$pass","$basedatos");
$fecha2=date("Y-m-d");  	

$query = "SELECT id_departamento, nombre_depa FROM departamentos ORDER BY nombre_depa";
    $resultado=mysqli_query($conn,$query);

$buscar_sucursal = "SELECT id_sucursal, nombre_suc FROM sucursales ORDER BY nombre_suc";
$resultado_sucur = mysqli_query($conn,$buscar_sucursal);

$buscar_imp_cli = "SELECT clientes.id_sucursal, nombre_suc FROM sucursales, clientes WHERE condicion_suc = 'ACTIVO' AND clientes.id_sucursal=sucursales.id_sucursal GROUP BY nombre_suc ORDER BY nombre_suc; ";
$resultado_imp_cli = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_cli);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {

$sucursal=trim(strtoupper($_POST["sucursal"]));
$departamento=trim(strtoupper($_POST["departamento"]));
$provincia=trim(strtoupper($_POST["provincia"]));
$distrito=trim(strtoupper($_POST["distrito"]));
$nombre=trim(strtoupper($_POST["nombre"]));
$telefono=trim($_POST["telefono"]);
$ruc=trim($_POST["ruc"]);
$direccion=trim(strtoupper($_POST["direccion"]));

if($_POST['dni']!=null){
        $dni = trim($_POST['dni']);
    }else{
        $dni = null;
    }

if($_POST['correo']!=null){
        $correo = trim($_POST['correo']);
    }else{
        $correo= null;
    }  

if($_POST['direccion2']!=null){
        $direccion2 = trim($_POST['direccion2']);
    }else{
        $direccion2= null;
    } 


$sql="select * from clientes WHERE nombre_cli='$nombre' AND id_sucursal='$sucursal' AND id_departamento='$departamento' AND id_provincia='$provincia' AND id_distrito='$distrito' AND telefono_cli='$telefono' AND ruc_cli='$ruc' AND direccion_cli1='$direccion' "; 

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){

$sql2="INSERT INTO `clientes`(`id_sucursal`, `id_departamento`, `id_provincia`, `id_distrito`, `nombre_cli`, `telefono_cli`, `dni_cli`, `ruc_cli`, `direccion_cli1`, `direccion_cli2`, `email_cli`, `registro_cli`) VALUES ('$sucursal','$departamento','$provincia','$distrito','$nombre','$telefono','$dni', '$ruc', '$direccion', '$direccion2', '$correo', '$fecha2')";

                          $cs=$bd->consulta($sql2);

                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el cliente nuevo correctamente.';

                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=clientes&lista" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró este cliente!</b> Ya existe . . .';


                               echo '   </div>';
}

}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar cliente</h3>
                                </div>
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=clientes&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                                                                       
                                            <label for="exampleInputFile">Razón social <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la razón social" pattern='.{5,50}' maxlength="50" autofocus>

                                            <label for="exampleInputFile">Lugar de cobranza ( Sucursal ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un lugar de cobranza." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar un lugar de cobranza</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=sucursales&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=sucursales&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione un lugar de cobranza</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="sucursal" required>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_sucur)): ?>
                                                    <option class="btn-primary" value="<?php echo $SUC['id_sucursal'] ?>"><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                            
                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeydown="return enteros(this, event)" onblur="this.value=this.value.toUpperCase();" min='10000000000' max='29999999999' step='1' type="number" required name="ruc" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el RUC" pattern='.{11,12}' maxlength="11">

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número de DNI" pattern='.{8,9}' maxlength="8">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" required type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputcorreo1" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono">

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="correo" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico">

                                            <label for="exampleInputFile">Departamento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un departamento." onclick="Swal.fire({title:'<h2>Por favor seleccione un departamento</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="departamento" id="cbx_departamento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='0'>Seleccionar departamento . . .</option>
                                                <?php while($row = $resultado->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $row['id_departamento']; ?>"><?php echo $row['nombre_depa']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Provincia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una provincia." onclick="Swal.fire({title:'<h2>Por favor seleccione una provincia</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="provincia" id="cbx_provincia" data-show-subtext="true" data-live-search="true" required>               
                                            </select>

                                            <label for="exampleInputFile">Distrito <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un distrito." onclick="Swal.fire({title:'<h2>Por favor seleccione un distrito</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="distrito" id="cbx_distrito" data-show-subtext="true" data-live-search="true" required>
                                            </select>

                                            <label for="exampleInputFile">Dirección #1 <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputcorreo1" placeholder="Introducir la dirección" required>

                                            <label for="exampleInputFile">Dirección #2 <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion2" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputcorreo1" placeholder="Introducir la dirección">

                                         </div>
                                        
                                    </div><!-- /.box-body -->
                                    <center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar cliente</button>                              
                                    
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
                                    <h3 class="box-title">CLIENTES | Nuestra fuente de ingresos</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>  
                                                <th>Razón social</th>
                                                <th>RUC</th>
                                                <th>DNI</th>
                                                <th>Teléfono</th>
                                                <th>Cobranza</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT id_cliente, DATE_FORMAT(registro_cli, '%d/%m/%Y') AS REGISTRO, CONCAT(nombre_cli) AS CLIENTE, ruc_cli, (COALESCE(CASE dni_cli WHEN '0' THEN 'SIN REGISTRO'  ELSE dni_cli END,'SIN REGISTRO')) AS dni_cli, (COALESCE(CASE telefono_cli WHEN '0' THEN 'SIN TELÉFONO' ELSE telefono_cli END,'SIN TELÉFONO')) AS telefono_cli, nombre_suc FROM clientes, sucursales WHERE clientes.id_sucursal=sucursales.id_sucursal ORDER BY REGISTRO ASC";

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
                                                            $fila[CLIENTE]                        
                                                        </td>
                                                        <td>
                                                            $fila[ruc_cli]
                                                        </td>
                                                        <td>
                                                            $fila[dni_cli]
                                                        </td>
                                                        <td>
                                                            $fila[telefono_cli]
                                                        </td>
                                                        <td>  
                                                            $fila[nombre_suc]
                                                        </td>
                                                        <td><center>
                                                            ";
      
echo"
       <a  href=?mod=clientes&consultar&codigo=".$fila["id_cliente"]."><img src='./img/consul.png' width='25' alt='Edicion' class='faa-float animated-hover' title='CONSULTAR LOS DATOS DEL CLIENTE ".$fila["CLIENTE"]."'></a> ";
 
 if ($tipo2=='1') {
                                echo "
      
      <a  href=?mod=clientes&editar&codigo=".$fila["id_cliente"]."><img src='./img/editar.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL CLIENTE ".$fila["CLIENTE"]."'></a> 
      <a   href=?mod=clientes&eliminar&codigo=".$fila["id_cliente"]."><img src='./img/elimina.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR AL CLIENTE ".$fila["CLIENTE"]."'></a>
      ";
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
if($tipo2==1){
                                echo '
  <div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Agregar cliente<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=clientes&nuevo" method="post" id="ContactForm">

 <input title="AGREGAR UN NUEVO CLIENTE" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">
    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  '; 

                            } ?>
</br>       
                                
<div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <center>
                                <div class="box-header">
                                   <h3> <center>Imprimir listado</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Lugar de cobranza <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un lugar de cobranza para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de clientes por lugar de cobranza</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_admin" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($CLI = mysqli_fetch_assoc($resultado_imp_cli)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_cliente.php?id_sucursal=<?php echo $CLI['id_sucursal']?>&nombre_suc=<?php echo $CLI['nombre_suc']?>'><?php echo $CLI['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/clientes.gif" width="100%" height="200px" title="Cuide su fuente de ingresos"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>

                          
<?php
}

     

     if (isset($_GET['editar'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['editar'])) {
                           
$sucursal=trim(strtoupper($_POST["sucursal"]));
$departamento=trim(strtoupper($_POST["departamento"]));
$provincia=trim(strtoupper($_POST["provincia"]));
$distrito=trim(strtoupper($_POST["distrito"]));
$nombre=trim(strtoupper($_POST["nombre"]));
$telefono=trim($_POST["telefono"]);
$ruc=trim($_POST["ruc"]);
$direccion=trim(strtoupper($_POST["direccion"]));

if($_POST['dni']!=null){
        $dni = trim($_POST['dni']);
    }else{
        $dni = null;
    }

if($_POST['correo']!=null){
        $correo = trim($_POST['correo']);
    }else{
        $correo= null;
    }

if($_POST['direccion2']!=null){
        $direccion2 = trim($_POST['direccion2']);
    }else{
        $direccion2= null;
    }     
                       
if( $nombre=="" )
                {
                
                    echo "
   <script> alert('Campos vacíos')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {

$sql22="UPDATE clientes SET 
id_sucursal='$sucursal',
id_departamento='$departamento',
id_provincia='$provincia',
id_distrito='$distrito',
nombre_cli='$nombre' ,
telefono_cli='$telefono',
dni_cli='$dni',
ruc_cli='$ruc',
direccion_cli1='$direccion', 
direccion_cli2='$direccion2',
email_cli='$correo'
where id_cliente='$x1'";

 
$bd->consulta($sql22);
   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                        echo " Se actualizaron los datos del cliente '$nombre' correctamente.";

                               echo '   </div>';

echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=clientes&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

                           
}
   
}
                                        
     $consulta="SELECT (clientes.id_cliente) AS CODIGO, clientes.id_departamento, clientes.id_provincia, clientes.id_distrito, nombre_depa, nombre_provi, nombre_dist, (clientes.nombre_cli) AS NOMBRE, (clientes.ruc_cli) AS RUC, (clientes.dni_cli) AS DNI, (clientes.direccion_cli1) AS DIRECCION, clientes.direccion_cli2, (clientes.telefono_cli) AS TELEFONO, (sucursales.nombre_suc) AS LUGAR2,(clientes.email_cli) AS CORREO, clientes.id_sucursal, (sucursales.nombre_suc) AS LUGAR FROM clientes, sucursales, departamentos, provincias, distritos WHERE clientes.id_sucursal=sucursales.id_sucursal AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito  AND id_cliente='$x1'";
     $bd->consulta($consulta);

     while ($fila=$bd->mostrar_registros()) {

?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar cliente </h3>
                                </div>
                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=clientes&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                               
                                            <label for="exampleInputFile">Razón social <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la razón social" pattern='.{5,50}' maxlength="50" value="<?php echo $fila['NOMBRE']?>">

                                            <label for="exampleInputFile">Lugar de cobranza ( Sucursal ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar un lugar de cobranza</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=sucursales&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=sucursales&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione un lugar de cobranza</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="sucursal" required>
                                                <option class="btn-danger" value="<?php echo $fila['id_sucursal']?>">ACTUAL: <?php echo $fila['LUGAR2']?></option>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_sucur)): ?>
                                                    <option class="btn-primary" value="<?php echo $SUC['id_sucursal'] ?>"><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                            
                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeydown="return enteros(this, event)" onblur="this.value=this.value.toUpperCase();" type="number" required type="text" name="ruc" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el RUC" pattern='.{11,12}' maxlength="11" min='10000000000' max='29999999999' step='1' value="<?php echo $fila['RUC']?>">

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número de DNI" pattern='.{8,9}' maxlength="8" value="<?php if($fila['DNI']=='0') { echo "";} else echo $fila['DNI'] ?>">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" required type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputcorreo1" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono" value="<?php echo $fila['TELEFONO']?>">

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="correo" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico" value="<?php echo $fila['CORREO']?>">

                                            <label for="exampleInputFile">Departamento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un departamento." onclick="Swal.fire({title:'<h2>Por favor seleccione un departamento</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="departamento" id="cbx_departamento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['id_departamento']; ?>'>ACTUAL: <?php echo $fila['nombre_depa']; ?></option>
                                                <?php while($row = $resultado->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $row['id_departamento']; ?>"><?php echo $row['nombre_depa']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Provincia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una provincia." onclick="Swal.fire({title:'<h2>Por favor seleccione una provincia</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="provincia" id="cbx_provincia" data-show-subtext="true" data-live-search="true" required> 
                                            <option class='btn-danger' value='<?php echo $fila['id_provincia']; ?>'>ACTUAL: <?php echo $fila['nombre_provi']; ?></option>              
                                            </select>

                                            <label for="exampleInputFile">Distrito <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un distrito." onclick="Swal.fire({title:'<h2>Por favor seleccione un distrito</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="distrito" id="cbx_distrito" data-show-subtext="true" data-live-search="true" required>
                                                <option class='btn-danger' value='<?php echo $fila['id_distrito']; ?>'>ACTUAL: <?php echo $fila['nombre_dist']; ?></option>
                                            </select>

                                            <label for="exampleInputFile">Dirección #1 <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputcorreo1" placeholder="Introducir la dirección" value="<?php echo $fila['DIRECCION']?>" required>

                                            <label for="exampleInputFile">Dirección #2 <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion2" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputcorreo1" placeholder="Introducir la dirección" value="<?php echo $fila['direccion_cli2']?>">

                                                                                     
                                        </div>
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer"><center>
                                        <button type="submit" class="btn btn-primary btn-lg" name="editar" id="editar" value="Editar">Actualizar datos</button></center>
                                    </div>
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
                           
$sucursal=strtoupper($_POST["sucursal"]);
$departamento=strtoupper($_POST["departamento"]);
$provincia=strtoupper($_POST["provincia"]);            
$distrito=strtoupper($_POST["distrito"]);                         
$nombre=strtoupper($_POST["nombre"]);
$telefono=$_POST["telefono"];
$ruc=$_POST["ruc"];
$direccion=strtoupper($_POST["direccion"]);

if($_POST['dni']!=null){
        $dni = $_POST['dni'] ;
    }else{
        $dni = null;
    }

if($_POST['correo']!=null){
        $correo = $_POST['correo'] ;
    }else{
        $correo= null;
    }  

if($_POST['direccion2']!=null){
        $direccion2 = trim($_POST['direccion2']);
    }else{
        $direccion2= null;
    } 

if( $x1=="" )
                {
                
                    echo "
   <script> alert('error')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {

$sql="delete from clientes where id_cliente='$x1' ";

$bd->consulta($sql);
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se eliminó el cliente correctamente.';

                               echo '   </div>';

                                echo '
  <div class="col-md-12">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=clientes&lista" method="post" id="ContactForm">

 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  ';         

}
   
}
                                        
     $consulta="SELECT clientes.id_sucursal, (clientes.id_cliente) AS CODIGO, clientes.id_departamento, clientes.id_provincia, clientes.id_distrito, nombre_depa, nombre_provi, nombre_dist, (clientes.nombre_cli) AS NOMBRE, (clientes.ruc_cli) AS RUC, (clientes.dni_cli) AS DNI, (clientes.direccion_cli1) AS DIRECCION, direccion_cli2, (clientes.telefono_cli) AS TELEFONO, (sucursales.nombre_suc) AS LUGAR2,(clientes.email_cli) AS CORREO, (sucursales.nombre_suc) AS LUGAR FROM clientes, sucursales, departamentos, provincias, distritos WHERE clientes.id_sucursal=sucursales.id_sucursal AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito  AND id_cliente='$x1'";
     $bd->consulta($consulta);

     while ($fila=$bd->mostrar_registros()) {



?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Para borrar un cliente no debe tener operaciones . . .";


                                echo '   </div>'; ?>

  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar cliente</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=clientes&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                               
                                            <label for="exampleInputFile">Razón social <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la razón social" pattern='.{5,50}' maxlength="50" value="<?php echo $fila['NOMBRE']?>" disabled>

                                            <label for="exampleInputFile">Lugar de cobranza ( Sucursal ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal." onclick="Swal.fire({title:'<h2>Por favor seleccione una sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="sucursal" required>
                                                <option class="btn-danger" value="<?php echo $fila['id_sucursal']?>">ACTUAL: <?php echo $fila['LUGAR2']?></option>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_sucur)): ?>
                                                    <option class="btn-primary" value="<?php echo $SUC['id_sucursal'] ?>" disabled><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                            
                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeydown="return enteros(this, event)" onblur="this.value=this.value.toUpperCase();" type="number" required type="text" name="ruc" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el RUC" pattern='.{11,12}' maxlength="11" value="<?php echo $fila['RUC']?>" disabled>

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número de DNI" pattern='.{8,9}' maxlength="8" value="<?php if($fila['DNI']=='0') { echo "SIN REGISTRO";} else echo $fila['DNI'] ?>" disabled>

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" required type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputcorreo1" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono" value="<?php echo $fila['TELEFONO']?>" disabled>

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico" value="<?php if($fila['CORREO']=='') { echo "SIN CORREO";} else echo $fila['CORREO'] ?>" disabled>

                                            <label for="exampleInputFile">Departamento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un departamento." onclick="Swal.fire({title:'<h2>Por favor seleccione un departamento</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="departamento" id="cbx_departamento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['id_departamento']; ?>'>ACTUAL: <?php echo $fila['nombre_depa']; ?></option>
                                                <?php while($row = $resultado->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $row['id_departamento']; ?>" disabled><?php echo $row['nombre_depa']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Provincia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una provincia." onclick="Swal.fire({title:'<h2>Por favor seleccione una provincia</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="provincia" id="cbx_provincia" data-show-subtext="true" data-live-search="true" required> 
                                            <option class='btn-danger' value='<?php echo $fila['id_provincia']; ?>'>ACTUAL: <?php echo $fila['nombre_provi']; ?></option>              
                                            </select>

                                            <label for="exampleInputFile">Distrito <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un distrito." onclick="Swal.fire({title:'<h2>Por favor seleccione un distrito</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="distrito" id="cbx_distrito" data-show-subtext="true" data-live-search="true" required>
                                                <option class='btn-danger' value='<?php echo $fila['id_distrito']; ?>'>ACTUAL: <?php echo $fila['nombre_dist']; ?></option>
                                            </select>

                                            <label for="exampleInputFile">Dirección #1 <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputcorreo1" placeholder="Introducir la dirección" value="<?php echo $fila['DIRECCION']?>" disabled>

                                            <label for="exampleInputFile">Dirección #2 <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion2" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputcorreo1" placeholder="Introducir la dirección" value="<?php if($fila['direccion_cli2']=='') { echo "SIN SEGUNDA DIRECCIÓN REGISTRADA";} else echo $fila['direccion_cli2'] ?>" disabled>

                                                                                     
                                        </div>
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer"><center>
                                        <button type="submit" class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Eliminar">Eliminar cliente</button></center>
                                    </div>
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
                                    
     $consulta="SELECT DATE_FORMAT(registro_cli, '%d/%m/%Y') AS REGISTRO, (clientes.id_cliente) AS CODIGO, clientes.id_departamento, clientes.id_provincia, clientes.id_distrito, nombre_depa, nombre_provi, nombre_dist, (CONCAT(nombre_cli)) AS CLIENTE, (clientes.ruc_cli) AS RUC, (COALESCE(CASE direccion_cli1 
        WHEN '' THEN 'SIN DIRECCIÓN' 
        ELSE direccion_cli1 
        END,'SIN DIRECCIÓN')) AS direccion_cli1, (COALESCE(CASE direccion_cli2 
        WHEN '' THEN 'SIN SEGUNDA DIRECCIÓN REGISTRADA' 
        ELSE direccion_cli2
        END,'SIN SEGUNDA DIRECCIÓN REGISTRADA')) AS direccion_cli2, (clientes.telefono_cli) AS TELEFONO, (sucursales.nombre_suc) AS LUGAR2, (COALESCE(CASE email_cli 
        WHEN '' THEN 'SIN CORREO' 
        ELSE email_cli 
        END,'SIN CORREO')) AS CORREO, (sucursales.nombre_suc) AS LUGAR, (CONCAT(nombre_depa,', ',nombre_provi,', ',nombre_dist)) AS ubicacion, (COALESCE(CASE dni_cli 
        WHEN '0' THEN 'SIN REGISTRO' 
        ELSE dni_cli 
        END,'SIN REGISTRO')) AS DNI FROM clientes, sucursales, departamentos, provincias, distritos WHERE clientes.id_sucursal=sucursales.id_sucursal AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito  AND id_cliente='$x1'";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>
<center>
  <div class="col-md-9">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del cliente</h3>
                                </div>                               
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=clientes&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped">
                                            <td>
                                            <h3 class='faa-float animated-hover'> Fecha de registro</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['REGISTRO'] ?></td>
                                         </tr>
                                            <tr><td>
                                            <h3 class='faa-float animated-hover'> Razón social</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['CLIENTE'] ?></td></tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Lugar de cobranza</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['LUGAR2'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Identificación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo '<b>RUC:</b> '.$fila['RUC'] ?><br>
                                         <?php echo '<b>DNI:</b> '.$fila['DNI'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Contacto</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo '<b>TELÉFONO:</b> '.$fila['TELEFONO'] ?><br>
                                         <?php echo '<b>CORREO ELECTRÓNICO:</b> '.$fila['CORREO'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Dirección #1</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['direccion_cli1'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Dirección #2</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['direccion_cli2'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Ubicación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['ubicacion'] ?></td>
                                         </tr>
                                               
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
                            <form  name="fe" action="?mod=clientes&lista" method="post" id="ContactForm">

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

                            <?php

?>
