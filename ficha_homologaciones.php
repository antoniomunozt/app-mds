<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>

<?php
    $NHOrdinariaLarga="";
    $NHOrdinariaLargaPubli="";
    $NHOrdinariaAlta="";
    $NHOrdinariaLargaDel="";
    $NHMotocicletaOrdinaria="";
    $NHMotocicletaOrdinariaPubli="";
    $NHMotocicletaCorta="";
    $NHCiclomotor="";
    $NHCuatriciclo="";
    $NHRemolqueAlta="";
    $NHRemolqueLarga="";
    $NHEspecialAlta="";
    $NHEspecialLarga="";
    $NHHistoricoAlta="";
    $NHHistoricoLarga="";
    $NHOrdinariaLargaTaxi="";
    $NHCuatricicloLarga="";

    //Averiguo si hay algun registro en la Tabla para saber si estoy editanto o creando
    try
    {
        $query = "select pk from mds_configuracion_homologaciones LIMIT 1";
        $result = $mysqli->query($query);

        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row)
          {
            $pk = $row["pk"];
            $estoy_editando=1;
            //echo ("Estoy Editando $pk");          
          }
        else
          {
            $pk=0;
            $estoy_editando=0;
            //echo ("NO Estoy Editando");
          }
        $result->free();
    }
    catch(Exception $e)
    {
        //¡Oh, no! La consulta falló. 
        echo "Lo sentimos, este sitio web está experimentando problemas.";
        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        echo "Error: La ejecución de la consulta falló debido a: \n";
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    }
    

    //isset($_SESSION["valores"]) ? $valores=$_SESSION["valores"] : $valores="" ;


//Si me viene un prametro por GET es que estoy editando
if ($estoy_editando==1)
{    
    //Cargo los datos de la BBDD
    $sql="SELECT * FROM mds_configuracion_homologaciones";
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

    $NHOrdinariaLarga=$rs['NHOrdinariaLarga'];
    $NHOrdinariaLargaPubli=$rs['NHOrdinariaLargaPubli'];
    $NHOrdinariaAlta=$rs['NHOrdinariaAlta'];
    $NHOrdinariaLargaDel=$rs['NHOrdinariaLargaDel'];
    $NHMotocicletaOrdinaria=$rs['NHMotocicletaOrdinaria'];
    $NHMotocicletaOrdinariaPubli=$rs['NHMotocicletaOrdinariaPubli'];
    $NHMotocicletaCorta=$rs['NHMotocicletaCorta'];
    $NHCiclomotor=$rs['NHCiclomotor'];
    $NHCuatriciclo=$rs['NHCuatriciclo'];
    $NHRemolqueAlta=$rs['NHRemolqueAlta'];
    $NHRemolqueLarga=$rs['NHRemolqueLarga'];
    $NHEspecialAlta=$rs['NHEspecialAlta'];
    $NHEspecialLarga=$rs['NHEspecialLarga'];
    $NHHistoricoAlta=$rs['NHHistoricoAlta'];
    $NHHistoricoLarga=$rs['NHHistoricoLarga'];
    $NHOrdinariaLargaTaxi=$rs['NHOrdinariaLargaTaxi'];
    $NHCuatricicloLarga=$rs['NHCuatricicloLarga'];

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
                          <h2><?php if ($estoy_editando==0){echo 'Nuevo Registro de Homologaciones';}else{echo 'Editar Homologaciones';}?><small>Rellene los Elementos</small></h2>
                          <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                            
                          </ul>
                          <div class="clearfix"></div>
                        </div>
                        
                        <div class="x_content">
                          <br />                          
                          <form id="homologaciones" data-parsley-validate class="form-horizontal form-label-left" method="post" <?php if($estoy_editando==0){echo 'action="accion_homologaciones.php?ac=1"';}else{echo 'action="accion_homologaciones.php?ac=2"';};?> >

                            <div hidden class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pk">pk</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="pk" name="pk" class="form-control col-md-7 col-xs-12" value="<?php echo $pk;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHOrdinariaLarga">NH Ordinaria Larga </label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHOrdinariaLarga" name="NHOrdinariaLarga" class="form-control col-md-7 col-xs-12" value="<?php echo $NHOrdinariaLarga;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHOrdinariaLargaPubli">NH Ordinaria Larga Publi</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHOrdinariaLargaPubli" name="NHOrdinariaLargaPubli" class="form-control col-md-7 col-xs-12" value="<?php echo $NHOrdinariaLargaPubli ;  ?>">
                              </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHOrdinariaAlta">NH Ordinaria Alta</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="NHOrdinariaAlta" name="NHOrdinariaAlta" class="form-control col-md-7 col-xs-12" value="<?php echo $NHOrdinariaAlta ;?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHOrdinariaLargaDel">NH Ordinaria Larga Delantera</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHOrdinariaLargaDel" name="NHOrdinariaLargaDel" class="form-control col-md-7 col-xs-12" value="<?php echo $NHOrdinariaLargaDel ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHMotocicletaOrdinaria">NH Motocicleta Ordinaria</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHMotocicletaOrdinaria" name="NHMotocicletaOrdinaria" class="form-control col-md-7 col-xs-12" value="<?php echo $NHMotocicletaOrdinaria ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHMotocicletaOrdinariaPubli">NH Motocicleta Ordinaria Publi</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHMotocicletaOrdinariaPubli" name="NHMotocicletaOrdinariaPubli" class="form-control col-md-7 col-xs-12" value="<?php echo $NHMotocicletaOrdinariaPubli ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHMotocicletaCorta">NH Motocicleta Corta</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHMotocicletaCorta" name="NHMotocicletaCorta" class="form-control col-md-7 col-xs-12" value="<?php echo $NHMotocicletaCorta ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHCiclomotor">NH Ciclomotor</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHCiclomotor" name="NHCiclomotor" class="form-control col-md-7 col-xs-12" value="<?php echo $NHCiclomotor ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHCuatriciclo">NH Cuatriciclo</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">                                
                                  <input type="text" id="NHCuatriciclo" name="NHCuatriciclo" class="form-control col-md-7 col-xs-12" value="<?php echo $NHCuatriciclo ;?>"/>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHRemolqueAlta">NH Remolque Alta</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHRemolqueAlta" name="NHRemolqueAlta" class="form-control col-md-7 col-xs-12" value="<?php echo $NHRemolqueAlta ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHRemolqueLarga">NH Remolque Larga</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHRemolqueLarga" name="NHRemolqueLarga" class="form-control col-md-7 col-xs-12" value="<?php echo $NHRemolqueLarga ;?>">
                              </div>
                            </div> 

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHEspecialAlta">NH Especial Alta</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHEspecialAlta" name="NHEspecialAlta" class="form-control col-md-7 col-xs-12" value="<?php echo $NHEspecialAlta ;?>">
                              </div>
                            </div> 

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHEspecialLarga">NH Especial Larga</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHEspecialLarga" name="NHEspecialLarga" class="form-control col-md-7 col-xs-12" value="<?php echo $NHEspecialLarga ;?>">
                              </div>
                            </div> 

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHHistoricoAlta">NH Historico Alta</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHHistoricoAlta" name="NHHistoricoAlta" class="form-control col-md-7 col-xs-12" value="<?php echo $NHHistoricoAlta ;?>">
                              </div>
                            </div> 

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHHistoricoLarga">NH Historico Larga</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHHistoricoLarga" name="NHHistoricoLarga" class="form-control col-md-7 col-xs-12" value="<?php echo $NHHistoricoLarga ;?>">
                              </div>
                            </div> 

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHOrdinariaLargaTaxi">NH Ordinaria Larga Taxi</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHOrdinariaLargaTaxi" name="NHOrdinariaLargaTaxi" class="form-control col-md-7 col-xs-12" value="<?php echo $NHOrdinariaLargaTaxi ;?>">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="NHCuatricicloLarga">NH Cuatriciclo Larga</label>
                              <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="NHCuatricicloLarga" name="NHCuatricicloLarga" class="form-control col-md-7 col-xs-12" value="<?php echo $NHCuatricicloLarga ;?>">
                              </div>
                            </div>
                            
                            <div class="ln_solid"></div>
                            
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">                                
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
