<?php
  /* HECHO */
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
                <i class="fas fa-user-cog"></i> &nbsp; Administrador &nbsp;<small>Cuenta</small>
              </h3>
              <p class="text-justify">
              Registro de personas de tipo administrador con sus respectivas cuentas para el uso dentro de la plataforma. Los campos que tienen este símbolo (*) son de carácter obligatorio.
              </p>
          </div>

          <div class="container-fluid">
            <ul class="listado-panel">
                <li>
                    <a href="<?php echo SERVERURL; ?>adminLista/" class="enlace-lista">
                      <i class="far fa-list-alt"></i> &nbsp; LISTADO
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>adminNuevo/" class="enlace-nuevo activo2">
                        <i class="fas fa-plus"></i> &nbsp; AGREGAR
                    </a>
                </li>
                <li>
                  <a href="<?php echo SERVERURL; ?>adminBuscar/" class="enlace-buscar">
                    <i class="fas fa-search"></i> &nbsp; BUSCAR
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
                        <h3 class="panel-title">
                          <i class="fas fa-plus"></i>&nbsp; NUEVO ADMINISTRADOR
                        </h3>
                      </div>
                      <div class="panel-body">
                      <form class="needs-validation FormularioAjax" novalidate data-form="save" action="<?php echo SERVERURL; ?>ajax/administradorAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <fieldset>
                          <legend><i class="far fa-id-badge"></i> &nbsp; Información personal</legend>
                            <div class="container-fluid pt-2">
                              <div class="row">

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>DNI *</label>
                                    <input pattern="[0-9-]{1,9}" class="form-control" type="text" name="dni-reg" required maxlength="8" minlength="8">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Nombres *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" class="form-control" type="text" name="nombres-reg" required="" maxlength="80">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Apellido Paterno *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="paterno-reg" required="" maxlength="50">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Apellido Materno *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="materno-reg" required="" maxlength="50">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Teléfono</label>
                                    <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-reg" maxlength="10" minlength="6">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Género *</label>
                                    <div class="radio radio-primary">
                                      <label>
                                        <input type="radio" name="optionsGenero" id="optionsRadios1" value="Masculino" checked="">
                                        <i class="fas fa-mars"></i> &nbsp;Masculino
                                      </label>
                                    </div>
                                    <div class="radio radio-primary">
                                      <label>
                                        <input type="radio" name="optionsGenero" id="optionsRadios2" value="Femenino">
                                        <i class="fas fa-venus"></i> &nbsp;Femenino
                                      </label>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label>Dirección *</label>
                                    <textarea name="direccion-reg" class="form-control" rows="1" maxlength="100"></textarea>
                                  </div>
                                </div>

                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label>Descripción </label>
                                    <textarea name="descripción-reg" class="form-control" rows="3" maxlength="400"></textarea>
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
                            <legend><i class="far fa-user-circle"></i> &nbsp; Datos de la cuenta</legend>
                            <div class="container-fluid pt-2">
                              <div class="row">

                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label>Correo *</label>
                                    <input class="form-control" type="email" name="email-reg" maxlength="80" required="">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Contraseña *</label>
                                    <input class="form-control" type="password" name="pass1-reg" required="" maxlength="16" minlength="6">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Repita la contraseña *</label>
                                    <input class="form-control" type="password" name="pass2-reg" required="" maxlength="16" minlength="6">
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