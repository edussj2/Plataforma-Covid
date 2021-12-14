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
              <i class="fas fa-certificate"></i> &nbsp; Categoría &nbsp;<small>Gestión</small>
          </h3>
          <p class="text-justify">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
          </p>
        </div>

        <div class="container-fluid">
          <ul class="listado-regresar">
            <li>
              <a href="../../<?php SERVERURL; ?>categoriaLista/" class="enlace-lista">
                <i class="fas fa-arrow-circle-left"></i> REGRESAR
              </a>
            </li>
          </ul>
        </div>
<?php
  $datos = explode("/", $_GET['views']);
  require_once "./controladores/categoriaControlador.php";
  $clasAdmin = new categoriaControlador();

  $filesA = $clasAdmin->datos_categoria_controlador("Unico",$datos[1]);

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
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR CATEGORIA</h3>
                    </div>
                    <div class="panel-body">
                      <form action="<?php echo SERVERURL;?>ajax/categoriaAjax.php" method="POST" data-form="update" class="needs-validation FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="codigo-up" value="<?php echo $datos[1];?>">
                        <fieldset>
                          <legend><i class="fas fa-server"></i> &nbsp; Datos</legend>
                          <div class="container-fluid pt-2">
                            <div class="row">

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Descripción *</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" class="form-control" type="text" name="descripcion-up" required="" maxlength="180" value="<?php echo $campos['CategoriaDescripcion'];?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Icono *</label>
                                  <input class="form-control" type="text" name="icono-up" required="" maxlength="45">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Vigencia *</label>
                                  <select class="form-control" required="" name="vigencia">
                                      <option value="1" <?php if($campos['CategoriaVigencia']==1){echo 'selected';}?>>Vigente</option>
                                      <option value="0" <?php if($campos['CategoriaVigencia']==0){echo 'selected';}?>>No Vigente</option>
                                  </select>
                                  <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div>
                        </fieldset>
                        <br>
                        <p class="text-center" style="margin-top: 10px;">
                          <button type="submit" class="boton-actualizar"><i class="fas fa-edit"></i> Actualizar</button>
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