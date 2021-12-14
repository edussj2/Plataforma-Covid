
        <section class="pb-4">
          <div class="container">
              <div class="row mb-5">
<?php
 $fechaActual=date('Y-m-d');
  $datos = explode("/", $_GET['views']);
  require_once "./controladores/conferenciaControlador.php";
  $clasAdmin = new conferenciaControlador();

  $filesA = $clasAdmin->datos_conferencia_controlador("Unico",$datos[1]);

  if($filesA->rowCount()==1){
    $campos = $filesA->fetch();
    require_once "./controladores/ponenteControlador.php";
    $classCta = new ponenteControlador();
    $dataCta = $classCta->datos_ponente_controlador(mainModel::encryption($campos['idPonente']));
    $camposPon = $dataCta->fetch();

    require_once "./controladores/conferenciaControlador.php";
    $classdetalle = new conferenciaControlador();
    $datadetalle = $classdetalle->datos2_detalle_controlador(mainModel::encryption($campos['idConferencia']));
    $camposdetalle = $datadetalle->rowCount();
?>  
                  <!-- Contenido-->
                  <div class="col-lg-8 mb-3">
                      <!-- Indice-->
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light border-dc">
                          <li class="breadcrumb-item"><a href="<?php echo SERVERURL;?>conferencias/" class="enlace-texto-negro"><i class="fas fa-video"></i> Conferencias</a></li>
                          <li class="breadcrumb-item active" aria-current="page"><?php echo $campos['ConferenciaFecha'];?></li>
                        </ol>
                      </nav>

                      <!-- Conferencia -->
                      <div class="contenedor-conferencia-total bg-light border-dc">
                        <div class="contenedor-imagen-conferencia-total">
                          <img src="<?php echo SERVERURL;?>adjuntos/conferencias/<?php echo $campos['ConferenciaImagen'];?>" alt="" class="imagen-conferencia-total">
                        </div>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="tema-conferencia-total">
                              <h5><?php echo $campos['ConferenciaTema'];?></h5>
                            </div>
                            <div class="detalles-conferencia-total">
                              <ul>
                                <li><?php echo $camposPon['PonenteNombres'];?> <i class="fas fa-user-tie"></i></span></li>
                                <li><?php echo $campos['ConferenciaFecha'];?><span><i class="far fa-calendar-alt"></i></span></li>
                                <li><?php echo $camposdetalle ?> asistentes<span><i class="fas fa-users"></i></span></li>
                              </ul>
                            </div>
                          </div>
                          <div class="col-lg-8">
                            <h2 class="titulo-conferencia-total"><?php echo $campos['ConferenciaTitulo'];?></h2>
                            <p><?php echo $campos['ConferenciaDescripcion'];?></p>
                          </div>
                        </div>
                        <div class="row mt-2 m-3">
                          <div class="col-lg-12">
                          <?php
                          if($_SESSION['tipo_unprg']=="Usuario"){
                            require_once "./controladores/conferenciaControlador.php";
                            $detalle = new conferenciaControlador();
                            $id=$_SESSION['id_unprg'];
                            $contar = $detalle->datos_detalle_controlador($id,$datos[1]);

                            if($contar->rowCount()==0){
                          ?>
                          <div class="d-flex justify-content-center align-items-center pt-2 pb-2">
                              <form class="FormularioAjax" data-form="save" action="<?php echo SERVERURL; ?>ajax/conferenciaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="usuarioD-reg" value="<?php echo mainModel::encryption( $_SESSION['id_unprg']);?>">
                                <input type="hidden" name="conferenciaD-reg" value="<?php echo $datos[1];?>">
                                <input type="hidden" name="fechaD-reg" value="<?php echo $fechaActual;?>">
                                <button type="submit" class="btn btn-primary">Participar <i class="fas fa-user-check"></i></button>
                                <div class="RespuestaAjax"></div>
                              </form>
                            </div>
                          <?php
                            }else{
                          ?>
                              <div class="border rounded w-50 mx-auto p-3 text-center mt-2 mb-3 link">
                                  <p class="m-0 text-center font-weight-bold">Link:</p>
                                  <a href="<?php echo $campos['ConferenciaEnlace'];?>" target="_blank"><?php echo $campos['ConferenciaEnlace'];?></a>
                              </div>
                              <div class="alert alert-success alert-dismissible fade show mt-3 mb-2 text-center" role="alert">
                                <i class="fas fa-check-circle"></i> Participación registrada.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                          <?php } ?>
                            
                          <?php
                          }else{
                          ?>
                            <div class="alert alert-info alert-dismissible fade show mt-3 mb-2 text-center" role="alert">
                              <i class="fas fa-check-circle"></i> Los administradores no pueden participar.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                          <?php } ?> 
                          </div>
                        </div>
                        <hr class="m-0">
                        <small class="float-right p-1 text-secondary"><?php echo $fechaActual;?></small>
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
                  <!-- Enlaces izquierda-->
                  <div class="col-lg-4 mb-4">
                    <aside class="single_sidebar_widget border-dc">
                      <h3 class="widget_title"><i class="far fa-calendar-check"></i> Próximas</h3>
                        <?php
                          require_once "./controladores/conferenciaControlador.php";

                          $insProx = new conferenciaControlador();

                          echo $insProx->futuros_eventos_controlador(2,$datos[1]);  
                      ?>
                    </aside>
                    <aside class="single_sidebar_widget instagram_feeds border-dc">
                      <h4 class="widget_title"><i class="fas fa-user-nurse"></i> Especialistas</h4>
                      <ul class="instagram_row flex-wrap">
                      <?php
                        require_once "./controladores/especialistaControlador.php";

                        $insespecialista = new especialistaControlador();

                        echo $insespecialista->lista_corta_especialista_controlador(6);  
                      ?> 
                      </ul>
                    </aside>
                  </div>

              </div>
          </div>
        </section> 
