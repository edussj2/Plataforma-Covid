<?php
  /*HECHO*/
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>        
<section class="pb-4">   
  <div class="container">
      <div class="row mb-5">
        <div class="contenedor-formularios mb-2">
          <!-- Page header -->
          <div class="full-box page-header">
            <hr>
            <h3 class="text-left">
                <i class="far fa-building"></i> &nbsp; Facultad &nbsp;<small>Gestión</small>
            </h3>
            <p class="text-justify">
                Lista de Facultades ordenadas por orden de registro de forma descendente, con sus respectivas opciones según el privilegio de la cuenta.
            </p>
          </div>

          <div class="container-fluid">
              <ul class="listado-panel">
                  <li>
                      <a href="<?php echo SERVERURL; ?>facultadLista/" class="enlace-lista activo1">
                      <i class="far fa-list-alt"></i> &nbsp; LISTADO
                      </a>
                  </li>
                  <li>
                      <a href="<?php echo SERVERURL; ?>facultadNuevo/" class="enlace-nuevo">
                          <i class="fas fa-plus"></i> &nbsp; AGREGAR
                      </a>
                  </li>
              </ul>
          </div>

<?php 
  require_once "./controladores/facultadControlador.php";
  $insfacultad = new facultadControlador();
?>
          <div class="container">
            <div class="row">
              <div class="col-lg-12 mb-5">
                <div class="contenedor-paneles mb-5">
                  <div class="container-fluid">
                    <div class="panel panel-info shadow">
                      <div class="panel-heading">
                        <h3 class="panel-title"><i class="fas fa-list"></i> &nbsp; LISTA DE FACULTADES</h3>
                      </div>
                      <div class="panel-body">
                      <?php 
                          $pagina = explode("/", $_GET['views']);
                          echo $insfacultad->paginador_facultad_controlador($pagina[1],15,$_SESSION['privilegio_unprg'],"");
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