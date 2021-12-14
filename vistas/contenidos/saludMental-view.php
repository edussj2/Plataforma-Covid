        <section class="contenido-presentacion">
            <div class="container">
              <div class="row">
                <div class="col-lg-10 presentacion">
                  <h1 class="font-weight-bold mb-0">Salud mental</h1>
                  <p class="lead text-muted">Consulta consejos para cuidar tu salud emocional o buscar ayuda para un amigo.
                 </p>
                </div>
              </div>
            </div>
        </section>
        <section class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mb-3">
                        <div class="contenedor-general-salud">
                            <div class="texto-presentacion">
                                <h3>Explorar Temas</h3>
                                <p>Consulta consejos y recursos de expertos para hacer frente a situaciones difíciles durante la pandemia de COVID-19.</p>
                            </div>
                            <div class="contenedor-temas">
                            <?php
                                require "./controladores/temaControlador.php";

                                $instema = new temaControlador();

                                echo $instema->total_temas_controlador();  
                            ?> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="contenedor-contacta-especialista">
                        <h5>Habla con un Especialista</h5>
                        <p>Si tú o alguien que conoces buscan apoyo emocional, hay personas con las que puedes hablar. Habla con nuestro especialitas para que te puedan ayudar.</p>
                        <a href="<?php echo SERVERURL; ?>especialistas/" class="btn btn-primary d-flex justify-content-center">Más Información</a>
                      </div>
                    </div>
                </div>
            </div>
        </section>