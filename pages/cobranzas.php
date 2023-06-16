<?php
date_default_timezone_set('America/Lima');
header("Content-Type: text/html;charset=utf-8");

include './inc/config.php';
//$servidor="localhost";
//$basedatos="hwpaziid_abarrotero";
//$usuario="hwpaziid";
//$pass="OKfz43Ng+h3+L3";

$conn=mysqli_connect("$servidor","$usuario","$pass","$basedatos");

require ('validarnum.php');

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

<?php
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$fecha2=date("Y-m-d");  

if ($tipo2=='1') {

  $buscar_imp_destinatario = "SELECT manifiestos.nombre_dest_mani FROM manifiestos, movimientos WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND (estado_movi = 'DEUDA' OR estado_movi = 'PAGADO') GROUP BY manifiestos.nombre_dest_mani ORDER BY manifiestos.nombre_dest_mani;";
  $resultado_imp_destinatario = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_destinatario);

  $buscar_imp_estado = "SELECT movimientos.estado_movi, cobranza.estado_cobro FROM manifiestos, movimientos, cobranza WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND cobranza.id_movimiento=movimientos.id_movimiento GROUP BY movimientos.estado_movi ORDER BY cobranza.estado_cobro;";
  $resultado_imp_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado);

} else {
  
  $buscar_imp_destinatario = "SELECT manifiestos.nombre_dest_mani FROM manifiestos, movimientos, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=manifiestos.id_movimiento AND (estado_movi = 'DEUDA' OR estado_movi = 'PAGADO') AND movimientos.id_sucursal='$id_sucursal' GROUP BY manifiestos.nombre_dest_mani ORDER BY manifiestos.nombre_dest_mani;";
  $resultado_imp_destinatario = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_destinatario);

  $buscar_imp_estado = "SELECT movimientos.estado_movi, cobranza.estado_cobro FROM manifiestos, movimientos, cobranza, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=manifiestos.id_movimiento AND cobranza.id_movimiento=movimientos.id_movimiento AND movimientos.id_sucursal='$id_sucursal' GROUP BY movimientos.estado_movi ORDER BY cobranza.estado_cobro;";
  $resultado_imp_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado);
}

$buscar_imp_sucursal = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM sucursales, movimientos, manifiestos WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=manifiestos.id_movimiento AND (estado_movi = 'DEUDA' OR estado_movi = 'PAGADO') GROUP BY movimientos.id_sucursal ORDER BY nombre_suc;";
$resultado_imp_sucursal = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal);


if (isset($_GET['listacobranza'])) { 

                        if (isset($_POST['listacobranza'])) {
     
}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                              <ul class="nav nav-tabs" style="font-weight: bold; font-size: 15px;">
                                  <li class="active"><a data-toggle="tab" href="#pendientes">Pendientes</a></li>
                                  <li><a data-toggle="tab" href="#realizadas">Realizadas</a></li>
                                </ul>

                                <div class="tab-content">
                                <div id="pendientes" class="tab-pane fade in active">
                                <div class="box-header">
                                    <h3 class="box-title">COBRANZAS | Lista de cobranzas pendientes</h3><br><br>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Código</th>
                                                <th class="faa-float animated-hover">Remitente</th>
                                                <th class="faa-float animated-hover">Destinatario</th>
                                                <th class="faa-float animated-hover">Cobro</th>
                                                <th class="faa-float animated-hover">Flete</th>
                                                <th class="faa-float animated-hover">Pagado</th>
                                                <th class="faa-float animated-hover">Deuda</th>
                                                <th class="faa-float animated-hover">Pago</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT cobranza.id_cobro, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, manifiestos.id_manifiesto, movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND movimientos.id_sucursal='$id_sucursal' AND estado_movi='DEUDA' ORDER BY SALIDA DESC;";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT cobranza.id_cobro, manifiestos.id_manifiesto, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND estado_movi='DEUDA' ORDER BY SALIDA DESC;";
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
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER LA DESCRIPCIÓN DEL MANIFIESTO' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$fila["descripcion_movi"]."<br><br><b>CHOFER:</b><br>".$fila["CHOFER"]." <br><b>BREVETE:</b> ".$fila["BREVETE"].""."<br><br><b>VEHÍCULO:</b><br><b>CAMIÓN:</b> ".$fila["CAMION"]."<br><b>CARRETA:</b> ".$fila["CARRETA"].""."<br><br><b>PROPIETARIO:</b><br>".$fila["PROPIETARIO"]." <br><b>RUC:</b> ".$fila["RUC"].""."<br><br><b>SALIDA:</b> ".$fila["FECHA"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a><a> </a>
                                                        </td></center>
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
                                                           
                                                              $fila[FECHA_COBRO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FLETE]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[PAGO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[DEUDA]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FECHA_PAGO]
                                                            
                                                        </td>";
                                                        
                                                        echo "
                                                        <td><center>";
                                                        echo "
                                                            <a  href=?mod=cobranzas&consultarcobranza&codigo=".$fila["id_cobro"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title='CONSULTAR LOS DATOS DE LA COBRANZA DEL MANIFIESTO DE CARGA ".$fila["numero_movi"]."'></a>

                                                            <a  href=?mod=cobranzas&nuevopago&codigo=".$fila["id_cobro"]."><img src='./img/descargo2.png' class='faa-float animated-hover' width='25' alt='Edicion' title='REALIZAR PAGO DEL MANIFIESTO DE CARGA ".$fila["numero_movi"]."'></a>";         
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
                            <div id="realizadas" class="tab-pane fade">
                              <div class="box-header">
                                    <h3 class="box-title">COBRANZAS | Lista de cobranzas realizadas</h3><br><br>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Código</th>
                                                <th class="faa-float animated-hover">Remitente</th>
                                                <th class="faa-float animated-hover">Destinatario</th>
                                                <th class="faa-float animated-hover">Cobro</th>
                                                <th class="faa-float animated-hover">Flete</th>
                                                <th class="faa-float animated-hover">Pagado</th>
                                                <th class="faa-float animated-hover">Deuda</th>
                                                <th class="faa-float animated-hover">Pago</th>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT cobranza.id_cobro, manifiestos.id_manifiesto, movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND movimientos.id_sucursal='$id_sucursal' AND estado_movi='PAGADO' ORDER BY SALIDA DESC;";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT cobranza.id_cobro, manifiestos.id_manifiesto, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND estado_movi='PAGADO' ORDER BY SALIDA DESC;";
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
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER LA DESCRIPCIÓN DEL MANIFIESTO' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$fila["descripcion_movi"]."<br><br><b>CHOFER:</b><br>".$fila["CHOFER"]." <br><b>BREVETE:</b> ".$fila["BREVETE"].""."<br><br><b>VEHÍCULO:</b><br><b>CAMIÓN:</b> ".$fila["CAMION"]."<br><b>CARRETA:</b> ".$fila["CARRETA"].""."<br><br><b>PROPIETARIO:</b><br>".$fila["PROPIETARIO"]." <br><b>RUC:</b> ".$fila["RUC"].""."<br><br><b>SALIDA:</b> ".$fila["FECHA"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a><a> </a>
                                                        </td></center>
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
                                                           
                                                              $fila[FECHA_COBRO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FLETE]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[PAGO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[DEUDA]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FECHA_PAGO]
                                                            
                                                        </td>";
                                                        
                                                        echo "
                                                        <td><center>";
                                                        echo "
                                                            <a  href=?mod=cobranzas&consultarcobranza&codigo=".$fila["id_cobro"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title='CONSULTAR LOS DATOS DE LA COBRANZA DEL MANIFIESTO DE CARGA ".$fila["numero_movi"]."'></a>";         
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
                    </div></div>


<div class="col-md-3">
  <div class="box">
                                <div class="box-header">
                                <center>
                                <div class="box-header">
                                   <h3> <center>Imprimir listado</center></h3>
                                </div>

                                
                                <label for="exampleInputFile">Destinatario <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un destinatario para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cobranzas por destinatario</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_cobranza_destinatario" onchange="if(this.value=='Seleccione un destinatario para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un destinatario para exportar</option>
                                                <?php while($REMT = mysqli_fetch_assoc($resultado_imp_destinatario)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_cobranza_destinatario.php?destinatario=<?php echo $REMT['nombre_dest_mani']?>'><?php echo $REMT['nombre_dest_mani'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <label for="exampleInputFile">Estado de cobranza <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cobranzas por estado</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_manifiesto_estado" onchange="if(this.value=='Seleccione un estado para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un estado para exportar</option>
                                                <?php while($REME = mysqli_fetch_assoc($resultado_imp_estado)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_cobranza_estado.php?estado_movi=<?php echo $REME['estado_cobro']?>'><?php echo $REME['estado_cobro'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <?php if($tipo2==1){ ?>

                                    <label for="exampleInputFile">Nuestras sucursales <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de cobranzas por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_cobranza_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($REMS = mysqli_fetch_assoc($resultado_imp_sucursal)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_cobranza_sucursal.php?id_sucursal=<?php echo $REMS['id_sucursal']?>'><?php echo $REMS['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 
                                    <?php } ?>
                                            
                                 </div>
                                 <img src="./img/gif/cobranza.gif" width="100%" height="200px" title="Tenga a la mano las cuentas por cobrar"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>

<?php
}
?>
<?php
      if (isset($_GET['nuevopago'])) { 

 $x1=$_GET['codigo'];

                        if (isset($_POST['nuevopago'])) {


 $descripcion=trim(strtoupper($_POST["descripcion"]));                           
 $monto=trim(strtoupper($_POST["monto"]));
 $admin=$_SESSION['dondequeda_id'];
 $id_sucursal=$_SESSION['dondequeda_sucursal'];
 $fecha_movi=date("Y-m-d");
 $hora_movi=date("H:i:s a");
 $enc_firma=trim(strtoupper($_SESSION['dondequeda_nombre']." ".$_SESSION['dondequeda_apellido']));


$consulta_deuda="SELECT CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, (cobranza.monto_pago) AS PAGO_ID, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, (cobranza.monto_cobro-cobranza.monto_pago) AS DEUDA_ID FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND cobranza.id_cobro='$x1'";

$cs=$bd->consulta($consulta_deuda);
$datosD = $bd-> mostrar_registros($consulta_deuda);
        
//DATOS DEL MANIFIESTO
$DEUDA_ID = $datosD['DEUDA_ID'];
$PAGO_ID = $datosD['PAGO_ID'];

if ($monto == $DEUDA_ID) {

    if ($PAGO_ID == '0') {

        $ACTUALIZAR_MOVI="UPDATE movimientos, cobranza SET estado_movi='PAGADO', fecha_pago=CURDATE(), monto_pago='$monto', estado_cobro='PAGADO' WHERE cobranza.id_cobro='$x1' AND movimientos.id_movimiento=cobranza.id_movimiento;";

        $INSERTAR_MOVIMIENTO="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi`, `monto_sub_movi`) VALUES ('75', '$id_sucursal', '63', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '$monto', '$enc_firma', '0000', '00000000', 'COBRO' ,'0')";

    } elseif ($PAGO_ID > '0') {

        $ACTUALIZAR_MOVI="UPDATE movimientos, cobranza SET estado_movi='PAGADO', fecha_pago=CURDATE(), monto_pago=monto_pago+'$monto', estado_cobro='PAGADO' WHERE cobranza.id_cobro='$x1' AND movimientos.id_movimiento=cobranza.id_movimiento;";

        $INSERTAR_MOVIMIENTO="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi`, `monto_sub_movi`) VALUES ('75', '$id_sucursal', '63', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '$monto', '$enc_firma', '0000', '00000000', 'COBRO' ,'0')";
    }

} elseif ($monto < $DEUDA_ID) {

    $ACTUALIZAR_MOVI="UPDATE movimientos, cobranza SET fecha_pago=CURDATE(), monto_pago=monto_pago+'$monto' WHERE cobranza.id_cobro='$x1' AND movimientos.id_movimiento=cobranza.id_movimiento;";

    $INSERTAR_MOVIMIENTO="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi`, `monto_sub_movi`) VALUES ('75', '$id_sucursal', '63', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '$monto', '$enc_firma', '0000', '00000000', 'COBRO' ,'0')";

}
    
    $INSERTAR_HISTORIAL="INSERT INTO `historial` (`id_cobro`, `fecha_historial`, `monto_historial`) VALUES ('$x1', CURDATE(), '$monto');";

    

    $bd->consulta($ACTUALIZAR_MOVI);
    $bd->consulta($INSERTAR_HISTORIAL);
    $bd->consulta($INSERTAR_MOVIMIENTO);


                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el pago correctamente.';

                               echo '   </div>';

                               echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=cobranzas&listacobranza" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';                             



   

}
                                        
     $consulta="SELECT cobranza.id_cobro, manifiestos.id_manifiesto, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, (cobranza.monto_cobro-cobranza.monto_pago) AS DEUDA_ID, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND estado_movi='DEUDA' AND cobranza.id_cobro='$x1' ORDER BY SALIDA DESC;";
     $bd->consulta($consulta);

     while ($fila=$bd->mostrar_registros()) {

            $SUCURSAL_ID = $fila ['REMITENTE'];
            $DEUDA_ID = $fila ['DEUDA_ID'];
            $ESTADO_COBRO = $fila ['estado_cobro'];

?>
<center>  
  <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Información del movimiento</h3>
                                </div>
                                <h3 style="font-size: 28px;">
                                  <b>MANIFIESTO DE CARGA<br>N° <?php echo $fila['numero_movi']?></b>
                                </h3>

        <?php  
        echo '  <form role="form"  name="fe" action="?mod=cobranzas&nuevopago=nuevopago&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                             <table id="example1" class="table table-bordered table-striped">
                                              
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                             <h3> Código</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['MANIFIESTO'] ?></td></tr>
                                           <tr>
                                          <td class='faa-float animated-hover'>    
                                             <h3> Descripción</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['descripcion_movi'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                            <h3> Remitente</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['REMITENTE'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                           <h3> Destinatario</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['DESTINATARIO'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                           <h3> Fecha de salida</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['FECHA'] ?></td></tr>
                                            

                                               
                                                </table>
               
  </center>

<center>  
  <div class="col-md-6">
    <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Información de la cobranza</h3>
                                    <h3 class="box-title" style="font-size: 25px; float: right;"><b><?php echo "$ESTADO_COBRO"?> </b></h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Cobro</th>
                                                <th class="faa-float animated-hover">Flete</th>
                                                <th class="faa-float animated-hover">Pagado</th>
                                                <th class="faa-float animated-hover">Deuda</th>
                                                <th class="faa-float animated-hover">Pago</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT cobranza.id_cobro, manifiestos.id_manifiesto, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(movimientos.id_movimiento,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND estado_movi='DEUDA' AND cobranza.id_cobro='$x1' ORDER BY SALIDA DESC;";
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
                                                           
                                                              $fila[FECHA_COBRO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FLETE]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[PAGO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[DEUDA]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[FECHA_PAGO]
                                                            
                                                        </td>
                                                         ";
   } 
                                               echo "    
                                                    </tr>";
                                        

                                        } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                              </div>
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar pago </h3>
                                    <img style="float: right;" width="65px" height="55px" frameborder="0" src="img/liqui.png"> 
                                </div>
                  
        <?php  
        echo '  <form role="form"  name="fe" action="?mod=cobranzas&nuevopago=nuevopago&codigo='.$x1.'" method="post">';

            $nombre_tra=$_SESSION['dondequeda_nombre'];
            $apellido_tra=$_SESSION['dondequeda_apellido'];
        ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                          <div class="autocomplete">
                                            <label for="exampleInputFile">Descripción del pago <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (. _ - ). Se requieren (5-60) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>Caracteres (5-60)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="descripcionm" pattern='.{5,60}' maxlength="60" placeholder="Introducir la descripción del pago" autofocus><script>
                                                autocomplete(document.getElementById("descripcionm"), descripciones_guia);
                                            </script>
                                          </div>

                                            <label for="exampleInputFile">Monto a pagar <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max="<?php echo $DEUDA_ID?>" pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto a pagar">

                                            <label for="exampleInputFile">Trabajador ( Sucursal ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Los datos del trabajador con su sucursal respectiva los carga el sistema automáticamente." onclick="Swal.fire({title:'<h2>Los datos del trabajador con su sucursal respectiva los carga el sistema automáticamente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="trabajador" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="<?php echo "$nombre_tra $apellido_tra ( ".$SUCURSAL_ID." )"?>" value="<?php echo "$nombre_tra $apellido_tra ( ".$SUCURSAL_ID." )"?>" disabled>

                                        <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="nuevopago" id="nuevopago" value="Registrar pago">
                                        </div>
                                        </center>
                                                                            
                                    </div><!-- /.box-body -->

                                    
                                </form>
                            </div><!-- /.box -->
                            
</div>



                            <?php
  
}

} ?>
<?php
      if (isset($_GET['consultarcobranza'])) { 

 $x1=$_GET['codigo'];

                        if (isset($_POST['consultarcobranza'])) {
                           
 $monto=trim(strtoupper($_POST["monto"]));
 $id=$_SESSION['dondequeda_id'];

}
                                        
     $consulta="SELECT cobranza.id_cobro, manifiestos.id_manifiesto, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, (cobranza.monto_cobro-cobranza.monto_pago) AS DEUDA_ID, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza WHERE movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND cobranza.id_cobro='$x1' ORDER BY SALIDA DESC;";
     $bd->consulta($consulta);

     while ($fila=$bd->mostrar_registros()) {

            $SUCURSAL_ID = $fila ['REMITENTE'];
            $DEUDA_ID = $fila ['DEUDA_ID'];
            $ESTADO_COBRO = $fila ['estado_cobro'];
            $FECHA_PAG = $fila ['FECHA_PAGO'];

            $FLETE_COB = $fila ['FLETE'];
            $DEUDA_COB = $fila ['DEUDA'];
            $PAGO_COB  = $fila ['PAGO'];
            $FECHA_COB = $fila ['FECHA_COBRO'];

?>
<center>  
  <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Información del movimiento</h3>
                                    <?php 
                                        if ($ESTADO_COBRO=='PAGADO') {
                                                echo "<img style='float: right; margin: 0px 0px 15px 0px;' src='./img/pagado.png' width='30%' height='50'>";
                                        }
                                    ?>
                                </div>
                                <h3 style="font-size: 28px;">
                                  <b>MANIFIESTO DE CARGA<br>N° <?php echo $fila['numero_movi']?></b>
                                </h3>

        <?php  
        echo '  <form role="form"  name="fe" action="?mod=cobranzas&listacobranza=listacobranza" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                             <table id="example111" class="table table-bordered table-striped">
                                              
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                             <h3> Código</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['MANIFIESTO'] ?></td></tr>
                                           <tr>
                                          <td class='faa-float animated-hover'>    
                                             <h3> Descripción</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['descripcion_movi'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                            <h3> Remitente</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['REMITENTE'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                           <h3> Destinatario</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['DESTINATARIO'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                           <h3> Fecha de salida</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['FECHA'] ?></td></tr>
                                            

                                               
                                                </table>
               
  </center>

<center>  
  <div class="col-md-6">
    <div class="box">
                                <div class="box-header" style="overflow: auto;">
                                    <h3 class="box-title">Información de la cobranza</h3>
                                    <h3 class="box-title" style="font-size: 25px; float: right;"><b><?php echo "PENDIENTE"?> <br><?php echo "$DEUDA_COB"?> </b></h3>                                  
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <div style="overflow: auto; font-size: 13px; margin: -0px 0px 0px 0px;">
                                        <span style="float: left;">
                                            <b> FECHA DE COBRO ( LÍMITE ):</b> <?php echo $FECHA_COB."."?>
                                        </span><br>
                                        <span style="float: left;">
                                            <b> ÚLTIMO PAGO REALIZADO:</b> <?php echo $FECHA_PAG."."?>
                                        </span><br><br>
                                        <span style="float: left;">
                                            <b> FLETE TOTAL:</b> <?php echo $FLETE_COB."."?>
                                        </span><br>
                                        <span style="float: left;">
                                            <b> MONTO PAGADO:</b> <?php echo $PAGO_COB."."?>
                                        </span>
                                    </div>
                                    <br>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Ítem</th>
                                                <th class="faa-float animated-hover">Fecha</th>
                                                <th class="faa-float animated-hover">Monto</th>
                                                <th class="faa-float animated-hover">Pagado</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                        $consulta="SELECT CAST(@s:=@s+1 AS UNSIGNED) AS orden, (CONCAT('S/',FORMAT(@a:=@a+(monto_historial),2))) SA, cobranza.id_cobro, manifiestos.id_manifiesto, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS FECHA, DATE_FORMAT(cobranza.fecha_cobro, '%d/%m/%Y') AS FECHA_COBRO, COALESCE(DATE_FORMAT(cobranza.fecha_pago, '%d/%m/%Y'),'SIN PAGOS') AS FECHA_PAGO, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(movimientos.id_movimiento,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(cobranza.monto_cobro,2)) AS FLETE, CONCAT('S/',FORMAT(cobranza.monto_pago,2)) AS PAGO, CONCAT('S/',FORMAT(cobranza.monto_cobro-cobranza.monto_pago,2)) AS DEUDA, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_cobro, ruc_prop AS RUC, DATE_FORMAT(historial.fecha_historial, '%d/%m/%Y') AS fecha_historial, CONCAT('S/',FORMAT(monto_historial,2)) AS monto_historial FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios, cobranza, historial, (SELECT @s:=0) AS s, (SELECT @a:=0) AS a WHERE cobranza.id_cobro=historial.id_cobro AND movimientos.id_movimiento=cobranza.id_movimiento AND movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND cobranza.id_cobro='$x1' ORDER BY orden ASC;";
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
                                                           
                                                              $fila[orden]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[fecha_historial]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[monto_historial]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[SA]
                                                            
                                                        </td>
                                                         ";
   } 
                                               echo "    
                                                    </tr>";
                                        

                                        } ?>                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                              
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div><!-- /.box-body -->
                              </div>

<?php



                                echo '
  <div class="col-md-12">
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=cobranzas&listacobranza" method="post" id="ContactForm111">
    


 <input title="REGRESAR A LISTA" name="btn111"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div></div>  ';
?>
    
<?php

}

}
                                   
 ?>