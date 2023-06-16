<?php
if(ob_get_length() > 0) {
    ob_clean();
}
?>
<?php
include"../inc/comun.php";
include"../fpdf/fpdf.php";

ob_end_clean();    
header("Content-Encoding: None", true);

 $bd = new GestarBD;
 $id_manifiesto=$_GET['id_manifiesto'];

date_default_timezone_set('America/Lima');
$hora = date('H:i:s a');
$fecha = date('d/m/Y ');

class MiPDF extends FPDF {
	
	public function header()
		{

		}
	
	}
	
	$mipdf = new MiPDF('L','mm','A4');

	$encabezado_info="SELECT movimientos.id_movimiento, numero_movi, DATE_FORMAT(CONCAT(movimientos.fecha_movi,' ',movimientos.hora_movi), '%d/%m/%Y %r') AS SALIDA2, DATE_FORMAT(movimientos.fecha_movi, '%d/%m/%Y') AS SALIDA, DATE_FORMAT(manifiestos.fecha_mani, '%d/%m/%Y') AS FECHA, DATE_FORMAT(movimientos.hora_movi, '%r') AS HORA, movimientos.descripcion_movi, CONCAT('M',LPAD(manifiestos.id_manifiesto,'6','0')) AS MANIFIESTO, sucursales.nombre_suc AS REMITENTE, manifiestos.nombre_dest_mani AS DESTINATARIO, sucursales.direccion_suc AS DIRE_REMI, manifiestos.direccion_dest_mani AS DIRE_DESTI, vehiculos.placa_vehi AS CAMION, (COALESCE(CASE placa_carreta WHEN '' THEN 'SIN PLACA' ELSE CONCAT(placa_carreta) END, 'SIN PLACA')) AS CARRETA, propietarios.nombre_prop AS PROPIETARIO, propietarios.ruc_prop AS RUC, CONCAT(choferes.apellido_cho,', ',choferes.nombre_cho) AS CHOFER, choferes.brevete_cho AS BREVETE, CONCAT(administrador.nombre,' ',administrador.apellido) AS ENCARGADO, CONCAT('S/',FORMAT(movimientos.monto_movi,2)) AS FLETE, (COALESCE(CASE manifiestos.nombre_sub_mani WHEN '' THEN 'NO REQUERIDA' ELSE CONCAT(manifiestos.nombre_sub_mani) END, 'NO REQUERIDA')) AS nombre_sub_mani, (COALESCE(CASE manifiestos.observacion_mani WHEN '' THEN 'SIN OBSERVACIONES' ELSE CONCAT(manifiestos.observacion_mani) END, 'SIN OBSERVACIONES')) AS observacion_mani, CONCAT('S/',FORMAT(movimientos.monto_sub_movi,2)) AS MONTO_SUB, CONCAT('S/',FORMAT((movimientos.monto_sub_movi-movimientos.monto_sub_movi),2)) AS TOTAL, estado_movi, ruc_prop AS RUC FROM movimientos, manifiestos, sucursales, vehiculos, choferes, administrador, propietarios WHERE movimientos.id_movimiento=manifiestos.id_movimiento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id=administrador.id AND manifiestos.id_vehiculo=vehiculos.id_vehiculo AND manifiestos.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND manifiestos.id_manifiesto='$id_manifiesto' ORDER BY SALIDA DESC";

		$cs=$bd->consulta($encabezado_info);
		$datos2 = $bd-> mostrar_registros($encabezado_info);
        
        //DATOS DEL MANIFIESTO
		$DESCRIP = $datos2['descripcion_movi'];
		$OBSERVACIONES = $datos2['observacion_mani'];
		$MANIFIESTO_C = $datos2['numero_movi'];
		$COD_MANI = $datos2['MANIFIESTO'];
		$REGISTRO = $datos2['FECHA'];
		$SALIDA = $datos2['SALIDA'];
		$REMITENTE = $datos2['REMITENTE'];
		$DESTINATARIO = $datos2['DESTINATARIO'];
		$DIRE_REMI = $datos2['DIRE_REMI'];
		$DIRE_DESTI = $datos2['DIRE_DESTI'];
		$CAMION = $datos2['CAMION'];
		$CARRETA = $datos2['CARRETA'];
		$PROPIETARIO = $datos2['PROPIETARIO'];
		$RUC = $datos2['RUC'];
		$CHOFER = $datos2['CHOFER'];
		$BREVETE = $datos2['BREVETE'];
		$SUBCONTRATACION = $datos2['nombre_sub_mani'];
		$MONTO_SUB = $datos2['MONTO_SUB'];
		$FLETE = $datos2['FLETE'];

		$mipdf -> addPage();

		$mipdf -> SetFont('ARIAL','B', 9);
		$mipdf -> cell('mm',5,utf8_decode("ABARROTERO EXPRESS S.R.L."), 0 , 0, 'L');
		$mipdf -> cell('mm',5,utf8_decode("FECHA : $fecha"), 0 , 10, true);
		$mipdf -> cell('mm',2,utf8_decode("HORA : $hora"), 0 , 10, true);

		$mipdf -> Setfont('Arial','B',12);
		$mipdf -> Ln (2);
		$mipdf -> Cell('mm',11,utf8_decode("MANIFIESTO DE CARGA N° $MANIFIESTO_C"),0,0,'C');
		$mipdf -> Ln (10);

		$mipdf -> Setfont('Arial','B',9);
		$mipdf -> Ln (2);
		$mipdf -> Cell('mm',11,utf8_decode("EMISIÓN: $REGISTRO."),0,0,'L');
		$mipdf -> Cell('mm',11,utf8_decode("SALIDA: $SALIDA."),0,0,'R');
		$mipdf -> Ln (5);
		$mipdf -> Cell('mm',11,utf8_decode("SEÑORES ( OFICINA ): $DESTINATARIO."),0,0,'L');
		$mipdf -> Cell('mm',11,utf8_decode("REMITENTE ( OFICINA ): $REMITENTE."),0,0,'R');
		$mipdf -> Ln (5);
		$mipdf -> Cell('mm',11,utf8_decode("DIRECCIÓN: $DIRE_DESTI."),0,0,'L');
		$mipdf -> Cell('mm',11,utf8_decode("DIRECCIÓN: $DIRE_REMI."),0,0,'R');
		$mipdf -> Ln (8);
		$mipdf -> Cell('mm',11,utf8_decode("CAMIÓN: $CAMION."),0,0,'L');
		$mipdf -> Cell('mm',11,utf8_decode("CARRETA: $CARRETA."),0,0,'R');
		$mipdf -> Ln (5);
		$mipdf -> Cell('mm',11,utf8_decode("PROPIETARIO: $PROPIETARIO."),0,0,'L');
		$mipdf -> Cell('mm',11,utf8_decode("RUC: $RUC."),0,0,'R');
		$mipdf -> Ln (5);
		$mipdf -> Cell('mm',11,utf8_decode("CHOFER: $CHOFER."),0,0,'L');
		$mipdf -> Cell('mm',11,utf8_decode("BREVETE: $BREVETE."),0,0,'R');

		$mipdf -> Ln (15);

        	$mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(13,11,utf8_decode("Ítem"),1,0,'C',true);
			
			$mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(39,11,utf8_decode("Guía TAE"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(39,11,utf8_decode("Guía / Fact. Proveedor"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(80,11,utf8_decode("Cliente"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,11,utf8_decode("Cantidad de bultos"),1,0,'C',true);

		    $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,11,utf8_decode("Peso ( KG.)"),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,11,utf8_decode("Flete"),1,0,'C',true);
				
			$mipdf -> Ln (1);
		
	$mipdf -> Ln(10);
	
$consulta_principal="SELECT DISTINCT movimientos.id_movimiento, carga.id_guia, CAST(@s:=@s+1 AS UNSIGNED) AS orden, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GRR' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GRT' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, CONCAT((CASE carga.escrito_car WHEN 'GUIA' THEN 'G' WHEN 'FACTURA' THEN 'F' ELSE '' END),' ',serie_car,'-',numero_car) AS DOCUPROVE, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, (FORMAT(SUM(monto_deta),2)) AS PRECIO FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, detalle, clientes, proveedores, departamentos, provincias, distritos, carga, (SELECT @s:=0) AS s WHERE movimientos.id_movimiento=detalle.id_movimiento AND guias.id_guia=carga.id_guia AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND carga.id_manifiesto='$id_manifiesto' GROUP BY id_carga ORDER BY orden;";


	$TOTALES="SELECT DISTINCT movimientos.id_movimiento, carga.id_guia, CAST(@s:=@s+1 AS UNSIGNED) AS orden, descripcion_movi, CONCAT(nombre_prov,' ( ',ruc_prov,' )') AS PROVEEDOR_RUC, nombre_prov AS PROVEEDOR, nombre_prov, ruc_prov, envio_guia, cliente2_guia, DATE_FORMAT(fecha_movi, '%d/%m/%Y') AS fecha_movi, TIME_FORMAT(hora_movi, '%r') AS hora_movi, operaciones.descripcion_ope, CONCAT((CASE documentos.nombre_doc WHEN 'GUIA DE REMISION - REMITENTE' THEN 'GRR' WHEN 'GUIA DE REMISION - TRANSPORTISTA' THEN 'GRT' ELSE 'GUÍA DE REMISIÓN' END),' ',serie_movi,'-',numero_movi) AS GUIA, CONCAT((CASE carga.escrito_car WHEN 'GUIA' THEN 'G' WHEN 'FACTURA' THEN 'F' ELSE '' END),' ',serie_car,'-',numero_car) AS DOCUPROVE, descripcion_movi, CONCAT('S/',FORMAT(monto_movi,2)) AS monto_movi, estado_movi, nombre_suc, serie_movi, numero_movi, DATE_FORMAT(fecha_hora_guia,'%d/%m/%Y - %r') AS fecha_hora_guia, partida_guia, salida_guia, clientes.nombre_cli, CASE partida_guia WHEN 'OFICINA' THEN CONCAT(sucursales.direccion_suc,' ( OFICINA )') WHEN 'PROVEEDOR' THEN CONCAT(proveedores.direccion_prov,' ( PROVEEDOR )') ELSE '' END AS direccion_part, CONCAT(vehiculos.marca_vehi,' ',vehiculos.color_vehi,' ( ',vehiculos.placa_vehi,(COALESCE(CASE placa_carreta WHEN '' THEN '' ELSE CONCAT(' / ',placa_carreta) END, '')),' )') AS VEHICULO, CONCAT(nombre_cho,' ',apellido_cho,' ( ',brevete_cho,' )') AS CHOFER, CONCAT(propietarios.nombre_prop,' ( ',propietarios.ruc_prop,' )') AS PROPIETARIO, CASE guias.subcontratacion_guia WHEN 'NO' THEN 'NO' WHEN 'SI' THEN CONCAT('SÍ. ',guias.nombre_sub_guia) ELSE '' END AS SUB, CASE salida_guia WHEN '1' THEN clientes.direccion_cli1 WHEN '2' THEN clientes.direccion_cli2 ELSE '' END AS direccion_sali, departamentos.nombre_depa, provincias.nombre_provi, distritos.nombre_dist, SUM(cantidad_deta) as cantidad_deta, SUM(peso_deta) as peso_deta, CONCAT('S/',(FORMAT(SUM(monto_deta),2))) AS PRECIO FROM movimientos, vehiculos, choferes, propietarios, operaciones, documentos, sucursales, guias, detalle, clientes, proveedores, departamentos, provincias, distritos, carga, (SELECT @s:=0) AS s WHERE movimientos.id_movimiento=detalle.id_movimiento AND guias.id_guia=carga.id_guia AND guias.id_vehiculo=vehiculos.id_vehiculo AND guias.id_cliente=clientes.id_cliente AND guias.id_chofer=choferes.id_chofer AND vehiculos.id_propietario=propietarios.id_propietario AND departamentos.id_departamento=provincias.id_departamento AND provincias.id_provincia=distritos.id_provincia AND movimientos.id_operacion=operaciones.id_operacion AND movimientos.id_documento=documentos.id_documento AND movimientos.id_sucursal=sucursales.id_sucursal AND movimientos.id_movimiento=guias.id_movimiento AND nombre_doc LIKE '%GUIA DE REMISION%' AND clientes.id_departamento=departamentos.id_departamento AND clientes.id_provincia=provincias.id_provincia AND clientes.id_distrito=distritos.id_distrito AND carga.id_manifiesto='$id_manifiesto' GROUP BY carga.id_manifiesto;";

	$cs=$bd->consulta($TOTALES);
	$final = $bd-> mostrar_registros($TOTALES);
    $CANTIDAD_FINAL = $final ['cantidad_deta'];
	$PESO_FINAL = $final ['peso_deta'];
	$PRECIO_FINAL = $final ['PRECIO'];

$sql2=$bd->consulta($consulta_principal);

$oye=0;
$num = 0; 


	while ( $datos = $bd-> mostrar_registros($sql2))
	{
	
		$num;

		$ORDEN= $datos ['orden'];	
		$CLIENTE = $datos ['nombre_cli'];
		$DOCUMENTO = $datos ['GUIA'];
		$DOCUPROVE = $datos ['DOCUPROVE'];
		$CANTIDAD = $datos ['cantidad_deta'];
		$PESO = $datos ['peso_deta'];
		$PRECIO = $datos ['monto_movi'];
		
		$cabeceraS = array("$id");
		
  		$num++;  
			
		$mipdf -> Cell(13,5,utf8_decode("$ORDEN"),1,0,'C');
		$mipdf -> Cell(39,5,utf8_decode("$DOCUMENTO"),1,0,'C');	  
		$mipdf -> Cell(39,5,utf8_decode("$DOCUPROVE"),1,0,'C');
		$mipdf -> Cell(80,5,utf8_decode("$CLIENTE"),1,0,'C');
		$mipdf -> Cell(35,5,utf8_decode("$CANTIDAD"),1,0,'C');
		$mipdf -> Cell(35,5,utf8_decode("$PESO KG."),1,0,'C');
		$mipdf -> Cell(35,5,utf8_decode("$PRECIO"),1,0,'C');		 

		$mipdf -> Ln(5);
	}	

	        $mipdf -> SetFont('ARIAL','B', 9);
			$mipdf -> SetFillColor(0, 191, 255);
			$mipdf -> Cell(171,7,utf8_decode("TOTAL  "),1,0,'R',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,7,utf8_decode("$CANTIDAD_FINAL"),1,0,'C',true);

		    $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,7,utf8_decode("$PESO_FINAL KG."),1,0,'C',true);

	        $mipdf -> SetFont('ARIAL','B', 9);
            $mipdf -> SetFillColor(0, 191, 255);
	        $mipdf -> Cell(35,7,utf8_decode("$PRECIO_FINAL"),1,0,'C',true);

	        $mipdf -> Ln (1);
		
	$mipdf -> Ln(10);

		$mipdf -> Ln (8);
		$mipdf -> SetFont('ARIAL','B', 9);
		$mipdf -> SetFillColor(0, 191, 255);
		$mipdf -> MultiCell('mm',11,utf8_decode("OBSERVACIONES: $OBSERVACIONES."));
		$mipdf -> Ln (5);
		$mipdf -> Cell('mm',11,utf8_decode("EMPRESA SUBCONTRATADA: $SUBCONTRATACION."),0,0,'L');
		$mipdf -> Ln (5);
		$mipdf -> Cell('mm',11,utf8_decode("MONTO: $MONTO_SUB."),0,0,'L');
		
	
		$mipdf -> Output();
		class PDF extends FPDF
{
function Footer()
{
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial','I',8);
    // Print centered page number
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');

}

}
?>