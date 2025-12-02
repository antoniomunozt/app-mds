<?php require_once('../Connections/conect.php'); ?>
<?php require_once('../Connections/user_info.php'); ?>

<?php      
    $data = array(); 
    
    if (!empty($_GET))
    {  
        $tipo = $_GET['tipo'];
        $id_equipo = $_GET['id_equipo'];
        $activo = $_GET['activo'];
        
        if ($tipo==1)
        {
            $sql="UPDATE mds_licencias_software SET activa=".$activo." Where id_equipo=".$id_equipo ;
        }
        elseif ($tipo==2)
        {
            $sql="UPDATE mds_licencias_software_etiamb2 SET activa=".$activo." Where id_equipo=".$id_equipo ;   
        }
        

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
            //$data['label'] = [];
            //$data['resut'] = [];    
            $data['error'] = " Error al ejecutar SQL: ".$sql ;    
            echo json_encode($data);

            exit;
        }

        $data['error'] = "";
        echo json_encode($data);        
    }     
?>