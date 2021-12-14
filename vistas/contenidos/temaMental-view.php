        <section class="pb-5">
            <div class="container mb-3">
                <div class="row">
                    <div class="col-lg-8 mb-3">
                        <div class="contenedor-tema-salud">
                            <h2>Estrés Financiero</h2>
                            <div class="detalles-tema">
                                <p>Si sientes estrés y ansiedad por la situación económica, al igual que tantas otras personas, lee estas recomendaciones de expertos para cuidar tu salud emocional.</p>
                                <div class="enlace">
                                    <a href="<?php echo SERVERURL;?>saludMental/" class="btn btn-primary">Ver más temas</a>
                                </div>
                            </div>
                            <div class="contenedor-consejos">
                            <?php
                             $fechaActual=date('Y-m-d');
                             $datos = explode("/", $_GET['views']);
                                require "./controladores/consejoControlador.php";

                                $insconsejo = new consejoControlador();

                                echo $insconsejo->total_consejos_controlador($datos[1]);  
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contenedor-contacta-especialista margin-top">
                          <h5>Habla con un Especialista</h5>
                          <p>Si tú o alguien que conoces buscan apoyo emocional, hay personas con las que puedes hablar. Habla con nuestro especialitas para que te puedan ayudar.</p>
                          <a href="#" class="btn btn-primary d-flex justify-content-center">Más Información</a>
                        </div>
                        <aside class="single_sidebar_widget instagram_feeds border-dc">
                            <h4 class="widget_title"><i class="fas fa-user-nurse"></i> Especialistas</h4>
                            <ul class="instagram_row flex-wrap">
                            <?php
                                    require "./controladores/especialistaControlador.php";

                                    $insespecialista = new especialistaControlador();

                                    echo $insespecialista->lista_corta_especialista_controlador(6);  
                                ?> 
                            </ul>
                          </aside>
                    </div>
                </div>
            </div>
        </section>