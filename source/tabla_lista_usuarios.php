<?php   

$sql = "SELECT id_usuario,usuario,nombre,dni,telefono,email,observaciones,es_admin FROM mds_usuarios order by id_usuario";

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

?>

<script>
function actualizar_es_admin(element)
{
    
    var id_usuario = element.id.substring(8, element.id.lengh);
    var es_admin = 0;
    if (element.checked) es_admin = 1;

    $.ajax({
        url: "../source/actualizar_es_admin_usuario.php",
        method: "GET",
        dataType: "json",
        data: { id_usuario: id_usuario, es_admin: es_admin },
        success: function(response) {                       
                    },
                    
        error:  function(response) {        
                    alert ("Error" + response.error );
                    }
    });
}
</script>

<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Id usuario</th>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Es Admin</th>
        <th>Observaciones</th>
        <th>Acción</th>        
      </tr>
    </thead>
    <tbody>
	<?php while ($rs = mysqli_fetch_array($resultado)) { ?>
		<tr>
		  <td><?php echo $rs['id_usuario']; ?></td>
	       <td><?php echo $rs['usuario']; ?></td>
	       <td><?php echo $rs['nombre']; ?></td>
           <td><?php echo $rs['telefono']; ?></td>
           <td><?php echo $rs['email']; ?></td>
           <td>
            <input type="checkbox" id="es_admin<?php echo $rs['id_usuario'];?>" class="checkbox js-switch" name="es_admin<?php echo $rs['id_usuario'];?>" value="1" onchange="actualizar_es_admin(this)" <?php echo ($rs['es_admin']==1 ? 'checked' : 'unchecked');?>/> Es Admin
           </td>
	         <td><?php echo $rs['observaciones']; ?></td>	    
           <td><a class="btn btn-sm btn-primary" href="ficha_usuario.php?id_usuario=<?php echo $rs['id_usuario']; ?> "><i class="fa fa-pencil"></i></a></td>
	    </tr>
	<?php } ?>      
    </tbody>
</table>