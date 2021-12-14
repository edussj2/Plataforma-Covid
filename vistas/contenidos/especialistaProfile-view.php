<section class="pb-5">
  <div class="container">
    <div class="row mb-4">
      <div class="col-lg-12 mb-3">
<?php
  /* HECHO */
  $datos = explode("/", $_GET['views']);
  require_once "./controladores/especialistaControlador.php";
  $clasAdmin = new especialistaControlador();
  $fechaActual=date('Y-m-d');
  $filesA = $clasAdmin->datos_especialista_controlador("Unico",$datos[1]);

  if($filesA->rowCount()==1){
    $campos = $filesA->fetch();

    $idEspecialista = mainModel::encryption($campos['idEspecialista']);
      require_once "./controladores/especialidadControlador.php";
      $classCta = new especialidadControlador();
		  $dataCta = $classCta->datos_especialidad_controlador("Unico",mainModel::encryption($campos['idEspecialidad']));
      $camposCta = $dataCta->fetch();

      require_once "./controladores/departamentoControlador.php";
      $classDepa = new departamentoControlador();
		  $dataDepa = $classDepa->datos_departamento_controlador("Unico",mainModel::encryption($campos['idDepartamento']));
		  $camposDepa = $dataDepa->fetch();
?>
          <!-- Indice-->
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light border">
              <li class="breadcrumb-item"><a href="<?php echo SERVERURL;?>especialistas/" class="enlace-texto-negro"><i class="fas fa-user-md"></i> Especialistas</a></li>
              <li class="breadcrumb-item active" aria-current="page"><?php echo $campos['EspecialistaNombres']?></li>
            </ol>
          </nav>

          <!-- Perfil-Especialista -->
          <div class="contenedor-perfil-especialista mb-3">
              <div class="presentacion-especialista">
                  <div class="texto-especialista">
                      <h6>Hola</h6>
                      <h3>Mi Nombre es <?php echo $campos['EspecialistaNombres']?></h3>
                      <p> <?php echo $camposCta['EspecialidadDescripcion']?></p>
                      
                      <?php if($_SESSION['tipo_unprg']=="Usuario"){?>
                      <a href="#" data-toggle="modal" data-target="#atencion" class="btn btn-primary" target="_blank">Contáctame <i class="fab fa-telegram-plane"></i></a>
                      <div class="modal fade" id="atencion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-hand-holding-heart"></i> Cuentame tu problema</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <small>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Magnam, sunt! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis, esse.</small>
                              <br>
                            <form class="FormularioAjax" data-form="save" action="<?php echo SERVERURL; ?>ajax/atencionAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                              <input type="hidden" name="usuario-reg" value="<?php echo mainModel::encryption($_SESSION['id_unprg']);?>">
                              <input type="hidden" name="especialista-reg" value="<?php echo $idEspecialista;?>">
                              <input type="hidden" name="fecha-reg" value="<?php echo $fechaActual;?>">
                              <div class="form-group">
                                <label for="exampleFormControlTextarea1">Mensaje:</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="12" name="mensaje-reg"></textarea>
                              </div>
                              <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" checked="">
                                <label class="form-check-label" for="exampleCheck1">Mantener mis datos en privado</label>
                              </div>
                              <button type="submit" class="btn btn-success w-100">Enviar</button>
                              <div class="RespuestaAjax"></div>
                            </form>
                            </div>
                            <div class="modal-footer">
                              <small>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <?php }?>
                  </div>
                  <div class="foto-especialista">
                      <img src="<?php echo SERVERURL; ?>adjuntos/especialistas/foto/<?php echo $campos['EspecialistaFoto']?>" alt="" class="shadow">
                  </div>
                  <div class="enlaces">
                      <a href="<?php echo SERVERURL; ?>adjuntos/especialistas/certificado/<?php echo $campos['EspecialistaCertificado']?>" target="_blank" class="enlace-especialista" data-toggle="tooltip" data-placement="right" title="Certificado"><i class="fas fa-certificate"></i></a>
                      <a href="<?php echo SERVERURL; ?>adjuntos/especialistas/cv/<?php echo $campos['EspecialistaCV']?>" target="_blank" class="enlace-especialista" data-toggle="tooltip" data-placement="right" title="CV"><i class="fas fa-file-alt"></i></a>
                      <a href="<?php echo $campos['EspecialistaLink']?>" target="_blank" class="enlace-especialista" data-toggle="tooltip" data-placement="right" title="Linkedin"><i class="fab fa-linkedin-in"></i></a>
                  </div>
              </div>
          </div>
          <div class="contenedor-perfil2-especialista">
            <div class="sobre-mi-especialista">
              <div class="prim-fila">
                <div class="titulo">
                  <h4><span><i class="far fa-user"></i></span> Sobre mí</h4>
                </div>
                <div class="texto">
                  <p><?php echo $campos['EspecialistaDescripcion']?></p>
                </div>
              </div>
              <div class="seg-fila"> 
                <div class="slider-testimonios">
                  <h4><span><i class="far fa-comment-dots"></i></span> Testimonios</h4>
                  <div class="slider-container">
                      <div class="swiper-container card-slider">
                          <div class="swiper-wrapper">
                              
                              <!-- Slide -->
                              <?php
                                require "./controladores/testimonioControlador.php";

                                $instestimonio = new testimonioControlador();

                                echo $instestimonio->total_testimonio_controlador(5,$idEspecialista);  
                            ?> 
                              <!-- end of slide -->
    
                              
                          </div> <!-- end of swiper-wrapper -->
      
                          <!-- Add Arrows -->
                          <div class="swiper-button-next"></div>
                          <div class="swiper-button-prev"></div>
                          <!-- end of add arrows -->
      
                      </div> <!-- end of swiper-container -->
                  </div> 
                </div>
                <div class="datos-especialista shadow">
                  <div class="datos-contenedor ">
                    <div class="titulo">
                      <h4><span><i class="far fa-id-badge"></i></span>Información</h4>
                    </div>
                    <div class="texto">
                      <p><span><i class="fas fa-id-card-alt"></i> Nombres :</span> <?php echo $campos['EspecialistaNombres']?></p>
                      <p><span><i class="far fa-id-card"></i> Apellidos :</span> <?php echo $campos['EspecialistaApellidos']?></p>
                      <p><span><i class="fas fa-street-view"></i> Ubicación :</span> <?php echo $camposDepa['DepartamentoDescripcion']?></p>
                      <p><span><i class="fas fa-building"></i> Centro :</span> <?php echo $campos['EspecialistaCentro']?></p>
                      <p><span><i class="fas fa-user-graduate"></i> Especialidad :</span> <?php echo $camposCta['EspecialidadDescripcion']?></p>
                      <p><span><i class="fas fa-briefcase"></i> Experencia Laboral :</span> <?php echo $campos['EspecialistaExperiencia']?>.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="contenido-extra-especialista">
            <?php if($_SESSION['tipo_unprg']=="Usuario"){?>
              <a href="" class="btn btn-success" data-toggle="modal" data-target="#ModalTestimonio"><i class="fas fa-comment-medical"></i></a>
              <!-- Modal -->
              <div class="modal fade" id="ModalTestimonio" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ModalTestimonioLabel" aria-hidden="true">
                <div class="modal-dialog" style="font-family: 'Poppins',sans-serif;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="ModalTestimonioLabel" style="font-family: 'Poppins',sans-serif; font-weight: 600; color: #333;"><i class="fas fa-comment-medical"></i> Agregar Testimonio</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p style="color: #333;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab cumque aperiam temporibus. Esse ratione nostrum, quam reprehenderit nam nobis blanditiis!</p>
                      <form class="FormularioAjax" data-form="save" action="<?php echo SERVERURL; ?>ajax/testimonioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="usuarioT-reg" value="<?php echo mainModel::encryption( $_SESSION['id_unprg']);?>">
                        <input type="hidden" name="especialistaT-reg" value="<?php echo $idEspecialista;?>">
                        <input type="hidden" name="fechaT-reg" value="<?php echo $fechaActual;?>">
                        <div class="form-group">
                          <label for="TestimonioTextarea1">Testimonio :</label>
                          <textarea class="form-control" rows="3" name="testimonioT-reg"></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                          <input type="submit" class="btn btn-success" value="Registrar"></input>
                        </div> 
                        <div class="RespuestaAjax"></div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <small>Contribuye al crecimientos de la plataforma</small>
                    </div>
                  </div>
                </div>
              </div>
              <a href="" class="btn btn-danger" data-toggle="modal" data-target="#ModalQueja"><i class="fas fa-ban"></i></a>
              <!-- Modal -->
              <div class="modal fade" id="ModalQueja" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="ModalQuejaLabel" aria-hidden="true">
                <div class="modal-dialog" style="font-family: 'Poppins',sans-serif;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="ModalQuejaLabel" style="font-family: 'Poppins',sans-serif; font-weight: 600; color: #333;"><i class="fas fa-ban"></i> Agregar Queja</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p style="color: #333;">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab cumque aperiam temporibus. Esse ratione nostrum, quam reprehenderit nam nobis blanditiis!</p>
                      <form class="FormularioAjax" data-form="save" action="<?php echo SERVERURL; ?>ajax/quejaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="usuarioQ-reg" value="<?php echo mainModel::encryption( $_SESSION['id_unprg']);?>">
                        <input type="hidden" name="especialistaQ-reg" value="<?php echo $idEspecialista;?>">
                        <input type="hidden" name="fechaQ-reg" value="<?php echo $fechaActual;?>">
                        <div class="form-group">
                          <label for="QuejaTextarea1">Comentario de queja :</label>
                          <textarea class="form-control" name="quejaQ-reg" rows="3"></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                          <input type="submit" class="btn btn-danger" value="Registrar"></input>
                        </div> 
                        <div class="RespuestaAjax"></div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <small>Contribuye al crecimientos de la plataforma</small>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
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