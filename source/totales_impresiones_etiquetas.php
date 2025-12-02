<?php 
    $manipulador =0;
    $tipo="";
    $formato ="";
    $fecha_desde = "" ;
    $fecha_hasta ="";
    $estoy_filtrando=0;

    if (!empty($_GET))
    {
    $manipulador = $_GET['id_manipulador'];
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0 ;
    //$formato = isset($_GET['formato']) ? $_GET['formato'] : 0 ;
    $fecha_desde = isset($_GET['fechadesde']) ? $_GET['fechadesde'] : 0 ;
    $fecha_hasta = isset($_GET['fechahasta']) ? $_GET['fechahasta'] : 0 ;
    $estoy_filtrando=1;
    }

    $sql = "Select count(id) as total_copias from mds_impresiones_etiquetas";

    $sql2 = "Select count(distinct id_manipulador) as Manipuladores from mds_impresiones_etiquetas";

    $where="";
    if ($manipulador !=0 )
    {
    $where = $where." and id_manipulador=".$manipulador ;
    }
    if ($tipo !=0 and $tipo!=-1 )
    {
    $where = $where." and tipo_etiqueta=".$tipo ;
    }
    
    /*
    if ($formato !=0 and $formato !=-1)
    {    
    $where = $where." and formato_matricula=".$formato ;
    }
    */
    
    if ($fecha_desde !=0)
    {
    $where = $where." and fecha_impresion>='".date('Y-m-d',strtotime($fecha_desde))."'" ;
    }
    if ($fecha_hasta !=0)
    {
    $where = $where." and fecha_impresion<'".date("Y-m-d",strtotime($fecha_hasta."+ 1 days"))."'" ;
    }
    if ($where!="")
    {
    $where = " Where ".substr($where, 5);
    //Para el num. de impresiones
    $sql = $sql.$where;
    //para el numero de Manipuladores
    $sql2 = $sql2.$where;
    }

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
    $rs = mysqli_fetch_array($resultado);

    if (!$resultado2 = $mysqli->query($sql2)) 
    {
        // ¡Oh, no! La consulta falló. 
        echo "Lo sentimos, este sitio web está experimentando problemas.";

        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        echo "Error: La ejecución de la consulta falló debido a: \n";
        echo "Query: " . $sql2 . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    }
    $rs2 = mysqli_fetch_array($resultado2);

?>

<!-- top tiles -->
<div class="row tile_count">
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-print"></i> Total Impresiones Etiquetas</span>
        <div class="count"><?php echo $rs['total_copias']; ?></div>
        <!--<span class="count_bottom"><i class="green">4% </i> From last Week</span>-->
    </div>
    <div class="col-md-3 col-sm-4 col-xs-6 tile_stats_count">
        <span class="count_top"><i class="fa fa-car"></i> Distintos Manipuladores</span>
        <div class="count"><?php echo $rs2['Manipuladores']; ?></div>
        <!--<span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>-->
    </div>                        
</div>
<!-- /top tiles -->