<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>

<?php
//1=agregar   2=Actualizar 3=Eliminar
$accion=$_GET['ac'];

$id_usuario=isset($_POST['idusuario']) ? $_POST['idusuario'] : "" ;
$user_name=isset($_POST['username']) ? $_POST['username'] : "" ;
$user_password=isset($_POST['userpassword']) ? $_POST['userpassword'] : "" ;
$nombre=isset($_POST['nombre']) ? $_POST['nombre'] : "" ;
$dni=isset($_POST['dni']) ? $_POST['dni'] : "" ;
$telefono=isset($_POST['telefono']) ? $_POST['telefono'] : "" ;
$email=isset($_POST['email']) ? $_POST['email'] : "" ;
$observaciones=isset($_POST['observaciones']) ? $_POST['observaciones'] : "" ;
$es_administrador=isset($_POST['esadmin']) ? 1 : 0 ; 

switch ($accion) 
{
case '1':
	//agrego el usuario			
	//Hago Comprobacion de que el nombre de usuario NO existe
    //$sql="select usuario from mds_usuarios where usuario= ? ";
    
    try
    {
        $sentencia = $mysqli->prepare("select usuario from mds_usuarios where usuario=?");
        $sentencia->bind_param("s", $user_name);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
    }catch(Exception $e){
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
    /* determinar el número de filas del resultado */
    $row_cnt = $resultado->num_rows;
    if ($row_cnt>0)
    {
        echo "<script languaje=’javascript’>alert('Ya existe este nombre de Usuario: ".$user_name."')</script>";
        /* cerrar el resultset */
        $resultado->close();
        header("Refresh:0.5; url=ficha_usuario.php");
        exit;
    }
    /* cerrar el resultset */
    $resultado->close();

    //Hago el INSERT en la BBD
    $sql = "INSERT INTO mds_usuarios (usuario,password,nombre,dni,telefono,email,observaciones,es_admin) VALUES (?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);
    $pas_codificada=md5($user_password);
    $stmt->bind_param("sssssssi", $user_name, $pas_codificada , $nombre ,$dni , $telefono ,$email ,$observaciones ,$es_administrador);
    $stmt->execute();   
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();      
    echo "<script languaje=’javascript’>alert('Usuario creado con éxito: ".$user_name."')</script>";
    header("Refresh:0.5; url=lista_usuarios.php");
    exit; 
	break;

case '2':
//Actualizo el usuario
	$sql = "UPDATE mds_usuarios set ";        
    //solo cambio el password cuando escriban algo
    //Si biene un cambio de password hay un campo mas que actualizar
    if ($user_password!="")
    {
        $sql .= "password= ?,";    
    }        
    $sql .= "nombre=?,";
    $sql .= "dni=?,";
    $sql .= "telefono=?,";
    $sql .= "email=?,";
    $sql .= "observaciones=?,";
    $sql .= "es_admin=?" ;
    $sql .= " Where id_usuario=?";

    $stmt = $mysqli->prepare($sql);
    //Si biene un cambio de password hay un campo mas que actualizar
    if ($user_password!="")
    {
        $pas_codificada=md5($user_password);
        $stmt->bind_param("ssssssii",$pas_codificada, $nombre ,$dni , $telefono ,$email ,$observaciones ,$es_administrador,$id_usuario);
    }
    else
    {
        $stmt->bind_param("sssssii", $nombre ,$dni , $telefono ,$email ,$observaciones ,$es_administrador,$id_usuario);
    }        
    $stmt->execute();
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();    
    echo "<script languaje=’javascript’>alert('Usuario Actualizado con éxito: ".$user_name."')</script>";
    header("Refresh:0.5; url=lista_usuarios.php");
    exit; 
	break; 

case '3':
//Borro el usuario
	$consulta="DELETE from mds_usuarios where id_usuario=?";
    
    $stmt = $mysqli->prepare($consulta);
    
    $stmt->bind_param("i",$id_usuario);
    $stmt->execute();   
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();	
    echo "<script languaje=’javascript’>alert('Usuario Eliminado con éxito: ".$user_name."')</script>";
    header("Refresh:0.5; url=lista_usuarios.php");
    exit; 					
	break;		
}	

?>