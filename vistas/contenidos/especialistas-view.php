<!-- Presentacion-->
        <section class="contenido-presentacion">
          <div class="container">
            <div class="row">
              <div class="col-lg-8 presentacion">
                <h1 class="font-weight-bold mb-0">Especialistas</h1>
                <p class="lead text-muted">Conoce a nuestros especialistas y ponte en contacto con ellos
                </p>
              </div>
              <div class="col-lg-4 d-flex align-items-center">
                <a href="#" class="btn btn-primary w-75 mx-auto"><i class="fas fa-hospital-user"></i> Participar</a>
              </div>
            </div>
          </div>
        </section>
        <!-- Presentacion-->

        <!-- Contenido Neto-->
        <section class="pb-5">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12 mb-5">
                      <div class="contenedor-especialistas mb-5">
                        <div class="container-fluid">
                          <div class="panel panel-info shadow">
                            <div class="panel-heading">
                              <h3 class="panel-title"><i class="fas fa-list"></i> &nbsp; LISTA DE ESPECIALISTAS</h3>
                            </div>
                            <div class="panel-body">
                            <?php 
                              require_once "./controladores/especialistaControlador.php";
                              $insespecialista = new especialistaControlador();
                              $pagina = explode("/", $_GET['views']);
                              echo $insespecialista->paginador_especialista_controlador($pagina[1],10,$_SESSION['privilegio_unprg'],"");
                         
                            ?>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
        </section>
        <!-- Contenido Neto-->