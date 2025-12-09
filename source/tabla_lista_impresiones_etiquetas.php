<?php 

$manipulador     = 0;
$tipo            = 0;
$fecha_desde     = 0;
$fecha_hasta     = 0;
$estoy_filtrando = 0;

// Para paginación (solo cuando hay filtros)
$per_page        = 100;
$page            = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) { $page = 1; }
$offset          = ($page - 1) * $per_page;

$total_registros = 0;
$total_paginas   = 1;

if (!empty($_GET))
{
  $manipulador     = isset($_GET['id_manipulador']) ? (int)$_GET['id_manipulador'] : 0;
  $tipo            = isset($_GET['tipo']) ? (int)$_GET['tipo'] : 0;
  $fecha_desde     = isset($_GET['fechadesde']) ? $_GET['fechadesde'] : 0;
  $fecha_hasta     = isset($_GET['fechahasta']) ? $_GET['fechahasta'] : 0;
  $estoy_filtrando = 1;
}

/******************************************************************
 *  CASO 1: SIN FILTROS → SOLO 100 ÚLTIMAS IMPRESIONES (SIN PÁGINAS)
 ******************************************************************/
if (!$estoy_filtrando) {

    $sql  = "SELECT t1.id_manipulador,t1.id_equipo,t1.matricula,t1.nombre,t1.apellidos,t1.dni,";
    $sql .= "t1.observaciones,t1.fecha_impresion,t1.tipo_etiqueta,";
    $sql .= "t2.Nombre_Comercial,";
    $sql .= "t3.descripcion AS des_tipo_etiqueta ";
    $sql .= " FROM mds_impresiones_etiquetas AS t1 ";
    $sql .= " LEFT JOIN mds_manipuladores  AS t2 ON t1.id_manipulador = t2.id_manipulador ";
    $sql .= " LEFT JOIN mds_tipo_etiqueta AS t3 ON t1.tipo_etiqueta   = t3.id ";
    $sql .= " ORDER BY t1.fecha_impresion DESC, t1.id_equipo DESC ";
    $sql .= " LIMIT 100";

    if (!$resultado = $mysqli->query($sql)) 
    {
        echo "Lo sentimos, este sitio web está experimentando problemas.";
        echo "Error: La ejecución de la consulta falló debido a: \n";
        echo "Query: " . $sql . "\n";
        echo "Errno: " . $mysqli->errno . "\n";
        echo "Error: " . $mysqli->error . "\n";
        exit;
    }

    echo '<p class="text-muted">Mostrando las <strong>100 impresiones de etiquetas más recientes</strong>. Usa los filtros para acotar la búsqueda y ver más resultados.</p>';

} else {

/******************************************************************
 *  CASO 2: CON FILTROS → PAGINACIÓN EN SERVIDOR
 ******************************************************************/

    // Base FROM + JOIN comunes
    $sql_base  = " FROM mds_impresiones_etiquetas AS t1 ";
    $sql_base .= " LEFT JOIN mds_manipuladores  AS t2 ON t1.id_manipulador = t2.id_manipulador ";
    $sql_base .= " LEFT JOIN mds_tipo_etiqueta AS t3 ON t1.tipo_etiqueta   = t3.id ";

    // Construcción del WHERE
    $where = "";

    if ($manipulador != 0)
    {
      $where .= " AND t1.id_manipulador = " . $manipulador;
    }
    if ($tipo != 0 && $tipo != -1)
    {
      $where .= " AND t1.tipo_etiqueta = " . $tipo;
    }
    if ($fecha_desde != 0)
    {
      // Formato DD.MM.YYYY → YYYY-MM-DD
      $where .= " AND t1.fecha_impresion >= '" . date('Y-m-d', strtotime($fecha_desde)) . "'";
    }
    if ($fecha_hasta != 0)
    {
      $where .= " AND t1.fecha_impresion < '" . date("Y-m-d", strtotime($fecha_hasta . "+ 1 days")) . "'";
    }

    if ($where != "")
    {
      $where = " WHERE " . substr($where, 5);
      $sql_base .= $where;
    }

    // 1) TOTAL registros filtrados
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

    $row_count       = mysqli_fetch_assoc($resultado_count);
    $total_registros = (int)$row_count['total'];
    $total_paginas   = ($total_registros > 0) ? ceil($total_registros / $per_page) : 1;

    if ($page > $total_paginas) {
        $page   = $total_paginas;
        $offset = ($page - 1) * $per_page;
    }

    // 2) Datos de la página actual
    $sql_datos  = "SELECT t1.id_manipulador,t1.id_equipo,t1.matricula,t1.nombre,t1.apellidos,t1.dni,";
    $sql_datos .= "t1.observaciones,t1.fecha_impresion,t1.tipo_etiqueta,";
    $sql_datos .= "t2.Nombre_Comercial,";
    $sql_datos .= "t3.descripcion AS des_tipo_etiqueta ";
    $sql_datos .= $sql_base;
    $sql_datos .= " ORDER BY t1.fecha_impresion DESC, t1.id_equipo DESC ";
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
}

?>

<!-- Large modal -->
<button type="button" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-lg">Filtros</button>

<div class="modal fade bs-example-modal-lg" id="myModal" role="dialog" aria-hidden="true" style="width:auto ;overflow:hidden;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title" id="myModalLabel">Filtros</h4>
    </div>
    <div class="modal-body">
      <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              
              <form method="GET" action="" accept-charset="UTF-8" class="form-horizontal form-label-left">                
                
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" id="mibuscador" name="id_manipulador" style="width: 100%" >
                  <option value="0">Manipulador</option>                  
                  <?php                    
                    $query = $mysqli->query("SELECT id_manipulador,Nombre_Comercial,Razon_Social FROM mds_manipuladores ORDER BY Nombre_Comercial");
                    while ($rs = mysqli_fetch_array($query)) {                    
                      if ($rs['id_manipulador'] == $manipulador) {
                        echo '<option value="'.$rs['id_manipulador'].'" selected>'.$rs['Nombre_Comercial'].'</option>';
                      } else {
                        echo '<option value="'.$rs['id_manipulador'].'">'.$rs['Nombre_Comercial'].'</option>';
                      }                    
                    }
                  ?>
                  </select>
                </div>                

                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" id="tipo" name="tipo">
                  <option value="0">Tipo Etiqueta</option>
                  <?php
                    $query = $mysqli->query("SELECT id,descripcion FROM mds_tipo_etiqueta ORDER BY id");
                    while ($rs = mysqli_fetch_array($query)) 
                    {
                      if ($rs['id'] == $tipo) {
                        echo '<option value="'.$rs['id'].'" selected>'.$rs['descripcion'].'</option>';
                      } else {
                        echo '<option value="'.$rs['id'].'">'.$rs['descripcion'].'</option>';
                      }
                    }
                  ?>
                  </select>
                </div>
              
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerdesde">Fecha Desde</label>
                  <div class='input-group date' id='myDatepickerdesde'>
                    <input type='text' class="form-control" name="fechadesde" id="fechadesde" value="<?php echo ($fecha_desde != 0 ? $fecha_desde : '01.01.2019'); ?>" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div> 
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerhasta">Fecha Hasta</label>
                  <div class='input-group date' id='myDatepickerhasta'>
                    <input type='text' class="form-control" name="fechahasta" id="fechahasta" value="<?php echo ($fecha_hasta != 0 ? $fecha_hasta : '01.03.2019'); ?>" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div>        
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <input class="btn btn-default" type="submit" value="Filtrar">                  
                </div>
              </form>
              
            </div>
          </div>
        </div>    
      </div>
    </div>
  </div>
</div>


<table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Manipulador</th>
        <th>Equipo</th>
        <th>Matrícula</th>        
        <th>Nombre</th>        
        <th>DNI</th>
        <th>Fecha</th>
        <th>Tipo</th>        
      </tr>
    </thead>
    <tbody>
  <?php while ($rs = mysqli_fetch_array($resultado)) { ?>
		<tr>
		  <td><?php echo (!is_null($rs['Nombre_Comercial']) ? $rs['Nombre_Comercial'] : $rs['id_manipulador']); ?></td>
      <td><?php echo $rs['id_equipo']; ?></td>
      <td><?php echo $rs['matricula']; ?></td>     
      <td><?php echo $rs['nombre']; ?></td>
      <td><?php echo $rs['dni']; ?></td>     
	    <td data-order="<?php echo $rs['fecha_impresion']; ?>">
        <?php echo (!empty($rs['fecha_impresion']) ? date('d-m-Y', strtotime($rs['fecha_impresion'])) : ''); ?>
      </td>
	    <td><?php echo (!is_null($rs['des_tipo_etiqueta']) ? $rs['des_tipo_etiqueta'] : $rs['tipo_etiqueta']); ?></td>     
    </tr>
  <?php } ?>      
    </tbody>
</table>

<?php
// Paginación solo cuando HAY filtros y registros
if ($estoy_filtrando && $total_registros > 0):

    $params = $_GET;
?>
<div class="row" style="margin-top:10px;">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <p class="text-muted" style="margin-top: 7px;">
      Total impresiones de etiquetas filtradas: <strong><?php echo $total_registros; ?></strong>
      <?php if ($total_paginas > 1): ?>
        &nbsp; | &nbsp;
        Página <strong><?php echo $page; ?></strong> de <strong><?php echo $total_paginas; ?></strong>
      <?php endif; ?>
    </p>
  </div>

  <?php if ($total_paginas > 1): ?>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <nav aria-label="Paginación de impresiones de etiquetas">
      <ul class="pagination pull-right">

        <!-- Anterior -->
        <?php
          $prev_page      = $page - 1;
          $params['page'] = $prev_page;
          $prev_disabled  = ($page <= 1) ? ' class="disabled"' : '';
          $prev_url       = '?' . http_build_query($params);
        ?>
        <li<?php echo $prev_disabled; ?>>
          <a href="<?php echo ($page <= 1 ? '#' : $prev_url); ?>" aria-label="Anterior">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <!-- Números -->
        <?php
          for ($i = 1; $i <= $total_paginas; $i++):
            $params['page'] = $i;
            $url            = '?' . http_build_query($params);
            $active         = ($i == $page) ? ' class="active"' : '';
        ?>
          <li<?php echo $active; ?>><a href="<?php echo $url; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>

        <!-- Siguiente -->
        <?php
          $next_page      = $page + 1;
          $params['page'] = $next_page;
          $next_disabled  = ($page >= $total_paginas) ? ' class="disabled"' : '';
          $next_url       = '?' . http_build_query($params);
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
