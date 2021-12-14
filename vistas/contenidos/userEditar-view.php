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
                <i class="fas fa-graduation-cap"></i> &nbsp; Usuario &nbsp;<small>Cuenta</small>
            </h3>
            <p class="text-justify">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
            </p>
        </div>

        <div class="container-fluid">
          <ul class="listado-regresar">
            <li>
              <a href="../../../<?php SERVERURL; ?>userLista/" class="enlace-lista">
                <i class="fas fa-arrow-circle-left"></i> REGRESAR
              </a>
            </li>
          </ul>
        </div>
<?php
    $datos = explode("/", $_GET['views']);
    require_once "./controladores/usuarioControlador.php";
    $clasAdmin = new usuarioControlador();

    $filesA = $clasAdmin->datos_usuario_controlador("Unico",$datos[2]);

    if($filesA->rowCount()==1){
        $campos = $filesA->fetch();

        if(1 != $_SESSION['privilegio_unprg']){
        echo $lc->forzar_cierre_sesion_controlador();		
        }

		//DISTRITO
		$distrito = $campos['idDistrito'];

		//HALLAR PROVINCIA
		require_once "./controladores/distritoControlador.php";
		$instancia1 = new distritoControlador();
		$resultado1 = $instancia1->datos_distrito_controlador("Unico",mainModel::encryption($distrito));
		$datos1 = $resultado1->fetch();
		$prov = $datos1['idProvincia'];

		//DEPARTAMENTO
		require_once "./controladores/provinciaControlador.php";
		$instancia2 = new provinciaControlador();
		$resultado2 = $instancia2->datos_provincia_controlador("Unico",mainModel::encryption($prov));
		$datos2 = $resultado2->fetch();
    $depa = $datos2['idDepartamento'];

    //ESCUELA
    $escuela = $campos['idEscuela'];

    //HALLAR FACULTAD
    require_once "./controladores/escuelaControlador.php";
		$instancia3 = new escuelaControlador();
		$resultado3 = $instancia3->datos_escuela_controlador("Unico",mainModel::encryption($escuela));
		$datos3 = $resultado3->fetch();
    $facu = $datos3['idFacultad'];
?>
        <div class="container">
          <div class="row">
            <div class="col-lg-12 mb-5">
              <div class="contenedor-paneles mb-5">
                <div class="container-fluid">

                  <div class="panel panel-info shadow">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR IMAGEN</h3>
                    </div>
                    <div class="panel-body">
                      <div class="imagen-actual">
                        <h6>Imagen Actual</h6>
                        <div class="imagen">
                        <?php if($campos['UsuarioFoto']=="nulo"){
                          echo '<div class="ml-4 w-100 alert alert-primary" role="alert">
                                  Foto vacía.
                                </div>';
                        }else{
                        ?>
                          <img src="<?php echo SERVERURL; ?>adjuntos/usuarios/<?php echo $campos['UsuarioFoto']?>" alt="">
                        <?php } ?>
                        </div>
                      </div>
                      <form class="form-imagen FormularioAjax needs-validation" action="<?php echo SERVERURL;?>ajax/usuarioAjax.php" method="POST" data-form="update"  autocomplete="off" enctype="multipart/form-data">
                        <label>Imagen Nueva</label>
                        <input type="hidden" name="codigo4-up" value="<?php echo $datos[2];?>">
                        <input type="file" id="archivoInput" name="foto4-up" placeholder="Cargue archivo" onchange="return validarExt()" required="">
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

                  <div class="panel panel-actualizar shadow mt-4">
                    <div class="panel-heading">
                      <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR USUARIO</h3>
                    </div>
                    <div class="panel-body">
                      <form action="<?php echo SERVERURL;?>ajax/usuarioAjax.php" method="POST" data-form="update" class="needs-validation FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="codigo3-up" value="<?php echo $datos[2];?>">
                        
                        <fieldset>
                          <legend><i class="far fa-id-badge"></i> &nbsp; Datos Generales </legend>
                          <div class="container-fluid pt-2">
                            <div class="row">

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Nombres*</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" class="form-control" type="text" name="nombres-up" required="" maxlength="70" value="<?php echo $campos['UsuarioNombres'];?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Apellido Paterno *</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="paterno-up" required="" maxlength="70" value="<?php echo $campos['UsuarioApellidoPaterno'];?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Apellido Materno *</label>
                                  <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" class="form-control" type="text" name="materno-up" required="" maxlength="50" value="<?php echo $campos['UsuarioApellidoMaterno'];?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Teléfono</label>
                                  <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" maxlength="10" minlength="6"  value="<?php echo $campos['UsuarioTelefono'];?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Fecha de Nacimiento *</label>
                                  <input class="form-control" type="date" max="<?php echo $fechaActual; ?>" name="fecha-up"  required=""  value="<?php echo $campos['UsuarioNacimiento'];?>">
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>
                              
                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Descripción</label>
                                  <textarea name="descripción-up" class="form-control" rows="3" maxlength="400"><?php echo $campos['UsuarioDescripcion'];?></textarea>
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
                                      <input type="radio" name="optionsGeneroup" id="optionsRadios1" value="Masculino" <?php if($campos['UsuarioGenero']=="Masculino"){echo 'checked=""';}?>>
                                      <i class="fas fa-mars"></i> &nbsp;Masculino
                                    </label>
                                  </div>
                                  <div class="radio radio-primary">
                                    <label>
                                      <input type="radio" name="optionsGeneroup" id="optionsRadios2" value="Femenino" <?php if($campos['UsuarioGenero']=="Femenino"){echo 'checked=""' ;} ?>>
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
                                  <select name="cboDepartamento2" id="cboDepartamento2" class="form-control" required="">
                                    <option value="-1">Seleccione un Departamento</option>
                                    <?php 
                                      require_once "./controladores/departamentoControlador.php";

                                      $instanciaDepa = new departamentoControlador();
                                      $resultadoDepa = $instanciaDepa->datos_departamento_controlador("Select",mainModel::encryption($depa));
                                        
                                      while($rowE = $resultadoDepa->fetch()) { ?>
                                      <option value="<?php echo $rowE['idDepartamento']; ?>" <?php if($rowE['idDepartamento']==$depa) { echo 'selected'; } ?>><?php echo $rowE['DepartamentoDescripcion']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label>Provincia *</label>
                                  <select name="cboProvincia2" id="cboProvincia2"  class="form-control" required="">
                                    <option value="-1">Seleccione una Provincia</option>
                                    <?php 
                                      require_once "./controladores/provinciaControlador.php";

                                      $instanciaProv = new provinciaControlador();
                                      $resultadoProv = $instanciaProv->datos_provincia_controlador("Select",mainModel::encryption($prov));
                      
                                      while($rowE = $resultadoProv->fetch()) { ?>
                                        <option value="<?php echo $rowE['idProvincia']; ?>" <?php if($rowE['idProvincia']==$prov) { echo 'selected'; } ?>><?php echo $rowE['ProvinciaDescripcion']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-4">
                                <div class="form-group">
                                  <label>Distrito *</label>
                                  <select name="cboDistrito2" id="cboDistrito2" class="form-control" required="">
                                    <option value="-1">Seleccione un distrito</option>
                                    <?php 
                                      require_once "./controladores/distritoControlador.php";

                                      $instanciaDistrito = new distritoControlador();
                                      $resultadoDistrito = $instanciaDistrito->datos_distrito_controlador("Select",mainModel::encryption($distrito));
                                          
                                      while($rowE = $resultadoDistrito->fetch()) { ?>
                                        <option value="<?php echo $rowE['idDistrito']; ?>" <?php if($rowE['idDistrito']==$distrito) { echo 'selected'; } ?>><?php echo $rowE['DistritoDescripcion']; ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Dirección *</label>
                                  <textarea name="direccion-up" class="form-control" rows="1" maxlength="100"><?php echo $campos['UsuarioDireccion'];?></textarea>
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
                                  <select name="cboFacultad2" id="cboFacultad2" class="form-control" required="">
                                  <option value="-1">Seleccione una Facultad</option>
                                  <?php 
                                    require_once "./controladores/facultadControlador.php";

                                    $instanciaFacu = new facultadControlador();
                                    $resultadoFacu = $instanciaFacu->datos_facultad_controlador("Select",mainModel::encryption($facu));
                                          
                                    while($rowE = $resultadoFacu->fetch()) { ?>
                                      <option value="<?php echo $rowE['idFacultad']; ?>" <?php if($rowE['idFacultad']==$facu) { echo 'selected'; } ?>><?php echo $rowE['FacultadDescripcion']; ?></option>
                                  <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group">
                                  <label>Escuela *</label>
                                  <select name="cboEscuela2" id="cboEscuela2"  class="form-control" required="">
                                      <option value="-1">Seleccione una Escuela</option>
                                      <?php 
                                        require_once "./controladores/escuelaControlador.php";

                                        $instanciaEscuela = new escuelaControlador();
                                        $resultadoEscuela = $instanciaEscuela->datos_escuela_controlador("Select",mainModel::encryption($escuela));
                                        
                                        while($rowE = $resultadoEscuela->fetch()) { ?>
                                          <option value="<?php echo $rowE['idEscuela']; ?>" <?php if($rowE['idEscuela']==$escuela) { echo 'selected'; } ?>><?php echo $rowE['EscuelaDescripcion']; ?></option>
                                      <?php } ?>
                                  </select>
                                  <div class="invalid-feedback">
                                    Complete el campo correctamente.
                                  </div>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="form-group">
                                  <label>Tipo de usuario *</label>
                                  <select class="form-control" required="" name="tipo-up">
                                      <option value="Docente" <?php if($campos['UsuarioTipo']=="Docente"){echo 'selected';}?>>Docente</option>
                                      <option value="Alumno"  <?php if($campos['UsuarioTipo']=="Alumno"){echo 'selected';}?>>Alumno</option>
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