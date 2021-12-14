<?php
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
    }
    $fechaActual = date('Y-m-d');
?>
<section class="pb-4">
  <div class="container">
    <div class="row mb-5">
      <div class="contenedor-formularios mb-2">
        <!-- Page header -->
          <div class="full-box page-header">
              <hr>
              <h3 class="text-left">
                <i class="fas fa-video"></i> &nbsp; Conferencia &nbsp;<small>Gestión</small>
              </h3>
          </div>

          <div class="container-fluid">
            <ul class="listado-panel">
                <li>
                    <a href="<?php echo SERVERURL; ?>conferenciaLista/" class="enlace-lista">
                      <i class="far fa-list-alt"></i> &nbsp; LISTADO
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>conferenciaNuevo/" class="enlace-nuevo activo2">
                        <i class="fas fa-plus"></i> &nbsp; AGREGAR
                    </a>
                </li>
            </ul>
          </div>

          <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5">
                    <div class="contenedor-paneles mb-5">
                        <div class="container-fluid">
                            <div class="panel panel-agregar shadow">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><i class="fas fa-video"></i>&nbsp; NUEVA CONFERENCIA</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="needs-validation FormularioAjax" novalidate data-form="save" action="<?php echo SERVERURL; ?>ajax/conferenciaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data"> 
                                        <fieldset>
                                          <legend><i class="far fa-user-circle"></i> &nbsp; Datos del Ponente</legend>
                                          <div class="container-fluid pt-2">
                                            <div class="row">
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>Nombre Completo *</label>
                                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,120}" class="form-control" type="text" name="nombres-reg" required="" maxlength="120">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>Descripción *</label>
                                                  <textarea name="descripcion-reg" class="form-control" rows="2" maxlength="200"></textarea>
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </fieldset>
                                        <br>
                                        <fieldset>
                                          <legend><i class="fas fa-video"></i> &nbsp; Datos de la conferencia </legend>
                                          <div class="container-fluid pt-2">
                                            <div class="row">
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>Titulo *</label>
                                                  <input class="form-control" type="text" name="titulo-reg" required="" maxlength="120">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                              </div>
                                              </div>
                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                  <label>Tema *</label>
                                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="tema-reg" required="" maxlength="50">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                  <label>Fecha *</label>
                                                  <input class="form-control" type="date"  name="fecha-reg"  required="">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>Enlace *</label>
                                                  <input class="form-control" type="text" name="enlaceC-reg" required="" maxlength="150">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label for="exampleFormControlFile1">Imagen</label>
                                                  <input type="file" name="foto-reg"class="form-control-file border p-2" id="exampleFormControlFile1" accept=".jpg, .png, .jpeg" required="">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>
                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>Descripción general *</label>
                                                  <textarea name="descripciónGeneral-reg" class="form-control" rows="4" maxlength="800" required=""></textarea>
                                          
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </fieldset>
                                        <br>
                                        <p class="text-center" style="margin-top: 10px;">
                                          <button type="submit" class="boton-guardar"><i class="far fa-save"></i> Guardar</button>
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
      </div>
    </div>
  </div>
</section> 