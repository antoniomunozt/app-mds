<?php require_once('../Connections/conect.php'); ?>
<?php require_once('../Connections/user_info.php'); ?>

<?php      
    $data = array(); 
    
    if (!empty($_GET))
    {  
        $id_usuario = $_GET['id_usuario'];
        $es_admin = $_GET['es_admin'];
        
        $sql="UPDATE mds_usuarios SET Es_Admin=".$es_admin." Where id_usuario=".$id_usuario ;

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