<?php   

$activo =0;
$nummanipulador="";
$nombrecomercial="";
$cif ="";
//$estoy_filtrando=0;

if (!empty($_GET))
{
  $activo = isset($_GET['activo']) ? $_GET['activo'] : 0 ;
  $nummanipulador = isset($_GET['nummanipulador']) ? $_GET['nummanipulador'] : "" ;
  $nombrecomercial = isset($_GET['nombrecomercial']) ? $_GET['nombrecomercial'] : "" ;
  $cif = isset($_GET['cif']) ? $_GET['cif'] : "" ;  
  //$estoy_filtrando=1;
}

$sql = "SELECT * FROM mds_manipuladores "; 

$where="";
if ($activo !=0)
{
    if ($activo ==1)
    {
        $where = $where." and activo=1";
    }
    elseif($activo==2)
    {
        $where = $where." and activo=0";
    }    
}

if ($nombrecomercial!="")
{
  $where = $where." and Nombre_Comercial like '%".$nombrecomercial."%'" ;
}

if ($nummanipulador!="")
{
  $where = $where." and num_manipulador like '%".$nummanipulador."%'" ;
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
$sql = $sql." order by id_manipulador";


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
function getAbsolutePath() 
{
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}

function actualizar_activo(element)
{
    
    var id_manipulador = element.id.substring(6, element.id.lengh);
    var activo = 0;
    if (element.checked) activo = 1;

    var url = "";
    url = getAbsolutePath() + "source/actualizar_estado_manipulador.php";

    $.ajax({
        //url: "../source/actualizar_estado_manipulador.php",
        url: url,
        method: "GET",
        dataType: "json",
        data: { id_manipulador: id_manipulador, activo: activo },
        success: function(response) {                       
                    },
                    
        error:  function(response) {        
                    alert ("Error" + response.error );
                    }
    });
}
</script>

<!-- Para Filtrar los Manipuladores -->
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">        
            <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <select class="form-control" id="activo" name="activo">
                        <option value="0" <?php if($activo==0) echo 'selected'; ?> >Está Activo</option>
                        <option value="1" <?php if($activo==1) echo 'selected'; ?> >Activo</option>
                        <option value="2" <?php if($activo==2) echo 'selected'; ?> >No Activo</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <div class='input-group date' id='nummanipulador'>
                        <input type='text' class="form-control" name="nummanipulador" id="nummanipulador" placeholder="Num manipulador" value="<?php echo isset($nummanipulador) ? $nummanipulador : '' ;  ?>" />                        
                    </div> 
                </div>

                <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <div class='input-group date' id='nombrecomercial'>
                        <input type='text' class="form-control" name="nombrecomercial" id="nombrecomercial" placeholder="Nombre Comercial" value="<?php echo isset($nombrecomercial) ? $nombrecomercial : '' ;  ?>" />                        
                    </div> 
                </div>

                <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <div class='input-group date' id='cif'>
                        <input type='text' class="form-control" name="cif" id="cif" placeholder="Cif" value="<?php echo isset($cif) ? $cif : '' ;  ?>" />                        
                    </div> 
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12 form-group">
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
        <th>#</th>
        <th>Num Manipulador</th>
        <th>Nombre Comercial</th>
        <th>Razón Social</th>
        <th>CIF</th>
        <th>Dirección</th>        
        <th>Población</th>        
        <th>Provincia</th>
        <th>CP</th>
        <!--<th>EMail</th>-->
        <!--<th>Contacto</th>-->
        <!--<th>Teléfono</th>-->
        <th>Activo</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
	<?php while ($rs = mysqli_fetch_array($resultado)) { ?>
		<tr>
		<td><?php echo $rs['id_manipulador']; ?></td>
	    <td><?php echo $rs['num_manipulador']; ?></td>
        <td><?php echo $rs['Nombre_Comercial']; ?></td>
	    <td><?php echo $rs['Razon_Social']; ?></td>        
	    <td><?php echo $rs['CIF']; ?></td>
        <td><?php echo $rs['Direccion']; ?></td>
        <td><?php echo $rs['Poblacion']; ?></td>
        <td><?php echo $rs['Provincia']; ?></td>	    
        <td><?php echo $rs['CP']; ?></td>
        <!--<td><?php echo $rs['EMail']; ?></td>-->
        <!--<td><?php echo $rs['Persona_Contacto']; ?></td>-->
        <!--<td><?php echo $rs['Telefono']; ?></td>--> 
        <td>
            <input type="checkbox" id="activo<?php echo $rs['id_manipulador'];?>" class="checkbox js-switch" name="activo<?php echo $rs['id_manipulador'];?>" value="1" onchange="actualizar_activo(this)" <?php echo ($rs['activo']==1 ? 'checked' : 'unchecked');?>/> Activo
        </td>
        <td>
            
            <form action="accion_manipulador.php?ac=3" method="POST">                
                <a class="btn btn-sm btn-primary" href="ficha_manipulador.php?id_manipulador=<?php echo $rs['id_manipulador']; ?> "><i class="fa fa-pencil"></i></a>
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-eraser"></i></button>
                <input type="hidden" name="id_manipulador" value="<?php echo $rs['id_manipulador'] ; ?>">
            </form>
            
        </td>
	    </tr>
	<?php } ?>       
    </tbody>
</table>