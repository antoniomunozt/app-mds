
<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>
<?php 
$correo =(isset($_GET['mail']))?$_GET['mail']:"";
$contraclave=(isset($_GET['lic']))?$_GET['lic']:"";
//echo ($contraclave);
//exit();
/*
function is_valid_email($str)
{
  return (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
}
*/

$destinatario = $correo; 
$asunto = "Contraclave de la APP Matriculados del Sur"; 
$cuerpo = " 
<!DOCTYPE html>
<html lang='es'> 
<head> 
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>   
    <title>Matriculados del Sur</title> 
</head> 
<body> 
<h1>Licencia para el uso de la APP Matriculados del Sur</h1> 
<h3>$contraclave</h3>
</body> 
</html> 
"; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: Matriculados del Sur <info@matriculadosdelsur.com>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To: info@matriculadosdelsur.com\r\n"; 

//direcciones que recibián copia 
//$headers .= "Cc: maria@desarrolloweb.com\r\n"; 

//direcciones que recibirán copia oculta 
//$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 

//mail($destinatario,$asunto,$cuerpo,$headers) 
//Enviamos el mensaje a tu_dirección_email 
$bool = mail($destinatario,$asunto,$cuerpo,$headers);
if($bool)
{
    echo "<script languaje=’javascript’>alert('Mail Enviado a :".$correo."')</script>";
    header("Refresh:0.5; url=principal.php");
    //exit;
}
else
{
    echo "<script languaje=’javascript’>alert('Mail NO Enviado')</script>";
    header("Refresh:0.5; url=principal.php");
    //exit;
}
?>
