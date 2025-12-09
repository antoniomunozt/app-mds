<?php 

$manipulador     = 0;
$tipo            = 0;
$formato         = 0;
$fecha_desde     = 0;
$fecha_hasta     = 0;
$estoy_filtrando = 0;

if (!empty($_GET))
{
    $manipulador     = isset($_GET['id_manipulador']) ? (int)$_GET['id_manipulador'] : 0;
    $tipo            = isset($_GET['tipo']) ? (int)$_GET['tipo'] : 0;
    $formato         = isset($_GET['formato']) ? (int)$_GET['formato'] : 0;
    $fecha_desde     = isset($_GET['fechadesde']) ? $_GET['fechadesde'] : 0;
    $fecha_hasta     = isset($_GET['fechahasta']) ? $_GET['fechahasta'] : 0;
    $estoy_filtrando = 1;
}

/******************************************************************
 *  CASO 1: SIN FILTROS → SOLO 100 ÚLTIMAS IMPRESIONES (SIN PÁGINAS)
 ******************************************************************/
if (!$estoy_filtrando) {

    $sql  = "SELECT t1.id_manipulador,t1.id_equipo,t1.matricula,t1.bastidor,t1.nombre,t1.apellidos,";
    $sql .= "t1.dni,t1.copias,t1.observaciones,t1.fecha_impresion,t1.tipo_matricula,t1.formato_matricula,";
    $sql .= "t2.Nombre_Comercial,";
    $sql .= "t3.descripcion AS des_tipo_matricula,";
    $sql .= "t4.descripcion AS des_formato_matricula ";
    $sql .= " FROM mds_impresiones AS t1 ";
    $sql .= " LEFT JOIN mds_manipuladores      AS t2 ON t1.id_manipulador   = t2.id_manipulador ";
    $sql .= " LEFT JOIN mds_tipo_matricula     AS t3 ON t1.tipo_matricula   = t3.id ";
    $sql .= " LEFT JOIN mds_formato_matricula  AS t4 ON t1.formato_matricula = t4.id_formato ";
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

    // Mensaje informativo
    echo '<p class="text-muted">Mostrando las <strong>100 impresiones más recientes</strong>. Usa los filtros para acotar la búsqueda y ver más resultados.</p>';

} else {

/******************************************************************
 *  CASO 2: CON FILTROS → PAGINACIÓN EN SERVIDOR
 ******************************************************************/

    // ---- PAGINACIÓN ----
    $per_page = 100; // nº de registros por página
    $page     = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) { 
        $page = 1; 
    }
    $offset = ($page - 1) * $per_page;
    // ---------------------

    // Base FROM + JOIN comunes
    $sql_base  = " FROM mds_impresiones AS t1 ";
    $sql_base .= " LEFT JOIN mds_manipuladores      AS t2 ON t1.id_manipulador    = t2.id_manipulador ";
    $sql_base .= " LEFT JOIN mds_tipo_matricula     AS t3 ON t1.tipo_matricula    = t3.id ";
    $sql_base .= " LEFT JOIN mds_formato_matricula  AS t4 ON t1.formato_matricula = t4.id_formato ";

    // Construcción del WHERE
    $where = "";

    if ($manipulador != 0)
    {
        $where .= " AND t1.id_manipulador = " . $manipulador;
    }
    if ($tipo != 0 && $tipo != -1)
    {
        $where .= " AND t1.tipo_matricula = " . $tipo;
    }
    if ($formato != 0 && $formato != -1)
    {
        $where .= " AND t1.formato_matricula = " . $formato;
    }
    if ($fecha_desde != 0)
    {
        // En el filtro usas formato DD.MM.YYYY → lo pasamos a YYYY-MM-DD
        $where .= " AND t1.fecha_impresion >= '" . date('Y-m-d', strtotime($fecha_desde)) . "'";
    }
    if ($fecha_hasta != 0)
    {
        // Hasta el día siguiente para incluir el propio día
        $where .= " AND t1.fecha_impresion < '" . date("Y-m-d", strtotime($fecha_hasta . "+ 1 days")) . "'";
    }

    if ($where != "")
    {
        $where = " WHERE " . substr($where, 5); // quitar el primer " AND"
        $sql_base .= $where;
    }

    // 1) Consulta de TOTAL de registros filtrados
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

    // Ajustar página si se pasa del máximo
    if ($page > $total_paginas) {
        $page   = $total_paginas;
        $offset = ($page - 1) * $per_page;
    }

    // 2) Consulta de datos de la página actual
    $sql_datos  = "SELECT t1.id_manipulador, t1.id_equipo, t1.matricula, t1.bastidor, t1.nombre, t1.apellidos, ";
    $sql_datos .= "t1.dni, t1.copias, t1.observaciones, t1.fecha_impresion, t1.tipo_matricula, t1.formato_matricula, ";
    $sql_datos .= "t2.Nombre_Comercial, ";
    $sql_datos .= "t3.descripcion AS des_tipo_matricula, ";
    $sql_datos .= "t4.descripcion AS des_formato_matricula ";
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

<!-- Botón de filtros (modal) -->
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
                  <option value="0">Tipo Matricula</option>
                  <?php
                    $query = $mysqli->query("SELECT id,descripcion FROM mds_tipo_matricula ORDER BY id");
                    while ($rs = mysqli_fetch_array($query)) {
                      if ($rs['id'] == $tipo) {
                        echo '<option value="'.$rs['id'].'" selected>'.$rs['descripcion'].'</option>';
                      } else {
                        echo '<option value="'.$rs['id'].'">'.$rs['descripcion'].'</option>';
                      }
                    }
                  ?>
                  </select>
                </div>
              
                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" name="formato">
                    <option value="-1">Formato Matricula</option>
                    <?php
                      $query = $mysqli->query("SELECT id,id_formato,descripcion FROM mds_formato_matricula ORDER BY id_formato");
                      while ($rs = mysqli_fetch_array($query)) {
                        if ($rs['id_formato'] == $formato) {
                          echo '<option value="'.$rs['id_formato'].'" selected>'.$rs['descripcion'].'</option>';
                        } else {
                          echo '<option value="'.$rs['id_formato'].'">'.$rs['descripcion'].'</option>';
                        }
                      }
                    ?>
                  </select> 
                </div>                    
                
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerdesde">Fecha Desde</label>
                  <div class='input-group date' id='myDatepickerdesde'>
                    <input type='text' class="form-control" name="fechadesde" id="fechadesde" value="<?php echo ($fecha_desde != 0 ? $fecha_desde : '01.01.2019') ;  ?>" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div> 
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerhasta">Fecha Hasta</label>
                  <div class='input-group date' id='myDatepickerhasta'>
                    <input type='text' class="form-control" name="fechahasta" id="fechahasta" value="<?php echo ($fecha_hasta != 0 ? $fecha_hasta : '01.03.2019') ;  ?>" />
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
        <th>Matricula</th>        
        <th>Bastidor</th>
        <th>Nombre</th>        
        <th>DNI</th>
        <th>Copias</th>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Formato</th> 
      </tr>
    </thead>
    <tbody>
  <?php while ($rs = mysqli_fetch_array($resultado)) { ?>
        <tr>
          <td><?php echo (!is_null($rs['Nombre_Comercial']) ? $rs['Nombre_Comercial'] : $rs['id_manipulador']); ?></td>
          <td><?php echo $rs['id_equipo']; ?></td>
          <td><?php echo $rs['matricula']; ?></td>
          <td><?php echo $rs['bastidor']; ?></td>
          <td><?php echo $rs['nombre']; ?></td>
          <td><?php echo $rs['dni']; ?></td>
          <td><?php echo $rs['copias']; ?></td>
          <td data-order="<?php echo $rs['fecha_impresion']; ?>">
            <?php echo (!empty($rs['fecha_impresion']) ? date('d-m-Y', strtotime($rs['fecha_impresion'])) : ''); ?>
        </td>
          <td><?php echo (!is_null($rs['des_tipo_matricula']) ? $rs['des_tipo_matricula'] : $rs['tipo_matricula']); ?></td>
          <td><?php echo (!is_null($rs['des_formato_matricula']) ? $rs['des_formato_matricula'] : $rs['formato_matricula']); ?></td>
        </tr>
  <?php } ?>      
    </tbody>
</table>

<?php
// Solo mostramos paginación si HAY filtros
if ($estoy_filtrando && $total_registros > 0):

    // Copiamos los parámetros GET para mantener filtros en los enlaces
    $params = $_GET;
?>
<div class="row" style="margin-top:10px;">
  <!-- Texto de total registros -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <p class="text-muted" style="margin-top: 7px;">
      Total impresiones filtradas: <strong><?php echo $total_registros; ?></strong>
      <?php if ($total_paginas > 1): ?>
        &nbsp; | &nbsp;
        Página <strong><?php echo $page; ?></strong> de <strong><?php echo $total_paginas; ?></strong>
      <?php endif; ?>
    </p>
  </div>

  <!-- Paginación a la derecha -->
  <?php if ($total_paginas > 1): ?>
  <div class="col-md-6 col-sm-6 col-xs-12">
    <nav aria-label="Paginación de impresiones">
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

        <!-- Números de página -->
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
