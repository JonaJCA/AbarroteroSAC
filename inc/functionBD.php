<?php
	date_default_timezone_set('America/Lima');
	header("Content-Type: text/html;charset=utf-8");
?>
<?php 
class GestarBD{

	private $conect;  
	private $base_datos;
	private $servidor;
	private $usuario;
	private $pass;
	function __construct()
	{
		include 'config.php';
		$this->servidor = $config['servidor'];
		$this->usuario = $config['usuario'];
		$this->pass = $config['pass'];
		$this->base_datos = $config['basedatos'];
		$this->conectar_base_datos();
	}

	private function conectar_base_datos() {
	 	//$this->conect = mysqli_connect($this->Servidor,$this->Usuario,$this->Clave);
		//mysqli_select_db($this->BaseDatos,$this->conect);
		
		if (! $this->conect = mysqli_connect($this->servidor,$this->usuario,$this->pass,$this->base_datos)) {
				# code...
				echo "Error al conectar";
				exit();
			}

			if (! mysqli_select_db($this->conect, $this->base_datos)) {
					# code...
					echo "Error Base de datos";
					exit();
				}
				mysqli_set_charset($this->conect, "utf8");
				return false;	
	}
	public function consulta($consulta)
	{
		# code...
		$this->consulta = mysqli_query($this->conect, $consulta);
		
	}




	public function mostrar_registros()
	{
		# code...
		if ($row = mysqli_fetch_array($this->consulta, MYSQLI_ASSOC)) {
			# code...
			return $row;
		} else {
			return false;
		}
	}
	public function mostrar_row()
	{
		if ($maxrow = mysqli_fetch_row($this->consulta)) {
			$idmaxrow = $maxrow[0];
			return $idmaxrow;
		}else {
			return false;
		}
	}
	public function numeroFilas()
	{
		if ($fila = mysqli_num_rows($this->consulta)) {
			$num_rows = $fila;
			return $num_rows;
		}else{
			return false;
		}
	}
	public function numero_campos()
	{
		if ($campos = mysqli_num_fields($this->consulta)) {
			return $campos;
		}else{
			return false;
		}
	}
	public function SelectText($campos,$tabla,$where,$order,$datoOrder,$tipoOrder)
	{
		# code...
		$select = "SELECT $campos FROM $tabla ";
		if ($where == true) {
			# code...
			$select .= "WHERE $where";
		}
		if ($order == true) {
			$select .= "ORDER BY $datoOrder $tipoOrder";
		}		
		return $select;
	}
	public function InsertText($tabla,$campos,$datos)
	{
		# code...
		$insert = "INSERT INTO $tabla ($campos)VALUES ($datos)";
		return $insert;
	}
	public function ActualizarText($tabla,$arraydatos,$where)
	{
		# code...
		$update = "UPDATE $tabla SET";
		foreach ($arraydatos as $key => $value) {
			$update .= " $key = $value";
		}
		$update .= " WHERE $where";
		return $update;
	}
	public function EliminarText($tabla,$where)
	{
		$delete = "DELETE FROM $tabla WHERE $where";
		return $delete;
	}
	public function INNER_JOIN3T($datos,$tabla1,$tabla2,$datosT2,$tabla3,$datosT3,$where)
	{
		# code...
		$inner_join = "SELECT 
		   $datos  
		FROM $tabla1
		INNER JOIN $tabla2 ON $datosT2";
		if ($tabla3 && $datosT3) {
			# code..
			$inner_join .= " INNER JOIN $tabla3 ON $datosT3";
		}
		if ($where) {
			# code...
			$inner_join .= " WHERE $where";
		}

		return $inner_join;
	}
	public function INNER_JOIN($datos,$from,$arrayTablas,$where)
	{
		# code...
		$inner_join = "SELECT 
		   $datos  
		FROM $from";

		foreach ($arrayTablas as $tabla => $relacion) {
			$inner_join .= " INNER JOIN $tabla ON $relacion";
		}
		if ($where) {
			# code...
			$inner_join .= " WHERE $where";
		}

		return $inner_join;
	}
}