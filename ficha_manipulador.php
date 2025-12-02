<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>

<?php
$estoy_editando=0;

$Num_Manipulador="";
$Nombre_Comercial="" ;
$Razon_Social="";
$CIF="";
$Direccion="";
$Poblacion="";
$Provincia="";
$CP="";
$EMail="";
$Persona_Contacto="";
$Telefono="";
$activo=0;

isset($_SESSION["valores"]) ? $valores=$_SESSION["valores"] : $valores="" ;

//Si me viene un prametro por GET es que estoy editando
if (!empty($_GET))
{    
    $estoy_editando=1;
    $id_manipulador=$_GET['id_manipulador'];    
    //Cargo los datos de la BBDD
    $sql="SELECT * FROM mds_manipuladores where id_manipulador=".$id_manipulador;
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

    $Num_Manipulador = $rs['num_manipulador'];
    $Nombre_Comercial = $rs['Nombre_Comercial'];
    $Razon_Social = $rs['Razon_Social'];;
    $CIF=$rs['CIF'];
    $Direccion=$rs['Direccion'];
    $Poblacion=$rs['Poblacion'];
    $Provincia=$rs['Provincia'];
    $CP=$rs['CP'];
    $EMail=$rs['EMail']; 
    $Persona_Contacto=$rs['Persona_Contacto'];     
    $Telefono=$rs['Telefono']; 
    $activo=$rs['activo']; 
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
    <!-- Switchery -->
    <link href="./vendors/switchery/dist/switchery.min.css" rel="stylesheet">      
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
                          <h2><?php if ($estoy_editando==0){echo 'Nuevo Manipulador';}else{echo 'Editar Manipulador';}?><small>Rellene los Elementos</small></h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                            
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        
                        <div class="x_content">
                          <br />                          
                          <form id="manipulador" data-parsley-validate class="form-horizontal form-label-left" method="post" <?php if($estoy_editando==0){echo 'action="accion_manipulador.php?ac=1"';}else{echo 'action="accion_manipulador.php?ac=2"';};?> >

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Num_Manipulador">Numero de Manipulador<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="Num_Manipulador" name="Num_Manipulador" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Num_Manipulador"]) ? $valores["Num_Manipulador"] : $Num_Manipulador ;  ?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Nombre_Comercial">Nombre Comercial<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="Nombre_Comercial" name="Nombre_Comercial" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Nombre_Comercial"]) ? $valores["Nombre_Comercial"] : $Nombre_Comercial ;  ?>">
                              </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Razon_Social">Razón Social<span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="Razon_Social" name="Razon_Social" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Razon_Social"]) ? $valores["Razon_Social"] : $Razon_Social ;?>">
                                </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CIF">CIF<span class="required">*</span></label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="CIF" name="CIF" required="required" class="form-control col-md-7 col-xs-12" <?php if ($estoy_editando==1){ echo "readonly";} ?> value="<?php echo isset($valores["CIF"]) ? $valores["CIF"] : $CIF ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Direccion">Dirección</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="Direccion" name="Direccion" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Direccion"]) ? $valores["Direccion"] : $Direccion ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Poblacion">Población</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="Poblacion" name="Poblacion" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Poblacion"]) ? $valores["Poblacion"] : $Poblacion ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Provincia">Provincia</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="Provincia" name="Provincia" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Provincia"]) ? $valores["Provincia"] : $Provincia ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="CP">CP</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="CP" name="CP" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["CP"]) ? $valores["CP"] : $CP ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="EMail">EMail</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">                                
                                  <input type="email" id="EMail" name="EMail" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["EMail"]) ? $valores["EMail"] : $EMail ;?>"/>                                  
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Persona_Contacto">Persona de Contacto</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="Persona_Contacto" name="Persona_Contacto" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Persona_Contacto"]) ? $valores["Persona_Contacto"] : $Persona_Contacto ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Telefono">Teléfono</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="Telefono" name="Telefono" class="form-control col-md-7 col-xs-12" value="<?php echo isset($valores["Telefono"]) ? $valores["Telefono"] : $Telefono ;?>">                                
                              </div>
                            </div>

                            <div class="form-group">
                              <label for="activo" class="control-label col-md-3 col-sm-3 col-xs-12">Activo</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">                                
                                  <input id="activo" name="activo" type="checkbox" class="js-switch" <?php if($activo==0){echo 'unchecked'; }else{echo 'checked';};?> />               
                                  <?php if($estoy_editando==1){echo '<input type="hidden" name="id_manipulador" value='.$id_manipulador.'>';}; ?>
                              </div>
                            </div>                                      

                            <div class="ln_solid"></div>
                            
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"> 
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
    <!-- Switchery -->
    <script src="./vendors/switchery/dist/switchery.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="./js/custom.min.js"></script>    
    </body>
</html>