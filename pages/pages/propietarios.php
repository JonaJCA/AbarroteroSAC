<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");
?>	
<?php
 
require ('validarnum.php');

$fecha2=date("Y-m-d");  	

include './inc/config.php';
$servidor="localhost";
$basedatos="hwpaziid_abarrotero";
$usuario="hwpaziid";
$pass="OKfz43Ng+h3+L3";

$buscar_imp_prop = "SELECT tipo_prop FROM propietarios GROUP BY tipo_prop ORDER BY tipo_prop";
$resultado_imp_prop = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_prop);


if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {
                           

$nombre=trim(strtoupper($_POST["nombre"]));
$ruc=trim(strtoupper($_POST["ruc"]));
$tipo=trim(strtoupper($_POST["tipo"]));

if($_POST['direccion']!=null){
        $direccion = trim(strtoupper($_POST['direccion']));
    }else{
        $direccion = null;
    } 

if($_POST['telefono']!=null){
        $telefono = trim($_POST['telefono']);
    }else{
        $telefono = null;
    }


$sql="select * from propietarios where nombre_prop='$nombre' AND ruc_prop='$ruc' AND tipo_prop='$tipo'";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){


$sql2="INSERT INTO `propietarios` ( `nombre_prop`, `tipo_prop`, `ruc_prop`, `direccion_prop`, `telefono_prop` ) 
       VALUES ( '$nombre', '$tipo', '$ruc', '$direccion', '$telefono' )";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el propietario nuevo correctamente.';

                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=propietarios&lista" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró este propietario!</b> Ya existe . . . ';

                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar propietario</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=propietarios&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nombre del propietario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="30" placeholder="Introducir el nombre del propietario" autofocus>

                                            <label for="exampleInputFile">Tipo de contribuyente <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de contribuyente." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de contribuyente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-primary" value="PERSONA JURIDICA">PERSONA JURIDICA</option>
                                                   <option class="btn-primary" value="PERSONA NATURAL">PERSONA NATURAL</option>
                                                </select>

                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" name="ruc" class="form-control faa-float animated-hover" min='10000000000' max='29999999999' step='1' pattern='.{11,11}' maxlength="11" placeholder="Introducir el número de RUC" required>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" id="exampleInputEmail1"pattern='.{5,100}' maxlength="100" placeholder="Introducir la dirección">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="tel" name="telefono" class="form-control faa-float animated-hover" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono">
                                        </div>
                                    </div><!-- /.box-body -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar propietario</button>
                                        
                                    
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
                                    <h3 class="box-title">PROPIETARIOS | Lista de titulares</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Dueño</th>
                                                <th class="faa-float animated-hover">Contribuyente</th>
                                                <th class="faa-float animated-hover">RUC</th>
                                                <th class="faa-float animated-hover">Teléfono</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT id_propietario, tipo_prop, nombre_prop, ruc_prop, (COALESCE(CASE telefono_prop WHEN '0' THEN 'SIN TELÉFONO' ELSE telefono_prop END,'SIN TELÉFONO')) AS telefono_prop FROM propietarios ORDER BY nombre_prop ASC";

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
                                                           
                                                              $fila[nombre_prop]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[tipo_prop]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[ruc_prop]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[telefono_prop]
                                                            
                                                        </td>
                                                        <td><center>";

                                                        if ($tipo2==1) {
                                                        echo "
                                                            <a  href=?mod=propietarios&consultar&codigo=".$fila["id_propietario"]."><img src='./img/consul.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DEL PROPIETARIO ".$fila["nombre_prop"]."'></a>";
      
                                echo "
      
      <a  href=?mod=propietarios&editar&codigo=".$fila["id_propietario"]."><img src='./img/editar.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL PROPIETARIO ".$fila["nombre_prop"]."'></a> 
      <a   href=?mod=propietarios&eliminar&codigo=".$fila["id_propietario"]."><img src='./img/elimina.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR AL PROPIETARIO ".$fila["nombre_prop"]."'></a>
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
                                    <h3> <center>Agregar propietario <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=propietarios&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO PROPIETARIO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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
                                   <h3> <center>Lista de titulares</center></h3>
                                </div>

                                <label for="exampleInputFile">Tipo de contribuyente <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de contribuyente para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de propietarios por tipo de contribuyente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_propietario" onchange="if(this.value=='Seleccione un tipo para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un tipo para exportar</option>
                                                <?php while($PROP = mysqli_fetch_assoc($resultado_imp_prop)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_propietario.php?tipo_prop=<?php echo $PROP['tipo_prop']?>'><?php echo $PROP['tipo_prop'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/propietarios.gif" width="100%" height="200px" title="Mantenga una buena relación con sus asociados"><br><br>

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
$ruc=trim(strtoupper($_POST["ruc"]));
$tipo=trim(strtoupper($_POST["tipo"]));

if($_POST['direccion']!=null){
        $direccion = trim(strtoupper($_POST['direccion']));
    }else{
        $direccion = null;
    } 

if($_POST['telefono']!=null){
        $telefono = trim($_POST['telefono']);
    }else{
        $telefono = null;
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


$sql22=" UPDATE propietarios SET 
nombre_prop='$nombre',
tipo_prop='$tipo',
ruc_prop='$ruc',
direccion_prop='$direccion',
telefono_prop='$telefono'
 where id_propietario='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos del propietario '$nombre' correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=propietarios&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT id_propietario, tipo_prop, nombre_prop, ruc_prop, direccion_prop, telefono_prop FROM propietarios WHERE id_propietario='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar propietario </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=propietarios&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nombre del propietario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="30" placeholder="Introducir el nombre del propietario" value="<?php echo $fila['nombre_prop']?>">

                                            <label for="exampleInputFile">Tipo de contribuyente <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de contribuyente." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de contribuyente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-danger" value="<?php echo $fila['tipo_prop']?>">ACTUAL: <?php echo $fila['tipo_prop']?></option>
                                                   <option class="btn-primary" value="PERSONA JURIDICA">PERSONA JURIDICA</option>
                                                   <option class="btn-primary" value="PERSONA NATURAL">PERSONA NATURAL</option>
                                                </select>

                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" name="ruc" class="form-control faa-float animated-hover" min='10000000000' max='29999999999' step='1' pattern='.{11,11}' maxlength="11" placeholder="Introducir el número de RUC" required value="<?php echo $fila['ruc_prop']?>">

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" id="exampleInputEmail1"pattern='.{5,100}' maxlength="100" placeholder="Introducir la dirección" value="<?php echo $fila['direccion_prop']?>">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="tel" name="telefono" class="form-control faa-float animated-hover" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono" value="<?php if($fila['telefono_prop']=='0') { echo "";} else echo $fila['telefono_prop'] ?>">
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
$ruc=trim(strtoupper($_POST["ruc"]));
$tipo=trim(strtoupper($_POST["tipo"]));

if($_POST['direccion']!=null){
        $direccion = trim(strtoupper($_POST['direccion']));
    }else{
        $direccion = null;
    } 

if($_POST['telefono']!=null){
        $telefono = trim($_POST['telefono']);
    }else{
        $telefono = null;
    }
         
if( $nombre=="" )
                {


$sql="DELETE FROM propietarios WHERE id_propietario='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se eliminó el propietario correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=propietarios&lista" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT id_propietario, tipo_prop, nombre_prop, ruc_prop, direccion_prop, telefono_prop FROM propietarios WHERE id_propietario='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Para borrar un propietario no debe tener vehículos registrados a su nombre . . .";


                                echo '   </div>'; ?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar propietario</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=propietarios&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nombre del propietario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="30" placeholder="Introducir el nombre del propietario" value="<?php echo $fila['nombre_prop']?>" disabled>

                                            <label for="exampleInputFile">Tipo de contribuyente <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de contribuyente." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de contribuyente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-danger" value="<?php echo $fila['tipo_prop']?>">ACTUAL: <?php echo $fila['tipo_prop']?></option>
                                                   <option class="btn-primary" value="PERSONA JURIDICA" disabled>PERSONA JURIDICA</option>
                                                   <option class="btn-primary" value="PERSONA NATURAL" disabled>PERSONA NATURAL</option>
                                                </select>

                                            <label for="exampleInputFile">RUC <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="ruc" class="form-control faa-float animated-hover" pattern='.{11,11}' maxlength="11" placeholder="Introducir el número de RUC" required value="<?php echo $fila['ruc_prop']?>" disabled>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" id="exampleInputEmail1"pattern='.{5,100}' maxlength="100" placeholder="Introducir la dirección" value="<?php if($fila['direccion_prop']=='') { echo "SIN DIRECCIÓN";} else echo $fila['direccion_prop'] ?>" disabled>

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="telefono" class="form-control faa-float animated-hover" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono" value="<?php if($fila['telefono_prop']=='0') { echo "SIN TELÉFONO";} else echo $fila['telefono_prop'] ?>" disabled>
                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Eliminar propietario">
                                        
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

     $consulta="SELECT propietarios.id_propietario, nombre_prop, tipo_prop, ruc_prop, COUNT(vehiculos.id_propietario) AS vehiculos, (COALESCE(CASE direccion_prop 
    WHEN '' THEN 'SIN DIRECCIÓN' 
    ELSE direccion_prop 
    END,'SIN DIRECCIÓN')) AS direccion_prop, (COALESCE(CASE telefono_prop WHEN '0' THEN 'SIN TELÉFONO' ELSE telefono_prop END,'SIN TELÉFONO')) AS telefono_prop FROM propietarios, vehiculos WHERE vehiculos.id_propietario=propietarios.id_propietario AND propietarios.id_propietario='$x1' ORDER BY nombre_prop ASC";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del propietario</h3>
                                </div>
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=propietarios&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped">
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Nombre del propietario</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['nombre_prop'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Tipo de contribuyente</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['tipo_prop'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Vehículos</h3>
                                         <td class='faa-float animated-hover'> <?php if($fila['vehiculos']=='1'){
                                                              echo "$fila[vehiculos] VEHÍCULO REGISTRADO";
                                                           } else { echo "$fila[vehiculos] VEHÍCULOS REGISTRADOS";}
                                                           ?>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> RUC</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['ruc_prop'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Dirección</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['direccion_prop'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Teléfono</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['telefono_prop'] ?></td></tr>
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
                            <form  name="fe" action="?mod=propietarios&lista" method="post" id="ContactForm">
    


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