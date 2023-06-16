<?php 
include 'inc/comun.php';
header("Content-Type: text/html;charset=utf-8"); 
?>
<!DOCTYPE html>
<html class="lockscreen">
    <head>
        <meta charset="UTF-8">
        <title>ABARROTERO EXPRESS S.R.L.</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="author" description="José Williams Córdova Urriola <br> José Corro Acosta">
        <meta name="description" description="Abarrotero Express S.R.L.">
        <meta name="keywords" description="Abarrotero, Express, transporte, manifiesto, cobranza">
        <link rel="icon" type="image/png" href="./img/sheraton.png" />
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="sweetalert2.all.min.js"></script>
    
        <script src="js/calendario/jquery-ui.min.js" type="text/javascript" ></script>
        <script src="js/tipo_alimen.js"></script>
        <script src="js/validarfrom.js"></script>
        <script src="js/myjava.js"></script>
        <!--<script src="cordova.js"></script>-->

        <script>
        $(function() {
            $( "[data-role='navbar']" ).navbar();
            $( "[data-role='header'], [data-role='footer']" ).toolbar();
        });
        // Update the contents of the toolbars
        $( document ).on( "pagecontainerchange", function() {
            // Each of the four pages in this demo has a data-title attribute
            // which value is equal to the text of the nav button
            // For example, on first page: <div data-role="page" data-title="Info">
            var current = $( ".ui-page-active" ).jqmData( "title" );
            // Change the heading
            $( "[data-role='header'] h1" ).text( current );
            // Remove active class from nav buttons
            $( "[data-role='navbar'] a.ui-btn-active" ).removeClass( "ui-btn-active" );
            // Add active class to current nav button
            $( "[data-role='navbar'] a" ).each(function() {
                if ( $( this ).text() === current ) {
                    $( this ).addClass( "ui-btn-active" );
                }
            });
        });
    </script>
    
    </head>
    <body class="lockscreen">
    <?php
    $bd = new GestarBD;

    if (isset($_POST["iniciar"])) {
        # code...
        $usuario = $_POST["usuario"];
        $password = $_POST["pass"];
        $password=md5($password);
        //$password1=password_verify($password,$password);
        
        $usuario = $bd->SelectText('*', 'administrador', "correo='$usuario' AND pass='$password'",false,null,null);
        $bd->consulta($usuario);
        if ($mostrar = $bd->mostrar_registros()) {
            
            
            $_SESSION['dondequedavalida'] = true;
            $_SESSION['dondequeda_tipo'] = $mostrar['nive_usua'];
            $_SESSION['dondequeda_nombre'] = $mostrar['nombre'];
            $_SESSION['dondequeda_apellido'] = $mostrar['apellido'];
            $_SESSION['dondequeda_nive_usua'] = $mostrar['nive_usua'];
            $_SESSION['dondequeda_usuario'] = $mostrar['usuario'];
            $_SESSION['dondequeda_correo'] = $mostrar['correo'];
            $_SESSION['dondequeda_id'] = $mostrar['id'];
            $_SESSION['dondequeda_sucursal'] = $mostrar['id_sucursal'];
            $_SESSION['dondequeda_estado'] = $mostrar['estado'];

            if ($_SESSION['dondequeda_estado']=='ACTIVO') {
                header("Location: index.php?mod=index"); 
            }
            else { 
                session_destroy();
            ?>
                <script>
                    let timerInterval
Swal.fire({
  title: '<h2><b>Alerta!</b></h2>',
  html: '<h3>Su cuenta está <b>INACTIVA!</b></h3><br><h4>Favor de contactarse con el equipo de soporte o encargado del área. <br><br>Este mensaje se cerrará automáticamente en <strong></strong></h4>',
  timer: 50000,
  type:'error',
  showCloseButton: true,
  onBeforeOpen: () => {
    Swal.showLoading()
    timerInterval = setInterval(() => {
      Swal.getContent().querySelector('strong')
        .textContent = Swal.getTimerLeft()
    }, 100)
  },
  onClose: () => {
    clearInterval(timerInterval)
  }
}).then((result) => {
  if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.timer
  ) {
    console.log('Este mensaje se cerrará automáticamente')
  }
})
                </script>
            <?php 

echo '
  
  <center>                         
  <div class="col-md-12">
  <center>     
  <div class="box">
                                <div class="box-header" style="background: rgba(242,243,242,1);
background: -moz-linear-gradient(top, rgba(242,243,242,1) 0%, rgba(242,243,242,1) 27%, rgba(255,255,255,1) 54%, rgba(255,255,255,1) 70%, rgba(255,255,255,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(242,243,242,1)), color-stop(27%, rgba(242,243,242,1)), color-stop(54%, rgba(255,255,255,1)), color-stop(70%, rgba(255,255,255,1)), color-stop(100%, rgba(255,255,255,1)));
background: -webkit-linear-gradient(top, rgba(242,243,242,1) 0%, rgba(242,243,242,1) 27%, rgba(255,255,255,1) 54%, rgba(255,255,255,1) 70%, rgba(255,255,255,1) 100%);
background: -o-linear-gradient(top, rgba(242,243,242,1) 0%, rgba(242,243,242,1) 27%, rgba(255,255,255,1) 54%, rgba(255,255,255,1) 70%, rgba(255,255,255,1) 100%);
background: -ms-linear-gradient(top, rgba(242,243,242,1) 0%, rgba(242,243,242,1) 27%, rgba(255,255,255,1) 54%, rgba(255,255,255,1) 70%, rgba(255,255,255,1) 100%);
background: linear-gradient(to bottom, rgba(242,243,242,1) 0%, rgba(242,243,242,1) 27%, rgba(255,255,255,1) 54%, rgba(255,255,255,1) 70%, rgba(255,255,255,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=#f2f3f2, endColorstr=#ffffff, GradientType=0 );
Copy text">
                                <div class="box-header">
                                    <h3> <center>Acceder al sistema<a href="#" class="alert-link"></a></center></h3>                                    
                                </div>
                               
                            <form  name="fe" action="?mod" method="post" id="ContactForm">
    


 <input title="ACCEDER AL SISTEMA" name="btn1"  class="btn btn-primary"type="submit" value="Acceder al sistema">

    
  </form>
  
                                </div>
                            </div></center> 
                            </div></center>
                             ';               
        }

            exit;
        } else {
            //header("Location: login.php");

            ?>
            <script>Swal.fire({title: '<h3><b>Error inesperado!</b><br>Ha ingresado un correo o contraseña incorrecta</h3> <br><br><br><br><br><br><br><br><br><br><br><br><br><br> <br><br><br>', text: '', width: 350, height: 420, background: '#fff url(img/error.gif) 50% 70% no-repeat', type:'error',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>INTENTAR NUEVAMENTE</h4>'})
            </script>

            <?php 
        }

    }
    $codigo = $_GET['codigo'];
    if (isset($codigo)) {
        $query = "SELECT * FROM registros_temp WHERE codigo = '$codigo'";
        $bd->consulta($query);
        if ($temp_resg = $bd->mostrar_registros()) {

            $insertUser = "INSERT INTO `administrador` (`usuario` ,`pass` ,`nombre`  ,`correo` ,`nive_usua`, codigo_user, codigo_referr)
                                VALUES (
                                 '$temp_resg[usuario]', '$temp_resg[pass]', '$temp_resg[nombre]',  '$temp_resg[email]' , '$temp_resg[nive_usua]', '$codigo', '$temp_resg[codigo_referr]'
                                ) ";
            $bd->consulta($insertUser);

            $borrarTemp = "DELETE FROM registros_temp WHERE codigo = '$codigo'";
            $bd->consulta($borrarTemp);

            echo '<div class="form-box">
                        <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <b>Registro!</b>  Has confirmado tu cuenta correctamente. Ingrese a nuestra Intranet.
                                    </div>
                                </div>';
        }else{

        }
    }
    ?>

    <div class="form-box" id="login-box">

        <?php
        if(isset($_POST["btn1"])){
            $btn=$_POST["btn1"];
            $bus=$_POST["txtbus"];

            if($btn=="Agregar"){
                $destino = $_POST['email'];
                //$cs=mysql_query($sql,$conexion);
                $bd = new GestarBD();
                
                $usuario = $bd->SelectText('*', 'administrador', "correo='$destino'",false,null,null);
                $bd->consulta($usuario);
                if ($mostrar = $bd->mostrar_registros()) {

                    $nombre= $mostrar['nombre'];
                    $apellido= $mostrar['apellido'];
                    $usuario= $mostrar['usuario'];
                    $hola= $mostrar['correo'];
                    $clave= $mostrar['pass'];
                    $destino = $_POST['email'];
                    $asunto="Abarrotero Express | Recuperación de contraseña";
                    $comentario="
                           email:$_POST[email]
                           comentario: $_POST[com]";

                    /*$headers = 'From: '.$destino."\r\n".
                    'Reply-To:'.$destino."\r\n".
                    'X-Mailer: PHP/'.phpversion();

                    echo $destino,$asunto,$comentario,$headers;

                    mail("yond1994@gmail.com",$asunto,$comentario,$headers); */

//ini_set("SMTP", "cloud.8ssi.com");
//ini_set("sendmail_from", "registro@dondequeda.com.ve");
//ini_set("smtp_port", "465");
                    $mail = $_POST['email'];
                    $registro = "https://abarroteroexpress.com/sistema/";
                    /* $email2= "dgarciah21@gmail.com";
                    $header = 'From: < com >' . "\r\n";
                    $header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
                    $header .= "Mime-Version: 1.0 \r\n";
                    $header .= "Content-Type: text/plain";          
                    $casilla = 'wcordova96crgk7@gmail.com';*/
                    $asunto = 'Abarrotero Express | Recuperación de contraseña';
                    $cabeceras = "From: " . strip_tags('Support@abarroteroexpress.pe') . "\r\n";
                    $cabeceras .= "Reply-To: ". strip_tags($_POST['email']) . "\r\n";
                    $cabeceras .= "CC: wcordova96crgk7@gmail.com\r\n";
                    $cabeceras .= "MIME-Version: 1.0\r\n";
                    $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
                    $mensaje .= '<html><body>';
                    $mensaje .= '<img src="https://abarroteroexpress.com/sistema/img/vcom_logo.jpg" width="670px" height="70px" alt="Abarrotero Express S.R.L."/>';
                    $mensaje .= "<br><br>Estimado(a) trabajador(a) ". $nombre ." ". $apellido . ", Abarrotero Express le envía un cordial saludo. <br><br>Sirva la presente para enviarle sus datos registrados en el sistema para poder acceder a nuestra Intranet.<br><br>Ingrese su clave en la página mostrada a continuación para desencriptar su contraseña.<br><br> Gracias por la atención prestada, tenga un buen día!<br><br>";
                    $mensaje .= '<table rules="all" border="1" style="border-color: #666; width: 670px;" cellpadding="15">';                    
                    $mensaje .= "<tr><td style='background-color: #DBDBDB;'><strong> Nombre de usuario:</strong> </td><td>" . $usuario . "</td></tr>";
                    $mensaje .= "<tr><td style='background-color: #DBDBDB;'><strong> Correo electrónico:</strong> </td><td>" . strip_tags($_POST['email']) . "</td></tr>";
                    $mensaje .= "<tr><td style='background-color: #DBDBDB;'><strong> Clave de usuario:</strong> </td><td>" . $clave . "</td></tr>";
                    $mensaje .= "<tr><td style='background-color: #DBDBDB;'><strong> Coloque su clave aquí: </strong> </td><td> https://hashtoolkit.com/reverse-hash?hash </td></tr>";
                    $mensaje .= "<tr><td style='background-color: #DBDBDB;'><strong> Inicie sesión aquí: </strong> </td><td>" . $registro. "</td></tr>";
                    $mensaje .= "</table>";
                    $mensaje .= '</br><br>';
                    $mensaje .= "<br>Si usted no solicitó la recuperación de contraseña puede omitir este mensaje.<br>© Todos los derechos reservados - Abarrotero Express ".date(Y).".";
                    $mensaje .= "</body></html>";
                    $para = "$mail";
                    $asunto = 'Abarrotero Express | Recuperación de contraseña';

//Enviamos el mensaje a tu_dirección_email

                    $bool = mail($para, $asunto, $mensaje, $cabeceras);
                    if($bool){ ?>

                        <script>
                        Swal.fire({title: '<h3><b>Recuperación exitosa!</b><br><br>Se ha enviado la contraseña de su usuario a su correo. <br><br>Verifique en la bandeja de correos no deseados en caso no se visualize en la bandeja principal</h3>', text: '', type:'success',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>ENTENDIDO</h4>'})
                        </script>

                    <?php }
                } else{
                    
                    ?>

                        <script>
                        Swal.fire({title:"<h4><?php echo "<b>Alerta!</b><br><br>No se pudo recuperar sus datos, el correo recientemente ingresado:<br><b> ".$destino." </b><br> no se encuentra registrado en nuestra Intranet. Verifique su dirección";?></h4>", text: '', type:'error',showCloseButton:true,focusConfirm:false, confirmButtonText:'<h4>INTENTAR NUEVAMENTE</h4>'})
                        </script>

                    <?php }
                    
            }
        }
        ?>



        <div class="faa-float animated header" onclick="Swal.fire({title: '<h3></h3> <br><br><br><br><br><br><br><br><br><br> <br><br><br>', html: '<h4>&#128667; Más de 10 años brindando servicios de alta calidad!</h4>', width: 505, height: 510, background: '#fff url(img/gif/bienvenida.gif) 50% 65% no-repeat', imageWidth: 300, imageHeight: 100, type:' ',showConfirmButton: true, showCloseButton:false,focusConfirm:false,confirmButtonText:'<h4>EMPEZAR &#9654;&#65039;</h4>'})">&#128666; Intranet Express</div>
        <img src="img/login.gif" width="100%" height="150" title="Abarrotero Express les da la bienvenida a nuestra Intranet!" style="filter: saturate(100%);" onclick="Swal.fire({title: '<h3></h3> <br><br><br><br><br><br><br><br><br><br> <br><br><br>', html: '<h4><b>&#128667; Más de 10 años brindando servicios de alta calidad!</b></h4>', width: 505, height: 510, background: '#fff url(img/gif/bienvenida.gif) 50% 65% no-repeat', imageWidth: 300, imageHeight: 100, type:' ',showConfirmButton: true, showCloseButton:false,focusConfirm:false,confirmButtonText:'<h4>EMPEZAR &#9654;&#65039;</h4>'})"></i>
        <form  name="frmLogin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="body bg-gray">
                <div class="form-group">
                    <input required type="email" onblur="this.value=this.value.toUpperCase();" name="usuario" class="form-control" placeholder="&#128231; Ingrese su correo electrónico" maxlength="50"/>
                </div>
                <div class="form-group">
                    <input required type="password" name="pass" class="form-control" placeholder="&#128272; Ingrese su contraseña" maxlength="32"/>
                </div>
            </div>
            <div class="footer">
                <center><button type="submit" name="iniciar" style="text-align: center;" class="btn bg-olive2">Acceder al sistema</button></div></center>
        </form>
        <center>
            <a type="submit" name="" data-toggle="modal" data-target="#myModal" class="page-header">¿Olvidó su contraseña?</a>
        </form>
        <center>
            


            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

               <div class="modal-dialog">
                   <div class="modal-content ">
                       <div class="modal-header ">
                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                           <center>
                               <form role="form"  name="fe" method="post">
                                   <h4 class="modal-title" id="myModalLabel">Recupere su contraseña </h4>
                       </div>
                       <div class="modal-body">
                           <center>
                               <div class="span12 alert alert-success" style="margin-left: 0">Datos para recuperar su contraseña</div>
                           </center>
                           <div class="box-body">
                               <div class="row">
                                   <div class="col-xs-12">
                                       <label>Correo electóronico</label>
                                       <p><input type="email" name="email" id="txtNombreCurso" placeholder="Ingrese su correo electrónico" required="" class="form-control"></p>
                                   </div>
                               </div>
                           </div>
                           </br>
                           <div class="span12 alert alert-success" style="margin-left: 0">Te enviaremos tu contraseña a tu correo!</div>
                       </div>

                       <div class="modal-footer">
                           <button name="btn1" type="submit" value="Agregar" class="btn btn-primary btn-lg">Recuperar</button>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       
       </center>
        </div>
    </div>


    <!-- jQuery 2.0.2 -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>