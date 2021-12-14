<!-- Presentacion-->
        <section class="contenido-presentacion">
          <div class="container">
            <div class="row">
              <div class="col-lg-8 presentacion">
                <h1 class="font-weight-bold mb-0">Conferencias</h1>
                <p class="lead text-muted">Revisa las próximas conferencias sobre el Covid-19
                </p>
              </div>
              <div class="col-lg-4 d-flex align-items-center">
                <a href="<?php echo SERVERURL;?>grabaciones/" class="btn btn-primary w-75 mx-auto"> <i class="fas fa-link"></i> Grabaciones</a>
              </div>
            </div>
          </div>
        </section>
        <!-- Presentacion-->

        <!-- Contenido Neto-->
        <section class="blog_area">
          <div class="container">
              <div class="row">
                  <div class="col-lg-12 mb-5">
                      <div class="blog_left_sidebar">
                        <?php
                            require "./controladores/conferenciaControlador.php";

                            $insconferencia = new conferenciaControlador();
                            echo $insconferencia->total_conferencias_controlador(10);  
                        ?>  
                      </div>
                  </div>
              </div>
          </div>
        </section>
        <!-- Contenido Neto-->