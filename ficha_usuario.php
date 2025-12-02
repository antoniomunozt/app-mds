<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>

<?php
$estoy_editando=0;
$user_name="" ;
$user_password="";
$nombre="";
$dni="";
$telefono="";
$email="";
$observaciones="";
$es_administrador=0;

//Si me viene un prametro por GET es que estoy editando
if (!empty($_GET))
{    
    $estoy_editando=1;
    $id_usuario=$_GET['id_usuario'];    
    //Cargo los datos de la BBDD
    $sql="SELECT id_usuario, usuario, password,nombre,dni,telefono,email,observaciones,es_admin FROM mds_usuarios where id_usuario=".$id_usuario;
    if (!$resultado = $mysqli->query($sql)) 
    {
        // ¡Oh, no! La consulta falló. 
        echo "Lo sentimos, este sitio web está experimentando problemas.";
        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        echo "Error: La ejecución de la consulta falló debido a: \n";
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    }
    $rs = $resultado->fetch_assoc();

    $user_name = $rs['usuario'];
    $user_password = "";
    $nombre=$rs['nombre'];
    $dni=$rs['dni'];
    $telefono=$rs['telefono'];
    $email=$rs['email'];
    $observaciones=$rs['observaciones'];
    $es_administrador=$rs['es_admin'];     
    $resultado->free();   
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
                          <h2><?php if ($estoy_editando==0){echo 'Nuevo Usuario';}else{echo 'Editar Usuario';}?><small>Rellene los Elementos</small></h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                            
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        
                        <div class="x_content">
                          <br />                          
                          <form id="usuario" data-parsley-validate class="form-horizontal form-label-left" method="post" <?php if($estoy_editando==0){echo 'action="accion_usuario.php?ac=1"';}else{echo 'action="accion_usuario.php?ac=2"';};?> >

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user-name">Usuario <span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="username" name="username" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $user_name;  ?>" <?php if ($estoy_editando==1){echo 'disabled';}?>  >
                              </div>
                            </div>

                            <div class="form-group">
	                        	  <label class="control-label col-md-3 col-sm-3 col-xs-12">Password<span class="required">*</span></label>
	                        	  <div class="col-md-6 col-sm-6 col-xs-12">
	                          	  <input type="password" id="userpassword" name="userpassword" 
                                  <?php if ($estoy_editando==0){echo 'required="required"';}?> 
                                  class="form-control" value="<?php echo $user_password;?>">
	                        	  </div>
	                      	  </div>

                            <div class="form-group">
                              <label for="nombre" class="control-label col-md-3 col-sm-3 col-xs-12">Nombre</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="nombre" class="form-control col-md-7 col-xs-12" type="text" name="nombre" value="<?php echo $nombre;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="dni" class="control-label col-md-3 col-sm-3 col-xs-12">DNI</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="dni" class="form-control col-md-7 col-xs-12" type="text" name="dni" value="<?php echo $dni;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="telefono" class="control-label col-md-3 col-sm-3 col-xs-12">Teléfono</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="telefono" class="form-control col-md-7 col-xs-12" type="text" name="telefono" value="<?php echo $telefono;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">E-Mail<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="email" class="form-control col-md-7 col-xs-12" type="text" name="email" required="required" value="<?php echo $email;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="observaciones" class="control-label col-md-3 col-sm-3 col-xs-12">Observaciones</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="observaciones" class="form-control col-md-7 col-xs-12" type="text" name="observaciones" value="<?php echo $observaciones;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="esadmin" class="control-label col-md-3 col-sm-3 col-xs-12">Administrador</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">                                
                                  <input id="esadmin" name="esadmin" type="checkbox" class="js-switch" <?php if($es_administrador==0){echo 'unchecked'; }else{echo 'checked';};?> />               
                                    <?php if($estoy_editando==1){echo '<input type="hidden" name="idusuario" value='.$id_usuario.'>';}; ?>
                              </div>
                            </div>                                   

                            <div class="ln_solid"></div>
                            
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                                
                                <button class="btn btn-primary" type="button">Cancelar</button>
                                <button class="btn btn-primary" type="reset">Resetear</button>
                                <button type="submit" class="btn btn-success">Aceptar</button>                                
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