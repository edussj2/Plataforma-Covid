        <section>
            <div class="container">
                <div class="row pb-5">
                    <div class="col-lg-12 my-1 mb-4">
                        <!-- Indice-->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-light border">
                              <li class="breadcrumb-item"><a href="<?php echo SERVERURL; ?>conferencias/" class="enlace-texto-negro"><i class="fas fa-video"></i> Conferencias</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Enlaces</li>
                            </ol>
                        </nav>
                       <!-- Enlaces de grabaciones-->
                      <div class="enlaces-grabaciones">
                        <h3><i class="fas fa-paperclip"></i> Enlaces de las grabaciones</h3>
                        <div class="contenedor-tabla-conferencia">
                        <?php
                          require "./controladores/grabacionControlador.php";

                          $insgrabacion = new grabacionControlador();

                          echo $insgrabacion->tabla_grabaciones_controlador();  
                       ?> 
                          
                        </div>
                      </div>
                      <!-- Enlaces de grabaciones-->
                    </div>
                </div>
            </div>
        </section>