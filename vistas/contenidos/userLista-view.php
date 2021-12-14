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
                  Lista de usuarios ordenados por orden de registro de forma descendente, con sus respectivas opciones, según el privilegio de la cuenta.
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
  require_once "./controladores/usuarioControlador.php";
  $insusuario = new usuarioControlador();
?>
            <div class="container">
              <div class="row">
                <div class="col-lg-12 mb-5">
                  <div class="contenedor-paneles mb-5">
                    <div class="container-fluid">
                      <div class="panel panel-info shadow">
                        <div class="panel-heading">
                          <h3 class="panel-title"><i class="fas fa-list"></i> &nbsp; LISTA DE USUARIOS</h3>
                        </div>
                        <div class="panel-body">
                          <?php 
                              $pagina = explode("/", $_GET['views']);
                              echo $insusuario->paginador_usuario_controlador($pagina[1],25,$_SESSION['privilegio_unprg'],$_SESSION['codigo_cuenta_unprg'],"");
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          
      </div>
    </div>
  </div>
</section>