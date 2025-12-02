<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>

<?php
//1=agregar   2=Actualizar 3=Eliminar
$accion=$_GET['ac'];

$id_manipulador=isset($_POST['id_manipulador']) ? $_POST['id_manipulador'] : "" ;
$Num_Manipulador=isset($_POST['Num_Manipulador']) ? $_POST['Num_Manipulador'] : "" ;
$Nombre_Comercial=isset($_POST['Nombre_Comercial']) ? $_POST['Nombre_Comercial'] : "" ;
$Razon_Social=isset($_POST['Razon_Social']) ? $_POST['Razon_Social'] : "" ;
$CIF=isset($_POST['CIF']) ? $_POST['CIF'] : "" ;
$Direccion=isset($_POST['Direccion']) ? $_POST['Direccion'] : "" ;
$Poblacion=isset($_POST['Poblacion']) ? $_POST['Poblacion'] : "" ;
$Provincia=isset($_POST['Provincia']) ? $_POST['Provincia'] : "" ;
$CP=isset($_POST['CP']) ? $_POST['CP'] : "" ;
$EMail=isset($_POST['EMail']) ? $_POST['EMail'] : "" ;
$Persona_Contacto=isset($_POST['Persona_Contacto']) ? $_POST['Persona_Contacto'] : "" ;
$Telefono=isset($_POST['Telefono']) ? $_POST['Telefono'] : "" ;
$activo=isset($_POST['activo']) ? 1 : 0 ;


switch ($accion) 
{
case '1':
	//agrego el manipulador			
	//Hago Comprobacion de que el CIF del manipulador NO existe
    //$sql="select id_manipulador from mds_manipuladores where CIF= ? ";
    
    try
    {
        $sentencia = $mysqli->prepare("select id_manipulador from mds_manipuladores where CIF=? and num_manipulador=?");
        $sentencia->bind_param("ss", $CIF,$Num_Manipulador);
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
        echo "<script languaje=’javascript’>alert('Ya existe un manipulador con este CIF: ".$CIF." y este Numero de Manipulador: ".$Num_Manipulador."')</script>";
        /* cerrar el resultset */
        $resultado->close();
        $_SESSION["valores"]=$_POST;
        header("Refresh:0.5; url=ficha_manipulador.php");
        exit;
    }
    /* cerrar el resultset */
    $resultado->close();

    //Hago el INSERT en la BBD
    $sql = "INSERT INTO mds_manipuladores (num_manipulador,Nombre_Comercial,Razon_Social,CIF,Direccion,Poblacion,Provincia,CP,EMail,Persona_Contacto,Telefono,activo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);
    //$pas_codificada=md5($user_password);
    $stmt->bind_param("sssssssssssi", $Num_Manipulador, $Nombre_Comercial, $Razon_Social , $CIF ,$Direccion , $Poblacion ,$Provincia ,$CP ,$EMail,$Persona_Contacto,$Telefono,$activo);
    $stmt->execute();   
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();    
    $_SESSION["valores"]="";  
    echo "<script languaje=’javascript’>alert('Manipulador creado con éxito: ".$Razon_Social." Num. Manipulador: ".$Num_Manipulador."')</script>";
    header("Refresh:0.5; url=lista_manipuladores.php");
    exit; 
	break;

case '2':
//Actualizo el manipulador. 
//Nunca cambio el CIF ya que es el campo que me sirve para controlar si el manipulador de los programas 
//locales existe en la BBDD de la nube
	$sql = "UPDATE mds_manipuladores set ";
    $sql .= "Num_Manipulador=?";
    $sql .= ",Nombre_Comercial=?";
    $sql .= ",Razon_Social=?";
    $sql .= ",CIF=?";
    $sql .= ",Direccion=?";
    $sql .= ",Poblacion=?";
    $sql .= ",Provincia=?" ;
    $sql .= ",CP=?" ;
    $sql .= ",EMail=?" ;
    $sql .= ",Persona_Contacto=?" ;
    $sql .= ",Telefono=?";
    $sql .= ",Activo=?";
    $sql .= " Where id_manipulador=?";

    $stmt = $mysqli->prepare($sql);      
    $stmt->bind_param("sssssssssssii", $Num_Manipulador, $Nombre_Comercial, $Razon_Social , $CIF ,$Direccion , $Poblacion ,$Provincia ,$CP ,$EMail,$Persona_Contacto,$Telefono,$activo, $id_manipulador);
    
    $stmt->execute();
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();    
    echo "<script languaje=’javascript’>alert('Manipulador Actualizado con éxito: ".$Razon_Social." Num. Manipulador: ".$Num_Manipulador."')</script>";
    header("Refresh:0.5; url=lista_manipuladores.php");
    exit; 
	break; 

case '3':
//Borro el Manipulador
    
    $consulta="DELETE from mds_manipuladores where id_manipulador=?";
    
    $stmt = $mysqli->prepare($consulta);
    
    $stmt->bind_param("i",$id_manipulador);
    $stmt->execute();   
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();	
    echo "<script languaje=’javascript’>alert('Manipulador Eliminado con éxito: ".$id_manipulador."')</script>";
    header("Refresh:0.5; url=lista_manipuladores.php");
    exit; 					
	break;		
}	

?>