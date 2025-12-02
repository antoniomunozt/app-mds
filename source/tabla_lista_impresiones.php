<?php 

$manipulador =0;
$tipo=0;
$formato =0;
$fecha_desde = 0 ;
$fecha_hasta =0;
$estoy_filtrando=0;

if (!empty($_GET))
{
  $manipulador = $_GET['id_manipulador'];
  $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0 ;
  $formato = isset($_GET['formato']) ? $_GET['formato'] : 0 ;
  $fecha_desde = isset($_GET['fechadesde']) ? $_GET['fechadesde'] : 0 ;
  $fecha_hasta = isset($_GET['fechahasta']) ? $_GET['fechahasta'] : 0 ;
  $estoy_filtrando=1;
}

$sql = "SELECT t1.id_manipulador,t1.id_equipo,t1.matricula,t1.bastidor,t1.nombre,t1.apellidos,t1.dni,t1.copias";
$sql .= ",t1.observaciones,t1.fecha_impresion,t1.tipo_matricula,t1.formato_matricula";
$sql .= ",t2.Nombre_Comercial";
$sql .= ",t3.descripcion as des_tipo_matricula ";
$sql .= ",t4.descripcion as des_formato_matricula ";
$sql .= " FROM mds_impresiones as t1 ";
$sql .= " left join mds_manipuladores as t2 on t1.id_manipulador=t2.id_manipulador ";
$sql .= " left join mds_tipo_matricula as t3 on t1.tipo_matricula=t3.id ";
$sql .= " left join mds_formato_matricula as t4 on t1.formato_matricula=t4.id_formato ";
if (!$estoy_filtrando)
{
  $sql .= " Limit 100";
}

$where="";
if ($manipulador !=0 )
{
  $where = $where." and t1.id_manipulador=".$manipulador ;
}
if ($tipo !=0 and $tipo!=-1 )
{
  $where = $where." and t1.tipo_matricula=".$tipo ;
}
if ($formato !=0 and $formato !=-1)
{
  $where = $where." and t1.formato_matricula=".$formato ;
}
if ($fecha_desde !=0)
{
  $where = $where." and t1.fecha_impresion>='".date('Y-m-d',strtotime($fecha_desde))."'" ;
}
if ($fecha_hasta !=0)
{
  $where = $where." and t1.fecha_impresion<'".date("Y-m-d",strtotime($fecha_hasta."+ 1 days"))."'" ;
}
if ($where!="")
{
  $where = " Where ".substr($where, 5);
  $sql = $sql.$where;
}

/*
if ($estoy_filtrando==1){
  var_dump ($where);
  exit();
}
*/

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
                    $query = $mysqli -> query ("SELECT id_manipulador,Nombre_Comercial,Razon_Social FROM mds_manipuladores order By Nombre_Comercial");
                    while ($rs = mysqli_fetch_array($query))                     
                    if ($rs['id_manipulador']==$manipulador)
                    {
                      echo '<option value="'.$rs['id_manipulador'].'" selected >'.$rs['Nombre_Comercial'].'</option>';
                    }
                    else
                    {
                      echo '<option value="'.$rs['id_manipulador'].'">'.$rs['Nombre_Comercial'].'</option>';
                    }                    
                  ?>
                  </select>
                </div>                

                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" id="tipo" name="tipo">
                  <option value="0">Tipo Matricula</option>
                  <?php
                    $query = $mysqli -> query ("SELECT id,descripcion FROM mds_tipo_matricula order By id");
                    while ($rs = mysqli_fetch_array($query)) 
                    {
                      if ($rs['id']==$tipo)
                      {
                        echo '<option value="'.$rs['id'].'" selected >'.$rs['descripcion'].'</option>';
                      }
                      else 
                      {
                        echo '<option value="'.$rs['id'].'">'.$rs['descripcion'].'</option>';
                      }
                      
                    }
                  ?>
                  </select>
                </div>
              
                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" name="formato"><option value="-1">Formato Matricula</option>
                    <?php
                      $query = $mysqli -> query ("SELECT id,id_formato,descripcion FROM mds_formato_matricula order By id_formato");
                      while ($rs = mysqli_fetch_array($query)) 
                      if ($rs['id_formato']==$formato)
                      {
                        echo '<option value="'.$rs['id_formato'].'" selected >'.$rs['descripcion'].'</option>';
                      }
                      else
                      {
                        echo '<option value="'.$rs['id_formato'].'">'.$rs['descripcion'].'</option>';
                      }
                    ?>
                  </select> 
                </div>                    
                
                <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerdesde">Fecha Desde</label>
                  <div class='input-group date' id='myDatepickerdesde'>
                    <input type='text' class="form-control" name="fechadesde" id="fechadesde" value="<?php echo isset($fecha_desde) ? $fecha_desde : '01.01.2019' ;  ?>" />
                    <span class="input-group-addon">
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </div> 
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerhasta">Fecha Hasta</label>
                  <div class='input-group date' id='myDatepickerhasta'>
                    <input type='text' class="form-control" name="fechahasta" id="fechahasta" value="<?php echo isset($fecha_hasta) ? $fecha_hasta : '01.03.2019' ;  ?>" />
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


<!--<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">-->
<table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Manipulador</th>
        <th>Equipo</th>
        <th>matricula</th>        
        <th>Bastidor</th>
        <th>Nombre</th>        
        <th>dni</th>
        <th>Copias</th>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Formato</th> 
      </tr>
    </thead>
    <tbody>
  <?php while ($rs = mysqli_fetch_array($resultado)) 
  { 
  ?>
		<tr>
		  <td><?php echo (!is_null($rs['Nombre_Comercial']) ? $rs['Nombre_Comercial'] : $rs['id_manipulador']); ?></td>
      <td><?php echo $rs['id_equipo']; ?></td>
      <td><?php echo $rs['matricula']; ?></td>
      <td><?php echo $rs['bastidor']; ?></td>
      <td><?php echo $rs['nombre']; ?></td>
      <td><?php echo $rs['dni']; ?></td>
      <td><?php echo $rs['copias']; ?></td>
	    <td><?php echo date('j-m-Y',strtotime($rs['fecha_impresion'])); ?></td>        
	    <td><?php echo (!is_null($rs['des_tipo_matricula']) ? $rs['des_tipo_matricula'] : $rs['tipo_matricula']); ?></td>
      <td><?php echo (!is_null($rs['des_formato_matricula']) ? $rs['des_formato_matricula'] : $rs['formato_matricula']); ?></td>
    </tr>
  <?php 
  } 
  ?>      
    </tbody>
</table>