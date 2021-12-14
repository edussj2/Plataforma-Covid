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
                <i class="fas fa-video"></i> &nbsp; Conferencia &nbsp;<small>Gestión</small>
              </h3>
              <p class="text-justify">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
              </p>
          </div>

          <div class="container-fluid">
            <ul class="listado-regresar">
              <li>
                <a href="../../<?php SERVERURL; ?>conferenciaLista/" class="enlace-lista">
                  <i class="fas fa-arrow-circle-left"></i> REGRESAR
                </a>
              </li>
            </ul>
          </div>
<?php
  $datos = explode("/", $_GET['views']);
  require_once "./controladores/conferenciaControlador.php";
  $clasAdmin = new conferenciaControlador();

  $filesA = $clasAdmin->datos_conferencia_controlador("Unico",$datos[1]);

  if($filesA->rowCount()==1){
    $campos = $filesA->fetch();
    if(1 != $_SESSION['privilegio_unprg']){
      echo $lc->forzar_cierre_sesion_controlador();		
    }
?>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mb-5">
              <div class="contenedor-paneles mb-5">
                <div class="container-fluid">
                  <div class="panel panel-actualizar shadow">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR FOTO</h3>
                    </div>
                    <div class="panel-body">
                    <div class="imagen-actual row container mb-4">
                        <h6>Imagen Actual</h6>
                        <div class="imagen ml-5">
                            <img src="<?php echo SERVERURL; ?>adjuntos/conferencias/<?php echo $campos['ConferenciaImagen']?>" alt="ImagenActual" style="width:120px;height:120px;"";>
                        </div>
                    </div>
                        <form class="FormularioAjax form-imagen" action="<?php echo SERVERURL;?>ajax/conferenciaAjax.php" method="POST" data-form="update"  autocomplete="off" enctype="multipart/form-data">
                          <label>Imagen Nueva</label>
                          <input type="hidden" name="codigoImg-up" value="<?php echo $datos[1];?>">
                          <input type="file" id="archivoInput" name="fotoImg-up" placeholder="Cargue archivo" onchange="return validarExt()" required="">
                          <div class="elementos">
                              <label for="archivoInput">
                              <i class="fas fa-paperclip"></i>Agregar archivo(.png/.jpg/.jpeg)
                              </label>
                          </div>
                          <div id="visorArchivo" class="visor border-danger">
                          </div> 
                          <p class="text-center pb-2 mt-4 mb-3">
                              <button type="submit" class="boton-actualizar"><i class="fas fa-sync"></i> Actualizar</button>
                          </p>
                          <div class="RespuestaAjax"></div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>                             
<?php 
  }else{
?>
    <div class="alert alert-dimissible alert-warning text-center border mt-3">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
			<h4>!LO SENTIMOS!</h4>
			<p>No pudimos mostrar la información buscada</p>
	  </div>
 <?php   
  }
 ?> 
      </div>
    </div>
  </div>
</section> 