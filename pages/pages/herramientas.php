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

$buscar_und = "SELECT id_medida, descripcion_med FROM medidas ORDER BY descripcion_med";
$resultado_und = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_und);

$buscar_imp_und = "SELECT herramientas.id_medida, descripcion_med FROM herramientas, medidas WHERE herramientas.id_medida=medidas.id_medida GROUP BY descripcion_med ORDER BY descripcion_med";
$resultado_imp_und = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_und);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {                         

$unidad=trim(strtoupper($_POST["unidad"]));
$nombre=trim(strtoupper($_POST["nombre"]));
$costo=trim($_POST['costo']);

$sql="select * from herramientas where id_medida='$unidad' AND descripcion_herra='$nombre' AND costo_herra='$costo'";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){

$sql2="INSERT INTO `herramientas`(`id_medida`, `descripcion_herra`, `costo_herra`, `fecha_herra`) VALUES ('$unidad','$nombre','$costo', '$fecha2')";

                          $cs=$bd->consulta($sql2);
                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró la herramienta nueva correctamente.';

                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=herramientas&lista" method="post" id="ContactForm">

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
                                        <b>Alerta no se registró esta herramienta!</b> Ya existe . . . ';

                               echo '   </div>';
}

}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar herramienta</h3>
                                </div>
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=herramientas&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción <img class="alert-link" width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (2-30) caracteres." onclick="Swal.fire({
                                            title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir la descripción" autofocus>

                                            <label for="exampleInputFile">Costo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="costo" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.10" min='0.10' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el costo">

                                            <label for="exampleInputFile">Unidad de medida <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una unidad de medida." onclick="Swal.fire({
                                            title:'<h2>Por favor seleccione una unidad de medida</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='unidad' required>
                                                  <?php while($row = $resultado_und->fetch_assoc()) { ?>
                                                 <option class="btn-primary" value="<?php echo $row['id_medida']; ?>"><?php echo $row['descripcion_med']; ?></option>
                                                <?php } ?>
                                                </select>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar herramienta</button>
                                        
                                    
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
                                    <h3 class="box-title">HERRAMIENTAS | Lista de materiales</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Registro</th>
                                                <th class="faa-float animated-hover">Descripción</th>
                                                <th class="faa-float animated-hover">Costo</th>
                                                <th class="faa-float animated-hover">Unidad de medida</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT DATE_FORMAT(fecha_herra, '%d/%m/%Y') AS REGISTRO, herramientas.id_herramienta, descripcion_herra, CONCAT('S/',FORMAT(costo_herra,2)) AS costo_herra, CONCAT(medidas.descripcion_med,' ( ',medidas.abreviatura_med,' )') AS UNIDAD FROM herramientas, medidas WHERE herramientas.id_medida = medidas.id_medida ORDER BY descripcion_herra ASC";

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
                                                           
                                                              $fila[REGISTRO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[descripcion_herra]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[costo_herra]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[UNIDAD]
                                                            
                                                        </td>
                                                         <td><center>";

                                                         echo "
                                                            <a  href=?mod=herramientas&consultar&codigo=".$fila["id_herramienta"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DE LA HERRAMIENTA ".$fila["descripcion_herra"]."'></a>";
      
                                echo "
      
      <a  href=?mod=herramientas&editar&codigo=".$fila["id_herramienta"]."><img src='./img/editar2.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DE LA HERRAMIENTA ".$fila["descripcion_herra"]."'></a> 
      <a   href=?mod=herramientas&eliminar&codigo=".$fila["id_herramienta"]."><img src='./img/elimina3.png' width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR LA HERRAMIENTA ".$fila["descripcion_herra"]."'></a>
      ";
     
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
                                    <h3> <center>Agregar herramienta <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=herramientas&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UNA NUEVA HERRAMIENTA" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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
                                   <h3> <center>Lista de materiales</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Unidad de medida <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una unidad de medida para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de herramientas por unidad de medida</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_herramienta" onchange="if(this.value=='Seleccione una unidad para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una unidad para exportar</option>
                                                <?php while($HERRA = mysqli_fetch_assoc($resultado_imp_und)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_herramienta.php?descripcion_med=<?php echo $HERRA['descripcion_med']?>'><?php echo $HERRA['descripcion_med'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/materiales.gif" width="100%" height="200px" title="Controle el stock de sus materiales"><br><br>

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
                           
$unidad=trim(strtoupper($_POST["unidad"]));
$nombre=trim(strtoupper($_POST["nombre"]));
$costo=trim($_POST['costo']);
                       
if( $nombre=="" )
                {
                
                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {


$sql22=" UPDATE herramientas SET 
id_medida='$unidad',
descripcion_herra='$nombre',
costo_herra='$costo'
 where id_herramienta='$x1'";

$bd->consulta($sql22);
  
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                               echo " Se actualizaron los datos de la herramienta '$nombre' correctamente.";
                                        
                         echo '</div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=herramientas&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT id_herramienta, (medidas.descripcion_med) AS descripcion_med, descripcion_herra, costo_herra , (medidas.id_medida) AS id_medida FROM herramientas, medidas WHERE id_herramienta='$x1' and herramientas.id_medida=medidas.id_medida";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar herramienta </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=herramientas&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                             <label for="exampleInputFile">Descripción <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (2-30) caracteres." onclick="Swal.fire({
                                            title:'<h2>Letras (a-z)<br>'+'Números (0-9) <br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" value="<?php echo $fila['descripcion_herra']?>" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir la descripción">

                                            <label for="exampleInputFile">Costo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number"  required name="costo" class="form-control faa-float animated-hover" value="<?php echo $fila['costo_herra'] ?>" id="exampleInputEmail1" step="0.10" min='0.10' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el costo">

                                            <label for="exampleInputFile">Unidad de medida <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una unidad de medida." onclick="Swal.fire({
                                            title:'<h2>Por favor seleccione una unidad de medida</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='unidad' required>
                                                   <option class="btn-danger" value="<?php echo $fila['id_medida'] ?>">Actual: <?php echo $fila['descripcion_med'] ?></option>
                                                  <?php while($row = $resultado_und->fetch_assoc()) { ?>
                                                 <option class="btn-primary" value="<?php echo $row['id_medida']; ?>"><?php echo $row['descripcion_med']; ?></option>
                                                <?php } ?>
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
                           
$unidad=trim(strtoupper($_POST["unidad"]));
$nombre=trim(strtoupper($_POST["nombre"]));
$costo=trim($_POST['costo']);
                       
if( $nombre=="" )
                {


$sql="DELETE FROM herramientas WHERE id_herramienta='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se eliminó la herramienta correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=herramientas&lista" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT id_herramienta, (medidas.descripcion_med) AS descripcion_med, (medidas.id_medida) AS id_medida, descripcion_herra, CONCAT('S/',FORMAT(costo_herra,2)) AS costo_herra FROM herramientas, medidas WHERE id_herramienta='$x1' AND herramientas.id_medida=medidas.id_medida";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Para borrar una herramienta no debe tener operaciones . . .";


                                echo '   </div>'; ?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar herramienta</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=herramientas&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (2-30) caracteres." onclick="Swal.fire({
                                            title:'<h2>Letras (a-z)<br>'+'Números (0-9) <br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" value="<?php echo $fila['descripcion_herra'] ?>" id="exampleInputEmail1" placeholder="Introducir la descripción" disabled>

                                            <label for="exampleInputFile">Costo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="text"  required name="costo" class="form-control faa-float animated-hover" value="<?php echo $fila['costo_herra'] ?>" id="exampleInputEmail1" step="0.10" min='0.10' max='99999999.99' maxlength="30" placeholder="Introducir el costo" disabled>

                                            <label for="exampleInputFile">Unidad de medida <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una unidad de medida." onclick="Swal.fire({
                                            title:'<h2>Por favor seleccione una unidad de medida</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='unidad' required>
                                                   <option class="btn-danger" value="<?php echo $fila['id_medida'] ?>">Actual: <?php echo $fila['descripcion_med'] ?></option>
                                                  <?php while($row = $resultado_und->fetch_assoc()) { ?>
                                                 <option class="btn-primary" value="<?php echo $row['id_medida']; ?>" disabled><?php echo $row['descripcion_med']; ?></option>
                                                <?php } ?>
                                                </select>




                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Eliminar herramienta">
                                        
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


                                        
     $consulta="SELECT DATE_FORMAT(fecha_herra, '%d/%m/%Y') AS REGISTRO, herramientas.id_herramienta, descripcion_herra, CONCAT('S/', FORMAT(costo_herra,2)) AS costo_herra, (CONCAT(medidas.descripcion_med,' ( ' ,medidas.abreviatura_med,' )')) AS UNIDAD FROM herramientas, medidas WHERE id_herramienta='$x1' and herramientas.id_medida = medidas.id_medida ORDER BY descripcion_herra ASC";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta de la herramienta</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=herramientas&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped">
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Fecha de registro</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['REGISTRO'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Descripción</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['descripcion_herra'] ?></td></tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Costo</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['costo_herra'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Unidad de medida</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['UNIDAD'] ?></td>
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
                            <form  name="fe" action="?mod=herramientas&lista" method="post" id="ContactForm">
    


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