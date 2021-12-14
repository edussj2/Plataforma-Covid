<?php
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>        
        <section class="pb-4">   
          <div class="container">
              <div class="row mb-5">
                <div class="contenedor-formularios mb-2">
                  <!-- Page header -->
                  <div class="full-box page-header">
                    <hr>
                    <h3 class="text-left">
                      <i class="fas fa-list-ol"></i> &nbsp; Lista de Participantes &nbsp;<small>Conferencia</small>
                    </h3>
                    <p class="text-justify">
                        Lista de participantes que se han registrado en las conferencias respectivas.
                    </p>
                </div>

                <div class="container-fluid">
                    <ul class="listado-panel">
                        <li>
                            <a href="<?php echo SERVERURL; ?>participantesCoferencia/" class="enlace-lista activo1">
                            <i class="far fa-list-alt"></i> &nbsp; LISTADO
                            </a>
                        </li>
                    </ul>
                </div>
                <?php 
                    if(!isset($_SESSION['busqueda_conferencia']) && empty($_SESSION['busqueda_conferencia'])):
                  ?>
                  <div class="container pt-5 pb-5 shadow mb-5 mt-3" style="width: 92%;">
                    <form action="<?php echo SERVERURL;?>ajax/buscadorAjax.php" method="POST" data-form="buscar" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <p class="text-center lead">¿Que conferencia buscando?</p>
                        <div class="form-row align-items-center justify-content-center">
                          <div class="col-sm-7 my-1">
                            <label class="sr-only" for="inlineFormInputGroupUsername">Titulo Coferencia</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user-cog"></i></div>
                              </div>
                              <select name="busqueda_conferencia" class="form-control" required="">
                                    <option value="-1">Seleccione una conferencia</option>
                                     <?php 
                                         require_once "./controladores/conferenciaControlador.php";

                                        $insConferencia = new conferenciaControlador();

                                        $Conferencia = $insConferencia->datos_conferencia_controlador("Select",0);
                                              while ($rowD = $Conferencia->fetch()) {
                                                          echo '<option value="'.$rowD['idConferencia'].'">'.$rowD['ConferenciaTitulo'].'</option>';
                                               }
                                    ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-auto my-1">
                            <button type="submit" class="boton-buscar"><i class="fas fa-search"></i> BUSCAR</button>
                          </div>
                        </div>
		                    <div class="RespuestaAjax"></div>
                    </form>
                  </div>
                  <?php else: ?>
                  <div class="container pt-5 pb-5 shadow mb-5" style="width: 92%;">
                        <form action="<?php echo SERVERURL;?>ajax/buscadorAjax.php" method="POST" data-form="default" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                            <p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_conferencia'];?>”</strong></p>
                            <div class="row">
                                <input class="form-control" type="hidden" name="eliminar_busqueda_conferencia" value="1">
                                <div class="col-12">
                                    <p class="text-center">
                                        <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i>&nbsp; Eliminar búsqueda</button>
                                    </p>
                                </div>
                            </div>
                            <div class="RespuestaAjax"></div>
                        </form>
                  </div>
  
                
                  <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="contenedor-paneles mb-5">
                                <div class="container-fluid">
                                    <div class="panel panel-lista shadow">
                                      <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fas fa-list"></i> &nbsp; LISTA DE  PARTICIPANTES</h3>
                                      </div>
                                      <div class="panel-body">
                                        
                                      <?php

                                        require_once "./controladores/conferenciaControlador.php";
                                        $insconferencia2 = new conferenciaControlador(); 
                                        $pagina = explode("/", $_GET['views']);
                                        echo $insconferencia2->paginador2_conferencia_controlador($_SESSION['privilegio_unprg'],$_SESSION['busqueda_conferencia']);
                                      ?>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <?php endif; ?>
                  
                </div>

              </div>
          </div>
        </section>