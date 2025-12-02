<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>

<?php
$es_respuesta=0;
$nombre_comercial = "";
$cif="";
$numero_manipulador="";
$email="";
$telefono = "";
$dato_a_codificar="";

//Si me viene algun Parametro es porque le he dado a SUBMIT
if (!empty( $_POST)) 
{
    $nombre_comercial = $_POST['nombre_comercial'];
    $cif = $_POST['cif'];
    $numero_manipulador = $_POST['numero_manipulador'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $dato_a_codificar = $_POST['dato_a_codificar'];
	  $es_respuesta=1;

	//clave para la encriptacion
	$key = "passwordDR0wSSLP6660juht";
	$iv = "password";

	$buffer=$dato_a_codificar;
	//Para llegar a multiplo de 8
	$text_add = strlen($buffer)%8;    
	for($i=$text_add; $i<8; $i++)
	{
    	$buffer .= chr(8-$text_add);    
	}

	//OK
	$resultado= mcrypt_encrypt(MCRYPT_3DES, $key, $buffer, MCRYPT_MODE_CBC, $iv);
	
	/*
	//Version para PHP 7.1 en adelante
	$l = ceil(strlen($buffer) / 8) * 8;
    $resultado=substr(openssl_encrypt($buffer . str_repeat("\0", $l - strlen($buffer)), 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv), 0, $l);
	*/
	
	$resultado=base64_encode($resultado);
	$dato_codificado=$resultado;

	//Hago el INSERT en la BBD
	$sql = "INSERT INTO mds_licencias (id_usuario,nombre_comercial,cif,numero_manipulador,email,telefono) VALUES (?,?,?,?,?,?)";
  
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("isssss", $id_usuario, $nombre_comercial , $cif, $numero_manipulador ,$email , $telefono);
  $stmt->execute();
  if ($stmt->error!="")
  {
    printf("Error: %s.\n", $stmt->error);      
    $stmt->close();  
    exit; 
  }
$stmt->close(); 	
}
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>APP Matriculados del Sur</title>    
    
    <!-- Bootstrap -->
    <link href="./vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="./vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="./vendors/iCheck/skins/flat/green.css" rel="stylesheet">  
    <!-- bootstrap-wysiwyg -->
    <link href="./vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">    
    <!-- bootstrap-progressbar -->
    <link href="./vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="./vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="./vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Switchery -->
    <link href="./vendors/switchery/dist/switchery.min.css" rel="stylesheet">    
    <!-- Select2 -->
    <link href="./vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- starrr -->
    <link href="./vendors/starrr/dist/starrr.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="./vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="css/custom.min.css" rel="stylesheet">

    <script>

      function capturar()
      {    
          // Obtenemos el valor por el id
          var object=document.getElementById("correo");
          //valueForm=object.value;
          var correo=object.value;
          var dato_codificado=document.getElementById("dato_codificado").value;

          //alert("Correo " + correo);
          //alert("Dato Codificado " + dato_codificado);
          //verificamos el correo
          // Patron para el correo
	        var patron=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
          if(correo.search(patron)==0)
          {
            //Mail correcto            
            object.style.color="#000";
            var url='envio_mail.php?mail='+ correo + '&lic=' + encodeURIComponent(dato_codificado);
            //var res = encodeURIComponent(url);
            //window.location.href = 'envio_mail.php?mail='+ correo + '&lic=' + encodeURI(dato_codificado) ;
            window.location.href = url;
            return;
          }
          //Mail incorrecto
          object.style.color="#f00";
      }

    </script>

  </head>

  <body class="nav-md">
    <div class="container body">
        <div class="main_container">        
            <?php include './source/menu.php';  ?>
            <?php include './source/top-navigation.php';  ?>       
            
            <!-- page content -->        
            <div class="right_col" role="main">
              <!-- top tiles -->
              <div class="row tile_count">
                <div class="clearfix"></div>
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2>Nueva Licencia <small>Rellene los Elementos</small></h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                            
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                          <br />
                          <!--demo-form2-->
                          <form id="form-licencia" data-parsley-validate class="form-horizontal form-label-left" method="post">

                            <div class="form-group">
                              <label for="nombre_comercial" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre Comercial donde se Instala la Licencia <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="nombre_comercial" name="nombre_comercial" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $nombre_comercial; ?>" >
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="cif" class="control-label col-md-3 col-sm-3 col-xs-12">CIF donde se Instala la Licencia <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="cif" name="cif" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $cif; ?>" >
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="numero_manipulador" class="control-label col-md-3 col-sm-3 col-xs-12">N. Manipulador <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="numero_manipulador" name="numero_manipulador" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $numero_manipulador; ?>" >
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">EMail donde se Instala la Licencia<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $email; ?>" >
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="telefono" class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono donde se Instala la Licencia<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="telefono" name="telefono" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $telefono; ?>" >
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="dato_a_codificar" class="control-label col-md-3 col-sm-3 col-xs-12">Dato a Codificar</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="dato_a_codificar" name="dato_a_codificar" class="form-control col-md-7 col-xs-12" value="<?php echo $dato_a_codificar; ?>">
                              </div>
                            </div>

                            <?php 
                            	if ($es_respuesta==1)
                            	{
                            		echo '<div class="ln_solid"></div>';
                            	}	
                            ?>
                            
                            <?php if ($es_respuesta==1) 
                    		{
                    		echo '<div class="form-group">';
                            echo '<label for="dato_codificado" class="control-label col-md-3 col-sm-3 col-xs-12">Dato Codificado</label>';
                          	echo '<div class="col-md-6 col-sm-6 col-xs-12">';
                            echo '<input type="text" id="dato_codificado" name="dato_codificado" class="form-control col-md-7 col-xs-12" value="'.$dato_codificado.'" >';
                          	echo '</div>';
                            echo '</div>';

                            echo '<div class="form-group">';
                            	echo '<label for="correo" class="control-label col-md-3 col-sm-3 col-xs-12">Enviar Por Correo</label>';
	                            echo '<div class="col-md-6 col-sm-6 col-xs-12">';                          		
	                          		echo '<div class="input-group">';
	                            		echo '<input type="text" class="form-control" id="correo" name="correo">';
	                            			echo '<span class="input-group-btn">';
                                        //$destino ="window.location='envio_mail.php?mail='.$mail.'&lic='.$licencia;";  
                                        echo '<button type="button" class="btn btn-primary" onclick="capturar()">Enviar</button>';
	                                    	echo '</span>';
	                          		echo '</div>';
	                        	echo '</div>';
                        	echo '</div>';
                    		}
                    		?>

                            <div class="ln_solid"></div>
                            
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <?php if ($es_respuesta==1) 
                                {
                            		$destino ="window.location='lista_licencias.php';";
                            		echo '<button class="btn btn-primary" type="button" onclick="'.$destino.'">Volver</button>';
                            		
                                
                                }
                                else
                                {
	                                echo '<button class="btn btn-primary" type="button">Cancelar</button>';
	                                echo '<button class="btn btn-primary" type="reset">Resetear</button>';
	                                echo '<button type="submit" class="btn btn-success">Aceptar</button>';	
                                } 
                                ?>
                              </div>
                            </div>                            
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>        
              <!-- /top tiles -->         
          </div>          
        </div>
    </div>

    <!-- jQuery -->
    <script src="./vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="./vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="./vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="./vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="./vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- gauge.js -->
    <script src="./vendors/gauge.js/dist/gauge.min.js"></script>    
    <!-- iCheck -->
    <script src="./vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="./vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="./vendors/Flot/jquery.flot.js"></script>
    <script src="./vendors/Flot/jquery.flot.pie.js"></script>
    <script src="./vendors/Flot/jquery.flot.time.js"></script>
    <script src="./vendors/Flot/jquery.flot.stack.js"></script>
    <script src="./vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="./vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="./vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="./vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="./vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="./vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="./vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="./vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="./vendors/moment/min/moment.min.js"></script>
    <script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>    
    <!-- Switchery -->
    <script src="./vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="./vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="./vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="./vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="./vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="./vendors/starrr/dist/starrr.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="./js/custom.min.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="./vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="./vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="./vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="./vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- bootstrap-datetimepicker -->    
    <script src="./vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>



  </body>
</html>