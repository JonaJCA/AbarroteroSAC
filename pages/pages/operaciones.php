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

$buscar_imp_ope = "SELECT tipo_ope FROM operaciones GROUP BY tipo_ope ORDER BY tipo_ope";
$resultado_imp_ope = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_ope);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {
                           

$nombre=trim(strtoupper($_POST["nombre"]));
$tipo=trim(strtoupper($_POST["tipo"]));

$sql="select * from operaciones where descripcion_ope='$nombre' AND tipo_ope='$tipo'";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){


$sql2="INSERT INTO `operaciones` ( `descripcion_ope`, `tipo_ope`) VALUES ('$nombre', '$tipo')";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró la operación nueva correctamente.';


                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=operaciones&lista" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró esta operación!</b> Ya existe . . . ';



                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar operación</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=operaciones&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir la descripción" autofocus>

                                            <label for="exampleInputFile">Tipo de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-primary" value="TIPO1">TIPO1</option>
                                                   <option class="btn-primary" value="TIPO2">TIPO2</option>
                                                </select>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar operación</button>
                                        
                                    
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
                                    <h3 class="box-title">OPERACIONES | Lista de procedimientos</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Descripción</th>
                                                <th class="faa-float animated-hover">Tipo</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT operaciones.id_operacion, descripcion_ope, tipo_ope FROM operaciones ORDER BY descripcion_ope ASC";
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
                                                           
                                                              $fila[descripcion_ope]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[tipo_ope]
                                                            
                                                        </td>
                                                         <td><center>";

                                                         if ($tipo2==1) {
                                                         echo "
                                                            <a  href=?mod=operaciones&consultar&codigo=".$fila["id_operacion"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DE LA OPERACIÓN ".$fila["descripcion_ope"]."'></a>";
      
                                echo "
      
      <a  href=?mod=operaciones&editar&codigo=".$fila["id_operacion"]."><img src='./img/editar2.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DE LA OPERACIÓN ".$fila["descripcion_ope"]."'></a> 
      <a   href=?mod=operaciones&eliminar&codigo=".$fila["id_operacion"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR LA OPERACIÓN ".$fila["descripcion_ope"]."'></a>
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
                                    <h3> <center>Agregar operación <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=operaciones&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UNA NUEVA OPERACIÓN" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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
                                   <h3> <center>Lista de procedimientos</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Tipo de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de operaciones por tipo</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_operacion" onchange="if(this.value=='Seleccione un tipo para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un tipo para exportar</option>
                                                <?php while($OPE = mysqli_fetch_assoc($resultado_imp_ope)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_operacion.php?tipo_ope=<?php echo $OPE['tipo_ope']?>'><?php echo $OPE['tipo_ope'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/operaciones.gif" width="100%" height="200px" title="Haga uso de buenas prácticas"><br><br>

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
$tipo=trim(strtoupper($_POST["tipo"]));
                       
if( $nombre=="" )
                {
                
                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {


$sql22=" UPDATE operaciones SET 
descripcion_ope='$nombre',
tipo_ope='$tipo'
 where id_operacion='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos de la operación '$nombre' correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=operaciones&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT id_operacion, descripcion_ope, tipo_ope FROM operaciones WHERE id_operacion='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar operación </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=operaciones&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" value="<?php echo $fila['descripcion_ope'] ?>" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir la descripción">

                                            <label for="exampleInputFile">Tipo de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-danger" value="<?php echo $fila['tipo_ope']?>">ACTUAL: <?php echo $fila['tipo_ope']?></option>
                                                   <option class="btn-primary" value="TIPO1">TIPO1</option>
                                                   <option class="btn-primary" value="TIPO2">TIPO2</option>
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
$tipo=trim(strtoupper($_POST["tipo"]));
                       
if( $nombre=="" )
                {


$sql="DELETE FROM operaciones WHERE id_operacion='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se eliminó la operación correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=operaciones&lista" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT id_operacion, descripcion_ope, tipo_ope FROM operaciones WHERE id_operacion='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Para borrar una operación no debe haberse ejecutado . . .";


                                echo '   </div>'; ?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar operación</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=operaciones&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="nombre" class="form-control faa-float animated-hover" value="<?php echo $fila['descripcion_ope'] ?>" id="exampleInputEmail1" placeholder="Introducir la descripción" disabled>

                                            <label for="exampleInputFile">Tipo de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo'>
                                                   <option class="btn-danger" value="<?php echo $fila['tipo_ope']?>">ACTUAL: <?php echo $fila['tipo_ope']?></option>
                                                   <option class="btn-primary" value="TIPO1" disabled>TIPO1</option>
                                                   <option class="btn-primary" value="TIPO2" disabled>TIPO2</option>
                                                </select>
                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Eliminar operación">
                                        
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


                                        
     $consulta="SELECT operaciones.id_operacion, descripcion_ope, tipo_ope, CASE WHEN COUNT(movimientos.id_operacion)>=1 THEN 'EJECUTADO' ELSE 'SIN EJECUCIÓN' END AS operaciones FROM operaciones,movimientos WHERE operaciones.id_operacion=movimientos.id_operacion AND operaciones.id_operacion='$x1' ORDER BY descripcion_ope ASC";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta de la operación</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=operaciones&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped">
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Descripción</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['descripcion_ope'] ?></td></tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Tipo de operación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['tipo_ope'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Aplicación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['operaciones'] ?></td>
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
                            <form  name="fe" action="?mod=operaciones&lista" method="post" id="ContactForm">
    


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