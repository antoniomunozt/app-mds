<?php   

$activo =0;
$nombrecomercial="";
$cif ="";

if (!empty($_GET))
{
  $activo = isset($_GET['activo']) ? $_GET['activo'] : 0 ;
  $nombrecomercial = isset($_GET['nombrecomercial']) ? $_GET['nombrecomercial'] : "" ;
  $cif = isset($_GET['cif']) ? $_GET['cif'] : "" ;  
  //$estoy_filtrando=1;
}

$sql = "SELECT t1.id_equipo,t1.id_manipulador,fecha_alta,fecha_ultimo_acceso,activa,t2.Nombre_Comercial ";
$sql .= " FROM mds_licencias_software_etiamb2 as t1 left join mds_manipuladores as t2 on t1.id_manipulador=t2.id_manipulador ";

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
  $where = $where." and t2.Nombre_Comercial like '%".$nombrecomercial."%'" ;
}
if ($cif !="")
{
  $where = $where." and t2.cif like '%".$cif."%'" ;
}
if ($where!="")
{
  $where = " Where ".substr($where, 5);
  $sql = $sql.$where;
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
    
    var id_equipo = element.id.substring(6, element.id.lengh);
    var activo = 0;
    if (element.checked) activo = 1;

    var url = "";
    url = getAbsolutePath() + "source/actualizar_estado_equipo_etiamb2.php";

    $.ajax({
        //url: "../source/actualizar_estado_manipulador.php",
        url: url,
        method: "GET",
        dataType: "json",
        data: { id_equipo: id_equipo, activo: activo },
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
        <th>Manipulador</th>
        <th>fecha Alta</th>
        <th>Fecha Ult. Acceso</th>
        <th>Activo</th>
      </tr>
    </thead>
    <tbody>
	<?php while ($rs = mysqli_fetch_array($resultado)) { ?>
		<tr>
		<td><?php echo $rs['id_equipo']; ?></td>
	    <td><?php echo (!is_null($rs['Nombre_Comercial']) ? $rs['Nombre_Comercial'] : $rs['id_manipulador']); ?></td>
	    <td><?php echo date('j-m-Y',strtotime($rs['fecha_alta'])); ?></td>        
	    <td><?php echo date('j-m-Y',strtotime($rs['fecha_ultimo_acceso'])); ?></td>
      <td>
        <input type="checkbox" id="activa<?php echo $rs['id_equipo'];?>" class="checkbox js-switch" name="activa<?php echo $rs['id_equipo'];?>" value="1" onchange="actualizar_activo(this)" <?php echo ($rs['activa']==1 ? 'checked' : 'unchecked');?>/>
      </td>
      <!--<td><?php //echo $rs['activa']; ?></td>-->
	    </tr>
	<?php } ?>      
    </tbody>
</table>