<?php
date_default_timezone_set('America/Lima');
?>	
<?php


//require ('validarnum.php');
$servidor="localhost";
$basedatos="abarrotero";
$usuario="root";
$pass="";

$fecha2=date("Y-m-d");  	

if (isset($_GET['nuevo'])) { 

                        if (isset($_POST['nuevo'])) {

include 'config.php';
    if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { 
     
     
      // creamos las variables para subir a la db
        $ruta = "/SHERATON/pages/archivos/"; 
        $nombrefinal = trim ($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
        //$nombrefinal = ereg_replace (" ", "", $nombrefinal);//Sustituye una expresión regular
        $upload = $_SERVER['DOCUMENT_ROOT'] . $ruta . $nombrefinal;  
        $nombre  = $_POST["nombre"]; 
        $description  = $_POST["description"]; 


        if(move_uploaded_file($_FILES['fichero']['tmp_name'], $upload)) { //movemos el archivo a su ubicacion 
                    

                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';
                            
                            echo " Se registró el documento '$nombre' con éxito.";

                            echo " Si desea visualizar el archivo subido haga click aquí: <i><a target='_blank' href=\"".$ruta . $nombrefinal."\">".$_FILES['fichero']['name']."</a></i><br>";  

                            echo '   </div>';


                            
                    // echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br>";  
                    // echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br>";  
                    // echo "<br><hr><br>";  
                         



                   $query = "INSERT INTO documento (nombre_doc,tipo_doc,ruta,tipo,size) 
    VALUES ('$nombre','$description','".$nombrefinal."','".$_FILES['fichero']['type']."','".$_FILES['fichero']['size']."')"; 

       mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$query) or die("Vuelva a intentarlo con un archivo menor a 2MB"); 
       // echo "El archivo '".$nombre."' se ha subido con éxito <br>";       
        }  
    } elseif ($nombre!=="" || $description!=="") {
      # code...
        
        $nombre  = $_POST["nombre"]; 
        $description  = $_POST["description"]; 

      echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';
                            
                            echo " Se registró el documento con éxito. No se olvide subir el modelo.";
  
                            echo '   </div>';                            

  $query = "INSERT INTO documento (nombre_doc, tipo_doc) VALUES ('$nombre', '$description');"; 

       mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$query) or die("Por favor vuelva a intentarlo");                             

    } else {

      echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta!</b>';



                            echo " Asegúrese de seleccionar un archivo válido para registrar el documento.
";
                            echo '   </div>';
    }


}
?>
  <div class="col-md-10">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar documentos</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form" name="fe" action="?mod=documento&nuevo=nuevo" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                           
                                            
                                            
                                            
                                            <label for="exampleInputFile">Nombre</label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control faa-float animated-hover" value="<?php echo $var2 ?>" id="exampleInputEmail1" placeholder="Intoducir el nombre">
                                            
                                            <label for="exampleInputFile">Aplicación</label>
                                                <select  for="exampleInputEmail" class="form-control faa-float animated-hover" name='description'>
                                                   <option value="ADMINISTRATIVOS">ADMINISTRATIVOS</option>
                                                   <option  value="APORTES">APORTES</option>
                                                   <option value="PRESTAMOS">PRÉSTAMOS</option>
                                                </select>
<script>
                                             function cambiar(){
                                                var pdrs = document.getElementById('file-upload').files[0].name;
                                                document.getElementById('info').innerHTML = pdrs;
                                            }
                                            </script>
                                            <label for="exampleInputFile">Archivo</label><center>
                                            <label for="file-upload" class="form-control btn-primary subir faa-float animated-hover" title="Tipo de archivos permitidos: *.pdf, *.doc, *.docx, *.xls, *.mpp, *.txt, *.rar, *.zip, *.7z, *.jpg, *.jpeg, *.bmp, *.gif, *.png, *.mp4, *.mp3, *.flac"><i class="fa fa-upload faa-tada animated"></i> SUBIR DOCUMENTO <i class="fa fa-refresh faa-spin animated"></i><i class="faa-horizontal animated"></i></label>
                                            <input name="fichero" id="file-upload" onchange="cambiar()" class="faa-float animated-hover" style="display: none" type="file" size="150" maxlength="5000"><div id="info"></div></center>

                                        </div>                                        
                                    </div><!-- /.box-body -->
                                    <center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevo" 
                                        id="nuevo" value="nuevo">Registrar documento</button>
                                        
                                    
                                    </div>
                                  </center>
                                </form>
                            </div><!-- /.box -->
<?php
}

	
   
   if (isset($_GET['lista'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['lista'])) {

    $ruta = "/SHERATON/pages/archivos/"; 
    $nombrefinal = trim ($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
    //$nombrefinal = ereg_replace (" ", " ", $nombrefinal); //Sustituye una expresión regular                           



        

}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">DOCUMENTOS | Lista de documentos</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="faa-float animated-hover">Documento</th>
                                                <th class="faa-float animated-hover">Aplicación</th>
                                                <td class="faa-float animated-hover">Modelo</td>
                                                <th class="faa-float animated-hover">Opciones</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){


                                        
                                        $consulta="SELECT CODIGO_DOC, NOMBRE_DOC, tipo_doc, size, ruta FROM documento ORDER BY NOMBRE_DOC ASC ";
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
                                                           
                                                              $fila[NOMBRE_DOC]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[tipo_doc]";

                                                        if($fila['ruta']==""){?>
                                                            <td class='faa-float animated-hover'>NO HAY ARCHIVO</td>
                                                        <?php }else{ ?>

                                                          <?php echo"

                                                        <td class='faa-float animated-hover'><i><a target='_blank' href=\"pages/archivos/".$ruta . $fila['ruta']."\">VER MODELO </a><a class='glyphicon glyphicon-zoom-in'></a></i></td>"; ?>

                                                        <?php  } ?> <?php echo"

                                                         <td><center>
                                                            <a  href=?mod=documento&consultar&codigo=".$fila["CODIGO_DOC"]."><img src='./img/consultarr.png' width='25' alt='Edicion' class='faa-float animated-hover' title=' CONSULTAR EL DOCUMENTO ".$fila["NOMBRE_DOC"]."'></a>";
      
                                echo "
      
      <a  href=?mod=documento&editar&codigo=".$fila["CODIGO_DOC"]."><img src='./img/editar2.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL DOCUMENTO ".$fila["NOMBRE_DOC"]."'></a> 

      ";
      
      if($tipo2==1){
                                        echo "
      <a   href=?mod=documento&eliminar&codigo=".$fila["CODIGO_DOC"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR EL DOCUMENTO ".$fila["NOMBRE_DOC"]."'></a>
      ";}}
      echo "
      
    
      
     </center>
                                                        </td>
                                                    </tr>";

                                        
                                        }
                                        
                                        
                                        else {
                                        
                                           $consulta="SELECT CODIGO_DOC, NOMBRE_DOC, tipo_doc FROM documento ORDER BY NOMBRE_DOC ASC ";
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
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[NOMBRE_DOC]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'> $fila[tipo_doc]                                                        </td>

                                                         <td><center>
                                                            <a  href=?mod=documento&consultar&codigo=".$fila["CODIGO_DOC"]."><img src='./img/consul.png' width='25' alt='Edicion' class='faa-float animated-hover' title=' CONSULTAR ".$fila["NOMBRE_DOC"]."'></a>";
      
                                echo "
      
      <a  href=?mod=documento&editar&codigo=".$fila["CODIGO_DOC"]."><img src='./img/editar.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DEL DOCUMENTO ".$fila["NOMBRE_DOC"]."'></a> ";
      
      if($tipo2==1){
                                        echo "
      <a   href=?mod=documento&eliminar&codigo=".$fila["CODIGO_DOC"]."><img src='./img/elimina.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ELIMINAR EL DOCUMENTO ".$fila["NOMBRE_DOC"]."'></a>";
      }
    }
      echo "
      
    
      
     </center>
                                                        </td>
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
                                    <h3> <center>Agregar documento <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=documento&nuevo" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO DOCUMENTO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  '; } ?>
                        </br>       
                                
  <div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <center>
                                <div class="box-header">
                                   <h3> <center>Imprimir lista de documentos</a></center></h3>                                    
                                </div>
                                
                                <div>

                                  
                                 <a target='_blank'  href=./pdf/documentoadm.php ><img src='./img/impresora.png'  width='50' alt='Edicion' class='faa-pulse animated' title='Lista de documentos administrativos'><div class='faa-float animated'>Administrativos</div></a>
                                 </div>

                                 <div>

                                  
                                 <a target='_blank'  href=./pdf/documentoapo.php ><img src='./img/impresora.png'  width='50' alt='Edicion' class='faa-pulse animated' title='Lista de documentos de saldo de aportes'><div class='faa-float animated'>Aportes</div></a>
                                 </div>

                                 <div>

                                  
                                 <a target='_blank'  href=./pdf/documentopre.php ><img src='./img/impresora.png'  width='50' alt='Edicion' class='faa-pulse animated' title='Lista de documentos de saldo de préstamos'><div class='faa-float animated'>Préstamos</div></a>
                                 </div>

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
                           

include 'config.php';
    if(is_uploaded_file($_FILES['fichero']['tmp_name'])) { 
     
     
      // creamos las variables para subir a la db
        $ruta = "/SHERATON/pages/archivos/"; 
        $nombrefinal = trim ($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
        //$nombrefinal = ereg_replace (" ", "", $nombrefinal);//Sustituye una expresión regular
        $upload = $_SERVER['DOCUMENT_ROOT'] . $ruta . $nombrefinal;  
        $nombre  = $_POST["nombre"]; 
        $description  = $_POST["description"]; 


        if(move_uploaded_file($_FILES['fichero']['tmp_name'], $upload)) { //movemos el archivo a su ubicacion 
                    

                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';
                            
                            echo " Se actualizó el documento '$nombre' con éxito.";

                            echo " Si desea visualizar el nuevo archivo subido haga click aquí: <i><a target='_blank' href=\"".$ruta . $nombrefinal."\">".$_FILES['fichero']['name']."</a></i><br>";  

                            echo '   </div>';


                            
                    // echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br>";  
                    // echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br>";  
                    // echo "<br><hr><br>";  
                         



                   $query = "UPDATE documento SET nombre_doc='$nombre', tipo_doc='$description', ruta='".$nombrefinal."', tipo='".$_FILES['fichero']['type']."', size='".$_FILES['fichero']['size']."' WHERE CODIGO_DOC='$x1';"; 

       mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$query) or die("Vuelva a intentarlo con un archivo menor a 2MB"); 
       // echo "El archivo '".$nombre."' se ha subido con éxito <br>";       
        }  
    } elseif ($nombre!=="" || $description!=="") {
      # code...
        
        $nombre  = $_POST["nombre"]; 
        $description  = $_POST["description"]; 

      echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';
                            
                            echo " Se actualizó el documento con éxito.";
  
                            echo '   </div>';                            

  $query = "UPDATE documento SET nombre_doc='$nombre', tipo_doc='$description' WHERE CODIGO_DOC='$x1';"; 

       mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$query) or die("Por favor vuelva a intentarlo");                             

    } else {

      echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta!</b>';



                            echo " Asegúrese de seleccionar un archivo válido para actualizar el documento.
";

                            echo '   </div>';
    }


}

                                        
     $consulta="SELECT NOMBRE_DOC, tipo_doc, ruta FROM documento where CODIGO_DOC='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-10">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar documentos</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=documento&editar=editar&codigo='.$x1.'" method="post" enctype="multipart/form-data">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                           
                                            
                                            <label for="exampleInputFile">Nombre</label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control faa-float animated-hover" value="<?php echo $fila['NOMBRE_DOC'] ?>" id="exampleInputEmail1" placeholder="Intoducir el nombre">
                                            
                                            <label for="exampleInputFile">Aplicación</label>
                                                <select  for="exampleInputEmail" class="form-control faa-float animated-hover" name='description'>
                                                   <option value="<?php echo $fila['tipo_doc'] ?>">ACTUAL: <?php echo $fila['tipo_doc'] ?></option>
                                                   <option value="ADMINISTRATIVOS">ADMINISTRATIVOS</option>
                                                   <option  value="APORTES">APORTES</option>
                                                   <option value="PRESTAMOS">PRÉSTAMOS</option>
                                                </select>
<script>
                                             function cambiar(){
                                                var pdrs = document.getElementById('file-upload').files[0].name;
                                                document.getElementById('info').innerHTML = pdrs;
                                            }
                                            </script>
                                            <label for="exampleInputFile">Archivo</label><center>
                                            <label for="file-upload" class="form-control btn-primary subir faa-float animated-hover" title="Tipo de archivos permitidos: *.pdf, *.doc, *.docx, *.xls, *.mpp, *.txt, *.rar, *.zip, *.7z, *.jpg, *.jpeg, *.bmp, *.gif, *.png, *.mp4, *.mp3, *.flac"><i class="fa fa-upload faa-tada animated"></i> SUBIR DOCUMENTO <i class="fa fa-refresh faa-spin animated"></i><i class="faa-horizontal animated"></i></label>
                                            <input name="fichero" id="file-upload" onchange="cambiar()" class="faa-float animated-hover" style="display: none" type="file" size="150" maxlength="5000"><div id="info"></div></center>
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
                           


$nombre=strtoupper($_POST["nombre"]);
$apellido=strtoupper($_POST["apellido"]);

                       
if( $nombre=="" )
                {







$sql="delete from documento where CODIGO_DOC='$x1' ";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



echo " Se eliminó el documento aplicado en '$apellido'.
";
                               echo '   </div>';
                           
                            
                        



}
   
}


                                        
     $consulta="SELECT CODIGO_DOC, NOMBRE_DOC, tipo_doc FROM documento where CODIGO_DOC='$x1'";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-10">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar documentos</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=documento&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                           
                                            
                                            
                                            
                                            <label for="exampleInputFile">Nombre</label>
                                            <input  onkeypress="return caracteres(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="tex" name="nombre" class="form-control" value="<?php echo  $fila['NOMBRE_DOC'] ?>" id="exampleInputEmail1" placeholder="Intoducir el nombre" disabled>

                                            <label for="exampleInputFile">Aplicación</label>
                                                <select  for="exampleInputEmail" class="form-control" name='apellido'>
                                                   <option value="<?php echo $fila['tipo_doc'] ?>">ACTUAL: <?php echo $fila['tipo_doc'] ?></option>
                                                   <option value="ADMINISTRATIVOS" disabled>ADMINISTRATIVOS</option>
                                                   <option  value="APORTES" disabled>APORTES</option>
                                                   <option value="PRESTAMOS" disabled>PRÉSTAMOS</option>
                                                </select>
                                            
  
                                        </div>
                                       
                                     
                                        
                                    </div><!-- /.box-body -->

                                    <div class="box-footer"><center>
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminar" id="eliminar" value="ELIMINAR DOCUMENTO"></center>
                                        
                                    
 

                                    </div>
                                </form>
                            </div><!-- /.box -->
<?php


}




}
if (isset($_GET['guia'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
$ruta="Guia.pdf";
                        if (isset($_POST['guia'])) {
                           
    //$ruta = "/SHERATON/pages/respaldo/"; 
    //$nombrefinal = trim ($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
    //$nombrefinal = ereg_replace (" ", " ", $nombrefinal); //Sustituye una expresión regular                           
   
}


                                        
     
?>
<center>
    <div class="col-md-9">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Vista previa manual de usuario</h3>
                                </div>
                                <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>                                                                    
                                <b>En caso no se visualice el archivo subido se procederá a descargarlo automáticamente</b></div>


                                                        <?php
  echo"

                                                         <td class='faa-float animated-hover'><iframe width='100%' height='470' src=\"pages/respaldo/".$ruta . "\">VER MODELO </a><a class='glyphicon glyphicon-zoom-in'></iframe></td>"; ?>

                                                          


                          
    
<?php


}
?>




