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

$buscar_imp_cho = "SELECT estado_cho FROM choferes GROUP BY estado_cho ORDER BY estado_cho ";
$resultado_imp_cho = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_cho);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {
                           

$nombre=trim(strtoupper($_POST["nombre"]));
$apellido=trim(strtoupper($_POST["apellido"]));
$brevete=trim(strtoupper($_POST["brevete"]));
$dni=trim(strtoupper($_POST["dni"]));
$estado=trim(strtoupper($_POST["estado"]));

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


$sql="select * from choferes where dni_cho='$dni'";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){


$sql2="INSERT INTO `choferes` ( `nombre_cho`, `apellido_cho`, `brevete_cho`, `estado_cho`, `dni_cho`, `telefono_cho`, `direccion_cho`, `registro_cho` ) VALUES ( '$nombre', '$apellido', '$brevete', '$estado', '$dni', '$telefono', '$direccion', '$fecha2' )";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el chofer nuevo correctamente.';

                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=choferes&lista" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró este chofer!</b> Ya existe . . . ';


                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar chofer</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=choferes&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nombres <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir los nombres" autofocus>

                                            <label for="exampleInputFile">Apellidos <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="apellido" class="form-control faa-float animated-hover" pattern='.{2,30}' maxlength="30" id="exampleInputEmail1" placeholder="Introducir los apellidos">

                                            <label for="exampleInputFile">Brevete <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (9) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="brevete" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{9,9}' maxlength="9" placeholder="Introducir el brevete" required>

                                            <label for="exampleInputFile">Estado de brevete <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado de brevete." onclick="Swal.fire({title:'<h2>Por favor seleccione un estado de brevete</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='estado' required>
                                                   <option class="btn-primary" value="HABILITADO">HABILITADO</option>
                                                   <option class="btn-primary" value="INHABILITADO">INHABILITADO</option>
                                                </select>

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" pattern='.{8,8}' maxlength="8" placeholder="Introducir el número de DNI" required>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la dirección">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" onkeydown="return enteros(this, event)" type="tel" name="telefono" class="form-control faa-float animated-hover" pattern='.{7,9}' maxlength="9" placeholder="Introducir el número de teléfono">
                                        </div>
                                    </div><!-- /.box-body -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar chofer</button>
                                        
                                    
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
                                    <h3 class="box-title">CHOFERES | Lista de transportistas</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Registro</th>
                                                <th class="faa-float animated-hover">Conductor</th>
                                                <th class="faa-float animated-hover">Brevete</th>
                                                <th class="faa-float animated-hover">DNI</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT id_chofer, (DATE_FORMAT(registro_cho, '%d/%m/%Y')) AS registro_cho, (CONCAT(nombre_cho,' ', apellido_cho)) AS CHOFER, brevete_cho, dni_cho FROM choferes ORDER BY registro_cho, CHOFER ASC";

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
                                                           
                                                              $fila[registro_cho]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[CHOFER]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[brevete_cho]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[dni_cho]
                                                            
                                                        </td>
                                                        <td><center>";

                                                        if ($tipo2==1) {
                                                        echo "
                                                            <a  href=?mod=choferes&consultar&codigo=".$fila["id_chofer"]."><img src='./img/consul.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DEL CHOFER ".$fila["CHOFER"]."'></a>";
      
                                echo "
      
      <a  href=?mod=choferes&editar&codigo=".$fila["id_chofer"]."><img src='./img/editar.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL CHOFER ".$fila["CHOFER"]."'></a> 
      <a   href=?mod=choferes&eliminar&codigo=".$fila["id_chofer"]."><img src='./img/elimina.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR EL CHOFER ".$fila["CHOFER"]."'></a>
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
                                    <h3> <center>Agregar chofer <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=choferes&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO CHOFER" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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
                                   <h3> <center>Lista de transportistas</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Estado de brevete <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado de brevete para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de choferes por su estado de brevete</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_chofer" onchange="if(this.value=='Seleccione un estado para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un estado para exportar</option>
                                                <?php while($CHO = mysqli_fetch_assoc($resultado_imp_cho)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_chofer.php?estado_cho=<?php echo $CHO['estado_cho']?>'><?php echo $CHO['estado_cho'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/choferes.gif" width="100%" height="200px" title="Entregas rápidas y seguras gracias a nuestro personal"><br><br>

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
$apellido=trim(strtoupper($_POST["apellido"]));
$brevete=trim(strtoupper($_POST["brevete"]));
$dni=trim(strtoupper($_POST["dni"]));
$estado=trim(strtoupper($_POST["estado"]));

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


$sql22=" UPDATE choferes SET 
nombre_cho='$nombre',
apellido_cho='$apellido',
brevete_cho='$brevete',
estado_cho='$estado',
dni_cho='$dni',
direccion_cho='$direccion',
telefono_cho='$telefono'
 where id_chofer='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos del chofer '$nombre' correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=choferes&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT id_chofer, nombre_cho, apellido_cho, brevete_cho, dni_cho, direccion_cho, telefono_cho, estado_cho FROM choferes WHERE id_chofer='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar chofer </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=choferes&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nombres <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir los nombres" value="<?php echo $fila['nombre_cho']?>">

                                            <label for="exampleInputFile">Apellidos <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="apellido" class="form-control faa-float animated-hover" pattern='.{2,30}' maxlength="30" id="exampleInputEmail1" placeholder="Introducir los apellidos" value="<?php echo $fila['apellido_cho']?>">

                                            <label for="exampleInputFile">Brevete <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (9) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="brevete" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{9,9}' maxlength="9" placeholder="Introducir el brevete" required value="<?php echo $fila['brevete_cho']?>">

                                            <label for="exampleInputFile">Estado de brevete <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado de brevete." onclick="Swal.fire({title:'<h2>Por favor seleccione un estado de brevete</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='estado' required>
                                                   <option class="btn-danger" value="<?php echo $fila['estado_cho'] ?>">ESTADO ACTUAL: <?php echo $fila['estado_cho'] ?></option>
                                                   <option class="btn-primary" value="HABILITADO">HABILITADO</option>
                                                   <option class="btn-primary" value="INHABILITADO">INHABILITADO</option>
                                                </select>

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" pattern='.{8,8}' maxlength="8" value="<?php echo $fila['dni_cho']?>" placeholder="Introducir el número de DNI" required>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" value="<?php echo $fila['direccion_cho']?>" id="exampleInputEmail1" maxlength="100" placeholder="Introducir la dirección">

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="tel" name="telefono" value="<?php if($fila['telefono_cho']=='0') { echo "";} else echo $fila['telefono_cho'] ?>" class="form-control faa-float animated-hover" maxlength="9" placeholder="Introducir el número de teléfono">
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
$brevete=trim(strtoupper($_POST["brevete"]));
$dni=trim(strtoupper($_POST["dni"]));
$estado=trim(strtoupper($_POST["estado"]));

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


$sql="DELETE FROM choferes WHERE id_chofer='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se eliminó el chofer correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=choferes&lista" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT id_chofer, nombre_cho, apellido_cho, brevete_cho, dni_cho, direccion_cho, telefono_cho, estado_cho FROM choferes WHERE id_chofer='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Para borrar un chofer no debe tener operaciones . . .";


                                echo '   </div>'; ?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar chofer</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=choferes&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Nombres <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir los nombres" value="<?php echo $fila['nombre_cho']?>" disabled>

                                            <label for="exampleInputFile">Apellidos <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" required type="text" name="apellido" class="form-control faa-float animated-hover" pattern='.{2,30}' maxlength="30" id="exampleInputEmail1" placeholder="Introducir los apellidos" value="<?php echo $fila['apellido_cho']?>" disabled>

                                            <label for="exampleInputFile">Brevete <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (9) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="brevete" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{9,9}' maxlength="9" placeholder="Introducir el brevete" required value="<?php echo $fila['brevete_cho']?>" disabled>

                                            <label for="exampleInputFile">Estado de brevete <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado de brevete." onclick="Swal.fire({title:'<h2>Por favor seleccione un estado de brevete</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='estado' required>
                                                   <option class="btn-danger" value="<?php echo $fila['estado_cho'] ?>">ESTADO ACTUAL: <?php echo $fila['estado_cho'] ?></option>
                                                   <option class="btn-primary" value="HABILITADO" disabled>HABILITADO</option>
                                                   <option class="btn-primary" value="INHABILITADO" disabled>INHABILITADO</option>
                                                </select>

                                            <label for="exampleInputFile">DNI <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="dni" class="form-control faa-float animated-hover" pattern='.{8,8}' maxlength="8" value="<?php echo $fila['dni_cho']?>" placeholder="Introducir el número de DNI" required disabled>

                                            <label for="exampleInputFile">Dirección <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="direccion" class="form-control faa-float animated-hover" value="<?php if($fila['direccion_cho']=='') { echo "SIN DIRECCIÓN";} else echo $fila['direccion_cho'] ?>" id="exampleInputEmail1" maxlength="100" placeholder="Introducir la dirección" disabled>

                                            <label for="exampleInputFile">Teléfono <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (7-9) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (7-9)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="telefono" value="<?php if($fila['telefono_cho']=='0') { echo "SIN TELÉFONO";} else echo $fila['telefono_cho'] ?>" class="form-control faa-float animated-hover" maxlength="9" placeholder="Introducir el número de teléfono" disabled>
                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Eliminar chofer">
                                        
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


                                        
     $consulta="SELECT id_chofer, (CONCAT(apellido_cho,', ',nombre_cho)) AS chofer, (CONCAT(brevete_cho,' ( ',estado_cho,' )')) AS brevete_cho, dni_cho, (COALESCE(CASE direccion_cho 
    WHEN '' THEN 'SIN DIRECCIÓN' 
    ELSE direccion_cho 
    END,'SIN DIRECCIÓN')) AS direccion_cho, 
    (COALESCE(CASE telefono_cho 
    WHEN '0' THEN 'SIN TELÉFONO' 
    ELSE telefono_cho 
    END,'SIN TELÉFONO')) AS telefono_cho, estado_cho, (DATE_FORMAT(registro_cho,'%d/%m/%Y')) AS registro_cho FROM choferes WHERE id_chofer='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del chofer</h3>
                                </div>
                                <?php  

                                  if($fila['estado_cho']=='HABILITADO')
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/habilitado.jpg' width='50%' height='80'></img></td></center>";
                                    } 
                                  else
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/inhabilitado.jpg' width='45%' height='60'></img></td></center>";
                                    } ?>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=choferes&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped">
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Registro</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['registro_cho'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Chofer</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['chofer'] ?></td></tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Brevete ( Estado )</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['brevete_cho'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> DNI</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['dni_cho'] ?></td>
                                         </tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Dirección</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['direccion_cho'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Teléfono</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['telefono_cho'] ?></td></tr>
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
                            <form  name="fe" action="?mod=choferes&lista" method="post" id="ContactForm">
    


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