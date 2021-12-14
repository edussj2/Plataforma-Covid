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
          <i class="far fa-comment-dots"></i> &nbsp; Comentarios &nbsp;<small>Gestión</small>
          </h3>
          <p class="text-justify">
              Lista de todos los comentarios que existen dentro de la plataforma, según la noticias y el usuario que la ha realizado.
          </p>
        </div>

<?php 
  require_once "./controladores/comentarioControlador.php";
  $inscomentario = new comentarioControlador();
?>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mb-5">
              <div class="contenedor-paneles mb-5">
                <div class="container-fluid">
                  <div class="panel panel-info shadow">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-list"></i> &nbsp; LISTA DE COMENTARIOS</h3>
                    </div>
                    <div class="panel-body">
                      <?php 
                          $pagina = explode("/", $_GET['views']);
                          echo $inscomentario->paginador_comentario_controlador($pagina[1],10,$_SESSION['privilegio_unprg'],"");
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