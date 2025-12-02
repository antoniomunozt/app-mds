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
                        <h2>Listado de Manipuladores</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                          </li>                          
                          <li><a class="close-link"><i class="fa fa-close"></i></a>
                          </li>
                        </ul>
                        <div class="clearfix"></div>
                      </div>
                      <div id="capa_lista_manipuladores" class="x_content">                        
                        <!-- Aqui va la Tabla con las Licencias-->
                        <?php require_once('source/tabla_lista_manipuladores.php'); ?>
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
 
</html>




