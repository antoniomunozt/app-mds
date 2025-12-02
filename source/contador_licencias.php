<?php  
$sql = "SELECT count(id_licencia) as total_licencias FROM mds_licencias";
if ($es_admin==0)
{
	$sql=$sql." where id_usuario=".$id_usuario;
}

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
$total=$rs['total_licencias'];

?>

<?php echo '<a href="./lista_licencias.php">';?>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-3 col-xs-12">
	<div class="tile-stats">
  		<div class="icon"><i class="fa fa-bar-chart"></i></div>
  		<div class="count"><?php echo $total; ?></div>
  		<h3>Licencias de Comerciales</h3>
  		<?php if ($es_admin==0) 
  		{
  			echo "<p>Total licencias otorgadas por este Comercial.</p>";
  		}
  		else 
  		{
  			echo "<p>Total licencias otorgadas por todos los Comerciales.</p>";
  		}

  		?>
  		
	</div>
</div> 
<?php echo '</a>';?>