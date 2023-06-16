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

function opciones_guia() {
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
function opciones_transacciones() {
      $texto = '';  
      global $conn;
      $sql = "SELECT descripcion_movi FROM movimientos, operaciones WHERE descripcion_ope NOT LIKE '%FLETE%' AND movimientos.id_operacion=operaciones.id_operacion GROUP BY descripcion_movi ORDER BY descripcion_movi ASC";
      
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
$opciones_guia = opciones_guia();
$opciones_transacciones = opciones_transacciones();
$encargado_firma='"' .trim(strtoupper($_SESSION['dondequeda_nombre'].' '.$_SESSION['dondequeda_apellido'])) . '"';
?>
<script type="text/javascript">
    var descripciones_transacciones = [<?php echo "$opciones_transacciones"?>];

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
<script type="text/javascript">
    var descripciones_guia = [<?php echo "$opciones_guia"?>];

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
<script type="text/javascript">
    var encargado = [<?php echo "$encargado_firma"?>];

    function autocompleteFIRMA(inp, arr) {
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
<script language="javascript" src="js/jquery-3.1.1.min.js"></script>
        
        <script language="javascript">
            $(document).ready(function(){
                $("#cbx_categoriaEgreso").change(function () {
                    $("#cbx_categoriaEgreso option:selected").each(function () {
                        categoria_ope = $(this).val();
                        $.post("includes/getOperacionEgreso.php", { categoria_ope: categoria_ope }, function(data){
                            $("#cbx_operacionEgreso").html(data);
                        });            
                    });
                })
            });
            $(document).ready(function(){
                $("#cbx_categoriaIngreso").change(function () {
                    $("#cbx_categoriaIngreso option:selected").each(function () {
                        categoria_ope = $(this).val();
                        $.post("includes/getOperacionIngreso.php", { categoria_ope: categoria_ope }, function(data){
                            $("#cbx_operacionIngreso").html(data);
                        });            
                    });
                })
            });
            $(document).ready(function(){
                $("#tipo_documento").change(function () {
                    $("#tipo_documento option:selected").each(function () {
                        tipo_doc = $(this).val();
                        $.post("includes/getDocumento.php", { tipo_doc: tipo_doc }, function(data){
                            $("#documento").html(data);
                        });            
                    });
                })
            });
            $(document).ready(function(){
                $("#cliente_remi").change(function () {
                    $("#cliente_remi option:selected").each(function () {
                        id_cliente = $(this).val();
                        $.post("includes/getDireccion.php", { id_cliente: id_cliente }, function(data){
                            $("#direccion_remi").html(data);
                        });            
                    });
                })
            });
</script>
<?php

require ('validarnum.php');
$fecha2=date("Y-m-d");  

$buscar_und = "SELECT id_medida, descripcion_med FROM medidas ORDER BY descripcion_med";
$resultado_und = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_und);	

if ($tipo2=='1') {
  $buscar_imp_tipo = "SELECT categoria_ope FROM movimientos, operaciones WHERE movimientos.id_operacion=operaciones.id_operacion AND tipo_ope='EGRESOS' GROUP BY categoria_ope ORDER BY categoria_ope";
  $resultado_imp_tipo = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_tipo);

  $buscar_imp_estado = "SELECT estado_movi FROM movimientos, operaciones WHERE tipo_ope='EGRESOS' AND movimientos.id_operacion=operaciones.id_operacion GROUP BY estado_movi ORDER BY estado_movi";
  $resultado_imp_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado);

} else {

  $buscar_imp_tipo = "SELECT categoria_ope FROM movimientos, operaciones, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_operacion=operaciones.id_operacion AND tipo_ope='EGRESOS' AND movimientos.id_sucursal='$id_sucursal' GROUP BY categoria_ope ORDER BY categoria_ope";
  $resultado_imp_tipo = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_tipo);

  $buscar_imp_estado = "SELECT estado_movi FROM movimientos, operaciones, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND tipo_ope='EGRESOS' AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal='$id_sucursal' GROUP BY estado_movi ORDER BY estado_movi";
  $resultado_imp_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado);
}

if ($tipo2=='1') {

  $buscar_imp_REM_tipo = "SELECT CASE WHEN documentos.nombre_doc LIKE '%REMITENTE%' THEN 'REMITENTE' ELSE 'TRANSPORTISTA' END AS tipo_guia FROM movimientos, documentos WHERE movimientos.id_documento=documentos.id_documento AND documentos.nombre_doc LIKE '%GUIA DE REMISION%' GROUP BY tipo_guia ORDER BY tipo_guia";
  $resultado_imp_REM_tipo = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_REM_tipo);

  $buscar_imp_REM_estado = "SELECT estado_movi FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND documentos.nombre_doc LIKE '%GUIA DE REMISION%' GROUP BY estado_movi ORDER BY estado_movi";
  $resultado_imp_REM_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_REM_estado);

} else {
  
  $buscar_imp_REM_tipo = "SELECT CASE WHEN documentos.nombre_doc LIKE '%REMITENTE%' THEN 'REMITENTE' ELSE 'TRANSPORTISTA' END AS tipo_guia FROM movimientos, documentos, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_documento=documentos.id_documento AND documentos.nombre_doc LIKE '%GUIA DE REMISION%' AND movimientos.id_sucursal='$id_sucursal' GROUP BY tipo_guia ORDER BY tipo_guia";
  $resultado_imp_REM_tipo = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_REM_tipo);

  $buscar_imp_REM_estado = "SELECT estado_movi FROM movimientos, operaciones, documentos, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND documentos.nombre_doc LIKE '%GUIA DE REMISION%' AND movimientos.id_sucursal='$id_sucursal' GROUP BY estado_movi ORDER BY estado_movi";
  $resultado_imp_REM_estado = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_REM_estado);
}

$buscar_imp_sucursal = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM sucursales, movimientos, operaciones WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_operacion=operaciones.id_operacion AND tipo_ope='EGRESOS' GROUP BY movimientos.id_sucursal ORDER BY nombre_suc;";
$resultado_imp_sucursal = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal);

$buscar_imp_sucursal2 = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM sucursales, movimientos, operaciones, documentos WHERE movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND (nombre_doc NOT LIKE '%GUIA DE REMISION%') AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND movimientos.id_operacion=operaciones.id_operacion AND tipo_ope='INGRESOS' GROUP BY movimientos.id_sucursal ORDER BY nombre_suc;";
$resultado_imp_sucursal2 = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_sucursal2);

$buscar_imp_REM_sucursal = "SELECT movimientos.id_sucursal, sucursales.nombre_suc FROM sucursales, movimientos, operaciones, documentos WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND documentos.nombre_doc LIKE '%GUIA DE REMISION%' GROUP BY movimientos.id_sucursal ORDER BY nombre_suc;";
$resultado_imp_REM_sucursal = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_REM_sucursal);

if ($tipo2=='1') {

  $buscar_imp_tipo2 = "SELECT categoria_ope FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND (nombre_doc NOT LIKE '%GUIA DE REMISION%') AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND tipo_ope='INGRESOS' GROUP BY categoria_ope ORDER BY categoria_ope";
  $resultado_imp_tipo2 = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_tipo2);

  $buscar_imp_estado2 = "SELECT estado_movi FROM movimientos, operaciones, documentos WHERE tipo_ope='INGRESOS' AND (nombre_doc NOT LIKE '%GUIA DE REMISION%') AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND movimientos.id_documento=documentos.id_documento AND movimientos.id_operacion=operaciones.id_operacion GROUP BY estado_movi ORDER BY estado_movi";
  $resultado_imp_estado2 = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado2);

} else {

  $buscar_imp_tipo2 = "SELECT categoria_ope FROM movimientos, operaciones, documentos, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND (nombre_doc NOT LIKE '%GUIA DE REMISION%') AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND tipo_ope='INGRESOS' AND movimientos.id_sucursal='$id_sucursal' GROUP BY categoria_ope ORDER BY categoria_ope";
  $resultado_imp_tipo2 = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_tipo2);

  $buscar_imp_estado2 = "SELECT estado_movi FROM movimientos, operaciones, documentos, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND tipo_ope='INGRESOS' AND (nombre_doc NOT LIKE '%GUIA DE REMISION%') AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND movimientos.id_documento=documentos.id_documento AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_sucursal='$id_sucursal' GROUP BY estado_movi ORDER BY estado_movi";
  $resultado_imp_estado2 = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_imp_estado2);  
}

$buscar_docu = "SELECT id_documento, nombre_doc FROM documentos WHERE tipo_doc='COMPROBANTES COMUNES' ORDER BY nombre_doc";
$resultado_docu = mysqli_query(mysqli_connect("$servidor","$usuario","$pass","$basedatos"),$buscar_docu);

$query_proveedor = "SELECT id_proveedor, CONCAT(ruc_prov,' - ',nombre_prov) AS PROVEEDOR FROM proveedores ORDER BY nombre_prov";
$resultado_proveedor=mysqli_query($conn,$query_proveedor);

$query_cliente = "SELECT id_cliente, CONCAT(ruc_cli,' - ',nombre_cli) AS CLIENTE FROM clientes ORDER BY nombre_cli";
$resultado_cliente=mysqli_query($conn,$query_cliente);

$query_cliente2 = "SELECT id_cliente, CONCAT(ruc_cli,' - ',nombre_cli) AS CLIENTE, nombre_cli FROM clientes ORDER BY nombre_cli";
$resultado_cliente2=mysqli_query($conn,$query_cliente2);

$query_chofer = "SELECT id_chofer, CONCAT(brevete_cho,' - ',nombre_cho,' ',apellido_cho) AS CHOFER FROM choferes WHERE estado_cho='HABILITADO' ORDER BY nombre_cho, apellido_cho";
$resultado_chofer=mysqli_query($conn,$query_chofer);

$query_vehiculo = "SELECT id_vehiculo, (COALESCE(CASE placa_carreta WHEN '' THEN CONCAT(placa_vehi,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )') ELSE CONCAT(placa_vehi,' / ',placa_carreta,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )') END, CONCAT(placa_vehi,' - ',marca_vehi,' ', color_vehi,' ( ',tipo_vehi,' )'))) AS VEHICULO FROM vehiculos WHERE condicion_vehi='OPERATIVO' ORDER BY marca_vehi, color_vehi, placa_vehi, placa_carreta";
$resultado_vehiculo=mysqli_query($conn,$query_vehiculo);

$query_documento = "SELECT id_documento, nombre_doc, tipo_doc FROM documentos GROUP BY tipo_doc ORDER BY tipo_doc";
$resultado_documento=mysqli_query($conn,$query_documento);

$query_documentoR = "SELECT id_documento, nombre_doc, tipo_doc FROM documentos WHERE nombre_doc LIKE '%GUIA DE REMISION%' ORDER BY nombre_doc";
$resultado_documentoR=mysqli_query($conn,$query_documentoR);

$query_egreso = "SELECT id_operacion, descripcion_ope, tipo_ope, categoria_ope FROM operaciones WHERE tipo_ope='EGRESOS' GROUP BY categoria_ope ORDER BY categoria_ope";
$resultado_egreso=mysqli_query($conn,$query_egreso);

$query_ingreso = "SELECT id_operacion, descripcion_ope, tipo_ope, categoria_ope FROM operaciones WHERE tipo_ope='INGRESOS' GROUP BY categoria_ope ORDER BY categoria_ope";
$resultado_ingreso=mysqli_query($conn,$query_ingreso);

$query_remito = "SELECT id_operacion, descripcion_ope, tipo_ope, categoria_ope FROM operaciones WHERE descripcion_ope LIKE '%FLETE%' ORDER BY descripcion_ope";
$resultado_remito=mysqli_query($conn,$query_remito);

if (isset($_GET['nuevoremito'])) { 

                        if (isset($_POST['nuevoremito'])) {

                           
$descripcion=trim(strtoupper($_POST["descripcion"]));
$cbx_operacionRemito=trim(strtoupper($_POST["cbx_operacionRemito"]));
$documento=trim(strtoupper($_POST["documento"]));
$monto=trim(strtoupper($_POST["monto"]));
$admin=$_SESSION['dondequeda_id'];
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$fecha_movi=date("Y-m-d");
$hora_movi=date("H:i:s a");
$serie=trim(strtoupper($_POST["serie"]));
$numero=trim(strtoupper($_POST["numero"]));
$chofer=trim(strtoupper($_POST["chofer"]));
$vehiculo=trim(strtoupper($_POST["vehiculo"]));
$proveedor=trim(strtoupper($_POST["proveedor"]));
$cliente_remi=trim(strtoupper($_POST["cliente_remi"]));
$fecha_hora=trim(strtoupper($_POST["fecha_hora"]));
$partida=trim(strtoupper($_POST["partida"]));
$envio=trim(strtoupper($_POST["envio"]));
$direccion_remi=trim(strtoupper($_POST["direccion_remi"]));
$subcontratacion=trim(strtoupper($_POST["subcontratacion"]));
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$enc_firma=trim(strtoupper($_SESSION['dondequeda_nombre']." ".$_SESSION['dondequeda_apellido']));

if($_POST['nombre_sub']!=null){
        $nombre_sub = trim(strtoupper($_POST['nombre_sub']));
    }else{
        $nombre_sub = null;
    } 

if($_POST['cliente2_guia']!=null){
        $cliente2_guia = trim(strtoupper($_POST['cliente2_guia']));
    }else{
        $cliente2_guia = null;
    }     

$sql="SELECT * FROM movimientos";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)>=0){


$registro_remito="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi`, `monto_sub_movi`) VALUES ('$documento', '$id_sucursal', '$cbx_operacionRemito', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '0', '$enc_firma', '$serie', '$numero', 'SIN ASIGNAR' ,'0')";

$cs=$bd->consulta($registro_remito);

$sql2="SELECT MAX(id_movimiento) AS ULTIMO FROM movimientos WHERE movimientos.id_sucursal='$id_sucursal' AND movimientos.id_operacion='$cbx_operacionRemito' ORDER BY id_movimiento DESC";
$cs=$bd->consulta($sql2);
$datos = $bd-> mostrar_registros($sql2);
$ULTIMO_ID = $datos ['ULTIMO'];

if($bd->numeroFilas($cs)>0){

    $registro_guia="INSERT INTO `guias`(`id_movimiento`, `id_chofer`, `id_vehiculo`, `id_proveedor`, `id_cliente`, `fecha_hora_guia`, `partida_guia`, `salida_guia`, `envio_guia`, `subcontratacion_guia`, `nombre_sub_guia`, `cliente2_guia`) VALUES ('$ULTIMO_ID', '$chofer', '$vehiculo', '$proveedor', '$cliente_remi', '$fecha_hora', '$partida', '$direccion_remi', '$envio', '$subcontratacion', '$nombre_sub', '$cliente2_guia')";

    $registro_cobranza="INSERT INTO `cobranza`(`id_movimiento`, `fecha_cobro`, `monto_cobro`, `estado_cobro`) VALUES ('$ULTIMO_ID', '$fecha_movi', '0', 'PENDIENTE')";

    $cs=$bd->consulta($registro_guia);
    //$cs=$bd->consulta($registro_cobranza);


                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró la guía de remisión nueva correctamente.';
                                        
                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaremito" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró esta guía de remisión!</b> Ya existe . . . ';



                               echo '   </div>';
}
}else{

    

//CONSULTAR SI EL CAMPO YA EXISTE

      echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta no se registró esta guía de remisión!</b> Ya existe . . . ';



                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar guía de remisión</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=movimientos&nuevoremito=nuevoremito" method="post">
                                      <div class="col-md-6">
                            <!-- general form elements -->
                                <div class="box-body">
                                        <div class="form-group">

                                        <div class="autocomplete">
                                            <label for="exampleInputFile">Descripción general <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-60) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>Caracteres (5-60)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"><img src="img/invi.png" width="15px" height="17.5px" frameborder="0"></label>
                                            <input  onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="autocomplete form-control faa-float animated-hover" id="descripciong" pattern='.{5,60}' maxlength="60" placeholder="Introducir la descripción general" autofocus>
                                            <script>
                                                autocomplete(document.getElementById("descripciong"), descripciones_guia);
                                            </script>
                                        </div>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionRemito" id="cbx_operacionRemito" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($REM = $resultado_remito->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $REM['id_operacion']; ?>"><?php echo $REM['descripcion_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($DOCR = $resultado_documentoR->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOCR['id_documento']; ?>"><?php echo $DOCR['nombre_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{4,4}' maxlength="4" required>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" required>

                                            <label for="exampleInputFile">Lugar de partida <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un lugar de partida" onclick="Swal.fire({title:'<h2>Por favor seleccione un lugar de partida</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='partida' required>
                                                   <option class="btn-primary" value="OFICINA">OFICINA</option>
                                                   <option class="btn-primary" value="PROVEEDOR">PROVEEDOR</option>
                                                </select>

                                            <label for="exampleInputFile">Fecha de emisión <img width="15px" height="15px" frameborder="0" src="img/info.png" title="La fecha y hora actual los carga el sistema automáticamente." onclick="Swal.fire({title:'<h2>La fecha y hora actual los carga el sistema automáticamente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" name="emision" class="form-control faa-float animated-hover" id="exampleInputEmail1" placeholder="<?php echo date("d/m/Y")?>" value="<?php echo date("d/m/Y")." (Hora actual)" ?>" disabled>

                                            <label for="exampleInputFile">Fecha de salida <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Fecha (año/mes/día) y tiempo (hora:minuto:segundo)." onclick="Swal.fire({title: '<h2> </h2> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>', html: 'Seleccione la fecha y hora de salida<br> Formato ( Ejemplo ): <b>2019-09-30 19:30:00</b>', width: 400, height: 900, background: '#fff url(img/tail.png) 50% 40% no-repeat', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"><img src="img/invi.png" width="15px" height="18px" frameborder="0"></label>
                                            <input  onblur="this.value=this.value.toUpperCase();" type="text" required name="fecha_hora" pattern='^([0-9]{4,4}-[0-9]{2,2}-[0-9]{2,2} [0-9]{2,2}:[0-9]{2,2}:\d{2,2})$' class="form-control faa-float animated-hover tail-datetime-field" id="datetime-picker" placeholder="Seleccione la fecha de salida" maxlength="19">

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
                                                timeFormat:     "HH:ii:ss",
                                                dateRanges:     [],
                                                weekStart:      "DOM", /* Depends on the tail.DateTime.strings value! */
                                                startOpen:      false,
                                                stayOpen:       true,
                                                zeroSeconds:    false,
                                            });
                                            </script>      



                                        </div></div>
                                    </div><!-- /.box-body selectpicker -->

                                    <div class="col-md-6">
                            <!-- general form elements -->
                                <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Tipo de entrega <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de entrega" onclick="Swal.fire({title: '<h2> </h2> <br><br><br><br><br><br><br><br><br><br> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>', text: ' ', width: 550, height: 1100, background: '#fff url(img/envio.png) 50% 70% no-repeat', imageWidth: 100, imageHeight: 100, type:' ',showConfirmButton: false, showCloseButton:true,focusConfirm:false})"></label>
                                                <select for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='envio' required>
                                                   <option class="btn-primary" value="1">TIPO DE ENTREGA 1</option>
                                                   <option class="btn-primary" value="2">TIPO DE ENTREGA 2</option>
                                                   <option class="btn-primary" value="3">TIPO DE ENTREGA 3</option>
                                                </select>

                                            <label for="exampleInputFile">Proveedor <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un proveedor. Se puede visualizar el RUC y nombre correspondiente del proveedor." onclick="Swal.fire({title: '<h2>Se requiere seleccionar un proveedor. Se puede visualizar su RUC correspondiente</h2>', html: 'En caso no encuentre el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=proveedores&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=proveedores&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="proveedor" id="proveedor" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($PROV = $resultado_proveedor->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $PROV['id_proveedor']; ?>"><?php echo $PROV['PROVEEDOR']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Cliente a facturar #1 ( Destinatario ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un cliente. Se puede visualizar el RUC y nombre correspondiente del cliente." onclick="Swal.fire({title: '<h2>Se requiere seleccionar un cliente. Se puede visualizar su RUC correspondiente</h2>', html: 'En caso no encuentre el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=clientes&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=clientes&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cliente_remi" id="cliente_remi" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="0">Seleccionar cliente . . .</option>
                                                <?php while($CLI = $resultado_cliente->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $CLI['id_cliente']; ?>"><?php echo $CLI['CLIENTE']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Dirección de llegada <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una dirección del cliente seleccionado." onclick="Swal.fire({title:'<h2>Por favor seleccione una dirección del cliente seleccionado</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="direccion_remi" id="direccion_remi" data-show-subtext="true" data-live-search="true" required>               
                                            </select>


                                            <label for="exampleInputFile">Cliente #2 ( Remitente ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un cliente en caso haya escogido el tipo de entrega 3. Se puede visualizar el RUC y nombre correspondiente del cliente." onclick="Swal.fire({title: '<h2>Se requiere seleccionar un cliente. Se puede visualizar su RUC correspondiente</h2>', html: 'En caso no encuentre el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=clientes&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=clientes&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})">  <code style="color:#DF493D;">(Puede registrar nuevo)</code> <code>(Puede ser omitido)</code></label>                
                                            <select class='btn btn-primary faa-float animated-hover' name="cliente2_guia" id="cliente2_guia" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="">Seleccionar cliente . . .</option>
                                                <?php while($CLI2 = $resultado_cliente2->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $CLI2['nombre_cli']; ?>"><?php echo $CLI2['CLIENTE']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Chofer <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un chofer. Se puede visualizar el brevete y nombre correspondiente del chofer." onclick="Swal.fire({title: '<h2>Se requiere seleccionar un chofer. Se puede visualizar su brevete correspondiente</h2>', html: 'En caso no encuentre el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=choferes&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=choferes&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="chofer" id="chofer" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($CHO = $resultado_chofer->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $CHO['id_chofer']; ?>"><?php echo $CHO['CHOFER']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Vehículo <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un vehículo. Se puede visualizar la placa, marca, color y tipo del vehículo" onclick="Swal.fire({title: '<h2>Se requiere seleccionar un vehículo. Se puede visualizar sus placas, marca, color y tipo correspondiente</h2>', html: 'En caso no encuentre el deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=vehiculos&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=vehiculos&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}})"> <code style="color:#DF493D;">(Puede registrar nuevo)</code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="vehiculo" id="vehiculo" data-show-subtext="true" data-live-search="true" required>
                                                <?php while($VEHI = $resultado_vehiculo->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $VEHI['id_vehiculo']; ?>"><?php echo $VEHI['VEHICULO']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Subcontratación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger si hay subcontratación. En caso haya colocarlo." onclick="Swal.fire({title:'<h2>Por favor seleccione si hay subcontratación<br><br>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"> <code>(Puede ser omitido)</code></label>                
                                            <input class="form-control faa-float animated-hover" required type="radio" name="subcontratacion" value="SI" /> SÍ
                                            <input class="form-control faa-float animated-hover" required type="radio" name="subcontratacion" value="NO" /> NO
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" type="text" name="nombre_sub" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre de la subcontratación">

                                        </div></div>
                                    </div><!-- /.box-body selectpicker -->

                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevoremito" id="nuevoremito" value="Guardar">Registrar guía de remisión</button>
                                    </div>
                                    </center>
                                </form>
                            </div><!-- /.box -->


<?php
}

if (isset($_GET['nuevoegreso'])) { 

                        if (isset($_POST['nuevoegreso'])) {

                           
$descripcion=trim(strtoupper($_POST["descripcion"]));
$cbx_operacionEgreso=trim(strtoupper($_POST["cbx_operacionEgreso"]));
$documento=trim(strtoupper($_POST["documento"]));
$monto=trim(strtoupper($_POST["monto"]));
$admin=$_SESSION['dondequeda_id'];
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$fecha_movi=date("Y-m-d");
$hora_movi=date("H:i:s a");
$firma=trim(strtoupper($_POST["firma"]));
$numero=trim(strtoupper($_POST["numero"]));
$serie=trim(strtoupper($_POST["serie"]));
   

$sql="SELECT * FROM movimientos";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)>=0){
//WARD - CÓDIGO DEL DOCUMENTO: (59) "VALES - PARA LIQUIDACIÓN" PARA VALES DE LIQUIDACIÓN
if ($documento=='59') {
  $sql2="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi`, `monto_sub_movi`) VALUES ('$documento', '$id_sucursal', '$cbx_operacionEgreso', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '$monto', '$firma', '$serie', '$numero', 'POR CANJEAR', '0')";

  $cs=$bd->consulta($sql2);

  $ULTIMO_VALOR="SELECT MAX(id_movimiento) AS ULTIMO FROM movimientos WHERE movimientos.id_sucursal='$id_sucursal' AND movimientos.id_operacion='$cbx_operacionEgreso' ORDER BY id_movimiento DESC";

  $cs=$bd->consulta($ULTIMO_VALOR);
  $datosID = $bd-> mostrar_registros($ULTIMO_VALOR);
  $ULTIMO_ID = $datosID ['ULTIMO'];

if($bd->numeroFilas($cs)>0){
  $sql3="INSERT INTO `liquidaciones` ( `id_movimiento`, `fecha_liqui`, `hora_liqui`, `monto_liqui`, `descripcion_liqui`) VALUES ('$ULTIMO_ID', '$fecha_movi', '$hora_movi', '$monto', '$firma')";
}

                          
                          $cs=$bd->consulta($sql3);

                          //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el egreso nuevo correctamente.';

                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaegreso" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';         
} else {
$sql2="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi`, `monto_sub_movi`) VALUES ('$documento', '$id_sucursal', '$cbx_operacionEgreso', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '$monto', '$firma', '$serie', '$numero', 'REALIZADO', '0')";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el egreso nuevo correctamente.';
  
                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaegreso" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';                                
}
}else{

	

//CONSULTAR SI EL CAMPO YA EXISTE

	  echo '<div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alerta no se registró esta egreso!</b> Ya existe . . . ';



                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar egreso</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=movimientos&nuevoegreso=nuevoegreso" method="post">
                                    <div class="box-body">
                                        <div class="form-group">

                                          <div class="autocomplete">
                                            <label for="exampleInputFile">Descripción del egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (. _ - ). Se requieren (5-60) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>Caracteres (5-60)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="descripcione" pattern='.{5,60}' maxlength="60" placeholder="Introducir la descripción del egreso" autofocus><script>
                                                autocomplete(document.getElementById("descripcione"), descripciones_transacciones);
                                            </script>
                                        </div>

                                            <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una categoría de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_categoriaEgreso" id="cbx_categoriaEgreso" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='0'>Seleccionar categoría de operación . . .</option>
                                                <?php while($EGR = $resultado_egreso->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $EGR['categoria_ope']; ?>"><?php echo $EGR['categoria_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar una operación</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=operaciones&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=operaciones&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionEgreso" id="cbx_operacionEgreso" data-show-subtext="true" data-live-search="true" required>               
                                            </select>

                                            
                                            <label for="exampleInputFile">Tipo de documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="tipo_documento" id="tipo_documento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='0'>Seleccionar tipo de documento . . .</option>
                                                <?php while($DOC = $resultado_documento->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOC['tipo_doc']; ?>"><?php echo $DOC['tipo_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar un documento</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=documentos&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=documentos&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true" required>               
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{4,4}' maxlength="4" required>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" required>

                                        <div class="autocomplete">
                                            <label for="exampleInputFile">Encargado de firmar <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="firma" class="form-control faa-float animated-hover" id="firmag" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre del encargado que firma">
                                            <script>
                                                autocompleteFIRMA(document.getElementById("firmag"), encargado);
                                            </script>
                                        </div>

                                            <label for="exampleInputFile">Monto de egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto del egreso">

                                        </div>
                                    </div><!-- /.box-body selectpicker -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevoegreso" id="nuevoegreso" value="Guardar">Registrar egreso</button>
                                    </div>
                                    </center>
                                </form>
                            </div><!-- /.box -->


<?php
}

if (isset($_GET['nuevoingreso'])) { 

                        if (isset($_POST['nuevoingreso'])) {

                           
$descripcion=trim(strtoupper($_POST["descripcion"]));
$cbx_operacionIngreso=trim(strtoupper($_POST["cbx_operacionIngreso"]));
$documento=trim(strtoupper($_POST["documento"]));
$monto=trim(strtoupper($_POST["monto"]));
$admin=$_SESSION['dondequeda_id'];
$id_sucursal=$_SESSION['dondequeda_sucursal'];
$fecha_movi=date("Y-m-d");
$hora_movi=date("H:i:s a");
$firma=trim(strtoupper($_POST["firma"]));
$numero=trim(strtoupper($_POST["numero"]));
$serie=trim(strtoupper($_POST["serie"]));
   

$sql="SELECT * FROM movimientos";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs)>=0){


$sql2="INSERT INTO `movimientos` ( `id_documento`, `id_sucursal`, `id_operacion`, `id`, `fecha_movi`, `hora_movi`, `descripcion_movi`, `monto_movi`, `firma_movi`, `serie_movi`, `numero_movi`, `estado_movi` , `monto_sub_movi`) VALUES ('$documento', '$id_sucursal', '$cbx_operacionIngreso', '$admin', '$fecha_movi', '$hora_movi', '$descripcion', '$monto', '$firma', '$serie', '$numero', 'REALIZADO', '0')";


                          $cs=$bd->consulta($sql2);

                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el ingreso nuevo correctamente.';
  
                               echo '   </div>';

                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaingreso" method="post" id="ContactForm">
    


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
                                        <b>Alerta no se registró esta ingreso!</b> Ya existe . . . ';



                               echo '   </div>';
}



}
?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar ingreso</h3>
                                </div>
                                
                            
                                <!-- form start -->
                                <form role="form"  name="fe" action="?mod=movimientos&nuevoingreso=nuevoingreso" method="post">
                                    <div class="box-body">
                                        <div class="form-group">

                                          <div class="autocomplete">
                                            <label for="exampleInputFile">Descripción del ingreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (. _ - ). Se requieren (5-60) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>Caracteres (5-60)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return off(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="descripcioni" pattern='.{5,60}' maxlength="60" placeholder="Introducir la descripción del ingreso" autofocus>
                                            <script>
                                                autocomplete(document.getElementById("descripcioni"), descripciones_transacciones);
                                            </script>
                                        </div>

                                            <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una categoría de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_categoriaIngreso" id="cbx_categoriaIngreso" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='0'>Seleccionar categoría de operación . . .</option>
                                                <?php while($IGR = $resultado_ingreso->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $IGR['categoria_ope']; ?>"><?php echo $IGR['categoria_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar una operación</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=operaciones&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=operaciones&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionIngreso" id="cbx_operacionIngreso" data-show-subtext="true" data-live-search="true" required>               
                                            </select>

                                            
                                            <label for="exampleInputFile">Tipo de documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="tipo_documento" id="tipo_documento" data-show-subtext="true" data-live-search="true" required>
                                              <option class='btn-danger' value='0'>Seleccionar tipo de documento . . .</option>
                                                <?php while($DOC = $resultado_documento->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOC['tipo_doc']; ?>"><?php echo $DOC['tipo_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="<?php if($tipo2=='1'){ ?> Swal.fire({title: '<h2>Se requiere seleccionar un documento</h2>', html: 'En caso no encuentre lo deseado, puedes registrar uno', type: 'info', showCancelButton: true, confirmButtonColor: '#010328', cancelButtonColor: '#2B0D11', confirmButtonText: '<h4><a href=index.php?mod=documentos&nuevo=nuevo>REGISTRAR NUEVO</a></h4>', cancelButtonText: '<h4>SEGUIR BUSCANDO</h4>', showCloseButton:true,  focusConfirm:true }).then((result) => { if (result.value) { Swal.fire('<h4>REDIRECCIONANDO!</h4>',   '<h3>Espere por favor . . .<br> Presione <a href=index.php?mod=documentos&nuevo=nuevo>AQUÍ</a> si está tardando demasiado</<h3>', 'success',)}}) <?php } else { ?> Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})<?php } ?>"> <code style="color:#DF493D;"><?php if($tipo2=='1'){ ?>(Puede registrar nuevo)<?php } else { }?></code></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true" required>               
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{4,4}' maxlength="4" required>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" required>

                                        <div class="autocomplete">
                                            <label for="exampleInputFile">Encargado de firmar <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="firma" class="form-control faa-float animated-hover" id="firmag" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre del encargado que firma">
                                            <script>
                                                autocompleteFIRMA(document.getElementById("firmag"), encargado);
                                            </script>
                                        </div>

                                            <label for="exampleInputFile">Monto de ingreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto del ingreso">

                                        </div>
                                    </div><!-- /.box-body selectpicker -->
                                    <center>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="nuevoingreso" id="nuevoingreso" value="Guardar">Registrar ingreso</button>
                                    </div>
                                    </center>
                                </form>
                            </div><!-- /.box -->


<?php
}
	
   
   if (isset($_GET['listaegreso'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['listaegreso'])) {
     
}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">TRANSACCIONES | Lista de egresos</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Código</th>
                                                <th class="faa-float animated-hover">Fecha</th>
                                                <th class="faa-float animated-hover">Hora</th>
                                                <th class="faa-float animated-hover">Operación</th>
                                                <th class="faa-float animated-hover">Monto</th>
                                                <th class="faa-float animated-hover">Estado</th>
                                                <?php if($tipo2==1){ ?>
                                                <th class="faa-float animated-hover">Sucursal</th>  
                                                <?php }?>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT CONCAT('E',LPAD(movimientos.id_movimiento,'6','0')) AS EGRESO, id_movimiento, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) END) AS DOCUMENTO, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, movimientos.id_documento AS DOCUMENTO_ID FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal='$id_sucursal' AND nombre_doc NOT LIKE '%GUIA DE REMISION%' AND tipo_ope='EGRESOS' ORDER BY fecha_movi DESC, hora_movi DESC";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT CONCAT('E',LPAD(movimientos.id_movimiento,'6','0')) AS EGRESO, id_movimiento, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) END) AS DOCUMENTO, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, movimientos.id_documento AS DOCUMENTO_ID FROM movimientos, operaciones, documentos, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND nombre_doc NOT LIKE '%GUIA DE REMISION%' AND tipo_ope='EGRESOS' ORDER BY fecha_movi DESC, hora_movi DESC";
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
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER INFORMACIÓN DEL EGRESO' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$fila["descripcion_movi"]."<br><br><b>DOCUMENTO:</b><br>".$fila["DOCUMENTO"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[EGRESO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[fecha_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[hora_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[descripcion_ope]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[monto_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[estado_movi]
                                                            
                                                        </td>";
                                                        if($tipo2==1){
                                                        echo "<td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_suc]
                                                            
                                                        </td>";
                                                        }
                                                        echo "
                                                        <td><center>";

                                                         echo "
                                                            <a  href=?mod=movimientos&consultaregreso&codigo=".$fila["id_movimiento"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DE LA OPERACIÓN DE ".$fila["descripcion_ope"]."'></a>";
      //<a  href=?mod=movimientos&editaregreso&codigo=".$fila["id_movimiento"]."><img src='./img/editar2.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DE LA OPERACIÓN DE ".$fila["descripcion_ope"]."'></a> 
      if ($fila["DOCUMENTO_ID"]=='59' AND $fila['estado_movi']=='POR CANJEAR') {
                                echo "
      <a   href=?mod=movimientos&canjearegreso&codigo=".$fila["id_movimiento"]."><img src='./img/contrato.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='CANJEAR VALE DE ".$fila["monto_movi"]." PARA ".$fila["descripcion_ope"]."'></a>
      ";}
      if ($tipo2==1) {
        if ($fila['estado_movi']!='ANULADO') {
                                echo "
      
      <a   href=?mod=movimientos&eliminaregreso&codigo=".$fila["id_movimiento"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ANULAR LA OPERACIÓN DE ".$fila["DOCUMENTO"]."'></a>
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
                                    <h3> <center>Agregar egreso <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=movimientos&nuevoegreso" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO EGRESO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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

                                
                                <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de egresos por categoría</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_tipo" onchange="if(this.value=='Seleccione una categoría para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una categoría para exportar</option>
                                                <?php while($EGRT = mysqli_fetch_assoc($resultado_imp_tipo)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_egreso_categoria.php?categoria_ope=<?php echo $EGRT['categoria_ope']?>'><?php echo $EGRT['categoria_ope'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <label for="exampleInputFile">Estado de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de egresos por estado</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_estado" onchange="if(this.value=='Seleccione un estado para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un estado para exportar</option>
                                                <?php while($EGRE = mysqli_fetch_assoc($resultado_imp_estado)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_egreso_estado.php?estado_movi=<?php echo $EGRE['estado_movi']?>'><?php echo $EGRE['estado_movi'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <?php if($tipo2==1){ ?>

                                    <label for="exampleInputFile">Nuestras sucursales <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de egresos por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_egreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($EGRS = mysqli_fetch_assoc($resultado_imp_sucursal)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_egreso_sucursal.php?id_sucursal=<?php echo $EGRS['id_sucursal']?>'><?php echo $EGRS['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 
                                    <?php } ?>
                                            
                                 </div>
                                 <img src="./img/gif/egresos.gif" width="100%" height="200px" title="Reduzca gastos innecesarios"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>

<?php
}
    
   
   if (isset($_GET['listaingreso'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['listaingreso'])) {
     
}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">TRANSACCIONES | Lista de ingresos</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Código</th>
                                                <th class="faa-float animated-hover">Fecha</th>
                                                <th class="faa-float animated-hover">Hora</th>
                                                <th class="faa-float animated-hover">Operación</th>
                                                <th class="faa-float animated-hover">Monto</th>
                                                <th class="faa-float animated-hover">Estado</th>
                                                <?php if($tipo2==1){ ?>
                                                <th class="faa-float animated-hover">Sucursal</th>  
                                                <?php }?>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT CONCAT('I',LPAD(movimientos.id_movimiento,'6','0')) AS INGRESO, id_movimiento, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) END) AS DOCUMENTO, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc FROM movimientos, operaciones, documentos, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND (nombre_doc NOT LIKE '%GUIA DE REMISION%') AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND tipo_ope='INGRESOS' AND movimientos.id_sucursal='$id_sucursal' ORDER BY fecha_movi DESC, hora_movi DESC";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT CONCAT('I',LPAD(movimientos.id_movimiento,'6','0')) AS INGRESO, id_movimiento, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) END) AS DOCUMENTO, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc FROM movimientos, operaciones, documentos, sucursales WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND nombre_doc NOT LIKE '%GUIA DE REMISION%' AND (nombre_doc NOT LIKE '%MANIFIESTO DE CARGA%') AND tipo_ope='INGRESOS' ORDER BY fecha_movi DESC, hora_movi DESC";
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
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER INFORMACIÓN DEL EGRESO' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$fila["descripcion_movi"]."<br><br><b>DOCUMENTO:</b><br>".$fila["DOCUMENTO"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo"</a>
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[INGRESO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[fecha_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[hora_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[descripcion_ope]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[monto_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[estado_movi]
                                                            
                                                        </td>";
                                                        if($tipo2==1){
                                                        echo "<td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_suc]
                                                            
                                                        </td>";
                                                        }
                                                        echo "
                                                        <td><center>";

                                                         echo "
                                                            <a  href=?mod=movimientos&consultaringreso&codigo=".$fila["id_movimiento"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title=' CONSULTAR LOS DATOS DE LA OPERACIÓN DE ".$fila["descripcion_ope"]."'></a>";
      //<a  href=?mod=movimientos&editaregreso&codigo=".$fila["id_movimiento"]."><img src='./img/editar2.png' width='25' alt='Edicion' class='faa-float animated-hover' title='EDITAR LOS DATOS DE LA OPERACIÓN DE ".$fila["descripcion_ope"]."'></a> 
      
      if ($tipo2==1) {
        if ($fila['estado_movi']=='REALIZADO') {
                                echo "
      
      <a   href=?mod=movimientos&eliminaringreso&codigo=".$fila["id_movimiento"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ANULAR LA OPERACIÓN DE ".$fila["DOCUMENTO"]."'></a>
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
                                    <h3> <center>Agregar ingreso <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=movimientos&nuevoingreso" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO INGRESO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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

                                
                                <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de ingresos por categoría</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_ingreso_tipo" onchange="if(this.value=='Seleccione una categoría para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una categoría para exportar</option>
                                                <?php while($IGRT = mysqli_fetch_assoc($resultado_imp_tipo2)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_ingreso_categoria.php?categoria_ope=<?php echo $IGRT['categoria_ope']?>'><?php echo $IGRT['categoria_ope'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <label for="exampleInputFile">Estado de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de ingresos por estado</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_ingreso_estado" onchange="if(this.value=='Seleccione un estado para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un estado para exportar</option>
                                                <?php while($IGRE = mysqli_fetch_assoc($resultado_imp_estado2)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_ingreso_estado.php?estado_movi=<?php echo $IGRE['estado_movi']?>'><?php echo $IGRE['estado_movi'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <?php if($tipo2==1){ ?>

                                    <label for="exampleInputFile">Nuestras sucursales <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de ingresos por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_ingreso_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($IGRS = mysqli_fetch_assoc($resultado_imp_sucursal2)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_ingreso_sucursal.php?id_sucursal=<?php echo $IGRS['id_sucursal']?>'><?php echo $IGRS['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 
                                    <?php } ?>
                                            
                                 </div>
                                 <img src="./img/gif/ingresos.gif" width="100%" height="200px" title="Aumente sus ganancias"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>

<?php
}
        
   
   if (isset($_GET['listaremito'])) { 

    $x1=$_GET['codigo'];

                        if (isset($_POST['listaremito'])) {
     
}
?>
  
                            
                    <div class="row">
                        <div class="col-md-9">
                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">GUÍAS DE REMISIÓN | Lista de rémitos</h3>
                                    <br><br>
                                    <h4> * Dónde: (R) = Remitente, (T) = Transportista.</h4>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                               
                                                <th class="faa-float animated-hover">Info</th>
                                                <th class="faa-float animated-hover">Fecha</th>
                                                <th class="faa-float animated-hover">Documento</th>
                                                <th class="faa-float animated-hover">Flete</th>
                                                <th class="faa-float animated-hover">Estado</th>
                                                <?php if($tipo2==1){ ?>
                                                <th class="faa-float animated-hover">Sucursal</th>  
                                                <?php }?>
                                                <th class="faa-float animated-hover">Opciones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){

                                                if($tipo2==2){
                                                    $id_sucursal=$_SESSION['dondequeda_sucursal'];
                                                    $consulta="SELECT movimientos.id_movimiento, CONCAT('M',LPAD(movimientos.id_movimiento,'6','0')) AS MANIFIESTO, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS DOCUMENTO, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi FROM movimientos, operaciones, documentos, sucursales, guias WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND movimientos.id_sucursal='$id_sucursal' ORDER BY fecha_movi DESC, hora_movi DESC";

                                                } else if ($tipo2==1){
                                                    $consulta="SELECT movimientos.id_movimiento, CONCAT('M',LPAD(movimientos.id_movimiento,'6','0')) AS MANIFIESTO, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS DOCUMENTO, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, monto_movi AS FLETE, estado_movi, nombre_suc, serie_movi, numero_movi FROM movimientos, operaciones, documentos, sucursales, guias WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' ORDER BY fecha_movi DESC, hora_movi DESC";
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
                                                        <td><center>";
                                                        echo "
                                                            <a class='fa faa-float animated'><img src='./img/info.png' width='25' alt='Edicion' title='PRESIONE ACA PARA VER LA DESCRIPCIÓN DE LA GUÍA' ";?> onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$fila["descripcion_movi"]."<br><br><b>EMISIÓN:</b> ".$fila["hora_movi"]."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})' <?php echo "
                                                        </td></center>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[fecha_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[DOCUMENTO]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[monto_movi]
                                                            
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                           
                                                              $fila[estado_movi]
                                                            
                                                        </td>";
                                                        if($tipo2==1){
                                                        echo "<td class='faa-float animated-hover'>
                                                           
                                                              $fila[nombre_suc]
                                                            
                                                        </td>";
                                                        }
                                                        
                                                        echo "
                                                        <td><center>";
                                                        echo "
                                                            <a  href=?mod=movimientos&consultarremito&codigo=".$fila["id_movimiento"]."><img src='./img/consultarr.png' class='faa-float animated-hover' width='25' alt='Edicion' title='CONSULTAR LOS DATOS DE LA GUÍA DE REMISIÓN ".$fila["serie_movi"]."-".$fila["numero_movi"]."'></a>";                                                        
      
      
        if ($fila['estado_movi']=='SIN ASIGNAR') {
                                echo "
      <a   href=?mod=movimientos&adicionarremito&codigo=".$fila["id_movimiento"]."><img src='./img/add.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ADICIONAR / ELIMINAR DESCRIPCIÓN, A LA GUÍA DE REMISIÓN ".$fila["serie_movi"]."-".$fila["numero_movi"]."'></a>";}

      if ($tipo2==1) {

        if ($fila['estado_movi']=='SIN ASIGNAR') {
                                echo "
      <a   href=?mod=movimientos&eliminarremito&codigo=".$fila["id_movimiento"]."><img src='./img/elimina3.png'  width='25' alt='Edicion' class='faa-float animated-hover' title='ANULAR LA GUÍA DE REMISIÓN ".$fila["serie_movi"]."-".$fila["numero_movi"]."'></a>
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
                                    <h3> <center>Agregar rémito <a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                        <center>        
                            <form  name="fe" action="?mod=movimientos&nuevoremito" method="post" id="ContactForm">
    


 <input title="AGREGAR UN NUEVO RÉMITO" name="btn1"  class="btn btn-primary"type="submit" value="Agregar nuevo">

    
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

                                
                                <label for="exampleInputFile">Tipo de guía de remisión <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de guías de remisión por tipo</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_remito_tipo" onchange="if(this.value=='Seleccione un tipo para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un tipo para exportar</option>
                                                <?php while($REMT = mysqli_fetch_assoc($resultado_imp_REM_tipo)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_remito_tipo.php?tipo_guia=<?php echo $REMT['tipo_guia']?>'><?php echo $REMT['tipo_guia'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <label for="exampleInputFile">Estado de guía de remisión <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un estado para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de guías de remisión por estado</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_remision_estado" onchange="if(this.value=='Seleccione un estado para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione un estado para exportar</option>
                                                <?php while($REME = mysqli_fetch_assoc($resultado_imp_REM_estado)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_remito_estado.php?estado_movi=<?php echo $REME['estado_movi']?>'><?php echo $REME['estado_movi'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select>

                                    <?php if($tipo2==1){ ?>

                                    <label for="exampleInputFile">Nuestras sucursales <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una sucursal para exportar." onclick="Swal.fire({title:'<h2>Exportar PDF de guías de remisión por sucursal</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select target='_blank' class='btn btn-primary faa-float animated-hover' for="exampleInputFile" name="imprimir_remision_sucursal" onchange="if(this.value=='Seleccione una sucursal para exportar'){} else { window.open(this.value,'_blank');}">
                                                <option class="btn-danger">Seleccione una sucursal para exportar</option>
                                                <?php while($REMS = mysqli_fetch_assoc($resultado_imp_REM_sucursal)): ?>
                                                    <option class="btn-primary" value='./pdf/lista_remito_sucursal.php?id_sucursal=<?php echo $REMS['id_sucursal']?>'><?php echo $REMS['nombre_suc'] ?></option>
                                                <?php endwhile; 
                                                ?>
                                            </select> 
                                    <?php } ?>
                                            
                                 </div>
                                 <img src="./img/gif/guia.gif" width="100%" height="200px" title="Proporcione todas las descripciones solicitadas"><br><br>

                                </center>
                                </div>
                                </div>
                                </div>


<?php
}

if (isset($_GET['adicionarremito'])) { 

$x1=$_GET['codigo'];
                        if (isset($_POST['adicionarremito'])) {
                           


$descripcion=trim(strtoupper($_POST["descripcion"]));
$cantidad=trim(strtoupper($_POST["cantidad"]));
$unidad=trim(strtoupper($_POST["unidad"]));
$peso=trim(strtoupper($_POST["peso"]));
$precio=trim(strtoupper($_POST["precio"]));
$id=$_SESSION['dondequeda_id'];


$sql="select * from movimientos";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs) >= 0){

    $sql2="INSERT INTO `detalle` (`id_movimiento`, `id_medida`, `descripcion_deta`, `cantidad_deta`, `peso_deta`, `monto_deta`) VALUES ('$x1', '$unidad', '$descripcion', '$cantidad', '$peso', '$precio');";

    $sql3="UPDATE movimientos SET monto_movi=monto_movi+$precio WHERE id_movimiento='$x1';";

    $cs=$bd->consulta($sql2);
    $cs=$bd->consulta($sql3);


                           
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se adicionó la descripción correctamente. ';


                               echo '   </div>';

                                                               echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaremito" method="post" id="ContactForm">
    


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
                                        <b>Alerta!</b> No se registró esta descripción. ';



                               echo '   </div>';
}
} elseif (isset($_POST['eliminardetalle'])) {
                           

$x1=$_GET['detalle'];
$codigo_detalle=trim(strtoupper($_POST["id_detalle"]));
$id=$_SESSION['dondequeda_id'];


$sql="SELECT * FROM detalle";

$cs=$bd->consulta($sql);

if($bd->numeroFilas($cs) >= 0){


    $PRECIO_DETALLE="SELECT monto_deta FROM detalle WHERE id_detalle='$codigo_detalle';";

    $cs=$bd->consulta($PRECIO_DETALLE);
    $datos = $bd-> mostrar_registros($PRECIO_DETALLE);
    $MONTO_DETALLE = $datos ['monto_deta'];

    $sql2="UPDATE movimientos SET monto_movi=monto_movi-$MONTO_DETALLE WHERE id_movimiento='$x1';";
    $sql3="DELETE FROM detalle WHERE id_detalle='$codigo_detalle';";

    $cs=$bd->consulta($sql2);
    $cs=$bd->consulta($sql3);

                           
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
                               
                            <form  name="fe" action="?mod=movimientos&listaremito" method="post" id="ContactForm">
    


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
                                        <b>Alerta!</b> No se eliminó esta descripción. ';



                               echo '   </div>';
}
}
?>


  <div class="col-md-3">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <ul class="nav nav-tabs" style="font-weight: bold; font-size: 15px;">
                                  <li class="active">
                                    <a data-toggle="tab" href="#Adicionar">Adicionar</a>
                                  </li>
                                  <li>
                                    <a data-toggle="tab" href="#Eliminar">Eliminar</a>
                                  </li>
                                </ul>
                                <div class="tab-content">
                                <div id="Adicionar" class="tab-pane fade in active">
                                <div class="box-header">
                                    <h3 class="box-title">Adicionar descripción</h3>
                                </div>

                                <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&adicionarremito=adicionarremito&codigo='.$x1.'" method="post">';
                                ?>

                                    <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Descripción <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales ( . _ - ). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (._-)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <textarea onkeypress="return off(event)" rows="6" onblur="this.value=this.value.toUpperCase();" type="text" name="descripcion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción"></textarea> 

                                            <label for="exampleInputFile">Cantidad total <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (1-8) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Caracteres (1-8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" required name="cantidad" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="1" min='1' max='99999999' pattern='.{1,8}' maxlength="8" placeholder="Introducir la cantidad">

                                            <label for="exampleInputFile">Unidad de medida <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una unidad de medida." onclick="Swal.fire({
                                            title:'<h2>Por favor seleccione una unidad de medida</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                                <select  for="exampleInputEmail" class="btn btn-primary faa-float animated-hover" name='unidad' required>
                                                  <?php while($row = $resultado_und->fetch_assoc()) { ?>
                                                 <option class="btn-primary" value="<?php echo $row['id_medida']; ?>"><?php echo $row['descripcion_med']; ?></option>
                                                <?php } ?>
                                                </select>

                                            <label for="exampleInputFile">Peso total <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (1-8) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Caracteres (1-8)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" required name="peso" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="1" min='1' max='99999999' pattern='.{1,8}' maxlength="8" placeholder="Introducir el peso">

                                            <label for="exampleInputFile">Precio total <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="precio" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el precio">

                                        </div>
                                    <center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="adicionarremito" id="adicionarremito" value="Guardar">Actualizar datos</button>
                                    
                                    </div>

                                    </center>
                                </form>
                              </div>
                            </div>
                            <div id="Eliminar" class="tab-pane fade">
                                <div class="box-header">
                                    <h3 class="box-title">Eliminar descripción</h3>
                                </div>

                                <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&adicionarremito=eliminardetalle&detalle='.$x1.'" method="post">';
                                ?>

                                    <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Código <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (1-8) caracteres." onclick="Swal.fire({title: '<h2>Escriba el código a eliminar</h2><br><br><br><br><br><br><br><br><br><br><br><br><br>', text: '', width: 500, height: 500, background: '#fff url(img/ejemplo.png)', imageWidth: 400, imageHeight: 600, type:'info',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})"></label>
                                            <input onkeydown="return enteros(this, event)" type="number" required name="id_detalle" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="1" min='1' max='99999999' pattern='.{1,8}' maxlength="8" placeholder="Introducir el código">

                                        </div>
                                    <center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="eliminardetalle" id="eliminardetalle" value="Guardar">Eliminar datos</button>
                                    
                                    </div>

                                    </center>
                                </form>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>


<?php 

$consulta="SELECT DISTINCT movimientos.id_movimiento, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, clientes, proveedores, departamentos, provincias, distritos WHERE guias.id_proveedor=proveedores.id_proveedor AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND estado_movi='SIN ASIGNAR' AND movimientos.id_movimiento='$x1'";

$prove_query="SELECT departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist FROM guias, proveedores, departamentos, provincias, distritos WHERE guias.id_proveedor=proveedores.id_proveedor AND proveedores.id_departamento=departamentos.id_departamento AND proveedores.id_provincia=provincias.id_provincia AND proveedores.id_distrito=distritos.id_distrito AND guias.id_movimiento='$x1'";

$sucu_query="SELECT departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist FROM movimientos, sucursales, departamentos, provincias, distritos WHERE movimientos.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND movimientos.id_movimiento='$x1'";

$lugar_query="SELECT CONCAT('SEDE DE ',sucursales.nombre_suc) AS nombre_suc FROM guias, clientes, sucursales WHERE clientes.id_sucursal=sucursales.id_sucursal AND guias.id_movimiento='$x1';";

$cs=$bd->consulta($consulta);
$datos = $bd-> mostrar_registros($consulta);
//DATOS DE LA GUÍA
$GUIA = $datos['GUIA'];
$FECHA_EMISION = $datos['fecha_movi']." - ".$datos['hora_movi'];
$FECHA_SALIDA = $datos['fecha_hora_guia'];
$HORA_EMISION = $datos['hora_movi'];
$FLETE = $datos['monto_movi'];
$DIRE_PART = $datos['direccion_part'];
$DIRE_SALI = $datos['direccion_sali'];
$CLIENTE = $datos['nombre_cli'];
$CLIENTE2 = $datos['cliente2_guia'];
$PROVEEDOR = $datos['PROVEEDOR'];
$PROVEEDOR_RUC = $datos['PROVEEDOR_RUC'];
$VEHICULO = $datos['VEHICULO'];
$PROPIETARIO = $datos['PROPIETARIO'];
$CHOFER = $datos['CHOFER'];
$SUB = $datos['SUB'];
$CLI_DEPA = $datos['nombre_depa'];
$CLI_PROVI = $datos['nombre_provi'];
$CLI_DIST = $datos['nombre_dist'];
$INFO = $datos['descripcion_movi'];
//DATOS DE LA COBRANZA
$FECHA_COBRO = $datos['fecha_cobro'];
$PAGADO_COBRO = $datos['monto_cobro'];
$ESTADO_COBRO = $datos['estado_cobro'];
//COMPARACIÓN
$PARTIDA_IF = $datos['partida_guia'];

$cs=$bd->consulta($prove_query);
$prove = $bd-> mostrar_registros($prove_query);
//PROVEEDORES
$PROVE_DEPA = $prove['nombre_depa'];
$PROVE_PROVI = $prove['nombre_provi'];
$PROVE_DIST = $prove['nombre_dist'];

$cs=$bd->consulta($sucu_query);
$sucu = $bd-> mostrar_registros($sucu_query);
//SUCURSAL
$SUCU_DEPA = $sucu['nombre_depa'];
$SUCU_PROVI = $sucu['nombre_provi'];
$SUCU_DIST = $sucu['nombre_dist'];

$cs=$bd->consulta($lugar_query);
$cobranza = $bd-> mostrar_registros($lugar_query);
//LUGAR DE COBRANZA
$LUGAR = $cobranza['nombre_suc'];

?>                                                        
                      <div class="col-md-9">
                          <div class="box">
                                <div class="box-header" style="overflow: auto;">
                                    <h3 class="box-title" style="float: left;"><img width="25px" height="25px" frameborder="0" src="img/info.png" title="PRESIONE ACA PARA VER LA DESCRIPCIÓN DE LA GUÍA." onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$INFO."<br><br><b>LUGAR DE COBRANZA:</b><br>".$LUGAR."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})'> <?php echo $GUIA;?></h3>
                                    <h3 class="box-title" style="float: right;"><b><?php echo "FLETE: ".$FLETE;?></b></h3>
                                </div>
                            <div class="box-body table-responsive">
                                 <div style="overflow: auto; font-size: 11.5px;">
                                  <span style="float: left;">
                                    <b>EMISIÓN:</b> <?php echo $FECHA_EMISION."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>SALIDA:</b> <?php echo $FECHA_SALIDA."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>PARTIDA:</b> <?php echo $DIRE_PART."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>LLEGADA:</b> <?php echo $DIRE_SALI."."?>
                                  </span><br>
                                  <?php if ($PARTIDA_IF=='OFICINA') { ?>
                                    <span style="float: left;">
                                      <b>DIST.:</b> <?php echo $SUCU_DIST?>
                                      <b>PROV.:</b> <?php echo $SUCU_PROVI?>
                                      <b>DEP.:</b> <?php echo $SUCU_DEPA."."?>
                                    </span>
                                  <?php } elseif ($PARTIDA_IF=='PROVEEDOR') { ?>
                                    <span style="float: left;">
                                      <b>DIST.:</b> <?php echo $PROVE_DIST?>
                                      <b>PROV.:</b> <?php echo $PROVE_PROVI?>
                                      <b>DEP.:</b> <?php echo $PROVE_DEPA."."?>
                                    </span>  
                                  <?php } ?>
                                  <span style="float: right;">
                                    <b>DIST.:</b> <?php echo $CLI_DIST?>
                                    <b>PROV.:</b> <?php echo $CLI_PROVI?>
                                    <b>DEP.:</b> <?php echo $CLI_DEPA."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>REMITENTE:</b> <?php 
                                    if($datos['envio_guia']=='1'){ echo $PROVEEDOR."."; }
                                    elseif ($datos['envio_guia']=='2'){ echo $CLIENTE."."; }
                                    elseif ($datos['envio_guia']=='3'){ echo $CLIENTE2."."; }
                                    else { echo "DESCONOCIDO.";}?>
                                  </span>
                                  <span style="float: right;">
                                    <b>DESTINATARIO:</b> <?php 
                                    if($datos['envio_guia']=='1'){ echo $CLIENTE."."; }
                                    elseif ($datos['envio_guia']=='2'){ echo $CLIENTE."."; }
                                    elseif ($datos['envio_guia']=='3'){ echo $CLIENTE."."; }
                                    else { echo "DESCONOCIDO.";}?>
                                  </span><br><br>
                                  <span style="float: left;">
                                    <b>PROVEEDOR ( RUC ):</b> <?php echo $PROVEEDOR_RUC."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>VEHÍCULO ( PLACA ):</b> <?php echo $VEHICULO."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>PROPIETARIO ( RUC ):</b> <?php echo $PROPIETARIO."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>CHOFER ( BREVETE ):</b> <?php echo $CHOFER."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>EMPRESA SUBCONTRATADA:</b> <?php echo $SUB."."?>
                                  </span> 
                                 </div>
                              <br>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class='faa-float animated-hover'>Ítem</th>
                                                <th class='faa-float animated-hover'>Descripción</th>
                                                <th class='faa-float animated-hover'>Cantidad</th>
                                                <th class='faa-float animated-hover'>Peso ( KG.)</th>
                                                <th class='faa-float animated-hover'>Precio</th>
                                                <th class='faa-float animated-hover'>Código</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                              $consulta_principal="SELECT id_detalle, CAST(@s:=@s+1 AS UNSIGNED) AS orden, detalle.id_movimiento, descripcion_deta, CONCAT(cantidad_deta,' ',descripcion_med) AS cantidad_deta, CONCAT(peso_deta,' KG.') AS peso_deta, CONCAT('S/',FORMAT(monto_deta,2)) AS PRECIO FROM movimientos, detalle, medidas, guias, (SELECT @s:=0) AS s WHERE movimientos.id_movimiento=detalle.id_movimiento AND detalle.id_medida=medidas.id_medida AND movimientos.id_movimiento=guias.id_movimiento AND detalle.id_movimiento='$x1' AND estado_movi='SIN ASIGNAR' ORDER BY orden, detalle.id_movimiento DESC";

                                              $TOTALES="SELECT detalle.id_detalle, detalle.id_movimiento, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, (FORMAT(SUM(monto_deta),2)) AS PRECIO FROM detalle WHERE detalle.id_movimiento='$x1' GROUP BY detalle.id_movimiento";

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
                                            echo '  <form role="form"  name="fe" action="?mod=movimientos&adicionarremito=eliminardetalle&detalle='.$fila_principal["id_detalle"].'&codigo='.$fila_principal["id_movimiento"].' method="post">';

                                             echo "<tr>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[orden]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[descripcion_deta]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[cantidad_deta]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[peso_deta]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[PRECIO]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[id_detalle]
                                                        </td>
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
                                                    echo $CANTIDAD_FINAL." elemento";
                                                  } elseif ($CANTIDAD_FINAL>1) {
                                                    echo $CANTIDAD_FINAL." elementos";
                                                  } else {
                                                    echo $CANTIDAD_FINAL." elementos";
                                                  }
                                                ?>
                                              </td>
                                              <td class='faa-float animated-hover'>
                                                <?php echo $PESO_FINAL." KG."?>
                                              </td>
                                              <td colspan="2" class='faa-float animated-hover'>
                                                <?php echo "S/".$PRECIO_FINAL?>
                                              </td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box-body -->
                                <!-- form start -->
                            </div><!-- /.box -->


<?php
}
}

     

     if (isset($_GET['editaregreso'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['editaregreso'])) {
                           
$descripcion=trim(strtoupper($_POST["descripcion"]));
$cbx_operacionEgreso=trim(strtoupper($_POST["cbx_operacionEgreso"]));
$documento=trim(strtoupper($_POST["documento"]));
$monto=trim(strtoupper($_POST["monto"]));
$serie=trim(strtoupper($_POST["serie"]));
$numero=trim(strtoupper($_POST["numero"]));


if( $descripcion=="" )
                {
                
                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {

$sql22=" UPDATE movimientos SET 
descripcion_movi='$descripcion',
id_operacion='$cbx_operacionEgreso',
id_documento='$documento',
monto_movi='$monto',
serie_movi='$serie',
numero_movi='$numero'
 where id_movimiento='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos del egreso correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaegreso" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, hora_movi, operaciones.descripcion_ope, serie_movi, numero_movi, CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) AS DOCUMENTO, descripcion_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, monto_movi FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND id_movimiento='$x1' AND tipo_ope='EGRESOS' ORDER BY fecha_movi, hora_movi";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar egreso </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&editaregreso=editaregreso&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Descripción del egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción del egreso" value="<?php echo $fila['descripcion_movi']?>">

                                            <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una categoría de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_categoriaEgreso" id="cbx_categoriaEgreso" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['categoria_ope']?>">ACTUAL: <?php echo $fila['categoria_ope']?></option>
                                                <?php while($EGR = $resultado_egreso->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $EGR['categoria_ope']; ?>"><?php echo $EGR['categoria_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionEgreso" id="cbx_operacionEgreso" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['descripcion_ope']?>">ACTUAL: <?php echo $fila['descripcion_ope']?></option>              
                                            </select>

                                            
                                            <label for="exampleInputFile">Tipo de documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="tipo_documento" id="tipo_documento" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['tipo_doc']?>">ACTUAL: <?php echo $fila['tipo_doc']?></option>
                                                <?php while($DOC = $resultado_documento->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOC['tipo_doc']; ?>"><?php echo $DOC['tipo_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['id_documento']?>">ACTUAL: <?php echo $fila['nombre_doc']?></option>  
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{1,4}' maxlength="4" required value="<?php echo $fila['serie_movi']?>">

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" required value="<?php echo $fila['numero_movi']?>">

                                            <label for="exampleInputFile">Monto de egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto del egreso" value="<?php echo $fila['monto_movi']?>">

                                        </div>                              
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="editaregreso" id="editaregreso" value="editaregreso">Actualizar datos</button>
                                        
                                    
                                    </div></center>
                                </form>
                            </div><!-- /.box -->

<?php
}
}
     

     if (isset($_GET['editaringreso'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['editaringreso'])) {
                           
$descripcion=trim(strtoupper($_POST["descripcion"]));
$cbx_operacionIngreso=trim(strtoupper($_POST["cbx_operacionIngreso"]));
$documento=trim(strtoupper($_POST["documento"]));
$monto=trim(strtoupper($_POST["monto"]));
$serie=trim(strtoupper($_POST["serie"]));
$numero=trim(strtoupper($_POST["numero"]));


if( $descripcion=="" )
                {
                
                    echo "
   <script> alert('campos vacios')</script>
   ";
                    echo "<br>";
                    
                }
        else
           {

$sql22=" UPDATE movimientos SET 
descripcion_movi='$descripcion',
id_operacion='$cbx_operacionIngreso',
id_documento='$documento',
monto_movi='$monto',
serie_movi='$serie',
numero_movi='$numero'
 where id_movimiento='$x1'";


$bd->consulta($sql22);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';



                               echo " Se actualizaron los datos del ingreso correctamente.";
                           
                            
                         echo '</div>';


                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaingreso" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';  

}
   
}


     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, hora_movi, operaciones.descripcion_ope, serie_movi, numero_movi, CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) AS DOCUMENTO, descripcion_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, monto_movi FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND id_movimiento='$x1' AND tipo_ope='INGRESOS' ORDER BY fecha_movi, hora_movi";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Editar ingreso </h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&editaringreso=editaringreso&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Descripción del ingreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción del ingreso" value="<?php echo $fila['descripcion_movi']?>">

                                            <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una categoría de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_categoriaIngreso" id="cbx_categoriaIngreso" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['categoria_ope']?>">ACTUAL: <?php echo $fila['categoria_ope']?></option>
                                                <?php while($IGR = $resultado_ingreso->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $IGR['categoria_ope']; ?>"><?php echo $IGR['categoria_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionIngreso" id="cbx_operacionIngreso" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['descripcion_ope']?>">ACTUAL: <?php echo $fila['descripcion_ope']?></option>              
                                            </select>

                                            
                                            <label for="exampleInputFile">Tipo de documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="tipo_documento" id="tipo_documento" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['tipo_doc']?>">ACTUAL: <?php echo $fila['tipo_doc']?></option>
                                                <?php while($DOC = $resultado_documento->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOC['tipo_doc']; ?>"><?php echo $DOC['tipo_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['id_documento']?>">ACTUAL: <?php echo $fila['nombre_doc']?></option>  
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{1,4}' maxlength="4" required value="<?php echo $fila['serie_movi']?>">

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return enteros(this, event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" required value="<?php echo $fila['numero_movi']?>">

                                            <label for="exampleInputFile">Monto de ingreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto del ingreso" value="<?php echo $fila['monto_movi']?>">

                                        </div>                              
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary btn-lg" name="editaringreso" id="editaringreso" value="editaringreso">Actualizar datos</button>
                                        
                                    
                                    </div></center>
                                </form>
                            </div><!-- /.box -->

<?php


}
}

 //eliminar

     if (isset($_GET['eliminaregreso'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['eliminaregreso'])) {
                           
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


$sql="UPDATE movimientos SET estado_movi='ANULADO' WHERE id_movimiento='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se anuló el egreso correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaegreso" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, numero_movi, CONCAT(documentos.nombre_doc,' ',numero_movi) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, serie_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND tipo_ope='EGRESOS' AND estado_movi!='ANULADO' AND id_movimiento='$x1' ORDER BY fecha_movi, hora_movi";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Está a punto de anular el egreso actual . . .";


                                echo '   </div>'; ?>

  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Anular egreso</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&eliminaregreso=eliminaregreso&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción del egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción del egreso" value="<?php echo $fila['descripcion_movi']?>" disabled>

                                            <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una categoría de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_categoriaEgreso" id="cbx_categoriaEgreso" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['categoria_ope']?>">ACTUAL: <?php echo $fila['categoria_ope']?></option>
                                                <?php while($EGR = $resultado_egreso->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $EGR['categoria_ope']; ?>" disabled><?php echo $EGR['categoria_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionEgreso" id="cbx_operacionEgreso" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['descripcion_ope']?>">ACTUAL: <?php echo $fila['descripcion_ope']?></option>              
                                            </select>

                                            
                                            <label for="exampleInputFile">Tipo de documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="tipo_documento" id="tipo_documento" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['tipo_doc']?>">ACTUAL: <?php echo $fila['tipo_doc']?></option>
                                                <?php while($DOC = $resultado_documento->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOC['tipo_doc']; ?>" disabled><?php echo $DOC['tipo_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['id_documento']?>">ACTUAL: <?php echo $fila['nombre_doc']?></option>  
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{4,4}' maxlength="4" value="<?php echo $fila['serie_movi']?>" disabled>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" value="<?php echo $fila['numero_movi']?>" disabled>

                                            <label for="exampleInputFile">Encargado de firmar <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="firma" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre del encargado que firma" value="<?php echo $fila['firma_movi']?>" disabled>

                                            <label for="exampleInputFile">Monto de egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="text" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto del egreso" value="<?php echo $fila['monto_movi']?>" disabled>


                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminaregreso" id="eliminaregreso" value="Anular egreso">
                                        
                                    </div></center>
                                </form>
                            </div><!-- /.box -->

<?php


}
}

 //eliminar

     if (isset($_GET['eliminarremito'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['eliminarremito'])) {
                           
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


$sql="UPDATE movimientos SET estado_movi='ANULADO' WHERE id_movimiento='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se anuló la guía de remisión correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaremito" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, serie_movi, numero_movi, CONCAT(documentos.nombre_doc,' ',numero_movi) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND documentos.nombre_doc LIKE '%GUIA DE REMISION%' AND estado_movi!='ANULADO' AND id_movimiento='$x1' ORDER BY fecha_movi, hora_movi";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Está a punto de anular la guía de remisión actual . . .";


                                echo '   </div>'; ?>

  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Anular guía de remisión</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&eliminarremito=eliminarremito&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción general <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción general" value="<?php echo $fila['descripcion_movi']?>" disabled>

                                            <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una categoría de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_categoriaEgreso" id="cbx_categoriaEgreso" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['categoria_ope']?>">ACTUAL: <?php echo $fila['categoria_ope']?></option>
                                                <?php while($EGR = $resultado_egreso->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $EGR['categoria_ope']; ?>" disabled><?php echo $EGR['categoria_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionEgreso" id="cbx_operacionEgreso" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['descripcion_ope']?>">ACTUAL: <?php echo $fila['descripcion_ope']?></option>              
                                            </select>

                                            
                                            <label for="exampleInputFile">Tipo de documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="tipo_documento" id="tipo_documento" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['tipo_doc']?>">ACTUAL: <?php echo $fila['tipo_doc']?></option>
                                                <?php while($DOC = $resultado_documento->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOC['tipo_doc']; ?>" disabled><?php echo $DOC['tipo_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['id_documento']?>">ACTUAL: <?php echo $fila['nombre_doc']?></option>  
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{4,4}' maxlength="4" value="<?php echo $fila['serie_movi']?>" disabled>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" value="<?php echo $fila['numero_movi']?>" disabled>

                                            <label for="exampleInputFile">Encargado de firmar <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="firma" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre del encargado que firma" value="<?php echo $fila['firma_movi']?>" disabled>

                                            <label for="exampleInputFile">Monto de egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="text" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto del egreso" value="<?php echo $fila['monto_movi']?>" disabled>


                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminarremito" id="eliminarremito" value="Anular guía de remisión">
                                        
                                    </div></center>
                                </form>
                            </div><!-- /.box -->


<?php


}
}

 //eliminar

     if (isset($_GET['eliminaringreso'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['eliminaringreso'])) {
                           
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


$sql="UPDATE movimientos SET estado_movi='ANULADO' WHERE id_movimiento='$x1'";


$bd->consulta($sql);
                          

   
                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b>';

                                        echo " Se anuló el ingreso correctamente.";


                               echo '   </div>';
                           
                                echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaingreso" method="post" id="ContactForm">
    


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


                                        
     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, hora_movi, operaciones.descripcion_ope, serie_movi, serie_movi, numero_movi, CONCAT(documentos.nombre_doc,' ',numero_movi) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi FROM movimientos, operaciones, documentos WHERE movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND tipo_ope='INGRESOS' AND estado_movi!='ANULADO' AND id_movimiento='$x1' ORDER BY fecha_movi, hora_movi";

     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {

?>

<?php echo '<div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Advertencia!</b>';

                                        echo " Está a punto de anular el ingreso actual . . .";


                                echo '   </div>'; ?>

  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Anular ingreso</h3>
                                </div>

                                
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&eliminaringreso=eliminaringreso&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Descripción del ingreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="descripcion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción del ingreso" value="<?php echo $fila['descripcion_movi']?>" disabled>

                                            <label for="exampleInputFile">Categoría de operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una categoría de operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una categoría de operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_categoriaIngreso" id="cbx_categoriaIngreso" data-show-subtext="true" data-live-search="true" required>
                                                <option class="btn-danger" value="<?php echo $fila['categoria_ope']?>">ACTUAL: <?php echo $fila['categoria_ope']?></option>
                                                <?php while($IGR = $resultado_ingreso->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $IGR['categoria_ope']; ?>" disabled><?php echo $IGR['categoria_ope']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Operación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger una operación." onclick="Swal.fire({title:'<h2>Por favor seleccione una operación</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="cbx_operacionIngreso" id="cbx_operacionIngreso" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['descripcion_ope']?>">ACTUAL: <?php echo $fila['descripcion_ope']?></option>              
                                            </select>

                                            
                                            <label for="exampleInputFile">Tipo de documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un tipo de documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un tipo de documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="tipo_documento" id="tipo_documento" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['tipo_doc']?>">ACTUAL: <?php echo $fila['tipo_doc']?></option>
                                                <?php while($DOC = $resultado_documento->fetch_assoc()) { ?>
                                                 <option class='btn-primary' value="<?php echo $DOC['tipo_doc']; ?>" disabled><?php echo $DOC['tipo_doc']; ?></option>
                                                <?php } ?>
                                            </select>

                                            <label for="exampleInputFile">Documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Se requiere escoger un documento." onclick="Swal.fire({title:'<h2>Por favor seleccione un documento</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <select class='btn btn-primary faa-float animated-hover' name="documento" id="documento" data-show-subtext="true" data-live-search="true">
                                                <option class="btn-danger" value="<?php echo $fila['id_documento']?>">ACTUAL: <?php echo $fila['nombre_doc']?></option>  
                                            </select>

                                            <label for="exampleInputFile">Serie del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (4) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (4)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="serie" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir la serie del documento" pattern='.{4,4}' maxlength="4" value="<?php echo $fila['serie_movi']?>" disabled>

                                            <label for="exampleInputFile">Número del documento <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z) y números (0-9). Se requieren (8-12) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Caracteres (8-12)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeypress="return spaceout(event)" type="text" name="numero" class="form-control faa-float animated-hover" id="exampleInputcorreo1" placeholder="Introducir el número del documento" pattern='.{8,12}' maxlength="12" value="<?php echo $fila['numero_movi']?>" disabled>

                                            <label for="exampleInputFile">Encargado de firmar <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="firma" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre del encargado que firma" value="<?php echo $fila['firma_movi']?>" disabled>

                                            <label for="exampleInputFile">Monto de egreso <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="text" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max='99999999.99' pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto del ingreso" value="<?php echo $fila['monto_movi']?>" disabled>


                                        </div>  
                                    </div><!-- /.box-body --><center>

                                    <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="eliminaringreso" id="eliminaringreso" value="Anular ingreso">
                                        
                                    </div></center>
                                </form>
                            </div><!-- /.box -->

<?php

}

}

if (isset($_GET['consultaregreso'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['consultaregreso'])) {
                           

   
}


                                        
     $consulta="SELECT CONCAT('E',LPAD(movimientos.id_movimiento,'6','0')) AS EGRESO, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, numero_movi, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) END) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, CONCAT(nombre,' ',apellido) AS nomape, nombre_suc, estado_movi FROM movimientos, operaciones, documentos, administrador, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND tipo_ope='EGRESOS' AND id_movimiento='$x1' ORDER BY fecha_movi, hora_movi";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del egreso</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&eliminar=eliminar&codigo='.$x1.'" method="post">';

        if($fila['estado_movi']=='LIQUIDADO'){

          $datos_vales="SELECT CONCAT('( VALE: ', descripcion_liqui,' )') AS descripcion_liqui, DATE_FORMAT(fecha_liqui, '( EMITIDO: %d/%m/%Y - ') AS FECHA_VALE, TIME_FORMAT(hora_liqui, '%r )') AS HORA_VALE, CONCAT('( IMPORTE MÁXIMO DEL VALE: S/',FORMAT(monto_liqui,2),' )') AS MONTO_VALE FROM liquidaciones, movimientos WHERE movimientos.id_movimiento=liquidaciones.id_movimiento AND liquidaciones.id_movimiento='$x1'";

                $cs=$bd->consulta($datos_vales);
                $vales = $bd-> mostrar_registros($datos_vales);

                $DESCRIPCION_VALE = $vales ['descripcion_liqui'];
                $MONTO_VALE = $vales ['MONTO_VALE'];
                $FECHA_VALE = $vales ['FECHA_VALE'];
                $HORA_VALE = $vales ['HORA_VALE'];
        }
        ?>

                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped"><tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Código</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['EGRESO'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Registro</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['fecha_movi']." - ".$fila['hora_movi']." ".$FECHA_VALE."".$HORA_VALE ?></td>
                                         </tr><tr><td>
                                            <h3 class='faa-float animated-hover'> Descripción</h3>
                                         <td class='faa-float animated-hover'> <?php echo $fila['descripcion_movi']." ".$DESCRIPCION_VALE ?></td></tr>
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
                                            <h3 class='faa-float animated-hover'> Monto</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['monto_movi']." ".$MONTO_VALE ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Encargado de firmar</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['firma_movi']?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Trabajador ( Sucursal )</h3>
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
                            <form  name="fe" action="?mod=movimientos&listaegreso" method="post" id="ContactForm">
    


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

<?php


if (isset($_GET['consultarremito'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['consultarremito'])) {
                           

   
}

$consulta2="SELECT DISTINCT movimientos.id_movimiento, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GUÍA DE REMISIÓN (R)' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GUÍA DE REMISIÓN (T)' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, clientes, proveedores, departamentos, provincias, distritos WHERE guias.id_proveedor=proveedores.id_proveedor AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND movimientos.id_movimiento='$x1'";

$prove_query="SELECT departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist FROM guias, proveedores, departamentos, provincias, distritos WHERE guias.id_proveedor=proveedores.id_proveedor AND proveedores.id_departamento=departamentos.id_departamento AND proveedores.id_provincia=provincias.id_provincia AND proveedores.id_distrito=distritos.id_distrito AND guias.id_movimiento='$x1'";

$sucu_query="SELECT departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist FROM movimientos, sucursales, departamentos, provincias, distritos WHERE movimientos.id_sucursal=sucursales.id_sucursal AND sucursales.id_departamento=departamentos.id_departamento AND sucursales.id_provincia=provincias.id_provincia AND sucursales.id_distrito=distritos.id_distrito AND movimientos.id_movimiento='$x1'";

$lugar_query="SELECT CONCAT('SEDE DE ',sucursales.nombre_suc) AS nombre_suc FROM guias, clientes, sucursales WHERE clientes.id_sucursal=sucursales.id_sucursal AND guias.id_movimiento='$x1';";

$cs=$bd->consulta($consulta2);
$datos = $bd-> mostrar_registros($consulta2);
//DATOS DE LA GUÍA
$GUIA = $datos['GUIA'];
$FECHA_EMISION = $datos['fecha_movi']." - ".$datos['hora_movi'];
$FECHA_SALIDA = $datos['fecha_hora_guia'];
$HORA_EMISION = $datos['hora_movi'];
$FLETE = $datos['monto_movi'];
$DIRE_PART = $datos['direccion_part'];
$DIRE_SALI = $datos['direccion_sali'];
$CLIENTE = $datos['nombre_cli'];
$CLIENTE2 = $datos['cliente2_guia'];
$PROVEEDOR = $datos['PROVEEDOR'];
$PROVEEDOR_RUC = $datos['PROVEEDOR_RUC'];
$VEHICULO = $datos['VEHICULO'];
$PROPIETARIO = $datos['PROPIETARIO'];
$CHOFER = $datos['CHOFER'];
$SUB = $datos['SUB'];
$CLI_DEPA = $datos['nombre_depa'];
$CLI_PROVI = $datos['nombre_provi'];
$CLI_DIST = $datos['nombre_dist'];
$INFO = $datos['descripcion_movi'];
//DATOS DE LA COBRANZA
$FECHA_COBRO = $datos['fecha_cobro'];
$PAGADO_COBRO = $datos['monto_cobro'];
$ESTADO_COBRO = $datos['estado_cobro'];
//COMPARACIÓN
$PARTIDA_IF = $datos['partida_guia'];

$cs=$bd->consulta($prove_query);
$prove = $bd-> mostrar_registros($prove_query);
//PROVEEDORES
$PROVE_DEPA = $prove['nombre_depa'];
$PROVE_PROVI = $prove['nombre_provi'];
$PROVE_DIST = $prove['nombre_dist'];

$cs=$bd->consulta($sucu_query);
$sucu = $bd-> mostrar_registros($sucu_query);
//SUCURSAL
$SUCU_DEPA = $sucu['nombre_depa'];
$SUCU_PROVI = $sucu['nombre_provi'];
$SUCU_DIST = $sucu['nombre_dist'];

$cs=$bd->consulta($lugar_query);
$cobranza = $bd-> mostrar_registros($lugar_query);
//LUGAR DE COBRANZA
$LUGAR = $cobranza['nombre_suc'];


                                        
     $consulta="SELECT DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, numero_movi, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) END) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, CONCAT(nombre,' ',apellido) AS nomape, nombre_suc, estado_movi FROM movimientos, operaciones, documentos, administrador, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND nombre_doc LIKE '%GUIA DE REMISION%' AND id_movimiento='$x1' ORDER BY fecha_movi, hora_movi";
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
                                    <h3 class="box-title">Consulta de la guía de remisión</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example2" class="table table-bordered table-striped">
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
                                    <h3 class="box-title" style="float: left;"><img width="25px" height="25px" frameborder="0" src="img/info.png" title="PRESIONE ACA PARA VER LA DESCRIPCIÓN DE LA GUÍA." onclick='Swal.fire({title:"<h4><?php echo "<b>DESCRIPCIÓN:</b><br>".$INFO."<br><br><b>LUGAR DE COBRANZA:</b><br>".$LUGAR."";?></h4>",type:"info",showCloseButton:true,focusConfirm:false,confirmButtonText:"<h5>ENTENDIDO</h5>",})'> <?php echo $GUIA;?></h3>
                                    <h3 class="box-title" style="float: right;"><b><?php echo "FLETE: ".$FLETE;?></b></h3>
                                </div>
                            <div class="box-body table-responsive">
                                 <div style="overflow: auto; font-size: 11.5px;">
                                  <span style="float: left;">
                                    <b>EMISIÓN:</b> <?php echo $FECHA_EMISION."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>SALIDA:</b> <?php echo $FECHA_SALIDA."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>PARTIDA:</b> <?php echo $DIRE_PART."."?>
                                  </span>
                                  <span style="float: right;">
                                    <b>LLEGADA:</b> <?php echo $DIRE_SALI."."?>
                                  </span><br>
                                  <?php if ($PARTIDA_IF=='OFICINA') { ?>
                                    <span style="float: left;">
                                      <b>DIST.:</b> <?php echo $SUCU_DIST?>
                                      <b>PROV.:</b> <?php echo $SUCU_PROVI?>
                                      <b>DEP.:</b> <?php echo $SUCU_DEPA."."?>
                                    </span>
                                  <?php } elseif ($PARTIDA_IF=='PROVEEDOR') { ?>
                                    <span style="float: left;">
                                      <b>DIST.:</b> <?php echo $PROVE_DIST?>
                                      <b>PROV.:</b> <?php echo $PROVE_PROVI?>
                                      <b>DEP.:</b> <?php echo $PROVE_DEPA."."?>
                                    </span>  
                                  <?php } ?>
                                  <span style="float: right;">
                                    <b>DIST.:</b> <?php echo $CLI_DIST?>
                                    <b>PROV.:</b> <?php echo $CLI_PROVI?>
                                    <b>DEP.:</b> <?php echo $CLI_DEPA."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>REMITENTE:</b> <?php 
                                    if($datos['envio_guia']=='1'){ echo $PROVEEDOR."."; }
                                    elseif ($datos['envio_guia']=='2'){ echo $CLIENTE."."; }
                                    elseif ($datos['envio_guia']=='3'){ echo $CLIENTE2."."; }
                                    else { echo "DESCONOCIDO.";}?>
                                  </span>
                                  <span style="float: right;">
                                    <b>DESTINATARIO:</b> <?php 
                                    if($datos['envio_guia']=='1'){ echo $CLIENTE."."; }
                                    elseif ($datos['envio_guia']=='2'){ echo $CLIENTE."."; }
                                    elseif ($datos['envio_guia']=='3'){ echo $CLIENTE."."; }
                                    else { echo "DESCONOCIDO.";}?>
                                  </span><br><br>
                                  <span style="float: left;">
                                    <b>PROVEEDOR ( RUC ):</b> <?php echo $PROVEEDOR_RUC."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>VEHÍCULO ( PLACA ):</b> <?php echo $VEHICULO."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>PROPIETARIO ( RUC ):</b> <?php echo $PROPIETARIO."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>CHOFER ( BREVETE ):</b> <?php echo $CHOFER."."?>
                                  </span><br>
                                  <span style="float: left;">
                                    <b>EMPRESA SUBCONTRATADA:</b> <?php echo $SUB."."?>
                                  </span> 
                                 </div>
                              <br>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class='faa-float animated-hover'>Ítem</th>
                                                <th class='faa-float animated-hover'>Descripción</th>
                                                <th class='faa-float animated-hover'>Cantidad</th>
                                                <th class='faa-float animated-hover'>Peso ( KG.)</th>
                                                <th class='faa-float animated-hover'>Precio</th>
                                                <th class='faa-float animated-hover'>Código</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($tipo2==1 || $tipo2==2){
                                        
                                              $consulta_principal="SELECT id_detalle, CAST(@s:=@s+1 AS UNSIGNED) AS orden, detalle.id_movimiento, descripcion_deta, CONCAT(cantidad_deta,' ',descripcion_med) AS cantidad_deta, CONCAT(peso_deta,' KG.') AS peso_deta, CONCAT('S/',FORMAT(monto_deta,2)) AS PRECIO FROM movimientos, detalle, medidas, guias, (SELECT @s:=0) AS s WHERE movimientos.id_movimiento=detalle.id_movimiento AND detalle.id_medida=medidas.id_medida AND movimientos.id_movimiento=guias.id_movimiento AND detalle.id_movimiento='$x1' ORDER BY orden, detalle.id_movimiento DESC";

                                              $TOTALES="SELECT detalle.id_detalle, detalle.id_movimiento, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, (FORMAT(SUM(monto_deta),2)) AS PRECIO FROM detalle WHERE detalle.id_movimiento='$x1' GROUP BY detalle.id_movimiento";

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
                                            echo '  <form role="form"  name="fe" action="?mod=movimientos&adicionarremito=eliminardetalle&detalle='.$fila_principal["id_detalle"].'&codigo='.$fila_principal["id_movimiento"].' method="post">';

                                             echo "<tr>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[orden]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[descripcion_deta]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[cantidad_deta]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[peso_deta]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[PRECIO]
                                                        </td>
                                                        <td class='faa-float animated-hover'>
                                                              $fila_principal[id_detalle]
                                                        </td>
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
                                                    echo $CANTIDAD_FINAL." elemento";
                                                  } elseif ($CANTIDAD_FINAL>1) {
                                                    echo $CANTIDAD_FINAL." elementos";
                                                  } else {
                                                    echo $CANTIDAD_FINAL." elementos";
                                                  }
                                                ?>
                                              </td>
                                              <td class='faa-float animated-hover'>
                                                <?php echo $PESO_FINAL." KG."?>
                                              </td>
                                              <td colspan="2" class='faa-float animated-hover'>
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
                            <form  name="fe" action="?mod=movimientos&listaremito" method="post" id="ContactForm">
    


 <input title="REGRESAR A LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  </center>
                                </div>
                            </div>
                            </div>  ';  ?>
                            
    
<?php

}
}
}
?>
<?php


if (isset($_GET['consultaringreso'])) { 

//codigo que viene de la lista
$x1=$_GET['codigo'];
                        if (isset($_POST['consultaringreso'])) {
                           

   
}


                                        
     $consulta="SELECT CONCAT('I',LPAD(movimientos.id_movimiento,'6','0')) AS INGRESO, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, numero_movi, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',serie_movi,'-',numero_movi) END) AS DOCUMENTO, descripcion_movi, firma_movi, categoria_ope, descripcion_ope, nombre_doc, tipo_doc, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, CONCAT(nombre,' ',apellido) AS nomape, nombre_suc, estado_movi FROM movimientos, operaciones, documentos, administrador, sucursales WHERE movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND tipo_ope='INGRESOS' AND id_movimiento='$x1' ORDER BY fecha_movi, hora_movi";
     $bd->consulta($consulta);
     while ($fila=$bd->mostrar_registros()) {



?>
<center>
  <div class="col-md-9">
                            
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Consulta del ingreso</h3>
                                </div>
                                
                            
        <?php  echo '  <form role="form"  name="fe" action="?mod=movimientos&eliminar=eliminar&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">                   
                                         <center>
                                         <table id="example1" class="table table-bordered table-striped"><tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Código</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['INGRESO'] ?></td>
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
                                            <h3 class='faa-float animated-hover'> Monto</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['monto_movi'] ?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Encargado de firmar</h3>
                                            </td><td class='faa-float animated-hover'>
                                         <?php echo $fila['firma_movi']?></td>
                                         </tr>
                                         <tr>
                                         <td>
                                            <h3 class='faa-float animated-hover'> Trabajador ( Sucursal )</h3>
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
                            <form  name="fe" action="?mod=movimientos&listaingreso" method="post" id="ContactForm">
    


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
<?php
      if (isset($_GET['canjearegreso'])) { 

 $x1=$_GET['codigo'];

                        if (isset($_POST['canjearegreso'])) {
                           
 $nombre=trim(strtoupper($_POST["nombre"]));
 $descripcion=trim(strtoupper($_POST["descripcion"]));
 $monto=trim(strtoupper($_POST["monto"]));
 $firma=trim(strtoupper($_POST["firma"]));
 $id=$_SESSION['dondequeda_id'];


 $ACTUALIZAR_MOVI="UPDATE movimientos SET estado_movi='LIQUIDADO', fecha_movi=CURDATE(), hora_movi=CURTIME(), id='$id', monto_movi='$monto', firma_movi='$firma' WHERE id_movimiento='$x1' AND estado_movi='POR CANJEAR'";

 $ACTUALIZAR_VALE="UPDATE liquidaciones SET descripcion_liqui='$descripcion' WHERE id_movimiento='$x1'";

 $bd->consulta($ACTUALIZAR_MOVI);
 $bd->consulta($ACTUALIZAR_VALE);                  


                            //echo "Datos Guardados Correctamente";
                            echo '<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Bien!</b> Se registró el egreso correctamente.';

                               echo '   </div>';

                               echo '
                           
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header">
                                <div class="box-header">
                                    <h3> <center>Regresar a la lista<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod=movimientos&listaegreso" method="post" id="ContactForm">
    


 <input title="REGRESAR A LA LISTA" name="btn1"  class="btn btn-primary"type="submit" value="Regresar a lista">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div>
                             ';                             



   

}
                                        
     $consulta="SELECT movimientos.id_movimiento, DATE_FORMAT(fecha_liqui, '%d/%m/%Y') AS fecha_liqui, TIME_FORMAT(hora_liqui, '%r') AS hora_liqui, operaciones.descripcion_ope, (CASE (documentos.nombre_doc) WHEN 'NINGUNO' THEN 'NINGUNO' ELSE CONCAT(documentos.nombre_doc,' ',numero_movi) END) AS DOCUMENTO, descripcion_movi, numero_movi, CONCAT('S/',FORMAT(monto_liqui,2)) AS monto_liqui2, monto_liqui, estado_movi, nombre_suc, movimientos.id_documento AS DOCUMENTO_ID, firma_movi FROM movimientos, operaciones, documentos, sucursales, liquidaciones WHERE movimientos.id_movimiento=liquidaciones.id_movimiento AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND nombre_doc NOT LIKE '%GUIA DE REMISION%' AND tipo_ope='EGRESOS' AND movimientos.id_movimiento='$x1' ORDER BY fecha_movi DESC, hora_movi DESC";
     $bd->consulta($consulta);

     while ($fila=$bd->mostrar_registros()) {


?>
<center>  
  <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Información del vale a liquidar</h3>
                                </div>
                                <h3 style="font-size: 28px;">
                                  <b>VALE - PARA LIQUIDACIÓN<br>N° <?php echo $fila['numero_movi']?></b>
                                </h3>

        <?php  
        echo '  <form role="form"  name="fe" action="?mod=movimientos&canjearegreso=canjearegreso&codigo='.$x1.'" method="post">';
        ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                             <table id="example1" class="table table-bordered table-striped">
                                              
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                         
                                             <h3> Descripción</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['descripcion_movi'] ?></td></tr>
                                           <tr>
                                          <td class='faa-float animated-hover'>
                                         
                                             <h3> Operación</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['descripcion_ope'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                            <h3> Emisión</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['fecha_liqui']." - ".$fila['hora_liqui'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                           <h3> Importe</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['monto_liqui2'] ?></td></tr>
                                          <tr>
                                          <td class='faa-float animated-hover'>
                                           <h3> Estado</h3>
                                           <td class='faa-float animated-hover'> <?php echo $fila['estado_movi'] ?></td></tr>
                                            

                                               
                                                </table>
               
  </center>

<center>  
  <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Registrar liquidación </h3>
                                    <img style="float: right;" width="65px" height="55px" frameborder="0" src="img/liqui.png"> 
                                </div>
                  
        <?php  
        echo '  <form role="form"  name="fe" action="?mod=movimientos&canjearegreso=canjearegreso&codigo='.$x1.'" method="post">';

            $nombre_tra=$_SESSION['dondequeda_nombre'];
            $apellido_tra=$_SESSION['dondequeda_apellido'];
        ?>
                                    <div class="box-body">
                                        <div class="form-group">

                                            <label for="exampleInputFile">Fecha de liquidación <img width="15px" height="15px" frameborder="0" src="img/info.png" title="La fecha y hora actual los carga el sistema automáticamente." onclick="Swal.fire({title:'<h2>La fecha y hora actual los carga el sistema automáticamente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="fecha" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="<?php echo date('d/m/Y') ." - ( Hora actual )"?>" value="<?php echo date('d/m/Y') ." - ( Hora actual )"?>" disabled>

                                            <label for="exampleInputFile">Descripción del vale <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-100) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-100)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <textarea onkeypress="return off(event)" rows="4" onblur="this.value=this.value.toUpperCase();" type="text" name="descripcion" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,100}' maxlength="100" placeholder="Introducir la descripción" required></textarea> 

                                            <label for="exampleInputFile">Monto gastado <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten números (0-9) y separador decimal (.). Se requieren (1-11) caracteres." onclick="Swal.fire({
                                            title:'<h2>Números (0-9)<br>'+'Separador decimal (.)<br>'+'Caracteres (1-11)</h2>',type:'info',showCloseButton:true,focusConfirm: false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input onkeydown="return decimales(this, event)" type="number" required name="monto" class="form-control faa-float animated-hover" id="exampleInputEmail1" step="0.01" min='0.01' max="<?php echo $fila['monto_liqui']?>" pattern='.{1,11}' maxlength="11" placeholder="Introducir el monto gastado">

                                            <label for="exampleInputFile">Encargado de firmar <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Solo se permiten letras (a-z), números (0-9) y especiales (&.). Se requieren (5-50) caracteres." onclick="Swal.fire({title:'<h2>Letras (a-z)<br>'+'Números (0-9)<br>'+'Especiales (&.)<br>Caracteres (5-50)</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="firma" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="Introducir el nombre del encargado que firma" value="<?php echo $fila['firma_movi']?>">

                                            <label for="exampleInputFile">Trabajador ( Sucursal ) <img width="15px" height="15px" frameborder="0" src="img/info.png" title="Los datos del trabajador con su sucursal respectiva los carga el sistema automáticamente." onclick="Swal.fire({title:'<h2>Los datos del trabajador con su sucursal respectiva los carga el sistema automáticamente</h2>',type:'info',showCloseButton:true,focusConfirm:false,confirmButtonText:'<h4>ENTENDIDO</h4>',})"></label>
                                            <input  onkeypress="return check(event)" onblur="this.value=this.value.toUpperCase();" type="text" required type="text" name="trabajador" class="form-control faa-float animated-hover" id="exampleInputEmail1" pattern='.{5,50}' maxlength="50" placeholder="<?php echo "$nombre_tra $apellido_tra ( ".$fila['nombre_suc']." )"?>" value="<?php echo "$nombre_tra $apellido_tra ( ".$fila['nombre_suc']." )"?>" disabled>

                                        <div class="box-footer">
                                        <input type=submit  class="btn btn-primary btn-lg" name="canjearegreso" id="canjearegreso" value="Registrar liquidación">
                                        </div>
                                        </center>
                                                                            
                                    </div><!-- /.box-body -->

                                    
                                </form>
                            </div><!-- /.box -->
                            
</div>



                            <?php
  
}

} ?>