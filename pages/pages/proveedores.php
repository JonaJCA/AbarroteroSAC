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

 
require ('validarnum.php');
include './inc/config.php';
$servidor="localhost";
$basedatos="hwpaziid_abarrotero";
$usuario="hwpaziid";
$pass="OKfz43Ng+h3+L3";

$conn=mysqli_connect("$servidor","$usuario","$pass","$basedatos");
$fecha2=date("Y-m-d");  	

$query = "SELECT id_departamento, nombre_depa FROM departamentos ORDER BY nombre_depa";
    $resultado=mysqli_query($conn,$query);

//$buscar_provincia = "SELECT id_provincia, nombre_provi FROM provincias ORDER BY nombre_provi";
//$resultado_provincia = mysqli_query($conn,$buscar_provincia);

//$buscar_distritos = "SELECT id_distrito, nombre_dist FROM distritos ORDER BY nombre_dist";
//$resultado_distritos = mysqli_query($conn,$buscar_distritos);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {

$departamento=trim(strtoupper($_POST["departamento"]));
$provincia=trim(strtoupper($_POST["provincia"]));
$distrito=trim(strtoupper($_POST["distrito"]));
$ruc=trim($_POST["ruc"]);
$nombre=trim(strtoupper($_POST["nombre"]));
$direccion=trim(strtoupper($_POST["direccion"]));
$telefono=trim($_POST["telefono"]);
$registro=trim(strtoupper($_POST["registro"]));


if($_POST['dni']!=null){
        $dni = trim(strtoupper($_POST['dni']));
    }else{
        $dni = null;
    }

if($_POST['email']!=null){
        $email = trim(strtoupper($_POST['email']));
    }else{
        $email= null;
    } 

if($_POST['observacion']!=null){
        $observacion = trim(strtoupper($_POST['observacion']));
    }else{
        $observacion = null;
    }

$sql="select * from proveedores where nombre_prov='$nombre' AND ruc_prov='$ruc'"; 

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){

$sql2="INSERT INTO `proveedores`(`id_departamento`, `id_provincia`, `id_distrito`, `ruc_prov`, `dni_prov`, `nombre_prov`, `direccion_prov`, `telefono_prov`, `email_prov`, `registro_prov`, `observacion_prov`) VALUES ('$departamento','$provincia','$distrito', '$ruc', '$dni', '$nombre', '$direccion', '$telefono', '$email', '$fecha2', '$observacion')";

                          $cs=$bd->consulta($sql2);

                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el proveedor nuevo correctamente.';

                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=proveedores&lista" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró este proveedor!</b> Ya existe . . . ';

                               echo '   </div>';
}

}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar proveedor</h3>
                                </div>
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=proveedores&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                                                                       
                                            <label for="exampleInputFile">Nombre del proveedor <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el nombre del proveedor" pattern='.{2,30}' maxlength="30" autofocus>
                                            
                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeydown="return enteros(this, event)" onblur="this.value=this.value.toUpperCase();" min='10000000000' max='29999999999' step='1' type="number" required name="ruc" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el RUC" pattern='.{11,11}' maxlength="11">

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el número de DNI" pattern='.{8,8}' maxlength="8">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" required type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono">

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="email" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico">

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

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputEmail1" placeholder="Intoducir la dirección">

                                            <label for="exampleInputFile">Observaciones <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-500) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-500)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <textarea onkeypress="return off(event)" rows="6" onblur="this.value=this.value.toUpperCase();" type="text" name="observacion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,500}' maxlength="500" placeholder="Introducir observación"></textarea>  

                                         </div>
                                        
                                    </div><!-- /.box-body -->
                                    <center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar proveedor</button>
                                        
                                    
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
                                    <h3 class="box-title">PROVEEDORES | Lista de abastecedores</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>  
                                                <th>Registro</th>
                                                <th>Proveedor</th>
                                                <th>RUC</th>
                                                <th>Teléfono</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT id_proveedor ,DATE_FORMAT(registro_prov, '%d/%m/%Y') AS REGISTRO, (proveedores.nombre_prov) AS NOMBRE, (proveedores.ruc_prov) AS RUC, (proveedores.telefono_prov) AS TELEFONO FROM proveedores ORDER BY REGISTRO DESC ";

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
                                                             $fila[REGISTRO]                                   
                                                        </td>
                                                        <td>
                                                              $fila[NOMBRE]
                                                        </td>
                                                         <td>
                                                              $fila[RUC]
                                                        </td>
                                                        <td>  
                                                              $fila[TELEFONO]
                                                        </td>
                                                         
                                                        <td><center>
                                                            ";
      
echo"
       <a  href=?mod=proveedores&consultar&codigo=".$fila["id_proveedor"]."><img src='./img/consul.png' width='25' alt='Edicion' class='faa-float animated-hover' title='CONSULTAR LOS DATOS DEL PROVEEDOR ".$fila["NOMBRE"]."'></a> ";
       if($tipo2==1){
                                echo "
      
      <a  href=?mod=proveedores&editar&codigo=".$fila["id_proveedor"]."><img src='./img/editar.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL PROVEEDOR ".$fila["NOMBRE"]."'></a> 
      <a   href=?mod=proveedores&eliminar&codigo=".$fila["id_proveedor"]."><img src='./img/elimina.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR AL PROVEEDOR ".$fila["NOMBRE"]."'></a>
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
                                    <h3> <center>Registrar proveedor<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=proveedores&nuevo" method="post" id="ContactForm">

 <input title="AGREGAR UN NUEVO PROVEEDOR" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">
    
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
                                   <h3> <center>Lista de abastecedores</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Todos los proveedores  <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una opción para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de todos los proveedores</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_proveedor" onchange="if(this.value=='Seleccione una opción para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una opción para exportar</option>
                                                <option class="btn-primary" value='./pdf/lista_proveedor.php'>TODOS LOS PROVEEDORES</option>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/proveedores.gif" width="100%" height="200px" title="No pierda el contacto de sus proveedores"><br><br>

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
                           
$departamento=trim(strtoupper($_POST["departamento"]));
$provincia=trim(strtoupper($_POST["provincia"]));
$distrito=trim(strtoupper($_POST["distrito"]));
$ruc=trim($_POST["ruc"]);
$nombre=trim(strtoupper($_POST["nombre"]));
$direccion=trim(strtoupper($_POST["direccion"]));
$telefono=trim($_POST["telefono"]);
$registro=trim(strtoupper($_POST["registro"]));


if($_POST['dni']!=null){
        $dni = trim(strtoupper($_POST['dni']));
    }else{
        $dni = null;
    }

if($_POST['email']!=null){
        $email = trim(strtoupper($_POST['email']));
    }else{
        $email= null;
    } 

if($_POST['observacion']!=null){
        $observacion = trim(strtoupper($_POST['observacion']));
    }else{
        $observacion = null;
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

$sql22=" UPDATE proveedores SET 
id_departamento='$departamento' ,
id_provincia='$provincia' ,
id_distrito='$distrito' ,
ruc_prov='$ruc', 
dni_prov='$dni',
nombre_prov='$nombre',
direccion_prov='$direccion',
telefono_prov='$telefono',
email_prov='$email',
observacion_prov='$observacion'
 where id_proveedor='$x1'";
 
$bd->consulta($sql22);
   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                        echo " Se actualizaron los datos del proveedor '$nombre' correctamente.";                                        

                               echo '   </div>';

echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=proveedores&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

                           
}
   
}

     $consulta="SELECT proveedores.id_proveedor, ruc_prov, dni_prov, nombre_prov, direccion_prov, telefono_prov, email_prov, observacion_prov, ruc_prov, nombre_provi, nombre_depa, nombre_dist, proveedores.id_departamento, proveedores.id_provincia, proveedores.id_distrito FROM proveedores, departamentos, provincias, distritos WHERE id_proveedor='$x1' AND proveedores.id_departamento=departamentos.id_departamento AND proveedores.id_provincia=provincias.id_provincia AND proveedores.id_distrito=distritos.id_distrito";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar proveedor </h3>
                                </div>
                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=proveedores&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                               
                                            <label for="exampleInputFile">Nombre del proveedor <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el nombre del proveedor" pattern='.{2,30}' maxlength="30" value="<?php echo $fila['nombre_prov']?>" autofocus>
                                            
                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeydown="return enteros(this, event)" onblur="this.value=this.value.toUpperCase();" min='10000000000' max='29999999999' step='1' required type="number" name="ruc" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el RUC" pattern='.{11,11}' maxlength="11" value="<?php echo $fila['ruc_prov']?>">

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el número de DNI" pattern='.{8,8}' maxlength="8" value="<?php if($fila['dni_prov']=='0') { echo "";} else echo $fila['dni_prov'] ?>">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" required type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono" value="<?php echo $fila['telefono_prov']?>">

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="email" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico" value="<?php echo $fila['email_prov']?>">

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

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputEmail1" placeholder="Intoducir la dirección" value="<?php if($fila['direccion_prov']=='') { echo "";} else echo $fila['direccion_prov'] ?>">

                                            <label for="exampleInputFile">Observaciones <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-500) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-500)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <textarea onkeypress="return off(event)" rows="6" onblur="this.value=this.value.toUpperCase();" type="text" name="observacion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,500}' maxlength="500" placeholder="Introducir observación" value="<?php echo $fila['observacion_prov']?>"><?php echo $fila['observacion_prov']?></textarea>  

                                            
                                        </div>
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <center><button type="submit" class="btn btn-primary btn-lg" name="editar" id="editar" value="Editar">Actualizar datos</button></center>      
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
                           
$departamento=trim(strtoupper($_POST["departamento"]));
$provincia=trim(strtoupper($_POST["provincia"]));
$distrito=trim(strtoupper($_POST["distrito"]));
$ruc=trim($_POST["ruc"]);
$nombre=trim(strtoupper($_POST["nombre"]));
$direccion=trim(strtoupper($_POST["direccion"]));
$telefono=trim($_POST["telefono"]);
$registro=trim(strtoupper($_POST["registro"]));


if($_POST['dni']!=null){
        $dni = trim(strtoupper($_POST['dni']));
    }else{
        $dni = null;
    }

if($_POST['email']!=null){
        $email = trim(strtoupper($_POST['email']));
    }else{
        $email= null;
    } 

if($_POST['observacion']!=null){
        $observacion = trim(strtoupper($_POST['observacion']));
    }else{
        $observacion = null;
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

$sql="delete from proveedores where id_proveedor='$x1' ";

$bd->consulta($sql);
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se eliminó el proveedor correctamente.';

                               echo '   </div>';

                                echo '
  <div class="col-md-12">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=proveedores&lista" method="post" id="ContactForm">

 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  ';         

}
   
}
                                        
     $consulta="SELECT proveedores.id_proveedor, ruc_prov, dni_prov, nombre_prov, direccion_prov, telefono_prov, email_prov, observacion_prov, ruc_prov, nombre_provi, nombre_depa, nombre_dist, proveedores.id_departamento, proveedores.id_provincia, proveedores.id_distrito FROM proveedores, departamentos, provincias, distritos WHERE id_proveedor='$x1' AND proveedores.id_departamento=departamentos.id_departamento AND proveedores.id_provincia=provincias.id_provincia AND proveedores.id_distrito=distritos.id_distrito";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {


?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Para borrar un proveedor no debe tener operaciones . . .";


                                echo '   </div>'; ?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar proveedor</h3>
                                </div>                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=proveedores&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                               
                                            <label for="exampleInputFile">Nombre del proveedor <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el nombre del proveedor" pattern='.{2,30}' maxlength="30" value="<?php echo $fila['nombre_prov']?>" disabled>
                                            
                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeydown="return enteros(this, event)" onblur="this.value=this.value.toUpperCase();" type="number" required type="text" name="ruc" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el RUC" pattern='.{11,11}' maxlength="11" value="<?php echo $fila['ruc_prov']?>" disabled>

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="Intoducir el número de DNI" pattern='.{8,8}' maxlength="8" value="<?php if($fila['dni_prov']=='0') { echo "SIN REGISTRO";} else echo $fila['dni_prov'] ?>" disabled>

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" required type="text" name="telefono" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono" value="<?php echo $fila['telefono_prov']?>" disabled>

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico" value="<?php if($fila['email_prov']=='') { echo "SIN CORREO";} else echo $fila['email_prov'] ?>" disabled>

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

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" pattern='.{5,100}' maxlength="100" id="exampleInputEmail1" placeholder="Intoducir la dirección" value="<?php if($fila['direccion_prov']=='') { echo "SIN DIRECCIÓN";} else echo $fila['direccion_prov'] ?>" disabled>

                                            <label for="exampleInputFile">Observaciones <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-500) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-500)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <textarea onkeypress="return off(event)" rows="6" onblur="this.value=this.value.toUpperCase();" type="text" name="observacion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,500}' maxlength="500" placeholder="Introducir observación" value="<?php if($fila['observacion_prov']=='') { echo "SIN OBSERVACIONES";} else echo $fila['observacion_prov'] ?>" disabled><?php if($fila['observacion_prov']=='') { echo "SIN OBSERVACIONES";} else echo $fila['observacion_prov'] ?></textarea>  

                                    <div class="box-footer"><center>
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Eliminar proveedor"></center>

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


                                        
     $consulta="SELECT proveedores.id_proveedor, (CONCAT(nombre_depa,', ',nombre_provi,', ',nombre_dist)) AS ubicacion, ruc_prov, nombre_prov, telefono_prov, email_prov, ruc_prov, nombre_provi, nombre_depa, nombre_dist, proveedores.id_departamento, proveedores.id_provincia, proveedores.id_distrito, (COALESCE(CASE email_prov 
        WHEN '' THEN 'SIN CORREO' 
        ELSE email_prov 
        END,'SIN CORREO')) AS email_prov, (COALESCE(CASE dni_prov 
        WHEN '0' THEN 'SIN REGISTRO' 
        ELSE dni_prov 
        END,'SIN REGISTRO')) AS dni_prov, (COALESCE(CASE direccion_prov 
        WHEN '' THEN 'SIN DIRECCIÓN' 
        ELSE direccion_prov 
        END,'SIN DIRECCIÓN')) AS direccion_prov, (COALESCE(CASE observacion_prov 
        WHEN '' THEN 'SIN OBSERVACIONES' 
        ELSE observacion_prov 
        END,'SIN OBSERVACIONES')) AS observacion_prov, DATE_FORMAT(registro_prov, '%d/%m/%Y') AS REGISTRO FROM proveedores, departamentos, provincias, distritos WHERE id_proveedor='$x1' AND proveedores.id_departamento=departamentos.id_departamento AND proveedores.id_provincia=provincias.id_provincia AND proveedores.id_distrito=distritos.id_distrito";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>
<center>
  <div class="col-md-9">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del proveedor</h3>
                                </div>                               
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=proveedores&eliminar=eliminar&codigo='.$x1.'" method="post">';
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
                                            <h3 class='faa-float animated-hover'> Nombre del proveedor</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['nombre_prov'] ?></td></tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Identificación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo 'RUC: '.$fila['ruc_prov'] ?><br>
                                         <?php echo 'DNI: '.$fila['dni_prov'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Contacto</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo 'TELÉFONO: '.$fila['telefono_prov'] ?><br>
                                         <?php echo 'CORREO ELECTRÓNICO: '.$fila['email_prov'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Dirección</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['direccion_prov'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Ubicación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['ubicacion'] ?></td>
                                         </tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Observación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['observacion_prov'] ?></td>
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
                            <form  name="fe" action="?mod=proveedores&lista" method="post" id="ContactForm">
    


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