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
           Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
          </p>
        </div>

        <div class="container-fluid">
          <ul class="listado-regresar">
            <li>
              <a href="../../../<?php SERVERURL; ?>adminLista/" class="enlace-lista">
                <i class="fas fa-arrow-circle-left"></i> REGRESAR
              </a>
            </li>
          </ul>
        </div>
<?php
  $datos = explode("/", $_GET['views']);
  require_once "./controladores/administradorControlador.php";
  $clasAdmin = new administradorControlador();

  $filesA = $clasAdmin->datos_administrador_controlador("Unico",$datos[2]);

  if($filesA->rowCount()==1){
    $campos = $filesA->fetch();
    if(1 != $_SESSION['privilegio_unprg']){
      echo $lc->forzar_cierre_sesion_controlador();		
    }
?>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mb-5">
              <div class="contenedor-paneles mb-5">
                <div class="container-fluid">
                  <div class="panel panel-actualizar shadow">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR ADMINISTRADOR</h3>
                    </div>
                    <div class="panel-body">
                      <form action="<?php echo SERVERURL;?>ajax/administradorAjax.php" method="POST" data-form="update" class="needs-validation FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="codigo2-up" value="<?php echo $datos[2];?>">
                        <fieldset>
                          <legend><i class="far fa-id-badge"></i> &nbsp; Información personal</legend>
                          <div class="container-fluid pt-2">
                            <div class="row">

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>DNI *</label>
                                  <input pattern="[0-9-]{1,9}" class="form-control" value="<?php echo $campos['AdminDNI'];?>" type="text" name="dni2-up" required maxlength="8" minlength="8">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Nombres *</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" class="form-control" value="<?php echo $campos['AdminNombre'];?>" type="text" name="nombres2-up" required="" maxlength="80">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Apellido Paterno *</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" value="<?php echo $campos['AdminApellidoPaterno'];?>" type="text" name="paterno2-up" required="" maxlength="50">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Apellido Materno *</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" value="<?php echo $campos['AdminApellidoMaterno'];?>" type="text" name="materno2-up" required="" maxlength="50">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Teléfono</label>
                                  <input pattern="[0-9+]{1,15}" class="form-control" value="<?php echo $campos['AdminTelefono'];?>" type="text" name="telefono2-up" maxlength="10" minlength="6">
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
                                        <input type="radio" name="optionsGenero2-up" id="optionsRadios1" value="Masculino" <?php if($campos['AdminGenero']=="Masculino"){echo 'checked=""' ;} ?>>
                                        <i class="fas fa-mars"></i> &nbsp;Masculino
                                      </label>
                                    </div>
                                    <div class="radio radio-primary">
                                      <label>
                                        <input type="radio" name="optionsGenero2-up" id="optionsRadios2" value="Femenino" <?php if($campos['AdminGenero']=="Femenino"){echo 'checked=""' ;} ?>>
                                        <i class="fas fa-venus"></i> &nbsp;Femenino
                                      </label>
                                    </div>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Dirección *</label>
                                  <textarea name="direccion2-up" class="form-control" rows="1" maxlength="100"><?php echo $campos['AdminDireccion'];?></textarea>
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Descripción *</label>
                                  <textarea name="descripcion2-up" class="form-control" rows="3" maxlength="400"><?php echo $campos['AdminDescripcion'];?></textarea>
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Vigencia *</label>
                                  <select class="form-control" required="" name="vigencia-up">
                                      <option value="1">Vigente</option>
                                      <option value="0">No Vigente</option>
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
                          <button type="submit" class="boton-actualizar"><i class="fas fa-edit"></i> Actualizar</button>
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
<?php 
  }else{
?>
    <div class="alert alert-dimissible alert-warning text-center border mt-3">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
			<h4>!LO SENTIMOS!</h4>
			<p>No pudimos mostrar la información buscada</p>
	  </div>
 <?php   
  }
 ?>       
      </div>
    </div>
  </div>
</section> 