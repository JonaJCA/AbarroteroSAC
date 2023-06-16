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

$buscar_prop = "SELECT id_propietario, (CONCAT(ruc_prop, ' - ',nombre_prop)) AS PROPIETARIO FROM propietarios ORDER BY nombre_prop; ";
$resultado_prop = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_prop);

$buscar_imp_vehi_tipo = "SELECT tipo_vehi FROM vehiculos GROUP BY tipo_vehi ORDER BY tipo_vehi ";
$resultado_imp_vehi_tipo = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_vehi_tipo);

$buscar_imp_vehi_condicion = "SELECT condicion_vehi FROM vehiculos GROUP BY condicion_vehi ORDER BY condicion_vehi ";
$resultado_imp_vehi_condicion = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_vehi_condicion);

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {
                           

$propietario=trim(strtoupper($_POST["propietario"]));
$tipo=trim(strtoupper($_POST["tipo"]));
$placa=trim(strtoupper($_POST["placa"]));
$constancia=trim(strtoupper($_POST["constancia"]));
$marca=trim(strtoupper($_POST["marca"]));
$color=trim(strtoupper($_POST["color"]));
$condicion=trim(strtoupper($_POST["condicion"]));

if($_POST['carreta']!=null){
        $carreta = strtoupper($_POST['carreta']);
    }else{
        $carreta = null;
    } 

$sql="select * from vehiculos where tipo_vehi='$tipo' AND placa_vehi='$placa' AND constancia_vehi='$constancia' AND marca_vehi='$marca' AND color_vehi='$color'";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)==0){


$sql2="INSERT INTO `vehiculos` ( `id_propietario`, `tipo_vehi`, `placa_vehi`, `placa_carreta`, `constancia_vehi`, `marca_vehi`, `color_vehi`, `condicion_vehi` ) VALUES ( '$propietario', '$tipo', '$placa', '$carreta', '$constancia', '$marca', '$color', '$condicion' )";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el vehículo nuevo correctamente.';

                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=vehiculos&lista" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró este vehículo!</b> Ya existe . . . ';


                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar vehículo</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=vehiculos&nuevo=nuevo" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Propietario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un propietario. Se puede visualizar el RUC y nombre correspondiente del propietario" onclick="Swal.fire({title: '<h2>Se requiere seleccionar un propietario</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=propietarios&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=propietarios&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="propietario" required>
                                                <?php while($PROP = mysqli_fetch_assoc($resultado_prop)): ?>
                                                    <option class="btn-primary" value="<?php echo $PROP['id_propietario'] ?>"><?php echo $PROP['PROPIETARIO'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Tipo de vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de vehículo." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de vehículo</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-primary" value="MOTRIZ">MOTRIZ</option>
                                                   <option class="btn-primary" value="NO MOTRIZ">NO MOTRIZ</option>
                                                </select>

                                            <label for="exampleInputFile">Placa del vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (-). Se requieren (7) caracteres." onclick="Swal.fire({title: '<h2>Formato de placa</h2> <br><br><br><br><br><br><br><br> <br><br><br>', text: 'SE REQUIEREN (7) CARACTERES', width: 300, height: 400, background: '#fff url(img/placa.jpg) no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"></label>
                                            <input onkeypress="return formato_placa(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="placa" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='^([A-Za-z0-9]{3}-\d{3,4})$' maxlength="7" placeholder="Introducir la placa del vehículo" required>

                                            <label for="exampleInputFile">Placa de la carreta <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (-). Se requieren (7) caracteres." onclick="Swal.fire({title: '<h2>Formato de placa</h2> <br><br><br><br><br><br><br><br> <br><br><br>', text: 'SE REQUIEREN (7) CARACTERES', width: 300, height: 400, background: '#fff url(img/placa.jpg) no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return formato_placa(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="carreta" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='^([A-Za-z0-9]{3}-\d{3,4})$' maxlength="7" placeholder="Introducir la placa de la carreta">

                                            <label for="exampleInputFile">Constancia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="constancia" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{11,11}' maxlength="11" placeholder="Introducir la constancia" required>

                                            <label for="exampleInputFile">Marca <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="marca" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir la marca" required>

                                            <label for="exampleInputFile">Color <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="color" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir el color" required>

                                            <label for="exampleInputFile">Condición <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una condición." onclick="Swal.fire({title:'<h2>Por favor seleccione una condición</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='condicion' required>
                                                   <option class="btn-primary" value="OPERATIVO">OPERATIVO</option>
                                                   <option class="btn-primary" value="EN MANTENIMIENTO">EN MANTENIMIENTO</option>
                                                   <option class="btn-primary" value="MALOGRADO">MALOGRADO</option>
                                                </select>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" id="nuevo" value="Guardar">Registrar vehículo</button>
                                        
                                    
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
                                    <h3 class="box-title">VEHÍCULOS | Lista de medios</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Tipo</th>
                                                <th class="faa-float animated-hover">Placa</th>
                                                <th class="faa-float animated-hover">Carreta</th>
                                                <th class="faa-float animated-hover">Constancia</th>
                                                <th class="faa-float animated-hover">Marca</th>
                                                <th class="faa-float animated-hover">Color</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT id_vehiculo, nombre_prop, ruc_prop, tipo_vehi, placa_vehi, (COALESCE(CASE placa_carreta 
                                            WHEN '' THEN 'SIN PLACA' 
                                            ELSE placa_carreta 
                                            END,'SIN PLACA')) AS placa_carreta, constancia_vehi, marca_vehi, color_vehi FROM propietarios, vehiculos WHERE vehiculos.id_propietario=propietarios.id_propietario ORDER BY nombre_prop, placa_vehi ASC";

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
                                                           
                                                              $fila[tipo_vehi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[placa_vehi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[placa_carreta]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[constancia_vehi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[marca_vehi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[color_vehi]
                                                            
                                                        </td>
                                                        <td><center>";

                                                        echo "
                                                            <a  href=?mod=vehiculos&consultar&codigo=".$fila["id_vehiculo"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DEL VEHÍCULO ".$fila["marca_vehi"]." ".$fila["color_vehi"]."'></a>";

if ($tipo2==1) {      
                                echo "
      
      <a  href=?mod=vehiculos&editar&codigo=".$fila["id_vehiculo"]."><img src='./img/editar2.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL VEHÍCULO ".$fila["marca_vehi"]." ".$fila["color_vehi"]."'></a> 
      <a   href=?mod=vehiculos&eliminar&codigo=".$fila["id_vehiculo"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR EL VEHÍCULO ".$fila["marca_vehi"]." ".$fila["color_vehi"]."'></a>
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

                                echo '
  <div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Agregar vehículo <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=vehiculos&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO VEHÍCULO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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

                                
                                <label for="exampleInputFile">Tipo de vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de vehículo para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de vehículos por tipo</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_vehiculo_tipo" onchange="if(this.value=='Seleccione un tipo para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un tipo para exportar</option>
                                                <?php while($VEHI_TIPO = mysqli_fetch_assoc($resultado_imp_vehi_tipo)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_vehiculo_tipo.php?tipo_vehi=<?php echo $VEHI_TIPO['tipo_vehi']?>'><?php echo $VEHI_TIPO['tipo_vehi'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                <label for="exampleInputFile">Condición de vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una condición de vehículo para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de vehículos por condición</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_vehiculo_condicion" onchange="if(this.value=='Seleccione una condición para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una condición para exportar</option>
                                                <?php while($VEHI_CONDICION = mysqli_fetch_assoc($resultado_imp_vehi_condicion)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_vehiculo_condicion.php?condicion_vehi=<?php echo $VEHI_CONDICION['condicion_vehi']?>'><?php echo $VEHI_CONDICION['condicion_vehi'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>
                                            
                                 </div>
                                 <img src="./img/gif/vehiculos.gif" width="100%" height="200px" title="Tenga en buen estado sus medios de transporte"><br><br>

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
                           
$propietario=trim(strtoupper($_POST["propietario"]));
$tipo=trim(strtoupper($_POST["tipo"]));
$placa=trim(strtoupper($_POST["placa"]));
$constancia=trim(strtoupper($_POST["constancia"]));
$marca=trim(strtoupper($_POST["marca"]));
$color=trim(strtoupper($_POST["color"]));
$condicion=trim(strtoupper($_POST["condicion"]));

if($_POST['carreta']!=null){
        $carreta = strtoupper($_POST['carreta']);
    }else{
        $carreta = null;
    } 
    
if( $propietario=="" )
                {
                
                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {


$sql22=" UPDATE vehiculos SET 
id_propietario='$propietario',
tipo_vehi='$tipo',
placa_vehi='$placa',
placa_carreta='$carreta',
constancia_vehi='$constancia',
marca_vehi='$marca',
color_vehi='$color',
condicion_vehi='$condicion'
 where id_vehiculo='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos del vehículo '$marca $color' correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=vehiculos&lista" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT id_vehiculo, vehiculos.id_propietario, (CONCAT(ruc_prop, ' - ',nombre_prop)) AS PROPIETARIO, tipo_vehi, placa_vehi, (COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE placa_carreta END,'')) AS placa_carreta, constancia_vehi, marca_vehi, color_vehi, condicion_vehi FROM propietarios, vehiculos WHERE vehiculos.id_propietario=propietarios.id_propietario AND id_vehiculo='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar vehículo </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=vehiculos&editar=editar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Propietario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un propietario. Se puede visualizar el RUC y nombre correspondiente del propietario" onclick="Swal.fire({title: '<h2>Se requiere seleccionar un propietario</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=propietarios&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>', '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=propietarios&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="propietario" required>
                                                    <option class="btn-danger" value="<?php echo $fila['id_propietario']?>">ACTUAL: <?php echo $fila['PROPIETARIO']?></option>
                                                <?php while($PROP = mysqli_fetch_assoc($resultado_prop)): ?>
                                                    <option class="btn-primary" value="<?php echo $PROP['id_propietario'] ?>"><?php echo $PROP['PROPIETARIO'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Tipo de vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de vehículo." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de vehículo</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-danger" value="<?php echo $fila['tipo_vehi']?>">ACTUAL: <?php echo $fila['tipo_vehi']?></option>
                                                   <option class="btn-primary" value="MOTRIZ">MOTRIZ</option>
                                                   <option class="btn-primary" value="NO MOTRIZ">NO MOTRIZ</option>
                                                </select>

                                            <label for="exampleInputFile">Placa del vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (-). Se requieren (7) caracteres." onclick="Swal.fire({title: '<h2>Formato de placa</h2> <br><br><br><br><br><br><br><br> <br><br><br>', text: 'SE REQUIEREN (7) CARACTERES', width: 300, height: 400, background: '#fff url(img/placa.jpg) no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"></label>
                                            <input onkeypress="return formato_placa(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="placa" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='^([A-Za-z0-9]{3}-\d{3,4})$' maxlength="7" placeholder="Introducir la placa del vehículo" required value="<?php echo $fila['placa_vehi']?>">

                                            <label for="exampleInputFile">Placa de la carreta <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (-). Se requieren (7) caracteres." onclick="Swal.fire({title: '<h2>Formato de placa</h2> <br><br><br><br><br><br><br><br> <br><br><br>', text: 'SE REQUIEREN (7) CARACTERES', width: 300, height: 400, background: '#fff url(img/placa.jpg) no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return formato_placa(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="carreta" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='^([A-Za-z0-9]{3}-\d{3,4})$' maxlength="7" placeholder="Introducir la placa de la carreta" value="<?php echo $fila['placa_carreta']?>">

                                            <label for="exampleInputFile">Constancia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="constancia" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{11,11}' maxlength="11" placeholder="Introducir la constancia" required value="<?php echo $fila['constancia_vehi']?>">

                                            <label for="exampleInputFile">Marca <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="marca" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir la marca" required value="<?php echo $fila['marca_vehi']?>">

                                            <label for="exampleInputFile">Color <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="color" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir el color" required value="<?php echo $fila['color_vehi']?>">

                                            <label for="exampleInputFile">Condición <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una condición." onclick="Swal.fire({title:'<h2>Por favor seleccione una condición</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='condicion' required>
                                                   <option class="btn-danger" value="<?php echo $fila['condicion_vehi']?>">ACTUAL: <?php echo $fila['condicion_vehi']?></option>
                                                   <option class="btn-primary" value="OPERATIVO">OPERATIVO</option>
                                                   <option class="btn-primary" value="EN MANTENIMIENTO">EN MANTENIMIENTO</option>
                                                   <option class="btn-primary" value="MALOGRADO">MALOGRADO</option>
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
                           
$propietario=trim(strtoupper($_POST["propietario"]));
$tipo=trim(strtoupper($_POST["tipo"]));
$placa=trim(strtoupper($_POST["placa"]));
$constancia=trim(strtoupper($_POST["constancia"]));
$marca=trim(strtoupper($_POST["marca"]));
$color=trim(strtoupper($_POST["color"]));
$condicion=trim(strtoupper($_POST["condicion"]));

if($_POST['carreta']!=null){
        $carreta = strtoupper($_POST['carreta']);
    }else{
        $carreta = null;
    } 
                       
if( $propietario=="" )
                {


$sql="DELETE FROM vehiculos WHERE id_vehiculo='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se eliminó el vehículo correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=vehiculos&lista" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT id_vehiculo, vehiculos.id_propietario, (CONCAT(ruc_prop, ' - ',nombre_prop)) AS PROPIETARIO, tipo_vehi, placa_vehi, (COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE placa_carreta END,'')) AS placa_carreta, constancia_vehi, marca_vehi, color_vehi, condicion_vehi FROM propietarios, vehiculos WHERE vehiculos.id_propietario=propietarios.id_propietario AND id_vehiculo='$x1'";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Para borrar un vehículo no debe tener operaciones . . .";


                                echo '   </div>'; ?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar vehículo</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=vehiculos&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Propietario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un propietario. Se puede visualizar el RUC y nombre correspondiente del propietario" onclick="Swal.fire({title:'<h2>Por favor seleccione un propietario. Se puede visualizar su RUC</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="propietario" required>
                                                    <option class="btn-danger" value="<?php echo $fila['id_propietario']?>">ACTUAL: <?php echo $fila['PROPIETARIO']?></option>
                                                <?php while($PROP = mysqli_fetch_assoc($resultado_prop)): ?>
                                                    <option class="btn-primary" value="<?php echo $PROP['id_propietario'] ?>" disabled><?php echo $PROP['PROPIETARIO'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Tipo de vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de vehículo." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de vehículo</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='tipo' required>
                                                   <option class="btn-danger" value="<?php echo $fila['tipo_vehi']?>">ACTUAL: <?php echo $fila['tipo_vehi']?></option>
                                                   <option class="btn-primary" value="MOTRIZ" disabled>MOTRIZ</option>
                                                   <option class="btn-primary" value="NO MOTRIZ" disabled>NO MOTRIZ</option>
                                                </select>

                                            <label for="exampleInputFile">Placa del vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (-). Se requieren (7) caracteres." onclick="Swal.fire({title: '<h2>Formato de placa</h2> <br><br><br><br><br><br><br><br> <br><br><br>', text: 'SE REQUIEREN (7) CARACTERES', width: 300, height: 400, background: '#fff url(img/placa.jpg) no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"></label>
                                            <input onkeypress="return formato_placa(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="placa" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='^([A-Za-z0-9]{3}-\d{3,4})$' maxlength="7" placeholder="Introducir la placa del vehículo" required value="<?php echo $fila['placa_vehi']?>" disabled>

                                            <label for="exampleInputFile">Placa de la carreta <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (-). Se requieren (7) caracteres." onclick="Swal.fire({title: '<h2>Formato de placa</h2> <br><br><br><br><br><br><br><br> <br><br><br>', text: 'SE REQUIEREN (7) CARACTERES', width: 300, height: 400, background: '#fff url(img/placa.jpg) no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"> <code>(Puede ser omitido)</code></label>
                                            <input onkeypress="return formato_placa(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="carreta" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='^([A-Za-z0-9]{3}-\d{3,4})$' maxlength="7" placeholder="Introducir la placa de la carreta" value="<?php if($fila['placa_carreta']=='') { echo "SIN PLACA";} else echo $fila['placa_carreta'] ?>" disabled>

                                            <label for="exampleInputFile">Constancia <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (11) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (11)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="constancia" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{11,11}' maxlength="11" placeholder="Introducir la constancia" required value="<?php echo $fila['constancia_vehi']?>" disabled>

                                            <label for="exampleInputFile">Marca <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="marca" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir la marca" required value="<?php echo $fila['marca_vehi']?>" disabled>

                                            <label for="exampleInputFile">Color <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z). Se requieren (2-30) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Caracteres (2-30)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="color" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{2,30}' maxlength="30" placeholder="Introducir el color" required value="<?php echo $fila['color_vehi']?>" disabled>

                                            <label for="exampleInputFile">Condición <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una condición." onclick="Swal.fire({title:'<h2>Por favor seleccione una condición</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='condicion' required>
                                                   <option class="btn-danger" value="<?php echo $fila['condicion_vehi']?>">ACTUAL: <?php echo $fila['condicion_vehi']?></option>
                                                   <option class="btn-primary" value="OPERATIVO" disabled>OPERATIVO</option>
                                                   <option class="btn-primary" value="EN MANTENIMIENTO" disabled>EN MANTENIMIENTO</option>
                                                   <option class="btn-primary" value="MALOGRADO" disabled>MALOGRADO</option>
                                                </select>
                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="Eliminar vehículo">
                                        
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


                                        
     $consulta="SELECT id_vehiculo, (CONCAT(nombre_prop,' ( ',ruc_prop,' )')) AS PROP, tipo_vehi, placa_vehi, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE placa_carreta END,'SIN PLACA')) AS placa_carreta, constancia_vehi, marca_vehi, color_vehi, condicion_vehi FROM propietarios, vehiculos WHERE vehiculos.id_propietario=propietarios.id_propietario AND id_vehiculo='$x1' ORDER BY nombre_prop, placa_vehi ASC";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del vehículo</h3>
                                </div>
                                <?php  

                                  if($fila['condicion_vehi']=='OPERATIVO')
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/operativo.png' width='50%' height='80'></img></td></center>";
                                    } 
                                  else if($fila['condicion_vehi']=='EN MANTENIMIENTO')
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/mantenimiento.png' width='50%' height='80'></img></td></center>";
                                    } 
                                  else
                                    {  echo"
                                       <center><td class='faa-float animated-hover'><img src='./img/malogrado.png' width='45%' height='55'></img></td></center>";
                                    } ?>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=vehiculos&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped">
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Propietario  ( RUC )</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['PROP'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Tipo de vehículo</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['tipo_vehi'] ?></td></tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Placa del vehículo</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['placa_vehi'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Placa de la carreta</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['placa_carreta'] ?></td>
                                         </tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Constancia</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['constancia_vehi'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Marca</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['marca_vehi'] ?></td></tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'> Color</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['color_vehi'] ?></td></tr>
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
                            <form  name="fe" action="?mod=vehiculos&lista" method="post" id="ContactForm">
    


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