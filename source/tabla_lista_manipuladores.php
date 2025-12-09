<?php
// Inicialización de filtros
$activo = 0;
$nummanipulador = "";
$nombrecomercial = "";
$cif = "";

// ---- PAGINACIÓN ----
$per_page = 100; // nº de registros por página (ajústalo a tu gusto)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) { 
    $page = 1; 
}
$offset = ($page - 1) * $per_page;
// ---------------------

if (!empty($_GET)) {
    $activo = isset($_GET['activo']) ? (int)$_GET['activo'] : 0;
    $nummanipulador = isset($_GET['nummanipulador']) ? $_GET['nummanipulador'] : "";
    $nombrecomercial = isset($_GET['nombrecomercial']) ? $_GET['nombrecomercial'] : "";
    $cif = isset($_GET['cif']) ? $_GET['cif'] : "";
}

$where = "";

// Filtro activo / no activo
if ($activo != 0) {
    if ($activo == 1) {
        $where .= " AND activo = 1";
    } elseif ($activo == 2) {
        $where .= " AND activo = 0";
    }
}

// Filtro nombre comercial
if ($nombrecomercial != "") {
    $nombrecomercial = $mysqli->real_escape_string($nombrecomercial);
    $where .= " AND Nombre_Comercial LIKE '%" . $nombrecomercial . "%'";
}

// Filtro nº manipulador
if ($nummanipulador != "") {
    $nummanipulador = $mysqli->real_escape_string($nummanipulador);
    $where .= " AND num_manipulador LIKE '%" . $nummanipulador . "%'";
}

// Filtro CIF
if ($cif != "") {
    $cif = $mysqli->real_escape_string($cif);
    $where .= " AND cif LIKE '%" . $cif . "%'";
}

// Base de la consulta
$sql_base = "FROM mds_manipuladores";

if ($where != "") {
    // quitamos el primer " AND "
    $where = " WHERE " . substr($where, 5);
    $sql_base .= $where;
}

// 1) Consulta de TOTAL de registros (para saber cuántas páginas hay)
$sql_count = "SELECT COUNT(*) AS total " . $sql_base;

if (!$resultado_count = $mysqli->query($sql_count)) {
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

// Ajustar página si se pasa del máximo (por ejemplo, al cambiar filtros)
if ($page > $total_paginas) {
    $page = $total_paginas;
    $offset = ($page - 1) * $per_page;
}

// 2) Consulta de datos de la página actual
$sql_datos = "SELECT * " . $sql_base . " ORDER BY id_manipulador LIMIT $offset, $per_page";

if (!$resultado = $mysqli->query($sql_datos)) {
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
    // id viene como "activo<ID>"
    var id_manipulador = element.id.substring(6); // desde el carácter 6 hasta el final
    var activo = 0;
    if (element.checked) activo = 1;

    var url = "";
    url = getAbsolutePath() + "source/actualizar_estado_manipulador.php";

    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        data: { id_manipulador: id_manipulador, activo: activo },
        success: function(response) {
            // Aquí podrías mostrar un toast o algo si quieres
        },
        error:  function(response) {        
            alert("Error actualizando el estado del manipulador");
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
                    <div class='input-group' id='nummanipulador_group'>
                        <input type='text' class="form-control" name="nummanipulador" id="nummanipulador" placeholder="Num manipulador" value="<?php echo isset($nummanipulador) ? htmlspecialchars($nummanipulador) : '' ;  ?>" />                        
                    </div> 
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

<!-- Tabla de manipuladores -->
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
            <td>
                <input 
                    type="checkbox" 
                    id="activo<?php echo $rs['id_manipulador'];?>" 
                    class="checkbox js-switch" 
                    name="activo<?php echo $rs['id_manipulador'];?>" 
                    value="1" 
                    onchange="actualizar_activo(this)" 
                    <?php echo ($rs['activo']==1 ? 'checked' : ''); ?>
                /> Activo
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
      Total manipuladores: <strong><?php echo $total_registros; ?></strong>
      <?php if ($total_paginas > 1): ?>
        &nbsp; | &nbsp;
        Página <strong><?php echo $page; ?></strong> de <strong><?php echo $total_paginas; ?></strong>
      <?php endif; ?>
    </p>
  </div>

  <!-- Paginación a la derecha -->
  <?php if ($total_paginas > 1): ?>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <nav aria-label="Paginación de manipuladores">
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
