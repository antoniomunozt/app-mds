<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>

<?php
//1=agregar   2=Actualizar 3=Eliminar
$accion=$_GET['ac'];

$pk=isset($_POST['pk']) ? $_POST['pk'] : "" ;

$NHOrdinariaLarga= isset($_POST['NHOrdinariaLarga']) ? $_POST['NHOrdinariaLarga'] : "" ; 
$NHOrdinariaLargaPubli=isset($_POST['NHOrdinariaLargaPubli']) ? $_POST['NHOrdinariaLargaPubli'] : "" ;
$NHOrdinariaAlta=isset($_POST['NHOrdinariaAlta']) ? $_POST['NHOrdinariaAlta'] : "" ;
$NHOrdinariaLargaDel=isset($_POST['NHOrdinariaLargaDel']) ? $_POST['NHOrdinariaLargaDel'] : "" ;
$NHMotocicletaOrdinaria=isset($_POST['NHMotocicletaOrdinaria']) ? $_POST['NHMotocicletaOrdinaria'] : "" ;
$NHMotocicletaOrdinariaPubli=isset($_POST['NHMotocicletaOrdinariaPubli']) ? $_POST['NHMotocicletaOrdinariaPubli'] : "" ;
$NHMotocicletaCorta=isset($_POST['NHMotocicletaCorta']) ? $_POST['NHMotocicletaCorta'] : "" ;
$NHCiclomotor=isset($_POST['NHCiclomotor']) ? $_POST['NHCiclomotor'] : "" ;
$NHCuatriciclo=isset($_POST['NHCuatriciclo']) ? $_POST['NHCuatriciclo'] : "" ;
$NHRemolqueAlta=isset($_POST['NHRemolqueAlta']) ? $_POST['NHRemolqueAlta'] : "" ;
$NHRemolqueLarga=isset($_POST['NHRemolqueLarga']) ? $_POST['NHRemolqueLarga'] : "" ;
$NHEspecialAlta=isset($_POST['NHEspecialAlta']) ? $_POST['NHEspecialAlta'] : "" ;
$NHEspecialLarga=isset($_POST['NHEspecialLarga']) ? $_POST['NHEspecialLarga'] : "" ;
$NHHistoricoAlta=isset($_POST['NHHistoricoAlta']) ? $_POST['NHHistoricoAlta'] : "" ;
$NHHistoricoLarga=isset($_POST['NHHistoricoLarga']) ? $_POST['NHHistoricoLarga'] : "" ;
$NHOrdinariaLargaTaxi=isset($_POST['NHOrdinariaLargaTaxi']) ? $_POST['NHOrdinariaLargaTaxi'] : "" ;
$NHCuatricicloLarga=isset($_POST['NHCuatricicloLarga']) ? $_POST['NHCuatricicloLarga'] : "" ;

switch ($accion) 
{
case '1':
	//agrego el Registro de Homologaciones			
	//Hago el INSERT en la BBD
    $sql = "INSERT INTO mds_configuracion_homologaciones (NHOrdinariaLarga,NHOrdinariaLargaPubli,NHOrdinariaAlta,NHOrdinariaLargaDel,NHMotocicletaOrdinaria,NHMotocicletaOrdinariaPubli,NHMotocicletaCorta,NHCiclomotor,NHCuatriciclo,NHRemolqueAlta,NHRemolqueLarga,NHEspecialAlta,NHEspecialLarga,NHHistoricoAlta,NHHistoricoLarga,NHOrdinariaLargaTaxi,NHCuatricicloLarga) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $mysqli->prepare($sql);
    //$pas_codificada=md5($user_password);
    $stmt->bind_param("sssssssssssssssss", $NHOrdinariaLarga,$NHOrdinariaLargaPubli,$NHOrdinariaAlta,$NHOrdinariaLargaDel,$NHMotocicletaOrdinaria,$NHMotocicletaOrdinariaPubli,$NHMotocicletaCorta,$NHCiclomotor,$NHCuatriciclo,$NHRemolqueAlta,$NHRemolqueLarga,$NHEspecialAlta,$NHEspecialLarga,$NHHistoricoAlta,$NHHistoricoLarga,$NHOrdinariaLargaTaxi,$NHCuatricicloLarga);
    $stmt->execute();   
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();    
    //$_SESSION["valores"]="";  
    echo "<script languaje=’javascript’>alert('Homologaciones creadas con éxito')</script>";
    header("Refresh:0.5; url=principal.php");
    exit; 
	break;

case '2':
//Actualizo el manipulador. 
//Nunca cambio el CIF ya que es el campo que me sirve para controlar si el manipulador de los programas 
//locales existe en la BBDD de la nube
	$sql = "UPDATE mds_configuracion_homologaciones set ";
    $sql .= "NHOrdinariaLarga=?";
    $sql .= ",NHOrdinariaLargaPubli=?";
    $sql .= ",NHOrdinariaAlta=?";
    $sql .= ",NHOrdinariaLargaDel=?";
    $sql .= ",NHMotocicletaOrdinaria=?";
    $sql .= ",NHMotocicletaOrdinariaPubli=?";
    $sql .= ",NHMotocicletaCorta=?" ;
    $sql .= ",NHCiclomotor=?" ;
    $sql .= ",NHCuatriciclo=?" ;
    $sql .= ",NHRemolqueAlta=?" ;
    $sql .= ",NHRemolqueLarga=?";
    $sql .= ",NHEspecialAlta=?";
    $sql .= ",NHEspecialLarga=?";
    $sql .= ",NHHistoricoAlta=?";
    $sql .= ",NHHistoricoLarga=?";
    $sql .= ",NHOrdinariaLargaTaxi=?";
    $sql .= ",NHCuatricicloLarga=?";
    $sql .= " Where pk=?";

    $stmt = $mysqli->prepare($sql);      
    $stmt->bind_param("sssssssssssssssssi", $NHOrdinariaLarga,$NHOrdinariaLargaPubli,$NHOrdinariaAlta,$NHOrdinariaLargaDel,$NHMotocicletaOrdinaria,$NHMotocicletaOrdinariaPubli,$NHMotocicletaCorta,$NHCiclomotor,$NHCuatriciclo,$NHRemolqueAlta,$NHRemolqueLarga,$NHEspecialAlta,$NHEspecialLarga,$NHHistoricoAlta,$NHHistoricoLarga,$NHOrdinariaLargaTaxi,$NHCuatricicloLarga, $pk);
    
    $stmt->execute();
    if ($stmt->error!=""){
        printf("Error: %s.\n", $stmt->error);      
        $stmt->close();  
        exit; 
    }
    $stmt->close();    
    echo "<script languaje=’javascript’>alert('Homologaciones Actualizadas con éxito')</script>";
    header("Refresh:0.5; url=principal.php");
    exit; 
	break; 		
}	

?>