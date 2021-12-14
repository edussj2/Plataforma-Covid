 <?php
  /*HECHO*/
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
                <i class="fas fa-graduation-cap"></i> &nbsp; Usuario &nbsp;<small>Cuenta</small>
              </h3>
              <p class="text-justify">
                  Registro de personas con sus respectivas cuentas para el uso dentro de la plataforma. Los campos que tienen este símbolo (*) son de carácter obligatorio.
              </p>
          </div>

          <div class="container-fluid">
            <ul class="listado-panel">
                <li>
                    <a href="<?php echo SERVERURL; ?>userLista/" class="enlace-lista">
                      <i class="far fa-list-alt"></i> &nbsp; LISTADO
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>userNuevo/" class="enlace-nuevo activo2">
                        <i class="fas fa-plus"></i> &nbsp; AGREGAR
                    </a>
                </li>
                <li>
                  <a href="<?php echo SERVERURL; ?>userBuscar/" class="enlace-buscar">
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
                        <h3 class="panel-title"><i class="fas fa-plus"></i>&nbsp; NUEVO USUARIO</h3>
                      </div>
                      <div class="panel-body">
                        <form class="needs-validation FormularioAjax" novalidate data-form="save" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
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
                                    <label>Fecha de Nacimiento *</label>
                                    <input class="form-control" type="date" max="<?php echo $fechaActual; ?>" name="fecha-reg"  required="">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label>Descripción</label>
                                    <textarea name="descripción-reg" class="form-control" rows="3" maxlength="400"></textarea>
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>
                
                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label for="exampleFormControlFile1">Foto del Usuario</label>
                                    <input type="file" name="foto-reg" style="overflow:hidden;" class="form-control-file border p-2" id="exampleFormControlFile1" accept=".jpg, .png, .jpeg">
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-12">
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

                              </div>
                            </div>
                          </fieldset>
                          <br>

                          <fieldset>
                            <legend><i class="fas fa-street-view"></i> &nbsp; Datos de Ubicación</legend>
                            <div class="container-fluid pt-2">
                              <div class="row">

                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>Departamento *</label>
                                    <select name="cboDepartamento" id="cboDepartamento" class="form-control" required="">
                                    <option value="-1">Seleccione un Departamento</option>
                                        <?php 
                                          require_once "./controladores/departamentoControlador.php";

                                          $insDepartamento = new departamentoControlador();

                                          $departamento = $insDepartamento->datos_departamento_controlador("Select",0);
                                          while ($rowD = $departamento->fetch()) {
                                            echo '<option value="'.$rowD['idDepartamento'].'">'.$rowD['DepartamentoDescripcion'].'</option>';
                                          }
                                        ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>Provincia *</label>
                                    <select name="cboProvincia" id="cboProvincia"  class="form-control" required="">
                                        <option value="-1">Seleccione una Provincia</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-4">
                                  <div class="form-group">
                                    <label>Distrito *</label>
                                    <select name="cboDistrito" id="cboDistrito" class="form-control" required="">
                                      <option value="-1">Seleccione un Distrito</option>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label>Dirección *</label>
                                    <input type="text" name="direccion-reg" class="form-control" required="">
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
                            <legend><i class="fas fa-school"></i> &nbsp; Datos en la Universidad</legend>
                            <div class="container-fluid pt-2">
                              <div class="row">

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Facultad *</label>
                                    <select name="cboFacultad" id="cboFacultad" class="form-control" required="">
                                      <option value="-1">Seleccione una facultad</option>
                                        <?php 
                                          require_once "./controladores/facultadControlador.php";

                                          $insFacultad = new facultadcontrolador("Select",0);

                                          $Facultad = $insFacultad->datos_facultad_controlador("Select",0);
                                          while ($rowD = $Facultad->fetch()) {
                                            echo '<option value="'.$rowD['idFacultad'].'">'.$rowD['FacultadDescripcion'].'</option>';
                                          }
                                        ?>
                                    </select>
                                  </div>
                                </div>

                                <div class="col-lg-6">
                                  <div class="form-group">
                                    <label>Escuela *</label>
                                    <select name="cboEscuela" id="cboEscuela"  class="form-control" required="">
                                      <option value="-1">Seleccione una Escuela</option>
                                    </select>
                                    <div class="invalid-feedback">
                                      Complete el campo correctamente.
                                    </div>
                                  </div>
                                </div>

                                <div class="col-lg-12">
                                  <div class="form-group">
                                    <label>Tipo de usuario *</label>
                                    <select class="form-control" required="" name="tipo-reg">
                                        <option value="Docente">Docente</option>
                                        <option value="Alumno">Alumno</option>
                                    </select>
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
                                    <label>Correo Institucional*</label>
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