<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");
?>
<!--<script language="javascript" src="js/jquery-1.11.2.min.js"></script>
        <script>  
            $('.selectpicker').selectpicker({
                style: 'btn btn-file'
            });
        </script>-->
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
$fecha2=date("Y-m-d");  	

include './inc/config.php';
$servidor="localhost";
$basedatos="hwpaziid_abarrotero";
$usuario="hwpaziid";
$pass="OKfz43Ng+h3+L3";

$buscar_imp_suc = "SELECT condicion_suc FROM sucursales GROUP BY condicion_suc ";
$resultado_imp_suc = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_suc);

$conn=mysqli_connect("$servidor","$usuario","$pass","$basedatos");
$query = "SELECT id_departamento, nombre_depa FROM departamentos ORDER BY nombre_depa";
$resultado=mysqli_query($conn,$query);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {
                           
$nombre=trim(strtoupper($_POST["nombre"]));
$cbx_departamento=trim(strtoupper($_POST["cbx_departamento"]));
$cbx_provincia=trim(strtoupper($_POST["cbx_provincia"]));
$cbx_distrito=trim(strtoupper($_POST["cbx_distrito"]));
$direccion=trim(strtoupper($_POST["direccion"]));

if($_POST['telefono']!=null){
        $telefono = trim($_POST['telefono']);
    }else{
        $telefono = null;
    }

if($_POST['correo']!=null){
        $correo = trim(strtoupper($_POST['correo']));
    }else{
        $correo = null;
    }    

$sql="select * from sucursales where nombre_suc='$nombre' AND id_departamento='$cbx_departamento' AND id_provincia='$cbx_provincia' AND id_distrito='$cbx_distrito' AND direccion_suc='$direccion'";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){


$sql2="INSERT INTO `sucursales` ( `nombre_suc`, `id_departamento`, `id_provincia`, `id_distrito`, `direccion_suc`, `condicion_suc`, `telefono_suc`, `email_suc`) VALUES ('$nombre', '$cbx_departamento', '$cbx_provincia', '$cbx_distrito', '$direccion', 'ACTIVO', '$telefono', '$correo')";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró la sucursal nueva correctamente.';
                                        
                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=sucursales&lista" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró esta sucursal!</b> Ya existe . . . ';



                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar sucursal</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=sucursales&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Base <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{3,50}' maxlength="50" placeholder="Introducir el nombre de la sede" autofocus>

                                            <label for="exampleInputFile">Departamento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un departamento." onclick="Swal.fire({title:'<h2>Por favor seleccione un departamento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_departamento" id="cbx_departamento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='0'>Seleccionar departamento . . .</option>
                                                <?php while($row = $resultado->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $row['id_departamento']; ?>"><?php echo $row['nombre_depa']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Provincia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una provincia." onclick="Swal.fire({title:'<h2>Por favor seleccione una provincia</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_provincia" id="cbx_provincia" data-show-subtext="true" data-live-search="true" required>               
                                            </select>

                                            <label for="exampleInputFile">Distrito <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un distrito." onclick="Swal.fire({title:'<h2>Por favor seleccione un distrito</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_distrito" id="cbx_distrito" data-show-subtext="true" data-live-search="true" required>
                                            </select>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="direccion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la dirección">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de telefono">

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="email" name="correo" class="form-control faa-float animated-hover" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico">

                                        </div>
                                    </div><!-- /.box-body selectpicker -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar sucursal</button>
                                        
                                    
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
                                    <h3 class="box-title">SUCURSALES | Lista de sedes</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Base</th>
                                                <th class="faa-float animated-hover">Departamento</th>
                                                <th class="faa-float animated-hover">Provincia</th>
                                                <th class="faa-float animated-hover">Distrito</th>
                                                <th class="faa-float animated-hover">Condición</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT id_sucursal, nombre_suc, nombre_depa, nombre_provi, nombre_dist, telefono_suc, condicion_suc FROM sucursales, departamentos, provincias, distritos WHERE sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito ORDER BY nombre_suc ASC";

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
                                                           
                                                              $fila[nombre_suc]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_depa]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_provi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_dist]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[condicion_suc]
                                                            
                                                        </td>
                                                        <td><center>";

                                                         if ($tipo2==1) {
                                                         echo "
                                                            <a  href=?mod=sucursales&consultar&codigo=".$fila["id_sucursal"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DE LA SUCURSAL DE ".$fila["nombre_suc"]."'></a>";
      
                                echo "
      
      <a  href=?mod=sucursales&editar&codigo=".$fila["id_sucursal"]."><img src='./img/editar2.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DE LA SUCURSAL DE ".$fila["nombre_suc"]."'></a> 
      <a   href=?mod=sucursales&eliminar&codigo=".$fila["id_sucursal"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ANULAR LA SUCURSAL DE ".$fila["nombre_suc"]."'></a>
      ";
     
     } else { echo "-";}
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
                                    <h3> <center>Agregar sucursal <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=sucursales&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UNA NUEVA SUCURSAL" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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
                                   <h3> <center>Lista de sedes</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Condición de sucursal <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una condición para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de sucursales por condición de sede</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_operacion" onchange="if(this.value=='Seleccione una condición para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una condición para exportar</option>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_imp_suc)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_sucursal.php?condicion_suc=<?php echo $SUC['condicion_suc']?>'><?php echo $SUC['condicion_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/sucursales.gif" width="100%" height="200px" title="Ubique de forma sencilla cada sede"><br><br>

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
                           
$nombre=trim(strtoupper($_POST["nombre"]));
$cbx_departamento=trim(strtoupper($_POST["cbx_departamento"]));
$cbx_provincia=trim(strtoupper($_POST["cbx_provincia"]));
$cbx_distrito=trim(strtoupper($_POST["cbx_distrito"]));
$direccion=trim(strtoupper($_POST["direccion"]));

if($_POST['telefono']!=null){
        $telefono = trim($_POST['telefono']);
    }else{
        $telefono = null;
    }

if($_POST['correo']!=null){
        $correo = trim(strtoupper($_POST['correo']));
    }else{
        $correo = null;
    }    

if( $nombre=="" )
                {
                
                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {

$sql22=" UPDATE sucursales SET 
nombre_suc='$nombre',
id_departamento='$cbx_departamento',
id_provincia='$cbx_provincia',
id_distrito='$cbx_distrito',
direccion_suc='$direccion',
telefono_suc='$telefono',
email_suc='$correo'
 where id_sucursal='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos de la sucursal '$nombre' correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=sucursales&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT sucursales.id_sucursal, sucursales.id_departamento, sucursales.id_provincia, sucursales.id_distrito, nombre_suc, direccion_suc, nombre_depa, nombre_provi, nombre_dist, telefono_suc, email_suc FROM sucursales, departamentos, provincias, distritos WHERE sucursales.id_sucursal='$x1' AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar sucursal </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=sucursales&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Base <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{3,50}' maxlength="50" value='<?php echo $fila['nombre_suc']; ?>' placeholder="Introducir el nombre de la sede">

                                            <label for="exampleInputFile">Departamento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un departamento." onclick="Swal.fire({title:'<h2>Por favor seleccione un departamento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_departamento" id="cbx_departamento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['id_departamento']; ?>'>ACTUAL: <?php echo $fila['nombre_depa']; ?></option>
                                                <?php while($row = $resultado->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $row['id_departamento']; ?>"><?php echo $row['nombre_depa']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Provincia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una provincia." onclick="Swal.fire({title:'<h2>Por favor seleccione una provincia</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_provincia" id="cbx_provincia" data-show-subtext="true" data-live-search="true" required>   
                                            <option class='btn-danger' value='<?php echo $fila['id_provincia']; ?>'>ACTUAL: <?php echo $fila['nombre_provi']; ?></option>            
                                            </select>

                                            <label for="exampleInputFile">Distrito <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un distrito." onclick="Swal.fire({title:'<h2>Por favor seleccione un distrito</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_distrito" id="cbx_distrito" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['id_distrito']; ?>'>ACTUAL: <?php echo $fila['nombre_dist']; ?></option>
                                            </select>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="direccion" class="form-control faa-float animated-hover" value="<?php echo $fila['direccion_suc'] ?>" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la dirección">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputEmail1" value="<?php if($fila['telefono_suc']=='0') { echo "";} else echo $fila['telefono_suc'] ?>" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de telefono">

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="email" name="correo" class="form-control faa-float animated-hover" value="<?php echo $fila['email_suc'] ?>" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico">

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
$cbx_departamento=trim(strtoupper($_POST["cbx_departamento"]));
$cbx_provincia=trim(strtoupper($_POST["cbx_provincia"]));
$cbx_distrito=trim(strtoupper($_POST["cbx_distrito"]));
$direccion=trim(strtoupper($_POST["direccion"]));

if($_POST['telefono']!=null){
        $telefono = trim($_POST['telefono']);
    }else{
        $telefono = null;
    }

if($_POST['correo']!=null){
        $correo = trim(strtoupper($_POST['correo']));
    }else{
        $correo = null;
    }    

if( $nombre=="" )
                {


$sql="UPDATE sucursales set condicion_suc = 'INACTIVO' WHERE id_sucursal='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se dio de baja a la sucursal correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=sucursales&lista" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT sucursales.id_sucursal, sucursales.id_departamento, sucursales.id_provincia, sucursales.id_distrito, nombre_suc, direccion_suc, nombre_depa, nombre_provi, nombre_dist, telefono_suc, email_suc FROM sucursales, departamentos, provincias, distritos WHERE sucursales.id_sucursal='$x1' AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Está a punto de darle de baja a la sucursal . . .";


                                echo '   </div>'; ?>

  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Anular sucursal</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=sucursales&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Base <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{3,50}' maxlength="50" value='<?php echo $fila['nombre_suc']; ?>' placeholder="Introducir el nombre de la sede" disabled>

                                            <label for="exampleInputFile">Departamento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un departamento." onclick="Swal.fire({title:'<h2>Por favor seleccione un departamento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_departamento" id="cbx_departamento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['id_departamento']; ?>'>ACTUAL: <?php echo $fila['nombre_depa']; ?></option>
                                                <?php while($row = $resultado->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $row['id_departamento']; ?>" disabled><?php echo $row['nombre_depa']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Provincia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una provincia." onclick="Swal.fire({title:'<h2>Por favor seleccione una provincia</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_provincia" id="cbx_provincia" data-show-subtext="true" data-live-search="true" required>   
                                            <option class='btn-danger' value='<?php echo $fila['id_provincia']; ?>'>ACTUAL: <?php echo $fila['nombre_provi']; ?></option>            
                                            </select>

                                            <label for="exampleInputFile">Distrito <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un distrito." onclick="Swal.fire({title:'<h2>Por favor seleccione un distrito</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_distrito" id="cbx_distrito" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['id_distrito']; ?>'>ACTUAL: <?php echo $fila['nombre_dist']; ?></option>
                                            </select>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="direccion" class="form-control faa-float animated-hover" value="<?php echo $fila['direccion_suc'] ?>" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la dirección" disabled>

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="tel" name="telefono" class="form-control faa-float animated-hover" id="exampleInputEmail1" value="<?php if($fila['telefono_suc']=='0') { echo "";} else echo $fila['telefono_suc'] ?>" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de telefono" disabled>

                                            <label for="exampleInputFile">Correo electrónico <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( @ . _ + = / * - ). Se requieren (3-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (@._+=/*-)<br>'+'Caracteres (3-50)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return email(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="correo" class="form-control faa-float animated-hover" value="<?php if($fila['email_suc']=='') { echo "SIN CORREO";} else echo $fila['email_suc'] ?>" pattern='.{3,50}' maxlength="50" placeholder="Introducir el correo electrónico" disabled>

                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Anular sucursal">
                                        
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


                                        
     $consulta="SELECT id_sucursal, nombre_suc, nombre_depa, nombre_provi, nombre_dist, condicion_suc, direccion_suc, (COALESCE(CASE telefono_suc 
    WHEN '0' THEN 'SIN TELÉFONO' 
    ELSE telefono_suc 
    END,'SIN TELÉFONO')) AS telefono_suc,

    (COALESCE(CASE email_suc 
    WHEN '' THEN 'SIN CORREO' 
    ELSE email_suc 
    END,'SIN CORREO')) AS email_suc FROM sucursales, departamentos, provincias, distritos WHERE condicion_suc='ACTIVO' AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND id_sucursal='$x1' ORDER BY nombre_suc ASC";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta de la sucursal</h3>
                                </div>
                                <?php  

                                  if($fila['condicion_suc']=='ACTIVO')
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/activo.png' width='50%' height='80'></img></td></center>";
                                    } 
                                  else
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/inactivo.png' width='45%' height='60'></img></td></center>";
                                    } ?>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=sucursales&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped">
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Base</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['nombre_suc'] ?></td></tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Departamento</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['nombre_depa'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Provincia</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['nombre_provi'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Distrito</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['nombre_dist'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Dirección</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['direccion_suc'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Teléfono</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['telefono_suc'] ?></td>
                                         </tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Correo electrónico</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['email_suc'] ?></td>
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
                            <form  name="fe" action="?mod=sucursales&lista" method="post" id="ContactForm">
    


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