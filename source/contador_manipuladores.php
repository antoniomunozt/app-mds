<?php  
$sql = "SELECT count(id_manipulador) as total_manipuladores FROM mds_manipuladores";

if (!$resultado = $mysqli->query($sql)) 
{
    // ¡Oh, no! La consulta falló. 
    echo "Lo sentimos, este sitio web está experimentando problemas.";

    // De nuevo, no hacer esto en un sitio público, aunque nosotros mostraremos
    // cómo obtener información del error
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}
$rs = mysqli_fetch_array($resultado);
$total=$rs['total_manipuladores'];

?>

<?php if ($es_admin==1){echo '<a href="./lista_manipuladores.php">';}?>

<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="tile-stats">
  		<div class="icon"><i class="fa fa-users"></i></div>
  		<div class="count"><?php echo $total; ?></div>
  		<h3>Manipuladores</h3>
  		<p>Total de manipuladores creados</p>
	</div>
</div>
<?php if ($es_admin==1){echo '</a>';}?>
