<?php   

$activo = 0;
$nombrecomercial = "";
$cif = "";

// ---- PAGINACIÓN ----
$per_page = 50; // nº de registros por página (ajusta a tu gusto)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) { 
    $page = 1; 
}
$offset = ($page - 1) * $per_page;
// ---------------------

if (!empty($_GET))
{
  $activo = isset($_GET['activo']) ? (int)$_GET['activo'] : 0 ;
  $nombrecomercial = isset($_GET['nombrecomercial']) ? $_GET['nombrecomercial'] : "" ;
  $cif = isset($_GET['cif']) ? $_GET['cif'] : "" ;  
}

// Construcción del WHERE
$where = "";

if ($activo != 0)
{
    if ($activo == 1)
    {
        // equipos activos
        $where .= " AND t1.activa = 1";
    }
    elseif($activo == 2)
    {
        // equipos no activos
        $where .= " AND t1.activa = 0";
    }    
}

if ($nombrecomercial != "")
{
  $nombrecomercial = $mysqli->real_escape_string($nombrecomercial);
  $where .= " AND t2.Nombre_Comercial LIKE '%".$nombrecomercial."%'";
}

if ($cif != "")
{
  $cif = $mysqli->real_escape_string($cif);
  $where .= " AND t2.cif LIKE '%".$cif."%'";
}

// Base de la consulta (FROM + JOIN)
$sql_base = " FROM mds_licencias_software AS t1 
              LEFT JOIN mds_manipuladores AS t2 
                ON t1.id_manipulador = t2.id_manipulador";

if ($where != "")
{
  // quitamos el primer " AND"
  $where = " WHERE " . substr($where, 5);
  $sql_base .= $where;
}

// 1) Consulta de TOTAL de registros (para paginación y resumen)
$sql_count = "SELECT COUNT(*) AS total " . $sql_base;

if (!$resultado_count = $mysqli->query($sql_count)) 
{
    echo "Lo sentimos, este sitio web está experimentando problemas.";
    echo "Error: La ejecución de la consulta de conteo falló debido a: \n";
    echo "Query: " . $sql_count . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}

$row_count = mysqli_fetch_assoc($resultado_count);
$total_registros = (int)$row_count['total'];
$total_paginas = ($total_registros > 0) ? ceil($total_registros / $per_page) : 1;

// Ajustar página si se pasa del máximo (por ejemplo al filtrar)
if ($page > $total_paginas) {
    $page = $total_paginas;
    $offset = ($page - 1) * $per_page;
}

// 2) Consulta de datos de la página actual
$sql_datos  = "SELECT t1.id_equipo, t1.id_manipulador, t1.fecha_alta, t1.fecha_ultimo_acceso, ";
$sql_datos .= "t1.activa, t2.Nombre_Comercial ";
$sql_datos .= $sql_base;
$sql_datos .= " ORDER BY t1.id_equipo ";
$sql_datos .= " LIMIT $offset, $per_page";

if (!$resultado = $mysqli->query($sql_datos)) 
{
    echo "Lo sentimos, este sitio web está experimentando problemas.";
    echo "Error: La ejecución de la consulta falló debido a: \n";
    echo "Query: " . $sql_datos . "\n";
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
    // id viene como "activa<ID>"
    var id_equipo = element.id.substring(6); // desde el carácter 6 hasta el final
    var activo = 0;
    if (element.checked) activo = 1;

    var url = "";
    url = getAbsolutePath() + "source/actualizar_estado_equipo.php";

    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        data: { id_equipo: id_equipo, activo: activo },
        success: function(response) {                       
            // podrías mostrar un mensaje si quieres
        },
        error:  function(response) {        
            alert("Error al actualizar el estado del equipo");
        }
    });
}
</script>

<!-- Panel de filtros -->
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
                    <div class='input-group' id='nombrecomercial_group'>
                        <input type='text' class="form-control" name="nombrecomercial" id="nombrecomercial" placeholder="Nombre Comercial" value="<?php echo isset($nombrecomercial) ? htmlspecialchars($nombrecomercial) : '' ;  ?>" />                        
                    </div> 
                </div>

                <div class="col-md-2 col-sm-2 col-xs-12 form-group">
                    <div class='input-group' id='cif_group'>
                        <input type='text' class="form-control" name="cif" id="cif" placeholder="CIF" value="<?php echo isset($cif) ? htmlspecialchars($cif) : '' ;  ?>" />                        
                    </div> 
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12 form-group">
                    <input class="btn btn-default" type="submit" value="Filtrar">                   
                </div>
            </form>        
        </div>
    </div>
</div>  

<!-- Tabla -->
<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>Manipulador</th>
        <th>Fecha Alta</th>
        <th>Fecha Ult. Acceso</th>
        <th>Activo</th>
      </tr>
    </thead>
    <tbody>
    <?php while ($rs = mysqli_fetch_array($resultado)) { ?>
        <tr>
            <td><?php echo $rs['id_equipo']; ?></td>
            <td><?php echo (!is_null($rs['Nombre_Comercial']) ? $rs['Nombre_Comercial'] : $rs['id_manipulador']); ?></td>
            <td><?php echo (!empty($rs['fecha_alta']) ? date('j-m-Y',strtotime($rs['fecha_alta'])) : ''); ?></td>        
            <td><?php echo (!empty($rs['fecha_ultimo_acceso']) ? date('j-m-Y',strtotime($rs['fecha_ultimo_acceso'])) : ''); ?></td>
            <td>
                <input 
                    type="checkbox" 
                    id="activa<?php echo $rs['id_equipo'];?>" 
                    class="checkbox js-switch" 
                    name="activa<?php echo $rs['id_equipo'];?>" 
                    value="1" 
                    onchange="actualizar_activo(this)" 
                    <?php echo ($rs['activa']==1 ? 'checked' : ''); ?>
                />
            </td>
        </tr>
    <?php } ?>      
    </tbody>
</table>

<?php
// Paginación y resumen (solo si hay al menos 1 registro)
if ($total_registros > 0):

    // Copiamos los parámetros GET para mantener filtros en los enlaces
    $params = $_GET;
?>
<div class="row" style="margin-top:10px;">
  <!-- Texto de total registros -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <p class="text-muted" style="margin-top: 7px;">
      Total equipos en CLOUD: <strong><?php echo $total_registros; ?></strong>
      <?php if ($total_paginas > 1): ?>
        &nbsp; | &nbsp;
        Página <strong><?php echo $page; ?></strong> de <strong><?php echo $total_paginas; ?></strong>
      <?php endif; ?>
    </p>
  </div>

  <!-- Paginación a la derecha -->
  <?php if ($total_paginas > 1): ?>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <nav aria-label="Paginación de equipos CLOUD">
      <ul class="pagination pull-right">

        <!-- Anterior -->
        <?php
          $prev_page = $page - 1;
          $params['page'] = $prev_page;
          $prev_disabled = ($page <= 1) ? ' class="disabled"' : '';
          $prev_url = '?' . http_build_query($params);
        ?>
        <li<?php echo $prev_disabled; ?>>
          <a href="<?php echo ($page <= 1 ? '#' : $prev_url); ?>" aria-label="Anterior">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <!-- Números de página -->
        <?php
          for ($i = 1; $i <= $total_paginas; $i++):
            $params['page'] = $i;
            $url = '?' . http_build_query($params);
            $active = ($i == $page) ? ' class="active"' : '';
        ?>
          <li<?php echo $active; ?>><a href="<?php echo $url; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <!-- Siguiente -->
        <?php
          $next_page = $page + 1;
          $params['page'] = $next_page;
          $next_disabled = ($page >= $total_paginas) ? ' class="disabled"' : '';
          $next_url = '?' . http_build_query($params);
        ?>
        <li<?php echo $next_disabled; ?>>
          <a href="<?php echo ($page >= $total_paginas ? '#' : $next_url); ?>" aria-label="Siguiente">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>

      </ul>
    </nav>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>
