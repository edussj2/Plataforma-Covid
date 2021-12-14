        <section class="contenido-presentacion" id="inicio">
            <div class="container">
              <div class="row">
                <div class="col-lg-8 presentacion">
                  <h1 class="font-weight-bold mb-0">Reportes</h1>
                  <p class="lead text-muted">Revisa las cifras actuales de recuperados, fallecidos e infectados del Covid-19</p>
                </div>
                <div class="col-lg-4 d-flex align-items-center">
                    <a href="../mapaCovid.php" class="btn btn-primary w-75 mx-auto"><i class="fas fa-globe-americas"></i> Ver mapa</a>
                </div>
              </div>
            </div>
        </section>
        <!-- Contenido Neto-->
        <section class="tarjetas-global">
            <div class="container">
                <h2 class="mt-3 mb-3 pb-1 text-center"><i class="fas fa-globe"></i> Reporte Global</h2>
                <div class="row">
                    <div class="contenedor-tarjetas-global">
                        <div class="tarjeta wow animate__animated animate__zoomIn">
                            <div class="numero" style="color:#DA7300;" id="nuevos-infectados">
                                
                            </div>
                            <p>Nuevos casos de <br>Infectados</p>
                        </div>
                        <div class="tarjeta wow animate__animated animate__zoomIn">
                            <div class="numero" style="color: #E90B00;" id="nuevos-fallecidos">
                                
                            </div>
                            <p>Nuevos casos de <br>Fallecidos</p>
                        </div>
                        <div class="tarjeta wow animate__animated animate__zoomIn">
                            <div class="numero" style="color: #00BC00;" id="nuevos-recuperados">
                                
                            </div>
                            <p>Nuevos casos de <br>Recuperados</p>
                        </div>
                        <div class="tarjeta wow animate__animated animate__zoomIn">
                            <div class="numero" style="color:#DA7300;" id="total-infectados">
                                
                            </div>
                            <p>Total de casos de <br>Infectados</p>
                        </div>
                        <div class="tarjeta wow animate__animated animate__zoomIn">
                            <div class="numero" style="color: #E90B00;" id="total-muertes">
                                
                            </div>
                            <p>Total de casos de <br>Fallecidos</p>
                        </div>
                        <div class="tarjeta wow animate__animated animate__zoomIn">
                            <div class="numero" style="color: #00BC00;" id="total-recuperados">
                                
                            </div>
                            <p>Total de casos de <br>Recuperados</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="tabla-general mb-5">
            <div class="container">
                <h2 class="mt-3 mb-3 pb-1 text-center"><i class="fas fa-chart-bar"></i> Reporte por países</h2>
                <div class="table-responsive p-3">
                  <small>Si estas en un dispositivo móvil, deslizate sobre la tabla para ver más detalles.</small>
                    <table class="table table-hover">
                        <caption>Fuente: https://api.covid19api.com/.</caption>
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Nombre del <br>País <i class="fas fa-globe-americas" style="color: #00bfd8;"></i></th>
                                <th><i class="fas fa-circle" style="color: #DA7300; font-size: 5px;"></i> Nuevos Infectados </th>
                                <th><i class="fas fa-circle" style="color: #E90B00; font-size: 5px;"></i> Nuevos Fallecidos</th>
                                <th><i class="fas fa-circle" style="color: #00BC00; font-size: 5px;"></i> Nuevos Recuperados</th>
                                <th><i class="fas fa-circle" style="color: #DA7300; font-size: 5px;"></i> Total Infectados</th>
                                <th><i class="fas fa-circle" style="color: #E90B00; font-size: 5px;"></i> Total Fallecidos</th>
                                <th><i class="fas fa-circle" style="color: #00BC00; font-size: 5px;"></i> Total Recuperados</th>
                            </tr>
                        </thead>
                        <tbody id="countries-wise" class="text-center cuerpo-tabla-general"></tbody>
                    </table>
                </div>
                <!-- *** Ir arriba *** -->
                <div class="go-top">
                  <a href="#" class="scroll-top"><i class="fas fa-angle-up"></i></a>
                </div>
                <!-- *** Fin Ir arriba *** -->
            </div>
        </section>
        