<?php
  /* HECHO*/
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
    }
    $fechaActual = date('Y-m-d');
?>
<section class="pb-4">
  <div class="container">
    <div class="row mb-5">
      <div class="contenedor-formularios mb-2">

          <div class="full-box page-header">
              <hr>
              <h3 class="text-left">
                <i class="fas fa-user-md"></i> &nbsp; Especialista &nbsp;<small>Gestión</small>
              </h3>
              <p class="text-justify">
              Registro de personas de tipo administrador con sus respectivas cuentas para el uso dentro de la plataforma. Los campos que tienen este símbolo (*) son de carácter obligatorio.
              </p>
          </div>

          <div class="container-fluid">
            <ul class="listado-panel">
                <li>
                    <a href="<?php echo SERVERURL; ?>especialistaLista/" class="enlace-lista">
                      <i class="far fa-list-alt"></i> &nbsp; LISTADO
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>especialistaNuevo/" class="enlace-nuevo activo2">
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
                                    <h3 class="panel-title"><i class="fas fa-plus"></i>&nbsp; NUEVO ESPECIALISTA</h3>
                                </div>
                                <div class="panel-body">
                                    <form class="needs-validation FormularioAjax" novalidate data-form="save" action="<?php echo SERVERURL; ?>ajax/especialistaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        <fieldset>
                                          <legend><i class="far fa-id-badge"></i> &nbsp; Datos Generales </legend>
                                          <div class="container-fluid pt-2">
                                            <div class="row">
                                            
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
                                                  <label>Apellidos *</label>
                                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="apellidos-reg" required="" maxlength="80">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                  <label>Experiencia Laboral Resumida *</label>
                                                  <input class="form-control" type="text" name="experiencia-reg" required="" maxlength="120">
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
                                                  <label>Correo de contacto*</label>
                                                  <input class="form-control" type="email" name="correo-reg" maxlength="80" required="">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                  <label>Centro Laboral o de estudios *</label>
                                                  <input class="form-control" type="text" name="centro-reg" required="" maxlength="120">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>Descripción *</label>
                                                  <textarea name="descripción-reg" class="form-control" rows="3" maxlength="400" required=""></textarea>
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
                                          <legend><i class="fas fa-street-view"></i> &nbsp; Datos Extras</legend>
                                          <div class="container-fluid pt-2">
                                            <div class="row">

                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                  <label>Departamento *</label>
                                                  <select name="departamento-reg" class="form-control" required="">
                                                  <option value="0">Seleccione un Departamento</option>
                                                      <?php 
                                                        require_once "./controladores/departamentoControlador.php";

                                                        $insDepartamento = new departamentoControlador();

                                                        $departamento = $insDepartamento->datos_departamento_controlador("Select","");
                                                        while ($rowD = $departamento->fetch()) {
                                                          echo '<option value="'.$rowD['idDepartamento'].'">'.$rowD['DepartamentoDescripcion'].'</option>';
                                                        }
                                                      ?>
                                                  </select>
                                                </div>
                                              </div>

                                              <div class="col-lg-6">
                                                <div class="form-group">
                                                  <label>Especialidad *</label>
                                                  <select name="categoría-reg" class="form-control" required="">
                                                  <option value="0">Seleccione una Especialidad</option>
                                                      <?php 
                                                        require_once "./controladores/especialidadControlador.php";

                                                        $insespecialidad = new especialidadControlador();

                                                        $especialidad = $insespecialidad->datos_especialidad_controlador("Select",0);
                                                        while ($rowD = $especialidad->fetch()) {
                                                          echo '<option value="'.$rowD['idEspecialidad'].'">'.$rowD['EspecialidadDescripcion'].'</option>';
                                                        }
                                                      ?>
                                                  </select>
                                                </div>
                                              </div>  

                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label>Link Social *</label>
                                                  <input class="form-control" type="text" name="link-reg" required="" maxlength="120">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label for="exampleFormControlFile1">Foto del Especialista</label>
                                                  <input type="file" name="foto-reg" style="overflow:hidden;" class="form-control-file border p-2" id="exampleFormControlFile1" accept=".jpg, .png, .jpeg" required="">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label for="exampleFormControlFile1">Certificado Imagen</label>
                                                  <input type="file" style="overflow:hidden;" name="certificado-reg"class="form-control-file border p-2" id="exampleFormControlFile1" accept=".jpg, .png, .jpeg" required="">
                                                  <div class="invalid-feedback">
                                                   Complete el campo correctamente.
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="col-lg-12">
                                                <div class="form-group">
                                                  <label for="exampleFormControlFile1">CV</label>
                                                  <input type="file" name="cv-reg" style="overflow:hidden;" class="form-control-file border p-2" id="exampleFormControlFile1" accept=".PDF, .docx, .txt" required="">
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