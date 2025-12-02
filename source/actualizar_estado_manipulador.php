<?php require_once('../Connections/conect.php'); ?>
<?php require_once('../Connections/user_info.php'); ?>

<?php      
    $data = array(); 
    
    if (!empty($_GET))
    {  
        $id_manipulador = $_GET['id_manipulador'];
        $activo = $_GET['activo'];
        
        $sql="UPDATE mds_manipuladores SET Activo=".$activo." Where id_manipulador=".$id_manipulador ;

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