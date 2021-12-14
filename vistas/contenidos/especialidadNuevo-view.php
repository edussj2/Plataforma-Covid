 <?php
  /*HECHO*/
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>
<section class="pb-4">
  <div class="container">
    <div class="row mb-5">
      <div class="contenedor-formularios mb-2">

        <div class="full-box page-header">
          <hr>
          <h3 class="text-left">
              <i class="fas fa-stethoscope"></i> &nbsp; Especialidad &nbsp;<small>Gestión</small>
          </h3>
        </div>

        <div class="container-fluid">
          <ul class="listado-panel">
            <li>
              <a href="<?php echo SERVERURL; ?>especialidadLista/" class="enlace-lista">
                <i class="far fa-list-alt"></i> &nbsp; LISTADO
              </a>
            </li>
            <li>
              <a href="<?php echo SERVERURL; ?>especialidadNuevo/" class="enlace-nuevo activo2">
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
                      <h3 class="panel-title"><i class="fas fa-plus"></i>&nbsp; NUEVA ESPECIALIDAD</h3>
                    </div>
                    <div class="panel-body">
                      <form class="needs-validation FormularioAjax" novalidate data-form="save" action="<?php echo SERVERURL; ?>ajax/especialidadAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <fieldset>
                          <legend><i class="fas fa-server"></i> &nbsp; Datos</legend>
                          <div class="container-fluid pt-2">
                            <div class="row">

                              <div class="col-lg-8 mx-auto">
                                <div class="form-group">
                                  <label>Descripción *</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" class="form-control" type="text" name="descripcion-reg" required="" maxlength="180">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
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