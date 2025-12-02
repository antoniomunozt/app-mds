<?php

// Always start this first
if (!isset($_SESSION)) {
  session_start();
}

if (isset($_SESSION['user_id'])) {
	/* Consulta para obtener los datos del usuario logado */
	if ($DatosUser = $mysqli->query("SELECT id_usuario, usuario, password, es_admin FROM mds_usuarios WHERE id_usuario=".$_SESSION['user_id']."")) {
		while($dconex = mysqli_fetch_array($DatosUser)) {
	    	$nombre_usuario=$dconex['usuario'];
	    	$id_usuario=$dconex['id_usuario'];
	    	$es_admin=$dconex['es_admin'];
			$_SESSION['MM_idusuario']=$id_usuario;
		}
		$DatosUser->close();
	}   
} else {
    // Redirect them to the login page
    header($login_return);
}

?>