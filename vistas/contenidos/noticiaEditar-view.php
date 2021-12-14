<?php
  /* HECHO */
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
  $fechaActual = date('Y-m-d');
?>        
<section class="pb-4">
  <div class="container">
    <div class="row mb-5">
      <div class="contenedor-formularios mb-2">

        <div class="full-box page-header">
          <hr>
          <h3 class="text-left">
              <i class="far fa-newspaper"></i> &nbsp; Noticia &nbsp;<small>Gestión</small>
          </h3>
          <p class="text-justify">
              Lista de noticias  ordenadas por categoría(Nacionales,locales e internacionales), con sus respectivas opciones según el privilegio de la cuenta.
          </p>
        </div>

        <div class="container-fluid">
          <ul class="listado-regresar">
            <li>
              <a href="../../<?php SERVERURL; ?>noticiaLista/" class="enlace-lista">
                <i class="fas fa-arrow-circle-left"></i> REGRESAR
              </a>
            </li>
          </ul>
        </div>
<?php
    $datos = explode("/", $_GET['views']);
    require_once "./controladores/noticiaControlador.php";
    $clasAdmin = new noticiaControlador();

    $filesA = $clasAdmin->datos_noticia_controlador("Unico",$datos[1]);

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

                  <div class="panel panel-actualizar shadow ">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR NOTICIA</h3>
                    </div>
                    <div class="panel-body">
                      <form action="<?php echo SERVERURL;?>ajax/noticiaAjax.php" method="POST" data-form="update" class="needs-validation FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="codigo-up" value="<?php echo $datos[1];?>">
                        
                        <fieldset>
                          <legend><i class="far fa-id-badge"></i> &nbsp; Datos Generales </legend>
                          <div class="container-fluid pt-2">
                            <div class="row">

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Titulo *</label>
                                  <input class="form-control" type="text" name="titulo-up" required="" maxlength="120" value="<?php echo $campos['NoticiaTitulo']; ?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Fecha *</label>
                                  <input class="form-control" type="date"  name="fecha-up"  required="" value="<?php echo $campos['NoticiaFecha']; ?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Categoría</label>
                                  <select name="categoria-up" class="form-control" required="">
                                    <option value="0">Seleccione una categoria</option>
                                      <?php 
                                        require_once "./controladores/categoriaControlador.php";

                                        $insFacultad = new categoriaControlador();

                                        $Facultad = $insFacultad->datos_categoria_controlador("Select",0);
                                        while ($rowD = $Facultad->fetch()) {
                                          echo '<option value="'.$rowD['idCategoria'].'">'.$rowD['CategoriaDescripcion'].'</option>';
                                        }
                                      ?>
                                  </select>
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Enlace *</label>
                                  <input class="form-control" type="text" name="enlace-up" required="" maxlength="150" value="<?php echo $campos['NoticiaLink']; ?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Párrafo 1 *</label>
                                  <textarea name="noticia1-up" class="form-control" required="" rows="5"><?php echo $campos['NoticiaDescripcion']; ?></textarea>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Párrafo 2 *</label>
                                  <textarea name="noticia2-up" class="form-control" required="" rows="5"><?php echo $campos['NoticiaDescripcion2']; ?></textarea>
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

                  <div class="panel panel-info shadow mt-4">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR IMAGEN</h3>
                    </div>
                    <div class="panel-body">
                      <div class="imagen-actual">
                        <h6>Imagen Actual</h6>
                        <div class="imagen">
                        <?php if($campos['NoticiaImagen']=="nulo"){
                          echo '<div class="ml-4 w-100 alert alert-primary" role="alert">
                                  Foto vacía.
                                </div>';
                        }else{
                        ?>
                          <img src="<?php echo SERVERURL; ?>adjuntos/noticias/<?php echo $campos['NoticiaImagen']?>" alt="">
                        <?php } ?>
                        </div>
                      </div>
                      <form class="form-imagen FormularioAjax needs-validation" action="<?php echo SERVERURL;?>ajax/noticiaAjax.php" method="POST" data-form="update"  autocomplete="off" enctype="multipart/form-data">
                        <label>Imagen Nueva</label>
                        <input type="hidden" name="codigo2-up" value="<?php echo $datos[1];?>">
                        <input type="file" id="archivoInput" name="foto2-up" placeholder="Cargue archivo" onchange="return validarExt()" required="">
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