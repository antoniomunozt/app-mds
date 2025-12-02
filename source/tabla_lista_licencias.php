<?php   

$usuario =($es_admin ? 0 : $id_usuario);
$nombrecomercial="";
$cif ="";

if (!empty($_GET))
{
  $usuario = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : $id_usuario ;
  $nombrecomercial = isset($_GET['nombrecomercial']) ? $_GET['nombrecomercial'] : "" ;
  $cif = isset($_GET['cif']) ? $_GET['cif'] : "" ;  
}


$sql = "SELECT id_licencia,t1.id_usuario,fecha,nombre_comercial,cif,numero_manipulador,t1.email,t1.telefono,t2.nombre ";
$sql .= " FROM mds_licencias as t1 left join mds_usuarios as t2 on t1.id_usuario=t2.id_usuario";
$where="";

if ($usuario !=0)
{
    $where = $where." and t1.id_usuario=".$usuario;        
}
if ($nombrecomercial!="")
{
  $where = $where." and nombre_comercial like '%".$nombrecomercial."%'" ;
}
if ($cif !="")
{
  $where = $where." and cif like '%".$cif."%'" ;
}
if ($where!="")
{
  $where = " Where ".substr($where, 5);
  $sql = $sql.$where;
}

/*
if (!$es_admin)
{
	$sql .= " Where t1.id_usuario=".$id_usuario;
}
*/
$sql .= " Order by id_licencia";

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

<!-- Para Filtrar las licencias -->
<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">        
      <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
        <?php
          if ($es_admin)
          {
            echo '<div class="col-md-3 col-sm-3 col-xs-12 form-inline">';
            echo '<select class="form-control" id="buscadorusuario" name="id_usuario" style="width: 100%" >';
            echo '<option value="0">Usuario</option>';                  
                                  
                $query = $mysqli -> query ("SELECT id_usuario,nombre FROM mds_usuarios order By nombre");
                
                while ($rs = mysqli_fetch_array($query))                     
                if ($rs['id_usuario']==$usuario)
                {
                  echo '<option value="'.$rs['id_usuario'].'" selected >'.$rs['nombre'].'</option>';
                }
                else
                {
                  echo '<option value="'.$rs['id_usuario'].'">'.$rs['nombre'].'</option>';
                }                    
                echo '</select>';
                echo '</div>';
          }
        ?> 

        <div class="col-md-2 col-sm-2 col-xs-12 form-inline">
            <div class='input-group date' id='nombrecomercial'>
                <input type='text' class="form-control" name="nombrecomercial" id="nombrecomercial" placeholder="Nombre Comercial" value="<?php echo isset($nombrecomercial) ? $nombrecomercial : '' ;  ?>" />                        
            </div> 
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12 form-inline">
            <div class='input-group date' id='cif'>
                <input type='text' class="form-control" name="cif" id="cif" placeholder="Cif" value="<?php echo isset($cif) ? $cif : '' ;  ?>" />                        
            </div> 
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12 form-inline">
            <input class="btn btn-default" type="submit" value="Filtrar">                  
        </div>
      </form>        
    </div>
  </div>
</div>

<!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">-->
<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Id Licencia</th>
        <th>Nombre</th>
        <th>fecha</th>
        <th>Nombre Comercial</th>
        <th>CIF</th>        
        <th>Num. Manipulador</th>        
        <th>EMail</th>
        <th>Teléfono</th>
      </tr>
    </thead>
    <tbody>
	<?php while ($rs = mysqli_fetch_array($resultado)) { ?>
		<tr>
		<td><?php echo $rs['id_licencia']; ?></td>
	    <td><?php echo (!is_null($rs['nombre']) ? $rs['nombre'] : $rs['id_usuario']); ?></td>
	    <td><?php echo $rs['fecha']; ?></td>        
	    <td><?php echo $rs['nombre_comercial']; ?></td>
        <td><?php echo $rs['cif']; ?></td>
        <td><?php echo $rs['numero_manipulador']; ?></td>
        <td><?php echo $rs['email']; ?></td>	    
        <td><?php echo $rs['telefono']; ?></td>
	    </tr>
	<?php } ?>      
    </tbody>
</table>