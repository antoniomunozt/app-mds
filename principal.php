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
    <!--<link href="./vendors/iCheck/skins/flat/green.css" rel="stylesheet">	-->
    <!-- bootstrap-progressbar -->
    <!--<link href="./vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">-->
    <!-- JQVMap -->
    <!--<link href="./vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>-->
    <!-- bootstrap-daterangepicker -->
    <!--<link href="./vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">-->
    <!-- bootstrap-datetimepicker -->
    <link href="./vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
      
    <!-- Custom Theme Style -->
    <link href="./css/custom.min.css" rel="stylesheet">
    <style>
      canvas {
          -moz-user-select: none;
          -webkit-user-select: none;
          -ms-user-select: none;
        }
    </style>

  </head>

  <body class="nav-md">
    <div class="container body">
        <div class="main_container">        
            <?php include './source/menu.php';  ?>
            <?php include './source/top-navigation.php';  ?>       
            <!-- page content -->        
            <div class="right_col" role="main">
                <!-- top tiles -->
                <div class="row top_tiles">
                    
                    <!-- Usuarios Totales -->
                    <?php include './source/contador_usuarios.php';  ?>  
                
                    <!-- Licencias Totales -->
                    <?php include './source/contador_licencias.php';  ?>

                    <!-- Manipuladores Totales -->
                    <?php if ($es_admin==1) include './source/contador_manipuladores.php';  ?>

                    <!-- Licencias CLOUD -->
                    <?php if ($es_admin==1) include './source/contador_licencias_cloud.php';  ?>

                    <!-- DONUT MATRICULAS-->
                    <?php if ($es_admin==1) include './source/donut.php';  ?>

                    <!-- DONUT ETIQUETAS-->
                    <?php if ($es_admin==1) include './source/donut_etiquetas.php';  ?>
                    
                    <hr>

                    <!-- BARRAS MATRICULAS -->
                    <?php if ($es_admin==1) include './source/barras.php'; ?>

                    <!-- BARRAS ETIQUETAS -->
                    <?php if ($es_admin==1) include './source/barras_etiquetas.php'; ?>
                    
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
    <!--<script src="./vendors/Chart.js/dist/Chart.bundle.min.js"></script>-->
    <!-- gauge.js -->
    <!--<script src="./vendors/gauge.js/dist/gauge.min.js"></script>-->
    <!-- bootstrap-progressbar -->
    <!--<script src="./vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>-->
    <!-- iCheck -->
    <!--<script src="./vendors/iCheck/icheck.min.js"></script>-->
    <!-- Skycons -->
    <!--<script src="./vendors/skycons/skycons.js"></script>-->
    <!-- Flot -->
    <!--<script src="./vendors/Flot/jquery.flot.js"></script>-->
    <!--<script src="./vendors/Flot/jquery.flot.pie.js"></script>-->
    <!--<script src="./vendors/Flot/jquery.flot.time.js"></script>-->
    <!--<script src="./vendors/Flot/jquery.flot.stack.js"></script>-->
    <!--<script src="./vendors/Flot/jquery.flot.resize.js"></script>-->
    <!-- Flot plugins -->
    <!--<script src="./vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>-->
    <!--<script src="./vendors/flot-spline/js/jquery.flot.spline.min.js"></script>-->
    <!--<script src="./vendors/flot.curvedlines/curvedLines.js"></script>-->
    <!-- DateJS -->
    <!--<script src="./vendors/DateJS/build/date.js"></script>-->
    <!-- JQVMap -->
    <!--<script src="./vendors/jqvmap/dist/jquery.vmap.js"></script>-->
    <!--<script src="./vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>-->
    <!--<script src="./vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>-->
    <!-- bootstrap-daterangepicker -->
    <script src="./vendors/moment/min/moment.min.js"></script>
    <!--<script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>-->
    <!-- bootstrap-datetimepicker -->    
    <script src="./vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>    
    
    <!-- Custom Theme Scripts -->
    <script src="./js/custom.min.js"></script>

    <script>     
        //DONUT
        $('#myDatepickerdesde').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('#myDatepickerhasta').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        //DONUTETIQUETAS
        $('#myDatepickerdesdeet').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('#myDatepickerhastaet').datetimepicker({
            format: 'DD/MM/YYYY'
        }); 
        
        var MONTHS = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

        var randomScalingFactor = function() {
            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
        };
        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function() {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',.7)';
        };       

        var config = {
            type: 'doughnut',
            data: {
                datasets: [{                
                    data: [
                        5,
                        10,
                        20,
                        30,
                        40,                    
                    ],
                    backgroundColor: [
                        "#F7464A",
                        "#46BFBD",
                        "#FDB45C",
                        "#949FB1",
                        "#4D5360",
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    "Red",
                    "Green",
                    "Yellow",
                    "Grey",
                    "Dark Grey"
                ]
            },
            options: {
                responsive: true,
                legend: {                    
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Top 5 Manipuladores Por Impresión de Matrículas'
                }
            }
        };  

        var config_etiquetas = {
            type: 'doughnut',
            data: {
                datasets: [{                
                    data: [
                        5,
                        10,
                        20,
                        30,
                        40,                    
                    ],
                    backgroundColor: [
                        "#F7464A",
                        "#46BFBD",
                        "#FDB45C",
                        "#949FB1",
                        "#4D5360",
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    "Red",
                    "Green",
                    "Yellow",
                    "Grey",
                    "Dark Grey"
                    ]
            },
            options: {
                responsive: true,
                legend: {                    
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Top 5 Manipuladores Por Impresión de Etiquetas'
                }
            }
        };  

        function getAbsolutePath() 
        {
            var loc = window.location;
            var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
            return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
        }

        window.onload = function() {
            
            var ctx2 = document.getElementById("chart-area").getContext("2d");
            recargar_donut();
            window.myDoughnut = new Chart(ctx2, config);    
            
            var ctxetiquetas = document.getElementById("chart-area-donut-etiquetas").getContext("2d");
            recargar_donut_etiquetas();
            window.myDoughnut_etiquetas = new Chart(ctxetiquetas, config_etiquetas);    
                                 
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myBar = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: ["January"],
                    datasets: [{
                        label: 'Datos Año Anterior',
                        backgroundColor: "rgba(151,187,205,0.5)",
                        borderColor: 'rgb(255, 99, 132)',
                        data: [randomScalingFactor()]
                    }]
                },

                // Configuration options go here
                options: {}   
            });
            recargar_barra();

            var ctx_barra_etiquetas = document.getElementById("canvas_etiquetas").getContext("2d");
            window.myBar_etiquetas = new Chart(ctx_barra_etiquetas, {
                // The type of chart we want to create
                type: 'bar',

                // The data for our dataset
                data: {
                    labels: ["January"],
                    datasets: [{
                        label: 'Datos Año Anterior',
                        backgroundColor: "rgba(151,187,205,0.5)",
                        borderColor: 'rgb(255, 99, 132)',
                        data: [randomScalingFactor()]
                    }]
                },
                // Configuration options go here
                options: {}   
            });
            recargar_barra_etiquetas();            
        };
        

        function recargar_donut()
        {        
            let fecha_inicio = $('#fechadesde').val();
            let fecha_fin = $('#fechahasta').val();  
            
            
            if (!validarFormatoFecha(fecha_inicio))
            {
                alert("La Fecha Inicio no es valida");
                exit;
            }
            if (!validarFormatoFecha(fecha_fin))
            {
                alert("La Fecha Fin no es valida");
                exit;
            }
            
            var url = "";
            url = getAbsolutePath() + "source/actualizar_donut.php";
            //alert ("Directorio Local " + url); 
            
            $.ajax({
                //url: "../source/actualizar_donut.php",
                url: url,
                method: "GET",
                dataType: "json",
                data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
                success: function(response) {    
                            //console.log (response);
                            //alert ("Error" + response.error );
                            config.data.labels= response.label1 ;
                            config.data.datasets[0].data= response.result1 ;                        
                            window.myDoughnut.update();                        
                            },
                            
                error:  function(response) {        
                            //console.log (response);
                            alert ("Error" + response.error );
                            }
            })
        }

        function recargar_donut_etiquetas()
        {        
            let fecha_inicio = $('#fechadesdeet').val();
            let fecha_fin = $('#fechahastaet').val();  
            
            
            if (!validarFormatoFecha(fecha_inicio))
            {
                alert("La Fecha Inicio no es valida");
                exit;
            }
            if (!validarFormatoFecha(fecha_fin))
            {
                alert("La Fecha Fin no es valida");
                exit;
            }
            
            var url = "";
            url = getAbsolutePath() + "source/actualizar_donut_etiquetas.php";
            //alert ("Directorio Local " + url); 
            
            $.ajax({
                //url: "../source/actualizar_donut.php",
                url: url,
                method: "GET",
                dataType: "json",
                data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
                success: function(response) {    
                            //console.log (response);
                            //alert ("Error" + response.error );
                            config_etiquetas.data.labels= response.label1 ;
                            config_etiquetas.data.datasets[0].data= response.result1 ;                        
                            window.myDoughnut_etiquetas.update();                        
                            },
                            
                error:  function(response) {        
                            //console.log (response);
                            alert ("Error" + response.error );
                            }
            })
        }

        
        function recargar_barra()
        {    
            var url_barra = "";
            url_barra = getAbsolutePath() + "source/actualizar_barra.php";

            $.ajax({
                //url: "../source/actualizar_barra.php",
                url: url_barra,
                method: "GET",
                dataType: "json",                
                success: function(response) {    
                            //console.log (response);
                            //alert (window.myBar.data.labels);
                            //alert (response.error);
                            //alert (response.labels);
                            //alert (response.result);
                            //alert (response.result2);                                                       
                           
                            window.myBar.data.labels = response.labels ;
                            window.myBar.data.datasets[0].data= response.result ; 
                            //Por si uso 2 Datasets
                            //window.myBar.data.datasets[1].data= response.result2 ;
                            window.myBar.update();                        
                            },
                            
                error:  function(response) {        
                            alert ("Error" + response.error );
                            }
            })
        }

        function recargar_barra_etiquetas()
        {    
            var url_barra = "";
            url_barra = getAbsolutePath() + "source/actualizar_barra_etiquetas.php";

            $.ajax({
                //url: "../source/actualizar_barra.php",
                url: url_barra,
                method: "GET",
                dataType: "json",                
                success: function(response) {    
                            //console.log (response);
                            //alert (window.myBar.data.labels);
                            //alert (response.error);
                            //alert (response.labels);
                            //alert (response.result);
                            //alert (response.result2);                                                       
                           
                            window.myBar_etiquetas.data.labels = response.labels ;
                            window.myBar_etiquetas.data.datasets[0].data= response.result ; 
                            //Por si uso 2 Datasets
                            //window.myBar.data.datasets[1].data= response.result2 ;
                            window.myBar_etiquetas.update();                        
                            },
                            
                error:  function(response) {        
                            alert ("Error" + response.error );
                            }
            })
        }
        


        function validarFormatoFecha(campo) {
        var RegExPattern = /^\d{1,2}\/\d{1,2}\/\d{2,4}$/;
            
            if ((campo.match(RegExPattern)) && (campo!='')) 
            {
                return true;
            } 
            else 
            {
                return false;
            }
        }   

  </script>
  

  </body>
</html>

