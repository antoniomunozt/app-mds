<?php require_once('../Connections/conect.php'); ?>
<?php require_once('../Connections/user_info.php'); ?>

<?php      
    $data = array(); 
    
    if (!empty($_GET))
    {   
        $fecha_inicio = $_GET['fecha_inicio'];
        $fecha_fin = $_GET['fecha_fin'];        

        //$cadena_fecha_mysql = $fecha_inicio;
        //por si viene con "15-02-2010"
        $fecha_inicio = str_replace("-", "/", $fecha_inicio);        
        $objeto_DateTime = date_create_from_format('d/m/Y', $fecha_inicio);
        $inicio = date_format($objeto_DateTime, "Y/m/d");
        //Calculo el Historico año anterior
        //$inicio_historico = date("Y/m/d",strtotime($inicio."- 1 year"));
        
        $objeto_DateTime_Fin = date_create_from_format('d/m/Y', $fecha_fin);
        date_add($objeto_DateTime_Fin, date_interval_create_from_date_string('1 days'));
        $fin = date_format($objeto_DateTime_Fin, "Y/m/d");
        //Calculo el Historico año anterior
        //$fin_historico = date("Y/m/d",strtotime($fin."- 1 year"));
      
        $sql="Select t1.id_manipulador,t2.Nombre_Comercial,count(id) as total_copias from mds_impresiones_etiquetas as t1";
        $sql .= " left join mds_manipuladores as t2";
        $sql .= " on t1.id_manipulador=t2.id_manipulador";
        $sql .= " where fecha_impresion>='".$inicio."'";
        $sql .= " and fecha_impresion<'".$fin."'";
        $sql .= " and t2.activo=1";
        $sql .= " Group by t1.id_manipulador";
        $sql .= " Order By total_copias Desc";
        $sql .= " limit 5";        
       
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
            $data['label1'] = [];
            $data['resut1'] = [];    
            $data['error'] = " Errora al ejecutar SQL: ".$sql ;    
            echo json_encode($data);
            exit;
        }
        
        $nombre = array();
        $valores = array();
        $res="";
        
        while ($rs = mysqli_fetch_array($resultado))
        {   
            $nombre[]=utf8_encode($rs['Nombre_Comercial']);
            $valores[]=$rs['total_copias'];            
            //$res=$rs['Nombre_Comercial'];
        }
        
        /*
        $data['label1'] = [];
        $data['resut1'] = [];    
        $data['error'] = " Error 5 Pasado SQL ".$res; 
        echo json_encode($data);
        exit;
        */           
        
        $data['label1'] = $nombre;
        $data['result1'] = $valores;
        //$data['error'] = $inicio_historico." ".$fin_historico;       

        echo json_encode($data);
    }      
    
    
?>