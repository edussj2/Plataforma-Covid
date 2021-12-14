<?php
  /* HECHO */
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
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
            </p>
        </div>

        <div class="container-fluid">
          <ul class="listado-regresar">
            <li>
              <a href="../../<?php SERVERURL; ?>especialistaLista/" class="enlace-lista">
                <i class="fas fa-arrow-circle-left"></i> REGRESAR
              </a>
            </li>
          </ul>
        </div>
<?php
    $datos = explode("/", $_GET['views']);
    require_once "./controladores/especialistaControlador.php";
    $clasAdmin = new especialistaControlador();

    $filesA = $clasAdmin->datos_especialista_controlador("Unico",$datos[1]);

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

                  <div class="panel panel-actualizar shadow mt-4">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR ESPECIALISTA</h3>
                    </div>
                    <div class="panel-body">
                      <form action="<?php echo SERVERURL;?>ajax/especialistaAjax.php" method="POST" data-form="update" class="needs-validation FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="codigo-up" value="<?php echo $datos[1];?>">
                        <fieldset>
                            <legend><i class="far fa-id-badge"></i> &nbsp; Datos Generales </legend>
                            <div class="container-fluid pt-2">
                                <div class="row">
                                
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nombres *</label>
                                            <input type="text" class="form-control" id="nombres" value="<?php echo $campos['EspecialistaNombres'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" name="nombres-up" required="" maxlength="80">
                                            <div class="invalid-feedback">
                                            Complete el campo correctamente.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Apellidos *</label>
                                            <input type="text" class="form-control" id="paterno" value="<?php echo $campos['EspecialistaApellidos'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" name="apellidos-up" required="" maxlength="50">
                                            <div class="invalid-feedback">
                                            Complete el campo correctamente.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Experiencia Laboral Resumida *</label>
                                            <input class="form-control" type="text" name="experiencia-up" required="" maxlength="120" value="<?php echo $campos['EspecialistaExperiencia'];?>">
                                            <div class="invalid-feedback">
                                            Complete el campo correctamente.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" maxlength="10" minlength="6" value="<?php echo $campos['EspecialistaCelular'];?>">
                                            <div class="invalid-feedback">
                                            Complete el campo correctamente.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Correo de contacto*</label>
                                            <input class="form-control" type="email" name="correo-up" maxlength="80" required="" value="<?php echo $campos['EspecialistaCorreo'];?>">
                                            <div class="invalid-feedback">
                                            Complete el campo correctamente.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Centro Laboral o de estudios *</label>
                                            <input class="form-control" type="text" name="centro-up" required="" maxlength="120" value="<?php echo $campos['EspecialistaCentro'];?>">
                                            <div class="invalid-feedback">
                                                Complete el campo correctamente.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Descripción *</label>
                                            <textarea name="descripción-up" class="form-control" rows="3" maxlength="400" required=""><?php echo $campos['EspecialistaDescripcion'];?></textarea>
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
                                            <select name="departamento-up" class="form-control" required="">
                                            <option value="0">Seleccione un Departamento</option>
                                                <?php 
                                                    require_once "./controladores/departamentoControlador.php";

                                                    $insDepartamento = new departamentoControlador();

                                                    $departamento = $insDepartamento->datos_departamento_controlador("Select","");
                                                    while ($rowD = $departamento->fetch()) {?>
                                                    <option value="<?php echo $rowD['idDepartamento']; ?>" <?php if($rowD['idDepartamento']==$campos['idDepartamento']) { echo 'selected'; } ?>><?php echo $rowD['DepartamentoDescripcion']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Especialidad *</label>
                                            <select name="categoria-up" class="form-control" required="">
                                            <option value="0">Seleccione una Especialidad</option>
                                            <?php 
                                                require_once "./controladores/especialidadControlador.php";

                                                $insespecialidad = new especialidadControlador();

                                                $especialidad = $insespecialidad->datos_especialidad_controlador("Select",0);
                                                while ($rowD = $especialidad->fetch()) {?>
                                                <option value="<?php echo $rowD['idEspecialidad']; ?>" <?php if($rowD['idEspecialidad']==$campos['idEspecialidad']) { echo 'selected'; } ?>><?php echo $rowD['EspecialidadDescripcion']; ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>  

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Link Social *</label>
                                            <input class="form-control" type="text" name="link-up" required="" maxlength="120" value="<?php echo $campos['EspecialistaLink'];?>">
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

                  <div class="panel panel-info shadow">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR IMAGEN</h3>
                    </div>
                    <div class="panel-body">
                      <div class="imagen-actual">
                        <h6>Imagen Actual</h6>
                        <div class="imagen">
                        <?php if($campos['EspecialistaFoto']=="nulo"){
                          echo '<div class="ml-4 w-100 alert alert-primary" role="alert">
                                  Foto vacía.
                                </div>';
                        }else{
                        ?>
                          <img src="<?php echo SERVERURL; ?>adjuntos/especialistas/foto/<?php echo $campos['EspecialistaFoto']?>" alt="">
                        <?php } ?>
                        </div>
                      </div>
                      <form class="form-imagen FormularioAjax needs-validation" action="<?php echo SERVERURL;?>ajax/especialistaAjax.php" method="POST" data-form="update"  autocomplete="off" enctype="multipart/form-data">
                        <label>Imagen Nueva</label>
                        <input type="hidden" name="codigo2-up" value="<?php echo $datos[1];?>" acc>
                        <input type="file" id="archivoInput" name="foto2-up" placeholder="Cargue archivo" onchange="return validarExt()" required="" accept=".jpg, .png, .jpeg">
                        <div class="elementos">
                          <label for="archivoInput">
                            <i class="fas fa-paperclip"></i>Agregar archivo(.png/.jpg/.jpeg)
                          </label>
                        </div>
                        <div id="visorArchivo" class="visor border-danger">
                        </div> 
                        <p class="text-center pb-2 mt-4 mb-3">
                          <button type="submit" class="boton-actualizar"><i class="fas fa-sync"></i> Actualizar</button>
                        </p>
                        <div class="RespuestaAjax"></div>
                      </form>
                    </div>
                  </div>

                  <div class="panel panel-info shadow mt-4">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR CV</h3>
                    </div>
                    <div class="panel-body">
                      <div class="border p-3 m-3">
                      <?php if($campos['EspecialistaFoto']=="nulo"){
                        echo '<div class="ml-4 w-100 alert alert-primary" role="alert">
                                Foto vacía.
                              </div>';
                      }else{
                      ?>
                        <a href="<?php echo SERVERURL; ?>adjuntos/especialistas/cv/<?php echo $campos['EspecialistaCV']?>" alt="" target="_blank"><i class="fas fa-file-pdf"></i> Documento Actual</a>
                      <?php } ?>
                      </div>
                      <form class="FormularioAjax needs-validation" action="<?php echo SERVERURL;?>ajax/especialistaAjax.php" method="POST" data-form="update"  autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="codigo4-up" value="<?php echo $datos[1];?>">
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="exampleFormControlFile1">Cargué su CV</label>
                            <input type="file" name="foto4-up"class="form-control-file border p-2" id="exampleFormControlFile1" accept=".PDF, .docx, .txt" required="">
                            <div class="invalid-feedback">
                              Complete el campo correctamente.
                            </div>
                          </div>
                        </div>
                        <p class="text-center pb-2 mt-4 mb-3">
                          <button type="submit" class="boton-actualizar"><i class="fas fa-sync"></i> Actualizar</button>
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