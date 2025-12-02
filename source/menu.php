<?php require_once('Connections/conect.php'); ?>
<?php require_once('Connections/user_info.php'); ?>


<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="principal.php" class="site_title"><img src="images/logo-login.png" height="55" alt="Logo"/> </a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <?php $foto="images/img_".$id_usuario.".jpg";?>
        <img src="<?php echo $foto; ?>" alt="" class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Bienvenido,</span>
        <h2><?php echo $nombre_usuario; ?></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li><a href="principal.php"><i class="fa fa-home"></i> Home </a></li>
          
          <?php
            if ($es_admin==1)
            {
              echo '<li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>';
              echo '<ul class="nav child_menu">';
              echo '<li><a href="ficha_usuario.php">Nuevo Usuario</a></li>';
              echo '<li><a href="lista_usuarios.php">Listado Usuarios</a></li>';
              echo '</ul>';
              echo '</li>';
            }
          ?>

          <?php
            if ($es_admin==1)
            {
              echo '<li><a href="ficha_homologaciones.php"><i class="fa fa-briefcase"></i> Homologaciones Matriculas</a></li>';
            }
          ?>           
          
          <li><a><i class="fa fa-desktop"></i> Licencias Comerciales <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="nueva_licencia.php">Nueva Licencia</a></li>
              <li><a href="lista_licencias.php">Listado Licencias</a></li>              
            </ul>
          </li>
          <?php          
          if ($es_admin==1)
          {
            echo '<li><a><i class="fa fa-automobile"></i> Manipuladores <span class="fa fa-chevron-down"></span></a>';
            echo '  <ul class="nav child_menu">';              
            echo '    <li><a href="ficha_manipulador.php">Nuevo Manipulador</a></li>';
            echo '    <li><a href="lista_manipuladores.php">Listado Manipuladores</a></li>';              
            echo '  </ul>';
            echo '</li>';

            echo '<li><a><i class="fa fa-cloud"></i> Equipos en CLOUD <span class="fa fa-chevron-down"></span></a>';
            echo '  <ul class="nav child_menu">';              
            //echo '    <li><a href="lista_licencias_cloud.php">Licencias Matri2</a></li>';
            //echo '    <li><a href="lista_licencias_cloud_etiamb2.php">Licencias Etiamb2</a></li>';
            echo '    <li><a href="lista_licencias_cloud_todas.php">Licencias Cloud</a></li>';            
            echo '  </ul>';
            echo '</li>';

            echo '<li><a href="lista_impresiones.php"><i class="fa fa-print"></i> Impresiones Matriculas</a></li>';
            
            echo '<li><a href="lista_impresiones_etiquetas.php"><i class="fa fa-tags"></i> Impresiones Etiquetas</a></li>';
          }
          ?>
        </ul>
      </div> 

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">      
      <a data-toggle="tooltip" data-placement="top" title="Salir" href="index.php">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>