<?php
  /* HECHO */
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>        
<section class="pb-4">
  <div class="container">
    <div class="row mb-5">
      <div class="contenedor-formularios mb-2">

        <div class="full-box page-header">
          <hr>
          <h3 class="text-left">
              <i class="fas fa-graduation-cap"></i> &nbsp; Usuario &nbsp;<small>Cuenta</small>
          </h3>
          <p class="text-justify">
              Búsqueda de usuarios por número de DNI, Nombres y Apellidos. Se mostrará las mejores coincidencias en una lista con opciones, según el privilegio de la cuenta.
          </p>
        </div>

        <div class="container-fluid">
          <ul class="listado-panel">
            <li>
              <a href="<?php echo SERVERURL; ?>userLista/" class="enlace-lista activo1">
                <i class="far fa-list-alt"></i> &nbsp; LISTADO
              </a>
            </li>
            <li>
              <a href="<?php echo SERVERURL; ?>userNuevo/" class="enlace-nuevo">
                <i class="fas fa-plus"></i> &nbsp; AGREGAR
              </a>
            </li>
            <li>
              <a href="<?php echo SERVERURL; ?>userBuscar/" class="enlace-buscar">
                <i class="fas fa-search"></i> &nbsp; BUSCAR
              </a>
            </li>
          </ul>
        </div>

<?php 
  if(!isset($_SESSION['busqueda_usuario']) && empty($_SESSION['busqueda_usuario'])):
?>

        <div class="container pt-5 pb-5 shadow mb-5 mt-3" style="width: 92%;">
          <form action="<?php echo SERVERURL;?>ajax/buscadorAjax.php" method="POST" data-form="buscar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
              <p class="text-center lead">¿A quién estas buscando?</p>
              <div class="form-row align-items-center justify-content-center">
                <div class="col-sm-7 my-1">
                  <label class="sr-only" for="inlineFormInputGroupUsername">Username</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fas fa-user-cog"></i></div>
                    </div>
                    <input type="text" class="form-control" id="inlineFormInputGroupUsername" placeholder="Datos para buscar" name="busqueda_usuario" required="">
                  </div>
                </div>
                <div class="col-auto my-1">
                  <button type="submit" class="boton-buscar"><i class="fas fa-search"></i> BUSCAR</button>
                </div>
              </div>
              <div class="RespuestaAjax"></div>
          </form>
        </div>

<?php else: ?>

        <div class="container pt-5 pb-5 shadow mb-5" style="width: 92%;">
          <form action="<?php echo SERVERURL;?>ajax/buscadorAjax.php" method="POST" data-form="default" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
            <p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_usuario'];?>”</strong></p>
            <div class="row">
              <input class="form-control" type="hidden" name="eliminar_busqueda_usuario" value="1">
              <div class="col-12">
                  <p class="text-center">
                      <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>&nbsp; Eliminar búsqueda</button>
                  </p>
              </div>
            </div>
            <div class="RespuestaAjax"></div>
          </form>
        </div>

      
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mb-5">
              <div class="contenedor-paneles mb-5">
                <div class="container-fluid">
                  <div class="panel panel-lista shadow">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-list"></i> &nbsp; LISTA DE ESPECIALISTAS BUSCADOS</h3>
                    </div>
                    <div class="panel-body"> 
                      <?php

                        require_once "./controladores/usuarioControlador.php";
                        $insusuario = new usuarioControlador(); 
                        $pagina = explode("/", $_GET['views']);
                        echo $insusuario->paginador_usuario_controlador($pagina[1],15,$_SESSION['privilegio_unprg'],$_SESSION['codigo_cuenta_unprg'],$_SESSION['busqueda_usuario']);
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php endif; ?>
      </div>
    </div>
  </div>
</section> 