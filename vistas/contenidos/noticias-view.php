 <!-- HECHO -->
<section class="contenido-presentacion">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 presentacion">
        <h1 class="font-weight-bold mb-0">Noticias</h1>
        <p class="lead text-muted">Revisa las últimas noticias positivas del Covid-19</p>
      </div>
      <div class="col-lg-4 d-flex align-items-center">
        <a href="#" class="btn btn-primary w-75 mx-auto" data-toggle="modal" data-target="#ModalNoticia"><i class="fas fa-plus"></i> Agregar</a>
        <div class="modal fade" id="ModalNoticia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Noticia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form class="needs-validation FormularioAjax" novalidate data-form="save" action="<?php echo SERVERURL; ?>ajax/noticiaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data"> 
                      <div class="container-fluid pt-2">
                        <div class="row">

                          <div class="col-lg-12">
                            <div class="form-group">
                              <label>Titulo *</label>
                              <input class="form-control" type="text" name="titulo2-reg" required="" maxlength="120">
                              <div class="invalid-feedback">
                                Complete el campo correctamente.
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Fecha *</label>
                              <input class="form-control" type="date"  name="fecha2-reg"  required="">
                              <div class="invalid-feedback">
                                Complete el campo correctamente.
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-6">
                            <div class="form-group">
                              <label>Categoría</label>
                              <select name="categoria2-reg" class="form-control" required="">
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
                              <input class="form-control" type="text" name="enlace2-reg" required="" maxlength="150">
                              <div class="invalid-feedback">
                                Complete el campo correctamente.
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-12">
                            <div class="form-group">
                              <label for="exampleFormControlFile1">Imagen</label>
                              <input type="file" name="foto2-reg"class="form-control-file border p-2" id="exampleFormControlFile1" accept=".jpg, .png, .jpeg" required="" style="overflow:hidden;">
                              <div class="invalid-feedback">
                                Complete el campo correctamente.
                              </div>
                            </div>
                          </div>

                          <div class="col-lg-12">
                            <div class="form-group">
                              <label>Párrafo 1 *</label>
                              <textarea name="noticia3-reg" class="form-control" required="" rows="5"></textarea>
                            </div>
                          </div>

                          <div class="col-lg-12">
                            <div class="form-group">
                              <label>Párrafo 2 *</label>
                              <textarea name="noticia4-reg" class="form-control" required="" rows="5"></textarea>
                            </div>
                          </div>

                        </div>
                      </div>

                    <p class="text-center" style="margin-top: 10px;">
                      <button type="submit" class="boton-guardar"><i class="far fa-save"></i> Registrar</button>
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
</section>

<section class="pb-5">
  <div class="container">
    <div class="row pb-5 mb-5">
        
        <div class="col-lg-8 my-1 mb-1">
            <?php
            require "./controladores/noticiaControlador.php";

            $insnoticia = new noticiaControlador();
            $pagina = explode("/", $_GET['views']);
            echo $insnoticia->total_noticias_controlador($pagina[2],8,$pagina[1]);  
          ?>     
        </div>

        <!-- Enlaces izquierda-->
        <div class="col-lg-4 my-1">
        
          <!-- Clasificacion-->
          <div class="card rounded-0 mb-2">
              <div class="card-header bg-light">
                <h6 class="font-weight-bold mb-0">Clasificación</h6>
              </div>
              <div class="card-body pt-2 pb-3">
              <?php
                  require_once "./controladores/categoriaControlador.php";

                  $inscategoria = new categoriaControlador();

                  echo $inscategoria->total_categorias_controlador();  
              ?> 
              </div>
          </div>

        </div>
    </div>
  </div>
</section> 