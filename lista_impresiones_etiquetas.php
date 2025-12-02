<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>
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
    <!-- Select2 -->
    <link href="./vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="./vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="./vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="./vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="./vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="./vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="./vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
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
                        <h2>Listado de Impresiones de Etiquetas (Si no se filtra muestra sólo los 100 primeros Registros)</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>                          
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      
                      
                      <div id="capa_totales_impresiones_etiquetas" class="x_content">                        
                        <!-- Aqui va la fila de totales de Impresiones -->
                        <?php require_once('source/totales_impresiones_etiquetas.php'); ?>
                      </div>                


                      <div id="capa_lista_licencias_etiquetas" class="x_content">                        
                        <!-- Aqui va la Tabla con las Licencias-->
                        <?php require_once('source/tabla_lista_impresiones_etiquetas.php'); ?>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
        </div>
    </div>
  </body>
  <!-- jQuery -->
  <script src="./vendors/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="./vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="./vendors/iCheck/icheck.min.js"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="./vendors/moment/min/moment.min.js"></script>
  <script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <!-- Select2 -->
  <script src="./vendors/select2/dist/js/select2.full.min.js"></script>
  <!-- bootstrap-datetimepicker -->    
  <script src="./vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <!-- Datatables -->
  <script src="./vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="./vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="./vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="./vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="./vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="./vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="./vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="./vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="./vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="./vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="./vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="./vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="./vendors/jszip/dist/jszip.min.js"></script>
  <script src="./vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="./vendors/pdfmake/build/vfs_fonts.js"></script>
  <!-- Custom Theme Scripts -->
  <script src="./js/custom.min.js"></script>
  

  <!-- Initialize datetimepicker -->
  <script>

    $(document).ready (function(){
      $('#mibuscador').select2({
      dropdownParent: $("#myModal .modal-content")
      });
    });

    $('#myDatepickerdesde').datetimepicker({
        format: 'DD.MM.YYYY'
    });

    $('#myDatepickerhasta').datetimepicker({
        format: 'DD.MM.YYYY'
    });   

</script>
 
</html>
