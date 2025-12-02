<?php require_once('../Connections/conect.php'); ?>
<?php require_once('../Connections/user_info.php'); ?>

<?php      
    $data = array();

    //$fecha_inicio = $_GET['fecha_inicio'];
    //$fecha_fin = $_GET['fecha_fin'];
    

    //$cadena_fecha_mysql = $fecha_inicio;
    //por si viene con "15-02-2010"
    //$fecha_inicio = str_replace("-", "/", $fecha_inicio);        
    //$objeto_DateTime = date_create_from_format('d/m/Y', $fecha_inicio);
    //$inicio = date_format($objeto_DateTime, "Y/m/d");
    
    //Calculo el Historico año anterior
    $fecha = date('Y-m-d', strtotime('-1 year'));

    $anio= date("Y", strtotime($fecha));
    $mes= date("m", strtotime($fecha));
    $fecha = date( "Y-m-d", strtotime( $anio."-".$mes."-"."01")); 

    //$fecha_2 = date('Y-m-d', strtotime('-2 year'));
    
    //$mes = substr($fecha, 5, 2);
    $mes_fecha = (int)$mes;

    //$objeto_DateTime_Fin = date_create_from_format('d/m/Y', $fecha_fin);
    //date_add($objeto_DateTime_Fin, date_interval_create_from_date_string('1 days'));
    //$fin = date_format($objeto_DateTime_Fin, "Y/m/d");
    //Calculo el Historico año anterior
    //$fin_historico = date("Y/m/d",strtotime($fin."- 1 year"));
    
    $sql="Select Year(fecha_impresion) as ano,month(fecha_impresion) as mes,sum(copias) as total_copias"; 
    $sql .= " from mds_impresiones ";
    $sql .= " where ";
    $sql .= " fecha_impresion>='".$fecha."' ";        
    $sql .= " Group by ano,mes ";
    $sql .= " Order by ano,mes Limit 12";

    /*
    //Lo de 2 años antes
    $sql2="Select Year(fecha_impresion) as ano,month(fecha_impresion) as mes,sum(copias) as total_copias"; 
    $sql2 .= " from mds_impresiones ";
    $sql2 .= " where ";
    $sql2 .= " fecha_impresion>='".$fecha_2."' ";
    $sql2 .= " and fecha_impresion<'".$fecha."' ";        
    $sql2 .= " Group by Year(fecha_impresion),month(fecha_impresion) ";
    $sql2 .= " Order by Year(fecha_impresion),month(fecha_impresion)";
    */

    if (!$resultado = $mysqli->query($sql))  
    {
        // ¡Oh, no! La consulta falló. 
        //echo "Lo sentimos, este sitio web está experimentando problemas.";

        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        //echo "Error: La ejecución de la consulta falló debido a: \n";
        //echo "Query: " . $sql . "\n";
        //echo "Errno: " . $mysqli->errno . "\n";
        //echo "Error: " . $mysqli->error . "\n";
        
        //Quitar
        $data['labels'] = [];
        $data['result'] = [];    
        $data['error'] = " Error al ejecutar SQL: ".$sql." Error: Este es el Error ".$mysqli->errno ;    
        echo json_encode($data);

        exit;
    }

    /*
    if (!$resultado2 = $mysqli->query($sql2)) 
    {
        // ¡Oh, no! La consulta falló. 
        //echo "Lo sentimos, este sitio web está experimentando problemas.";

        // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
        // cómo obtener información del error
        //echo "Error: La ejecución de la consulta falló debido a: \n";
        //echo "Query: " . $sql . "\n";
        //echo "Errno: " . $mysqli->errno . "\n";
        //echo "Error: " . $mysqli->error . "\n";
        
        //Quitar
        $data['labels'] = [];
        $data['result'] = [];    
        $data['error'] = " Errora al ejecutar SQL: ".$sql ;    
        echo json_encode($data);

        exit;
    }
    */
            
    $nombre_meses = [
        1 => "Enero", 
        2 => "Febrero", 
        3 => "Marzo", 
        4 => "Abril", 
        5 => "Mayo", 
        6 => "Junio", 
        7 => "Julio", 
        8 => "Agosto", 
        9 => "Septiembre", 
        10 => "Octubre", 
        11 => "Noviembre", 
        12 => "Diciembre"];
    
    
    $meses = array();
    //Lleno el Array Meses que son desde el mes de la fecha hasta 12 meses despues
    for ($i = 1; $i <= 12; $i++) 
    {
        if ($mes_fecha >12)
        {
            $mes_fecha=1;
            $meses[]= $nombre_meses[$mes_fecha];
        }
        else 
        {
            $meses[]= $nombre_meses[$mes_fecha];
        }
        $mes_fecha=$mes_fecha+1;        
    }
    
    //Año Anterior
    $valores = array();
    $mes_fecha = (int)$mes;
    while ($rs = mysqli_fetch_array($resultado))
    {   
        $mes_bd = (int)$rs['mes'];
        if ($mes_fecha === $mes_bd )
        {
            $valores[]=$rs['total_copias'];
            $mes_fecha=$mes_fecha+1;
            if ($mes_fecha >12) {$mes_fecha=1;}
        }
        else 
        {
            for ($i=$mes_fecha;$i<$mes_bd;$i++)
            {
                $valores[]=0;
                $mes_fecha=$mes_fecha+1;
                if ($mes_fecha >12) {$mes_fecha=1;}
            }  
            $valores[]=$rs['total_copias'];
            $mes_fecha=$mes_fecha+1;
            if ($mes_fecha >12) {$mes_fecha=1;}
        }                            
    } 

    /*
    //2 Año Anterior
    $valores2 = array();
    $mes_fecha = (int)$mes;
    while ($rs2 = mysqli_fetch_array($resultado2))
    {   
        $mes_bd = (int)$rs2['mes'];
        if ($mes_fecha === $mes_bd )
        {
            $valores2[]=$rs2['total_copias'];
            $mes_fecha=$mes_fecha+1;
            if ($mes_fecha >12) {$mes_fecha=1;}
        }
        else 
        {
            for ($i=$mes_fecha;$i<$mes_bd;$i++)
            {
                $valores2[]=0;
                $mes_fecha=$mes_fecha+1;
                if ($mes_fecha >12) {$mes_fecha=1;}
            }  
            $valores2[]=$rs2['total_copias'];
            $mes_fecha=$mes_fecha+1;
            if ($mes_fecha >12) {$mes_fecha=1;}
        }                            
    } 
    */
    
           
    $data['labels'] = $meses;
    $data['result'] = $valores;
    //$data['result2'] = $valores2;
    //$data['error'] = "Tras la Consulta";       
    
    echo json_encode($data);


    
?>