<?php require_once('Connections/conect.php'); ?>
<?php
// Inicializar la sesión.
// Si está usando session_name("algo"), ¡no lo olvide ahora!
if (!isset($_SESSION)) {
  session_start();
}

// Destruir todas las variables de sesión.
$_SESSION = array();

/*
Esto lo he tenido que comentar porque SI  no tenia que validarme dos veces la primera no funcionaba
y la segunda es la que me mandba a principal.php
// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
	);
}
*/

// Finalmente, destruir la sesión.
session_destroy();

// Inicializar nuevamente la sesión.
session_start();

if (!empty($_POST)) {	
	if (isset($_POST['username']) && isset($_POST['password'])) 
	{	// Getting submitted user data from database
        $stmt = $mysqli->prepare("SELECT id_usuario,usuario,password,es_admin FROM mds_usuarios WHERE usuario=?");
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $result = $stmt->get_result();
    	$user = $result->fetch_object();
		
		if(!is_null($user))
		{			
			// Verify user password and set $_SESSION
    		if (md5($_POST['password']) == $user->password) 
    		{
				$_SESSION['user_id'] = $user->id_usuario;
				//echo"<script>alert('Antes de llamar ".$login_index." .');</script>"; 
				//exit();
				header($login_index);				
			} 
    		else
			{
				echo"<script>alert('Password no válido.');</script>"; 
			}
		}
		else
		{			
			echo"<script>alert('El usuario No Existe.');</script>"; 			
		}
    	
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>APP Matriculados del Sur</title>
	
	<link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="css/login.css" rel="stylesheet">
	<link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Arimo|Signika+Negative|Varela+Round|Work+Sans" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->	
</head>
<body class="login">
<div class="login-page">
	<div class="form">
		<div class="reg_foot">
			<img src="images/logo-login.png" height="35">
		</div>
		<form class="login-form" name="frm_access_rad" id="frm_access_rad" method="post">
		  <input type="text" name="username" id="username" placeholder="usuario" required />
		  <input type="password" name="password" id="password" placeholder="contraseña" required />
		  <input type="submit" class="button" value="ACCEDER"/>
		  <p class="message">Bienvenido a la APP de Matriculados del Sur</p>
		</form>
	</div>
</div>
<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
