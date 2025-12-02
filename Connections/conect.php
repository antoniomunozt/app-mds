<?php
$mysqli = new mysqli("localhost", "user_mds", "Bve4m_41", "matricul_mds");

/* comprobar la conexión */
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}
if (!isset($_SESSION)) {
  session_start();  
}
$login_return="Location: http://app-mds.test:8080/index.php";
$login_index="Location: http://app-mds.test:8080/principal.php";
?>