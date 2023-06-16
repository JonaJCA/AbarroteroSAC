<?php 


date_default_timezone_set('America/lima');



//------------------------------------------------------------------------------------------
//  Definiciones
$a=date("d-m-Y");
$b=date("H-m-s");

	//  Conexi?n con la Base de Datos.
	
	$arr_datos = array(
    "db_host"=> "localhost",  //mysql host
    "db_uname" => "root",  //usuario
    "db_password" => "", //password
    "db_to_backup" => "abarrotero", //nombre de la base de datos
    "db_backup_path" => "http://{$_SERVER['HTTP_HOST']}/ABARROTERO/", //directorio en tu servidor donde se hará el backup
);
backup_mysql_database ( $arr_datos );


function backup_mysql_database($params)
{
    $mtables = array();
    $contents = "CREATE DATABASE `".$params["db_to_backup"]."` \n";
    
    $mysqli = new mysqli($params["db_host"], $params["db_uname"], $params["db_password"], $params["db_to_backup"], "3306");
    if ($mysqli->connect_error) {
        die("Error : (". $mysqli->connect_errno .") ". $mysqli->connect_error);
    }
    
    $results = $mysqli->query("SHOW TABLES");
    
    while($row = $results->fetch_array()){
            $mtables[] = $row[0];
    }
    foreach($mtables as $table){
        $contents .= "#CREATE TABLE `".$table."` \n";
        
        $results = $mysqli->query("SHOW CREATE TABLE ".$table);
        while($row = $results->fetch_array()){
            $contents .= $row[1].";\n\n";
        }

        $results = $mysqli->query("SELECT * FROM ".$table);
        $row_count = $results->num_rows;
        $fields = $results->fetch_fields();
        $fields_count = count($fields);
        
        $insert_head = "INSERT INTO `".$table."` (";
        for($i=0; $i < $fields_count; $i++){
            $insert_head  .= "`".$fields[$i]->name."` ";
                if($i < $fields_count–1){
                        $insert_head  .= ", ";
                    }
        }
        $insert_head .=  ")";
        $insert_head .= " VALUES\n";        
                
        if($row_count>0){
            $r = 0;
            while($row = $results->fetch_array()){
                if(($r % 400)  == 0){
                    $contents .= $insert_head;
                }
                $contents .= "(";
                for($i=0; $i < $fields_count; $i++){
                    $row_content =  str_replace("\n","\\n",$mysqli->real_escape_string($row[$i]));
                    
                    switch($fields[$i]->type){
                        case 8: case 3:
                            $contents .=  $row_content;
                            break;
                        default:
                            $contents .= ",`". $row_content ."` ";
                    }
                    if($i < $fields_count–1){
                            $contents  .= ", ";
                        }
                }
                if(($r+1) == $row_count || ($r % 400) == 399){
                    $contents .= ");\n\n";
                }else{
                    $contents .= "),\n";
                }
                $r++;
            }
        }
    }
    
    if (!is_dir ( $params["db_backup_path"] )) {
            mkdir ( $params["db_backup_path"], 0777, true );
     }
    
    $backup_file_name = "sql-backup-".date( "d-m-Y–h-i-s").".sql";
         
    $fp = fopen($backup_file_name ,"w+");
    if (($result = fwrite($fp, $contents))) {


$hora22 = date('H:i:s a');
$fecha22=date("d/m/Y");  

?>
        <center>
  <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                </div>
                                <div>
                                    <h3 class="box-title">RESPALDO DE LA BASE DE DATOS</h3>
                                </div><div class="box-body">
                                        <div class="form-group">
                                           
                                            <center>
                                             <table id="example1" class="table table-bordered table-striped">

<tr>
                                          <td>
                                           <h3 class='faa-float animated-hover'> Nombre del archivo</h3>
                                           <td class='faa-float animated-hover'> <?php echo "$backup_file_name" ?></td></tr>    
                                           <tr>
                                          <td>
                                           <h3 class='faa-float animated-hover'> Fecha del respaldo</h3>
                                           <td class='faa-float animated-hover'> <?php echo "$fecha22 $hora22" ?></td></tr> 
<tr>
                                          <td>
                                           <h3 class='faa-float animated-hover'> Estado del respaldo</h3>
                                           <td class='faa-float animated-hover'> REALIZADO CON ÉXITO</td></tr>     
                                           <tr>
                                          <td>
                                           <h3 class='faa-float animated-hover'> Descarga del archivo</h3>
                                           <td class='faa-float animated-hover'> PRESIONE <?php echo"<a href='$backup_file_name'>AQUÍ</a> PARA DESCARGAR"?></td></tr>                                        
                                          
                                                </table>
               
  </center>
                                        </div>
                                       
                                     
                                        
                                    </div><!-- /.box-body -->

                            </div><!-- /.box -->
                            </center>
                            <?php
    }
    fclose($fp);
}
?>
</center>
