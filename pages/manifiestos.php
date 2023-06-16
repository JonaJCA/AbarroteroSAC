<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");

include './inc/config.php';
//$servidor="localhost";
//$basedatos="hwpaziid_abarrotero";
//$usuario="hwpaziid";
//$pass="OKfz43Ng+h3+L3";

$conn=mysqli_connect("$servidor","$usuario","$pass","$basedatos");
$id_sucursal=$_SESSION['dondequeda_sucursal'];

function opciones() {
      $texto = '';  
      global $conn;
      $sql = "SELECT descripcion_movi FROM movimientos, operaciones WHERE descripcion_ope LIKE '%FLETE%' AND movimientos.id_operacion=operaciones.id_operacion GROUP BY descripcion_movi ORDER BY descripcion_movi ASC";
      
      $resultado = mysqli_query($conn, $sql);
      if (mysqli_num_rows($resultado) > 0){ 

         while($fila = mysqli_fetch_assoc($resultado)){ 
              $texto .= '"' . $fila['descripcion_movi'] . '",';
             }
      
      }else{
               $texto = "NO HAY DESCRIPCIONES REGISTRADAS"; 
      }
      return $texto;
}
$opciones = opciones();
$encargado_firma='"' .trim(strtoupper($_SESSION['dondequeda_nombre'].' '.$_SESSION['dondequeda_apellido'])) . '"';
?>
<script type="text/javascript">
    var descripciones_guia = [<?php echo "$opciones"?>];

    function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}
</script>

<!--<script language="javascript" src="js/jquery-1.11.2.min.js"></script>
        <script>  
            $('.selectpicker').selectpicker({
                style: 'btn btn-file'
            });
        </script>-->

<?php

require ('validarnum.php');
$fecha2=date("Y-m-d");  

$buscar_docu = "SELECT id_documento, nombre_doc FROM documentos WHERE tipo_doc='COMPROBANTES COMUNES' ORDER BY nombre_doc";
$resultado_docu = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_docu);

$query_chofer = "SELECT id_chofer, CONCAT(brevete_cho,' - ',nombre_cho,' ',apellido_cho) AS CHOFER FROM choferes WHERE estado_cho='HABILITADO' ORDER BY nombre_cho, apellido_cho";
$resultado_chofer=mysqli_query($conn,$query_chofer);

$query_vehiculo = "SELECT id_vehiculo, (COALESCE(CASE placa_carreta WHEN '' THEN CONCAT(placa_vehi,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )') ELSE CONCAT(placa_vehi,' / ',placa_carreta,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )') END, CONCAT(placa_vehi,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )'))) AS VEHICULO FROM vehiculos WHERE condicion_vehi='OPERATIVO' ORDER BY marca_vehi, color_vehi, placa_vehi, placa_carreta";
$resultado_vehiculo=mysqli_query($conn,$query_vehiculo);

$query_documentoR = "SELECT id_documento, nombre_doc, tipo_doc FROM documentos WHERE nombre_doc LIKE '%TO DE CARGA%' ORDER BY nombre_doc";
$resultado_documentoR=mysqli_query($conn,$query_documentoR);

$query_manifiesto = "SELECT id_operacion, descripcion_ope, tipo_ope, categoria_ope FROM operaciones WHERE descripcion_ope LIKE '%FLETE%' ORDER BY descripcion_ope";
$resultado_manifiesto=mysqli_query($conn,$query_manifiesto);

$buscar_suc = "SELECT id_sucursal, CONCAT(nombre_suc,'||',direccion_suc) AS DESTINATARIO, nombre_suc FROM sucursales WHERE condicion_suc = 'ACTIVO' ORDER BY nombre_suc; ";
$resultado_suc = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_suc);

if ($tipo2=='1') {

  $buscar_imp_destinatario = "SELECT manifiestos.nombre_dest_mani FROM manifiestos, movimientos WHERE movimientos.id_movimiento=manifiestos.id_movimiento GROUP BY manifiestos.nombre_dest_mani ORDER BY manifiestos.nombre_dest_mani;";
  $resultado_imp_destinatario = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_destinatario);

  $buscar_imp_estado = "SELECT movimientos.estado_movi FROM manifiestos, movimientos WHERE movimientos.id_movimiento=manifiestos.id_movimiento GROUP BY movimientos.estado_movi ORDER BY movimientos.estado_movi;";
  $resultado_imp_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado);

} else {
  
  $buscar_imp_destinatario = "SELECT manifiestos.nombre_dest_mani FROM manifiestos, movimientos, sucursales WHERE movimientos.id_sucursal='$id_sucursal' AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=manifiestos.id_movimiento GROUP BY manifiestos.nombre_dest_mani ORDER BY manifiestos.nombre_dest_mani;";
  $resultado_imp_destinatario = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_destinatario);

  $buscar_imp_estado = "SELECT movimientos.estado_movi FROM manifiestos, movimientos, sucursales WHERE movimientos.id_sucursal='$id_sucursal' AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=manifiestos.id_movimiento GROUP BY movimientos.estado_movi ORDER BY movimientos.estado_movi;";
  $resultado_imp_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado);
}

$buscar_imp_sucursal = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM sucursales, movimientos, manifiestos WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=manifiestos.id_movimiento GROUP BY movimientos.id_sucursal ORDER BY nombre_suc;";
$resultado_imp_sucursal = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal);


if (isset($_GET['nuevomanifiesto'])) { 

                        if (isset($_POST['nuevomanifiesto'])) {

                           
$descripcion=trim(strtoupper($_POST["descripcion"]));
$operacion=trim(strtoupper($_POST["operacion"]));
$documento=trim(strtoupper($_POST["documento"]));
$destinatario=trim(strtoupper($_POST["destinatario"]));
$admin=$_SESSION['dondequeda_id'];
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$fecha_movi=date("Y-m-d");
$hora_movi=date("H:i:s a");
$numero=trim(strtoupper($_POST["numero"]));
$chofer=trim(strtoupper($_POST["chofer"]));
$vehiculo=trim(strtoupper($_POST["vehiculo"]));
$enc_firma=trim(strtoupper($_SESSION['dondequeda_nombre']." ".$_SESSION['dondequeda_apellido']));

if($_POST['nombre_sub']!=null){
        $nombre_sub = trim(strtoupper($_POST['nombre_sub']));
    }else{
        $nombre_sub = null;
    } 

if($_POST['monto']!=null){
        $monto = trim(strtoupper($_POST['monto']));
    }else{
        $monto = '0';
    }     

if($_POST['observacion']!=null){
        $observacion = trim(strtoupper($_POST['observacion']));
    }else{
        $observacion = null;
    }

$sql="SELECT * FROM movimientos";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)>=0){


$registro_remito="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi`, `monto_sub_movi`) VALUES ('$documento', '$id_sucursal', '$operacion', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '0', '$enc_firma', '0000', '$numero', 'EN PROCESO', '$monto')";

$cs=$bd->consulta($registro_remito);

$sql2="SELECT MAX(id_movimiento) AS ULTIMO FROM movimientos WHERE movimientos.id_sucursal='$id_sucursal' AND movimientos.id_operacion='$operacion' ORDER BY id_movimiento DESC";
$cs=$bd->consulta($sql2);
$datos = $bd-> mostrar_registros($sql2);
$ULTIMO_ID = $datos ['ULTIMO'];

if($bd->numeroFilas($cs)>0){

    $registro_guia="INSERT INTO `manifiestos`(`id_movimiento`, `id_chofer`, `id_vehiculo`, `nombre_dest_mani`, `direccion_dest_mani`, `nombre_sub_mani`, `observacion_mani`, `fecha_mani`) VALUES ('$ULTIMO_ID', '$chofer', '$vehiculo', SUBSTRING_INDEX('$destinatario','||',1), SUBSTRING_INDEX('$destinatario','||',-1), '$nombre_sub', '$observacion', '$fecha_movi')";

    $registro_cobranza="INSERT INTO `cobranza`(`id_movimiento`, `fecha_cobro`, `monto_cobro`, `estado_cobro`) VALUES ('$ULTIMO_ID', '$fecha_movi', '0', 'PENDIENTE')";

    $cs=$bd->consulta($registro_guia);
    //$cs=$bd->consulta($registro_cobranza);


                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el manifiesto de carga nuevo correctamente.';
  
                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=manifiestos&listamanifiestos" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró este manifiesto!</b> Ya existe . . . ';



                               echo '   </div>';
}
}else{

    

//CONSULTAR SI EL CAMPO YA EXISTE

      echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta no se registró este manifiesto!</b> Ya existe . . . ';



                               echo '   </div>';
}



}
?>

  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar manifiesto de carga</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=manifiestos&nuevomanifiesto=nuevomanifiesto" method="post">
                                    <div class="box-body">
                                        <div class="form-group">

                                          <div class="autocomplete">
                                            <label for="exampleInputFile">Descripción del manifiesto <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (. _ - ). Se requieren (5-60) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>Caracteres (5-60)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="descripcionm" pattern='.{5,60}' maxlength="60" placeholder="Introducir la descripción del manifiesto" autofocus><script>
                                                autocomplete(document.getElementById("descripcionm"), descripciones_guia);
                                            </script>
                                        </div>

                                            <label for="exampleInputFile">Destinatario ( Sucursal ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un destinatario." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar un destinatario</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=sucursales&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=sucursales&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione un destinatario</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="destinatario" required>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_suc)): ?>
                                                    <option class="btn-primary" value="<?php echo $SUC['DESTINATARIO'] ?>"><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="operacion" id="operacion" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($REM = $resultado_manifiesto->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $REM['id_operacion']; ?>"><?php echo $REM['descripcion_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($DOCM = $resultado_documentoR->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOCM['id_documento']; ?>"><?php echo $DOCM['nombre_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" required>

                                            <label for="exampleInputFile">Chofer <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un chofer. Se puede visualizar el brevete y nombre correspondiente del chofer." onclick="Swal.fire({title: '<h2>Se requiere seleccionar un chofer. Se puede visualizar su brevete correspondiente</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=choferes&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=choferes&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="chofer" id="chofer" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($CHO = $resultado_chofer->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $CHO['id_chofer']; ?>"><?php echo $CHO['CHOFER']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un vehículo. Se puede visualizar la placa, marca, color y tipo del vehículo" onclick="Swal.fire({title: '<h2>Se requiere seleccionar un vehículo. Se puede visualizar sus placas, marca, color y tipo correspondiente</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=vehiculos&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=vehiculos&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="vehiculo" id="vehiculo" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($VEHI = $resultado_vehiculo->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $VEHI['id_vehiculo']; ?>"><?php echo $VEHI['VEHICULO']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Subcontratación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger si hay subcontratación. En caso haya colocarlo." onclick="Swal.fire({title:'<h2>Por favor seleccione si hay subcontratación<br><br>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>                
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" type="text" name="nombre_sub" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre de la subcontratación">

                                            <label for="exampleInputFile">Monto de la subcontratación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>                
                                            <input onkeydown="return decimales(this, event)" type="number" name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.00' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto de la subcontratación">

                                            <label for="exampleInputFile">Observaciones <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-500) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-500)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <textarea onkeypress="return off(event)" rows="6" onblur="this.value=this.value.toUpperCase();" type="text" name="observacion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,500}' maxlength="500" placeholder="Introducir observación"></textarea> 

                                        </div>
                                    </div><!-- /.box-body selectpicker -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevomanifiesto" id="nuevomanifiesto" value="Guardar">Registrar manifiesto</button>
                                    </div>
                                    </center>
                                </form>
                            </div><!-- /.box -->


<?php
}


if (isset($_GET['listamanifiestos'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['listamanifiestos'])) {
     
}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">MANIFIESTOS | Lista de manifiestos de carga emitidos</h3><br><br>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Salida</th>
                                                <th class="faa-float animated-hover">Código</th>
                                                <th class="faa-float animated-hover">Remitente</th>
                                                <th class="faa-float animated-hover">Destinatario</th>
                                                <th class="faa-float animated-hover">Camión</th>
                                                <th class="faa-float animated-hover">Carreta</th>
                                                <th class="faa-float animated-hover">Flete</th>
                                                <th class="faa-float animated-hover">Estado</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT id_manifiesto, movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(movimientos.monto_movi,2)) AS FLETE, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_movi, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND movimientos.id_sucursal='$id_sucursal' ORDER BY SALIDA DESC;";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT id_manifiesto, movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(movimientos.monto_movi,2)) AS FLETE, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_movi, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario ORDER BY SALIDA DESC;";
                                                }

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
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER LA DESCRIPCIÓN DEL MANIFIESTO' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$fila["descripcion_movi"]."<br><br><b>CHOFER:</b><br>".$fila["CHOFER"]." <br><b>BREVETE:</b> ".$fila["BREVETE"].""."<br><br><b>PROPIETARIO:</b><br>".$fila["PROPIETARIO"]." <br><b>RUC:</b> ".$fila["RUC"].""."<br><br><b>EMISIÓN:</b> ".$fila["HORA"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a><a> </a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FECHA]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[MANIFIESTO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[REMITENTE]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[DESTINATARIO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[CAMION]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[CARRETA]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FLETE]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[estado_movi]
                                                            
                                                        </td>";
                                                        
                                                        echo "
                                                        <td><center>";
                                                        echo "
                                                            <a  href=?mod=manifiestos&consultarmanifiesto&codigo=".$fila["id_manifiesto"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title='CONSULTAR LOS DATOS DEL MANIFIESTO DE CARGA ".$fila["numero_movi"]."'></a>";                                                        
      
      
        if ($fila['estado_movi']=='EN PROCESO') {
                                echo "
      <a   href=?mod=manifiestos&adicionarmanifiesto&codigo=".$fila["id_manifiesto"]."><img src='./img/add.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ADICIONAR / ELIMINAR GUÍA, AL MANIFIESTO DE CARGA ".$fila["numero_movi"]."'></a>";}

      if ($tipo2==1) {

        if ($fila['estado_movi']=='EN PROCESO' || $fila['estado_movi']=='DEUDA') {
                                echo "
      <a   href=?mod=manifiestos&eliminarmanifiesto&codigo=".$fila["id_manifiesto"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ANULAR EL MANIFIESTO DE CARGA ".$fila["numero_movi"]."'></a>
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
                                    <h3> <center>Agregar manifiesto <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=manifiestos&nuevomanifiesto" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO MANIFIESTO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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

                                
                                <label for="exampleInputFile">Destinatario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un destinatario para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de manifiestos de carga por destinatario</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_manifiesto_destinatario" onchange="if(this.value=='Seleccione un destinatario para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un destinatario para exportar</option>
                                                <?php while($REMT = mysqli_fetch_assoc($resultado_imp_destinatario)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_manifiesto_destinatario.php?destinatario=<?php echo $REMT['nombre_dest_mani']?>'><?php echo $REMT['nombre_dest_mani'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <label for="exampleInputFile">Estado de manifiesto <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de manifiestos de carga por estado</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_manifiesto_estado" onchange="if(this.value=='Seleccione un estado para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un estado para exportar</option>
                                                <?php while($REME = mysqli_fetch_assoc($resultado_imp_estado)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_manifiesto_estado.php?estado_movi=<?php echo $REME['estado_movi']?>'><?php echo $REME['estado_movi'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <?php if($tipo2==1){ ?>

                                    <label for="exampleInputFile">Nuestras sucursales <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de manifiestos de carga por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_manifiesto_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($REMS = mysqli_fetch_assoc($resultado_imp_sucursal)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_manifiesto_sucursal.php?id_sucursal=<?php echo $REMS['id_sucursal']?>'><?php echo $REMS['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 
                                    <?php } ?>
                                            
                                 </div>
                                 <img src="./img/gif/manifiesto.gif" width="100%" height="200px" title="Realize las entregas de forma adecuada"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>

<?php
}

if (isset($_GET['adicionarmanifiesto'])) { 

$x1=$_GET['codigo'];
                        if (isset($_POST['adicionarmanifiesto'])) {
                           


$id_guia=trim(strtoupper($_POST["id_guia"]));
$escrito=trim(strtoupper($_POST["escrito"]));
$serie=trim(strtoupper($_POST["serie"]));
$numero=trim(strtoupper($_POST["numero"]));
$id=$_SESSION['dondequeda_id'];


$sql="SELECT guias.id_guia FROM guias, movimientos WHERE guias.id_guia='$id_guia' AND estado_movi='SIN ASIGNAR' AND movimientos.id_movimiento=guias.id_movimiento;";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs) > 0){

    $PRECIO_GUIA="SELECT monto_movi FROM movimientos, guias WHERE movimientos.id_movimiento=guias.id_movimiento AND id_guia='$id_guia';";

    $cs=$bd->consulta($PRECIO_GUIA);
    $datos = $bd-> mostrar_registros($PRECIO_GUIA);
    $MONTO_GUIA = $datos ['monto_movi'];

    $sql2="INSERT INTO `carga` (`id_manifiesto`, `id_guia`, `escrito_car`, `serie_car`, `numero_car`) VALUES ('$x1', '$id_guia', '$escrito', '$serie', '$numero');";
    $cs=$bd->consulta($sql2);

    $MOVI="SELECT id_movimiento FROM manifiestos WHERE id_manifiesto='$x1';";

    $cs=$bd->consulta($MOVI);
    $datos2 = $bd-> mostrar_registros($MOVI);
    $ID_MOVI = $datos2 ['id_movimiento'];

    $sql3="UPDATE movimientos SET monto_movi=monto_movi+$MONTO_GUIA, fecha_movi='$fecha2' WHERE id_movimiento='$ID_MOVI';";
    $cs=$bd->consulta($sql3);

    $GUI="SELECT id_movimiento FROM guias WHERE id_guia='$id_guia';";

    $cs=$bd->consulta($GUI);
    $datos3 = $bd-> mostrar_registros($GUI);
    $ID_GUI = $datos3 ['id_movimiento'];

    $sql4="UPDATE movimientos SET estado_movi='ASIGNADA' WHERE id_movimiento='$ID_GUI';";
    $cs=$bd->consulta($sql4);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se adicionó la guía correctamente. ';

                               echo '   </div>';

                                                               echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=manifiestos&listamanifiestos" method="post" id="ContactForm">
    


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
                                        <b>Alerta!</b> No se pudo registrar esta guía. Ya se encuentra asignada o ha ingresado un código inválido. ';



                               echo '   </div>';
}
} elseif (isset($_POST['eliminardetalle'])) {
                           

$id_guia=trim(strtoupper($_POST["id_guia2"]));
$id=$_SESSION['dondequeda_id'];


$sql="SELECT id_guia FROM carga WHERE id_guia='$id_guia';";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs) > 0){

    $PRECIO_GUIA="SELECT monto_movi FROM movimientos, guias WHERE movimientos.id_movimiento=guias.id_movimiento AND id_guia='$id_guia';";

    $cs=$bd->consulta($PRECIO_GUIA);
    $datos = $bd-> mostrar_registros($PRECIO_GUIA);
    $MONTO_GUIA = $datos ['monto_movi'];

    $sql2="DELETE FROM `carga` WHERE id_guia='$id_guia';";
    $cs=$bd->consulta($sql2);

    $MOVI="SELECT id_movimiento FROM manifiestos WHERE id_manifiesto='$x1';";

    $cs=$bd->consulta($MOVI);
    $datos2 = $bd-> mostrar_registros($MOVI);
    $ID_MOVI = $datos2 ['id_movimiento'];

    $sql3="UPDATE movimientos SET monto_movi=monto_movi-$MONTO_GUIA, fecha_movi='$fecha2' WHERE id_movimiento='$ID_MOVI';";
    $cs=$bd->consulta($sql3);

    $GUI="SELECT id_movimiento FROM guias WHERE id_guia='$id_guia';";

    $cs=$bd->consulta($GUI);
    $datos3 = $bd-> mostrar_registros($GUI);
    $ID_GUI = $datos3 ['id_movimiento'];

    $sql4="UPDATE movimientos SET estado_movi='SIN ASIGNAR' WHERE id_movimiento='$ID_GUI';";
    $cs=$bd->consulta($sql4);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se eliminó la descripción correctamente. ';

                               echo '   </div>';

                                  echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=manifiestos&listamanifiestos" method="post" id="ContactForm">
    


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
                                        <b>Alerta!</b> No se pudo eliminar esta descripción. No existe o ha ingresado un código inválido. ';



                               echo '   </div>';
}
} elseif (isset($_POST['finalizar'])) {

$fecha_cobro=trim(strtoupper($_POST["fecha_cobro"]));                           
$id=$_SESSION['dondequeda_id'];


$sql="SELECT id_manifiesto FROM movimientos, manifiestos WHERE id_manifiesto='$x1' AND (estado_movi!='REALIZADO' AND estado_movi!='ANULADO') AND movimientos.id_movimiento=manifiestos.id_movimiento;";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs) > 0){

  $sql="SELECT id_manifiesto FROM carga WHERE id_manifiesto='$x1';";
  $cs=$bd->consulta($sql);

  if($bd->numeroFilas($cs) > 0){

    $MOVI="SELECT id_movimiento FROM manifiestos WHERE id_manifiesto='$x1';";

    $cs=$bd->consulta($MOVI);
    $datos = $bd-> mostrar_registros($MOVI);
    $ID_MOVI = $datos ['id_movimiento'];

    $sql3="UPDATE movimientos SET estado_movi='DEUDA', fecha_movi='$fecha2' WHERE id_movimiento='$ID_MOVI';";
    $cs=$bd->consulta($sql3);

    $DEUDA="SELECT monto_movi FROM movimientos WHERE id_movimiento='$ID_MOVI';";

    $cs=$bd->consulta($DEUDA);
    $datos2 = $bd-> mostrar_registros($DEUDA);
    $MONTO_MOVI = $datos2 ['monto_movi'];

    $registro_cobranza="INSERT INTO `cobranza`(`id_movimiento`, `fecha_cobro`, `monto_cobro`, `monto_pago`, `estado_cobro`) VALUES ('$ID_MOVI', '$fecha_cobro', '$MONTO_MOVI', '0', 'PENDIENTE')";
    $cs=$bd->consulta($registro_cobranza);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se dio por finalizado el manifiesto de carga correctamente. Se ha generado su cobranza.';

                               echo '   </div>';

                                  echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=manifiestos&listamanifiestos" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             '; 
  }
  else{

        echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta!</b> No se pudo dar por finalizado el manifiesto. No cuenta con guías asignadas. ';



                               echo '   </div>';
  }

}else{

//CONSULTAR SI EL CAMPO YA EXISTE
    echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta!</b> No se pudo dar por finalizado el manifiesto. No se encuentra en proceso. ';



                               echo '   </div>';
}
}
?>


  <div class="col-md-3">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <ul class="nav nav-tabs" style="font-weight: bold; font-size: 11px;">
                                  <li class="active">
                                    <a data-toggle="tab" href="#Adicionar">Adicionar</a>
                                  </li>
                                  <li>
                                    <a data-toggle="tab" href="#Eliminar">Eliminar</a>
                                  </li>
                                  <li>
                                    <a data-toggle="tab" href="#Finalizar">Finalizar</a>
                                  </li>
                                </ul>
                                <div class="tab-content">
                                <div id="Adicionar" class="tab-pane fade in active">
                                <div class="box-header">
                                    <h3 class="box-title">Asignar guía de remisión</h3>
                                </div>

                                <?php  echo '  <form role="form"  name="fe" action="?mod=manifiestos&adicionarmanifiesto=adicionarmanifiesto&codigo='.$x1.'" method="post">';
                                ?>

                                    <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Código <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (1-8) caracteres." onclick="Swal.mixin({  progressSteps: ['1', '2'],}).queue([{title: '<h2>Seleccione la opción del menú</h2><br><br><br><br><br><br><br><br><br><br><br><br><br>', text: '', width: 500, height: 500, background: '#fff url(img/ejemplo2.png)', imageWidth: 400, imageHeight: 600,showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>VER SEGUNDO PASO</h4>'}, {title: '<h2>Escriba el código a asignar</h2><br><br><br><br><br><br><br><br><br><br><br><br><br>', text: '', width: 500, height: 500, background: '#fff url(img/ejemplo3.png)', imageWidth: 400, imageHeight: 600,showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'}])"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" required name="id_guia" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="1" min='1' max='99999999' pattern='.{1,8}' maxlength="8" placeholder="Introducir el código">

                                            <label for="exampleInputFile">Documento del proveedor <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento del proveedor." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento del proveedor</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='escrito' required>
                                                   <option class="btn-primary" value="FACTURA">FACTURA</option>
                                                   <option class="btn-primary" value="GUIA">GUÍA</option>
                                                </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{4,4}' maxlength="4" required>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" required>

                                        </div>
                                    <center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="adicionarmanifiesto" id="adicionarmanifiesto" value="Guardar">Actualizar datos</button>
                                    
                                    </div>

                                    </center>
                                </form>
                              </div>
                            </div>
                            <div id="Eliminar" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar guía de remisión</h3>
                                </div>

                                <?php  echo '  <form role="form"  name="fe" action="?mod=manifiestos&adicionarmanifiesto=eliminardetalle&codigo='.$x1.'" method="post">';
                                ?>

                                    <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Código <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (1-8) caracteres." onclick="Swal.mixin({  progressSteps: ['1', '2'],}).queue([{title: '<h2>Seleccione la opción del menú</h2><br><br><br><br><br><br><br><br><br><br><br><br><br>', text: '', width: 500, height: 500, background: '#fff url(img/ejemplo4.png)', imageWidth: 400, imageHeight: 600,showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>VER SEGUNDO PASO</h4>'}, {title: '<h2>Escriba el código a eliminar</h2><br><br><br><br><br><br><br><br><br><br><br><br><br>', text: '', width: 500, height: 500, background: '#fff url(img/ejemplo5.png)', imageWidth: 400, imageHeight: 600, showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'}])"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" required name="id_guia2" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="1" min='1' max='99999999' pattern='.{1,8}' maxlength="8" placeholder="Introducir el código">

                                        </div>
                                    <center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="eliminardetalle" id="eliminardetalle" value="Guardar">Eliminar datos</button>
                                    
                                    </div>

                                    </center>
                                </form>
                              </div>
                            </div>
                            <div id="Finalizar" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">Finalizar manifiesto</h3>
                                </div>

                                <?php  echo '  <form role="form"  name="fe" action="?mod=manifiestos&adicionarmanifiesto=finalizar&codigo='.$x1.'" method="post">';

                                $buscar_fin = "SELECT movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA2, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS SALIDA, DATE_FORMAT(manifiestos.fecha_mani, '%d/%m/%Y') AS FECHA, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, propietarios.ruc_prop AS RUC, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(movimientos.monto_movi,2)) AS FLETE, (COALESCE(CASE manifiestos.nombre_sub_mani WHEN '' THEN 'NO REQUERIDA' ELSE CONCAT(manifiestos.nombre_sub_mani) END, 'NO REQUERIDA')) AS nombre_sub_mani, (COALESCE(CASE manifiestos.observacion_mani WHEN '' THEN 'SIN OBSERVACIONES' ELSE CONCAT(manifiestos.observacion_mani) END, 'SIN OBSERVACIONES')) AS observacion_mani, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_movi, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND (estado_movi='EN PROCESO' OR estado_movi='REALIZADO') AND manifiestos.id_manifiesto='$x1' ORDER BY SALIDA DESC;";

                                $resultado_fin = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_fin);
                                ?>


                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example3" class="table table-bordered table-striped">
                                          <label for="exampleInputFile">Fecha de pago <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Fecha (año/mes/día)." onclick="Swal.fire({title: '<h2> </h2> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>', html: 'Seleccione la fecha<br> Formato ( Ejemplo ): <b>2019-09-30</b>', width: 400, height: 900, background: '#fff url(img/tail.png) 50% 40% no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"><img src="img/invi.png" width="15px" height="18px" frameborder="0"></label>
                                            <input  onblur="this.value=this.value.toUpperCase();" type="text" required name="fecha_cobro" pattern='^([0-9]{4,4}-[0-9]{2,2}-[0-9]{2,2})' class="form-control faa-float animated-hover tail-datetime-field" id="datetime-picker" placeholder="Seleccione la fecha de pago" maxlength="10">

                                            <script type="text/javascript">
                                              document.addEventListener("DOMContentLoaded", function(){
                                                tail.writer(document.querySelector(".tail-datetime-field"));
                                                tail.writer(".tail-datetime-field");
                                            });
                                              tail.DateTime(".tail-datetime-field", {
                                                static:         null,
                                                position:       "top",
                                                classNames:     "",
                                                dateFormat:     "YYYY-mm-dd",
                                                timeFormat:     null,
                                                dateRanges:     [],
                                                weekStart:      "DOM", /* Depends on the tail.DateTime.strings value! */
                                                startOpen:      false,
                                                stayOpen:       true,
                                                zeroSeconds:    false,
                                            });
                                            </script>      
                                            <td>
                                            <h3 class='faa-float animated-hover' style="font-size: 17px;">
                                             <?php while ($fila=mysqli_fetch_assoc($resultado_fin)): ?>
                                            <?php echo "<b>CÓDIGO: </b> $fila[MANIFIESTO]" ?></h3>
                                            </td>
                                         </tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'style="font-size: 17px;"><?php echo "<b>EMISIÓN: </b> $fila[FECHA]" ?></h3></td>
                                         </tr>
                                            <tr><td>
                                            <h3 class='faa-float animated-hover'style="font-size: 17px;"><?php echo "<b>REMITENTE: </b> $fila[REMITENTE]" ?></h3></td>
                                         </tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'style="font-size: 17px;"><?php echo "<b>DESTINATARIO: </b> $fila[DESTINATARIO]" ?></h3></td>
                                         </tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'style="font-size: 17px;"><?php echo "<b>ESTADO: </b> $fila[estado_movi]" ?></h3></td>
                                         </tr>
                                         <tr><td>
                                            <h3 class='faa-float animated-hover'style="font-size: 17px;"><?php echo "<b>SALIDA: </b> $fila[SALIDA]" ?></h3></td>
                                         </tr>
                                            <?php endwhile; ?>
                                         </table>
                                         </center>
                                        </div>
                                       
                                    <div class="box-footer"><center>
                                        <button type="submit" class="btn btn-primary btn-lg" name="finalizar" id="finalizar" value="Guardar">Finalizar manifiesto</button></center>
                                    
                                    </div>

                                    </center>
                                </form>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>


<?php 

$consulta="SELECT movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA2, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS SALIDA, DATE_FORMAT(manifiestos.fecha_mani, '%d/%m/%Y') AS FECHA, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, propietarios.ruc_prop AS RUC, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(movimientos.monto_movi,2)) AS FLETE, (COALESCE(CASE manifiestos.nombre_sub_mani WHEN '' THEN 'NO REQUERIDA' ELSE CONCAT(manifiestos.nombre_sub_mani) END, 'NO REQUERIDA')) AS nombre_sub_mani, (COALESCE(CASE manifiestos.observacion_mani WHEN '' THEN 'SIN OBSERVACIONES' ELSE CONCAT(manifiestos.observacion_mani) END, 'SIN OBSERVACIONES')) AS observacion_mani, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_movi, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND estado_movi='EN PROCESO' AND vehiculos.id_propietario=propietarios.id_propietario AND manifiestos.id_manifiesto='$x1' ORDER BY SALIDA DESC";

$cs=$bd->consulta($consulta);
$datos = $bd-> mostrar_registros($consulta);
//DATOS DEL MANIFIESTO
$DESCRIP = $datos['descripcion_movi'];
$OBSERVACIONES = $datos['observacion_mani'];
$MANIFIESTO_C = $datos['numero_movi'];
$COD_MANI = $datos['MANIFIESTO'];
$REGISTRO = $datos['FECHA'];
$SALIDA = $datos['SALIDA'];
$REMITENTE = $datos['REMITENTE'];
$DESTINATARIO = $datos['DESTINATARIO'];
$DIRE_REMI = $datos['DIRE_REMI'];
$DIRE_DESTI = $datos['DIRE_DESTI'];
$CAMION = $datos['CAMION'];
$CARRETA = $datos['CARRETA'];
$PROPIETARIO = $datos['PROPIETARIO'];
$RUC = $datos['RUC'];
$CHOFER = $datos['CHOFER'];
$BREVETE = $datos['BREVETE'];
$SUBCONTRATACION = $datos['nombre_sub_mani'];
$MONTO_SUB = $datos['MONTO_SUB'];
$FLETE = $datos['FLETE'];

?>                                                        
                      <div class="col-md-9">
                          <div class="box">
                            <ul class="nav nav-tabs" style="font-weight: bold; font-size: 15px;">
                                  <li class="active">
                                    <a data-toggle="tab" href="#Manifiesto">Manifiesto actual</a>
                                  </li>
                                  <li>
                                    <a data-toggle="tab" href="#Guia">Guías sin asignar</a>
                                  </li>
                                </ul>
                                <div class="tab-content">
                                <div id="Manifiesto" class="tab-pane fade in active">
                                <div class="box-header" style="overflow: auto;">
                                    <h3 class="box-title" style="float: left;"><img width="25px" height="25px" frameborder="0" src="img/info.png" title="PRESIONE ACA PARA VER LA DESCRIPCIÓN DEL MANIFIESTO." onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$DESCRIP."<br><br><b>CÓDIGO DEL MANIFIESTO:</b><br>".$COD_MANI."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})'> <?php echo "MANIFIESTO DE CARGA N° ".$MANIFIESTO_C;?></h3>
                                    <h3 class="box-title" style="float: right;"><b><?php echo "TOTAL: ".$FLETE;?></b></h3>
                                </div>
                            <div class="box-body table-responsive">
                                 <div style="overflow: auto; font-size: 11.5px;">
                                  <span style="float: left;">
                                    <b>EMISIÓN:</b> <?php echo $REGISTRO."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>SALIDA:</b> <?php echo $SALIDA."."?>
                                  </span><br>
                                  <span style="float: right;">
                                    <b>REMITENTE ( OFICINA ):</b> <?php echo $REMITENTE."."?>
                                  </span>
                                  <span style="float: left;">
                                    <b>SEÑORES ( OFICINA ):</b> <?php echo $DESTINATARIO."."?>
                                  </span><br>
                                  <span style="float: right;">
                                    <b>DIRECCIÓN:</b> <?php echo $DIRE_REMI."."?>
                                  </span>
                                  <span style="float: left;">
                                    <b>DIRECCIÓN:</b> <?php echo $DIRE_DESTI."."?>
                                  </span><br><br>
                                  <span style="float: left;">
                                    <b>CAMIÓN:</b> <?php echo $CAMION."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>CARRETA:</b> <?php echo $CARRETA."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>PROPIETARIO:</b> <?php echo $PROPIETARIO."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>RUC:</b> <?php echo $RUC."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>CHOFER:</b> <?php echo $CHOFER."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>BREVETE:</b> <?php echo $BREVETE."."?>
                                  </span><br><br>
                                  <span style="float: left;">
                                    <b>OBSERVACIONES:</b> <?php echo $OBSERVACIONES."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>EMPRESA SUBCONTRATADA:</b> <?php echo $SUBCONTRATACION."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>MONTO:</b> <?php echo $MONTO_SUB."."?>
                                  </span> 
                                 </div>
                              <br>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class='faa-float animated-hover'>Ítem</th>
                                                <th class='faa-float animated-hover'>Cliente</th>
                                                <th class='faa-float animated-hover'>Cantidad</th>
                                                <th class='faa-float animated-hover'>Peso ( KG.)</th>
                                                <th class='faa-float animated-hover'>Flete</th>
                                                <th class='faa-float animated-hover'>Código</th>
                                                <th class='faa-float animated-hover'>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                              $consulta_principal="SELECT DISTINCT movimientos.id_movimiento, carga.id_guia, CAST(@s:=@s+1 AS UNSIGNED) AS orden, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, (FORMAT(SUM(monto_deta),2)) AS PRECIO, (CONCAT(carga.escrito_car,' ',carga.serie_car,'-',numero_car)) AS DOCUPROVE FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, detalle, clientes, proveedores, departamentos, provincias, distritos, carga, (SELECT @s:=0) AS s WHERE guias.id_proveedor=proveedores.id_proveedor AND movimientos.id_movimiento=detalle.id_movimiento AND guias.id_guia=carga.id_guia AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND carga.id_manifiesto='$x1' GROUP BY id_carga;";

                                              $TOTALES="SELECT DISTINCT movimientos.id_movimiento, carga.id_guia, CAST(@s:=@s+1 AS UNSIGNED) AS orden, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, (FORMAT(SUM(monto_deta),2)) AS PRECIO FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, detalle, clientes, proveedores, departamentos, provincias, distritos, carga, (SELECT @s:=0) AS s WHERE guias.id_proveedor=proveedores.id_proveedor AND movimientos.id_movimiento=detalle.id_movimiento AND guias.id_guia=carga.id_guia AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND carga.id_manifiesto='$x1' GROUP BY carga.id_manifiesto;";

                                              $cs=$bd->consulta($TOTALES);
                                              $final = $bd-> mostrar_registros($TOTALES);
                                              $CANTIDAD_FINAL = $final ['cantidad_deta'];
                                              $PESO_FINAL = $final ['peso_deta'];
                                              $PRECIO_FINAL = $final ['PRECIO'];

                                        /*$consulta="SELECT id_usuarios,nombre,cedula ,apellido, correo, telefono, direccion FROM usuarios ORDER BY id_usuarios ASC ";*/
                                        $bd->consulta($consulta_principal);
                                        while ($fila_principal=$bd->mostrar_registros()) {
                                            switch ($fila_principal['status']) {
                                                case 1:
                                                    $btn_st = "danger";
                                                    $txtFuncion = "Desactivar";
                                                    break;
                                                
                                                case 0:
                                                    $btn_st = "primary";
                                                    $txtFuncion = "Activar";
                                                    break;
                                            }
                                            echo '  <form role="form"  name="fe" action="?mod=manifiestoss&adicionarmanifiesto=eliminardetalle&detalle='.$fila_principal["id_detalle"].'&codigo='.$fila_principal["id_movimiento"].' method="post">';

                                             echo "<tr>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[orden]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[nombre_cli]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[cantidad_deta] bultos
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[peso_deta] KG.
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[monto_movi]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[id_guia]
                                                        </td>
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER LA DESCRIPCIÓN DE LA GUÍA DE REMISIÓN' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>EMISIÓN:</b><br>".$fila_principal['fecha_movi']." - ".$fila_principal['hora_movi']."<br><br><b>PROVEEDOR:</b><br>".$fila_principal["PROVEEDOR"]."<br><br><b>DOCUMENTO DEL PROVEEDOR:</b><br>".$fila_principal["DOCUPROVE"]."<br><br><b>DOCUMENTO DE LA GUÍA:</b><br>".$fila_principal["GUIA"]."<br><br><b>DESCRIPCIÓN:</b><br>".$fila_principal['descripcion_movi']."<br><br><b>SALIDA:</b><br>".$fila_principal["fecha_hora_guia"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                   </tr>
                                                   </form>";
                                        
                                         } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              <td style="text-align: right;" colspan="2" class='faa-float animated-hover'>
                                                <?php echo "TOTAL "?>
                                              </td>
                                              <td class='faa-float animated-hover'>
                                                <?php if($CANTIDAD_FINAL==1) {
                                                    echo $CANTIDAD_FINAL." bulto";
                                                  } elseif ($CANTIDAD_FINAL>1) {
                                                    echo $CANTIDAD_FINAL." bultos";
                                                  } else {
                                                    echo $CANTIDAD_FINAL." bultos";
                                                  }
                                                ?>
                                              </td>
                                              <td class='faa-float animated-hover'>
                                                <?php echo $PESO_FINAL." KG."?>
                                              </td>
                                              <td colspan="3" class='faa-float animated-hover'>
                                                <?php echo "S/".$PRECIO_FINAL?>
                                              </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    </div><!-- /.box-body -->
                                <!-- form start -->
                            </div><!-- /.box -->
                            
                            <div id="Guia" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title"><img width="25px" height="25px" frameborder="0" src="img/info.png" title="PRESIONE ACA MAYOR INFORMACIÓN DE LAS GUÍAS MOSTRADAS." onclick='Swal.fire({title:"<h4>Se pueden visualizar todas las guías de remisión emitidas que se encuentren <b>SIN ASIGNAR</b> y en las que su flete total tenga un valor mayor a <b>S/0.00</b></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})'> GUÍAS DE REMISIÓN | Lista de rémitos sin asignar</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Remitente</th>
                                                <th class="faa-float animated-hover">Destinatario</th>
                                                <th class="faa-float animated-hover">Peso ( KG.)</th>
                                                <th class="faa-float animated-hover">Flete</th>
                                                <th class="faa-float animated-hover">Código</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta2="SELECT DISTINCT id_guia, movimientos.id_movimiento, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist, CONCAT(SUM(peso_deta),' KG.') AS PESO FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, detalle, clientes, proveedores, departamentos, provincias, distritos WHERE guias.id_proveedor=proveedores.id_proveedor AND movimientos.id_movimiento=detalle.id_movimiento AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND estado_movi='SIN ASIGNAR' AND monto_movi>=0.1 GROUP BY movimientos.id_movimiento ORDER BY fecha_movi;";

                                        $bd->consulta($consulta2);
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
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER LA DESCRIPCIÓN DE LA GUÍA DE REMISIÓN' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>EMISIÓN:</b><br>".$fila['fecha_movi']." - ".$fila['hora_movi']."<br><br><b>PROVEEDOR:</b><br>".$fila["PROVEEDOR"]."<br><br><b>DOCUMENTO:</b><br>".$fila["GUIA"]."<br><br><b>DESCRIPCIÓN:</b><br>".$fila['descripcion_movi']."<br><br><b>SALIDA:</b><br>".$fila["fecha_hora_guia"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a><a> </a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>";
                                                            if($fila['envio_guia']=='1'){ echo $fila['PROVEEDOR']; }
                                                            elseif ($fila['envio_guia']=='2'){ echo $fila['nombre_cli']; }
                                                            elseif ($fila['envio_guia']=='3'){ echo $fila['cliente2_guia']; }
                                                            else { echo "DESCONOCIDO";}  
                                                        echo "</td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_cli]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[PESO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[monto_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[id_guia]
                                                            ";

                                                            } 
                                               echo "</td>
                                                    </tr>";
                                        

                                        } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>


<?php
}
}


if (isset($_GET['eliminarmanifiesto'])) { 

$x1=$_GET['codigo'];

                        if (isset($_POST['eliminarmanifiesto'])) {
                
$MOVI="SELECT id_movimiento FROM manifiestos WHERE id_manifiesto='$x1';";

    $cs=$bd->consulta($MOVI);
    $datos = $bd-> mostrar_registros($MOVI);
    $ID_MOVI = $datos ['id_movimiento'];

$sql="UPDATE movimientos SET estado_movi='ANULADO' WHERE id_movimiento='$ID_MOVI';";
$bd->consulta($sql);


$sql2="UPDATE movimientos, guias, carga SET movimientos.estado_movi='SIN ASIGNAR' WHERE movimientos.id_movimiento=guias.id_movimiento AND carga.id_guia=guias.id_guia AND carga.id_manifiesto='$x1' AND movimientos.estado_movi='ASIGNADA';";
$bd->consulta($sql2);

                          
   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se anuló el manifiesto de carga correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=manifiestos&listamanifiestos" method="post" id="ContactForm">
    


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
   



                                        
     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, numero_movi, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',numero_movi) END) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, CONCAT(nombre,' ',apellido) AS nomape, nombre_suc, estado_movi, sucursales.id_sucursal, CONCAT(brevete_cho,' - ',nombre_cho,' ',apellido_cho) AS CHOFER, (COALESCE(CASE placa_carreta WHEN '' THEN CONCAT(placa_vehi,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )') ELSE CONCAT(placa_vehi,' / ',placa_carreta,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )') END, CONCAT(placa_vehi,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )'))) AS VEHICULO, observacion_mani, CONCAT('S/',FORMAT(monto_sub_movi,2)) AS monto_sub_movi2, monto_sub_movi, nombre_sub_mani FROM choferes, manifiestos, movimientos, operaciones, documentos, administrador, sucursales, vehiculos WHERE manifiestos.id_chofer=choferes.id_chofer AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND manifiestos.id_manifiesto='$x1' AND estado_movi!='ANULADO' ORDER BY fecha_movi, hora_movi";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Está a punto de anular el manifiesto de carga actual . . .";


                                echo '   </div>'; ?>

  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Anular manifiesto de carga</h3>
                                </div>
                                                            
                                <!-- form start -->
                                <?php  echo '  <form role="form"  name="fe" action="?mod=manifiestos&eliminarmanifiesto=eliminarmanifiesto&codigo='.$x1.'" method="post">';
                                ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                          <div class="autocomplete">
                                            <label for="exampleInputFile">Descripción del manifiesto <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (. _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="descripcionm" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción del manifiesto" value="<?php echo $fila['descripcion_movi']?>" disabled><script>
                                                autocomplete(document.getElementById("descripcionm"), descripciones_guia);
                                            </script>
                                        </div>

                                            <label for="exampleInputFile">Destinatario ( Sucursal ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un destinatario." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar un destinatario</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=sucursales&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=sucursales&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione un destinatario</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="destinatario" required>
                                              <option class='btn-danger' value='<?php echo $fila['id_sucursal']; ?>'>ACTUAL: <?php echo $fila['nombre_suc']; ?></option>
                                                <?php while($SUC = mysqli_fetch_assoc($resultado_suc)): ?>
                                                    <option class="btn-primary" value="<?php echo $SUC['DESTINATARIO'] ?>" disabled><?php echo $SUC['nombre_suc'] ?></option>
                                                <?php endwhile; ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="operacion" id="operacion" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['descripcion_ope']; ?>'>ACTUAL: <?php echo $fila['descripcion_ope']; ?></option>
                                                <?php while($REM = $resultado_manifiesto->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $REM['id_operacion']; ?>" disabled><?php echo $REM['descripcion_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['nombre_doc']; ?>'>ACTUAL: <?php echo $fila['nombre_doc']; ?></option>
                                                <?php while($DOCM = $resultado_documentoR->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOCM['id_documento']; ?>" disabled><?php echo $DOCM['nombre_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" min="1" max="99999999" step="1" pattern='.{8,12}' maxlength="12" value="<?php echo $fila['numero_movi']?>" required disabled>

                                            <label for="exampleInputFile">Chofer <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un chofer. Se puede visualizar el brevete y nombre correspondiente del chofer." onclick="Swal.fire({title: '<h2>Se requiere seleccionar un chofer. Se puede visualizar su brevete correspondiente</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=choferes&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=choferes&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="chofer" id="chofer" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['CHOFER']; ?>'>ACTUAL: <?php echo $fila['CHOFER']; ?></option>
                                                <?php while($CHO = $resultado_chofer->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $CHO['id_chofer']; ?>" disabled><?php echo $CHO['CHOFER']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un vehículo. Se puede visualizar la placa, marca, color y tipo del vehículo" onclick="Swal.fire({title: '<h2>Se requiere seleccionar un vehículo. Se puede visualizar sus placas, marca, color y tipo correspondiente</h2>', html: 'En caso no encuentres el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=vehiculos&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=vehiculos&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="vehiculo" id="vehiculo" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='<?php echo $fila['VEHICULO']; ?>'>ACTUAL: <?php echo $fila['VEHICULO']; ?></option>
                                                <?php while($VEHI = $resultado_vehiculo->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $VEHI['id_vehiculo']; ?>" disabled><?php echo $VEHI['VEHICULO']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Subcontratación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger si hay subcontratación. En caso haya colocarlo." onclick="Swal.fire({title:'<h2>Por favor seleccione si hay subcontratación<br><br>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>                
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" type="text" name="nombre_sub" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre de la subcontratación" value="<?php if($fila['nombre_sub_mani']=='') { echo "SIN SUBCONTRATACIÓN REGISTRADA";} else echo $fila['nombre_sub_mani'] ?>" disabled>

                                            <label for="exampleInputFile">Monto de la subcontratación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>                
                                            <input onkeydown="return decimales(this, event)" type="text" name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.00' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto de la subcontratación" value="<?php if($fila['monto_sub_movi']=='0') { echo "SIN MONTO REGISTRADO";} else echo $fila['monto_sub_movi2'] ?>" disabled>

                                            <label for="exampleInputFile">Observaciones <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-500) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>'+'Caracteres (5-500)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>
                                            <textarea onkeypress="return off(event)" rows="6" onblur="this.value=this.value.toUpperCase();" type="text" name="observacion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,500}' maxlength="500" placeholder="Introducir observación" disabled><?php if($fila['observacion_mani']=='') { echo "SIN OBSERVACIONES";} else echo $fila['observacion_mani'] ?></textarea> 

                                        </div>
                                    </div><!-- /.box-body selectpicker -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="eliminarmanifiesto" id="eliminarmanifiesto" value="Guardar">Anular manifiesto</button>
                                    </div>
                                    </center>
                                </form>
                            </div><!-- /.box -->


<?php
}
}

if (isset($_GET['consultarmanifiesto'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['consultarmanifiesto'])) {
                           

   
}

$consulta2="SELECT movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA2, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS SALIDA, DATE_FORMAT(manifiestos.fecha_mani, '%d/%m/%Y') AS FECHA, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, propietarios.ruc_prop AS RUC, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(movimientos.monto_movi,2)) AS FLETE, (COALESCE(CASE manifiestos.nombre_sub_mani WHEN '' THEN 'NO REQUERIDA' ELSE CONCAT(manifiestos.nombre_sub_mani) END, 'NO REQUERIDA')) AS nombre_sub_mani, (COALESCE(CASE manifiestos.observacion_mani WHEN '' THEN 'SIN OBSERVACIONES' ELSE CONCAT(manifiestos.observacion_mani) END, 'SIN OBSERVACIONES')) AS observacion_mani, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_movi, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND manifiestos.id_manifiesto='$x1' ORDER BY SALIDA DESC";

$cs=$bd->consulta($consulta2);
$datos = $bd-> mostrar_registros($consulta2);
//DATOS DEL MANIFIESTO
$DESCRIP = $datos['descripcion_movi'];
$OBSERVACIONES = $datos['observacion_mani'];
$MANIFIESTO_C = $datos['numero_movi'];
$COD_MANI = $datos['MANIFIESTO'];
$REGISTRO = $datos['FECHA'];
$SALIDA = $datos['SALIDA'];
$REMITENTE = $datos['REMITENTE'];
$DESTINATARIO = $datos['DESTINATARIO'];
$DIRE_REMI = $datos['DIRE_REMI'];
$DIRE_DESTI = $datos['DIRE_DESTI'];
$CAMION = $datos['CAMION'];
$CARRETA = $datos['CARRETA'];
$PROPIETARIO = $datos['PROPIETARIO'];
$RUC = $datos['RUC'];
$CHOFER = $datos['CHOFER'];
$BREVETE = $datos['BREVETE'];
$SUBCONTRATACION = $datos['nombre_sub_mani'];
$MONTO_SUB = $datos['MONTO_SUB'];
$FLETE = $datos['FLETE'];


                                        
     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, numero_movi, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' N° ',numero_movi) END) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, CONCAT(nombre,' ',apellido) AS nomape, nombre_suc, estado_movi FROM manifiestos, movimientos, operaciones, documentos, administrador, sucursales WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND manifiestos.id_manifiesto='$x1' ORDER BY fecha_movi, hora_movi";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                              <ul class="nav nav-tabs" style="font-weight: bold; font-size: 15px;">
                                  <li class="active"><a data-toggle="tab" href="#rapida">Vista general</a></li>
                                  <li><a data-toggle="tab" href="#detallada">Vista detallada</a></li>
                                </ul>

                                <div class="tab-content">
                                <div id="rapida" class="tab-pane fade in active">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del manifiesto de carga</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example2" class="table table-bordered table-striped"><tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Código</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $COD_MANI ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Registro</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['fecha_movi']." - ".$fila['hora_movi'] ?></td>
                                         </tr><tr><td>
                                            <h3 class='faa-float animated-hover'> Descripción</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['descripcion_movi'] ?></td></tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Operación</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['descripcion_ope']." ( ".$fila['categoria_ope']." )" ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Documento</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['DOCUMENTO'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Flete</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['monto_movi'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Encargado</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['nomape']." ( ".$fila['nombre_suc']." )" ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Estado</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['estado_movi'] ?></td>
                                         </tr>
                                         </table>
                                         </center>
                                       
                                     
                                        
                                    </div><!-- /.box-body -->
                                  </div>
                                </form>
                              </div>
                            <div id="detallada" class="tab-pane fade">
                                <div class="box-header" style="overflow: auto;">
                                    <h3 class="box-title" style="float: left;"><img width="25px" height="25px" frameborder="0" src="img/info.png" title="PRESIONE ACA PARA VER LA DESCRIPCIÓN DEL MANIFIESTO." onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$DESCRIP."<br><br><b>CÓDIGO DEL MANIFIESTO:</b><br>".$COD_MANI."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})'> <?php echo "MANIFIESTO DE CARGA N° ".$MANIFIESTO_C;?></h3>
                                    <h3 class="box-title" style="float: right;"><b><?php echo "TOTAL: ".$FLETE;?></b></h3>
                                </div>
                            <div class="box-body table-responsive">
                                 <div style="overflow: auto; font-size: 11.5px;">
                                  <span style="float: left;">
                                    <b>EMISIÓN:</b> <?php echo $REGISTRO."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>SALIDA:</b> <?php echo $SALIDA."."?>
                                  </span><br>
                                  <span style="float: right;">
                                    <b>REMITENTE ( OFICINA ):</b> <?php echo $REMITENTE."."?>
                                  </span>
                                  <span style="float: left;">
                                    <b>SEÑORES ( OFICINA ):</b> <?php echo $DESTINATARIO."."?>
                                  </span><br>
                                  <span style="float: right;">
                                    <b>DIRECCIÓN:</b> <?php echo $DIRE_REMI."."?>
                                  </span>
                                  <span style="float: left;">
                                    <b>DIRECCIÓN:</b> <?php echo $DIRE_DESTI."."?>
                                  </span><br><br>
                                  <span style="float: left;">
                                    <b>CAMIÓN:</b> <?php echo $CAMION."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>CARRETA:</b> <?php echo $CARRETA."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>PROPIETARIO:</b> <?php echo $PROPIETARIO."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>RUC:</b> <?php echo $RUC."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>CHOFER:</b> <?php echo $CHOFER."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>BREVETE:</b> <?php echo $BREVETE."."?>
                                  </span><br><br>
                                  <span style="float: left;">
                                    <b>OBSERVACIONES:</b> <?php echo $OBSERVACIONES."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>EMPRESA SUBCONTRATADA:</b> <?php echo $SUBCONTRATACION."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>MONTO:</b> <?php echo $MONTO_SUB."."?>
                                  </span> 
                                 </div>
                              <br>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class='faa-float animated-hover'>Ítem</th>
                                                <th class='faa-float animated-hover'>Cliente</th>
                                                <th class='faa-float animated-hover'>Cantidad</th>
                                                <th class='faa-float animated-hover'>Peso ( KG.)</th>
                                                <th class='faa-float animated-hover'>Flete</th>
                                                <th class='faa-float animated-hover'>Código</th>
                                                <th class='faa-float animated-hover'>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                              $consulta_principal="SELECT DISTINCT movimientos.id_movimiento, carga.id_guia, CAST(@s:=@s+1 AS UNSIGNED) AS orden, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, (FORMAT(SUM(monto_deta),2)) AS PRECIO, (CONCAT(carga.escrito_car,' ',carga.serie_car,'-',carga.numero_car)) AS DOCUPROVE FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, detalle, clientes, proveedores, departamentos, provincias, distritos, carga, (SELECT @s:=0) AS s WHERE guias.id_proveedor=proveedores.id_proveedor AND movimientos.id_movimiento=detalle.id_movimiento AND guias.id_guia=carga.id_guia AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND carga.id_manifiesto='$x1' GROUP BY id_carga;";

                                              $TOTALES="SELECT DISTINCT movimientos.id_movimiento, carga.id_guia, CAST(@s:=@s+1 AS UNSIGNED) AS orden, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, (FORMAT(SUM(monto_deta),2)) AS PRECIO FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, detalle, clientes, proveedores, departamentos, provincias, distritos, carga, (SELECT @s:=0) AS s WHERE guias.id_proveedor=proveedores.id_proveedor AND movimientos.id_movimiento=detalle.id_movimiento AND guias.id_guia=carga.id_guia AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND carga.id_manifiesto='$x1' GROUP BY carga.id_manifiesto;";

                                              $cs=$bd->consulta($TOTALES);
                                              $final = $bd-> mostrar_registros($TOTALES);
                                              $CANTIDAD_FINAL = $final ['cantidad_deta'];
                                              $PESO_FINAL = $final ['peso_deta'];
                                              $PRECIO_FINAL = $final ['PRECIO'];

                                        /*$consulta="SELECT id_usuarios,nombre,cedula ,apellido, correo, telefono, direccion FROM usuarios ORDER BY id_usuarios ASC ";*/
                                        $bd->consulta($consulta_principal);
                                        while ($fila_principal=$bd->mostrar_registros()) {
                                            switch ($fila_principal['status']) {
                                                case 1:
                                                    $btn_st = "danger";
                                                    $txtFuncion = "Desactivar";
                                                    break;
                                                
                                                case 0:
                                                    $btn_st = "primary";
                                                    $txtFuncion = "Activar";
                                                    break;
                                            }
                                            echo '  <form role="form"  name="fe" action="?mod=manifiestoss&adicionarmanifiesto=eliminardetalle&detalle='.$fila_principal["id_detalle"].'&codigo='.$fila_principal["id_movimiento"].' method="post">';

                                             echo "<tr>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[orden]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[nombre_cli]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[cantidad_deta] bultos
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[peso_deta] KG.
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[monto_movi]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[id_guia]
                                                        </td>
                                                        <td><center>
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER LA DESCRIPCIÓN DE LA GUÍA DE REMISIÓN' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>EMISIÓN:</b><br>".$fila_principal['fecha_movi']." - ".$fila_principal['hora_movi']."<br><br><b>PROVEEDOR:</b><br>".$fila_principal["PROVEEDOR"]."<br><br><b>DOCUMENTO DEL PROVEEDOR:</b><br>".$fila_principal["DOCUPROVE"]."<br><br><b>DOCUMENTO DE LA GUÍA:</b><br>".$fila_principal["GUIA"]."<br><br><b>DESCRIPCIÓN:</b><br>".$fila_principal['descripcion_movi']."<br><br><b>SALIDA:</b><br>".$fila_principal["fecha_hora_guia"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                   </tr>
                                                   </form>";
                                        
                                         } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              <td style="text-align: right;" colspan="2" class='faa-float animated-hover'>
                                                <?php echo "TOTAL "?>
                                              </td>
                                              <td class='faa-float animated-hover'>
                                                <?php if($CANTIDAD_FINAL==1) {
                                                    echo $CANTIDAD_FINAL." bulto";
                                                  } elseif ($CANTIDAD_FINAL>1) {
                                                    echo $CANTIDAD_FINAL." bultos";
                                                  } else {
                                                    echo $CANTIDAD_FINAL." bultos";
                                                  }
                                                ?>
                                              </td>
                                              <td class='faa-float animated-hover'>
                                                <?php echo $PESO_FINAL." KG."?>
                                              </td>
                                              <td colspan="3" class='faa-float animated-hover'>
                                                <?php echo "S/".$PRECIO_FINAL?>
                                              </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div></div>

<?php




                                echo '
  <div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=manifiestos&listamanifiestos" method="post" id="ContactForm">
    


 <input title="REGRESAR A LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  ';  ?>

<br>                            

<div class="col-md-3">
  <div class="box">
                              <div class="box-header">
                                <center>
                                <div class="box-header">
                                   <h3> <center>Imprimir manifiesto</a></center></h3>
                                <div>
                                  
                                 <a target='_blank'  href='./pdf/manifiesto_doc.php?id_manifiesto=<?php echo "$x1"?>'><img src='./img/impresora.png'  width='50' alt='Edicion' class='faa-pulse animated' title='Imprimir manifiesto actual'><div class='faa-float animated' style="font-size: 18px;"><b><?php echo "$COD_MANI"?></b></div></a>

                                </center>
                              </div>
  </div>
</div>
    
<?php

}
}
}

?>
