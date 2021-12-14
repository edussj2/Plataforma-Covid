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
                <i class="fas fa-university"></i> &nbsp; Escuela &nbsp;<small>Gestión</small>
            </h3>
          </div>

          <div class="container-fluid">
            <ul class="listado-panel">
                <li>
                    <a href="<?php echo SERVERURL; ?>escuelaLista/" class="enlace-lista">
                      <i class="far fa-list-alt"></i> &nbsp; LISTADO
                    </a>
                </li>
                <li>
                    <a href="<?php echo SERVERURL; ?>escuelaNuevo/" class="enlace-nuevo activo2">
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
                            <h3 class="panel-title"><i class="fas fa-plus"></i>&nbsp; NUEVA ESCUELA</h3>
                          </div>
                          <div class="panel-body">
                            <form class="needs-validation FormularioAjax" novalidate data-form="save" action="<?php echo SERVERURL; ?>ajax/escuelaAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                              
                              <fieldset>
                                <legend><i class="fas fa-server"></i> &nbsp; Datos</legend>
                                <div class="container-fluid pt-2">
                                  <div class="row">

                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label>Nombre de la Escuela *</label>
                                        <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" class="form-control" type="text" name="descripcion-reg" required="" maxlength="180">
                                        <div class="invalid-feedback">
                                          Complete el campo correctamente.
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label>Facultad *</label>
                                        <select name="facultad-reg" class="form-control" required="">
                                          <option value="0">Seleccione una Facultad</option>
                                          <?php 
                                            require_once "./controladores/facultadControlador.php";

                                            $insFacultad = new facultadControlador();

                                            $Facultad = $insFacultad->datos_facultad_controlador("Select",0);
                                            while ($rowD = $Facultad->fetch()) {
                                              echo '<option value="'.$rowD['idFacultad'].'">'.$rowD['FacultadDescripcion'].'</option>';
                                            }
                                          ?>
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