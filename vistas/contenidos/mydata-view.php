<!-- **************HECHO******************-->
<section class="pb-5">
  <div class="container">

    <div class="row">
      <div class="col-lg-12">
        <div class="contenedor-formularios mb-2">

          <div class="full-box page-header">
            <hr>
            <h3 class="text-left">
              <i class="fas fa-address-card"></i>  &nbsp; Mis Datos
            </h3>
            <p class="text-justify">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
            </p>
          </div>

        </div>
      </div>
    </div>

<?php 
	$datos = explode("/", $_GET['views']);
	/*---ADMINSITRADOR---*/
	if($datos[1]=="admin"){
		if($_SESSION['tipo_unprg'] != "Administrador"){
			echo $lc->forzar_cierre_sesion_controlador();
		}
			
		require_once "./controladores/administradorControlador.php";
		$clasAdmin = new administradorControlador();

		$filesA = $clasAdmin->datos_administrador_controlador("Unico",$datos[2]);

		if($filesA->rowCount()==1){
			$campos = $filesA->fetch();

			if($campos['CuentaCodigo']!= $_SESSION['codigo_cuenta_unprg']){
				echo $lc->forzar_cierre_sesion_controlador();		
			}
?>	
      <div class="row">
        <div class="col-12">
          <div class="formulario-mydata mb-5">
            <h3><i class="fas fa-info-circle"></i> Información General</h3>
            <form action="<?php echo SERVERURL;?>ajax/administradorAjax.php" method="POST" data-form="update" class="needs-validation FormularioAjax" autocomplete="off" enctype="multipart/form-data">
              
              <input type="hidden" name="codigo1-up" value="<?php echo $datos[2];?>">

              <div class="form-group row">
                <label for="dni" class="col-sm-2 col-form-label">DNI</label>
                <div class="col-sm-6">
                  <input type="text" name="dni1-up" class="form-control"  value="<?php echo $campos['AdminDNI'];?>" pattern="[0-9-]{1,9}" required maxlength="8" minlength="8">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                <div class="col-sm-6">
                  <input type="text" name="nombres1-up" class="form-control" id="nombres" value="<?php echo $campos['AdminNombre'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}"  required="" maxlength="80">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="paterno" class="col-sm-2 col-form-label">Apellido Paterno</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="paterno" value="<?php echo $campos['AdminApellidoPaterno'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" name="paterno1-up" required="" maxlength="50">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="materno" class="col-sm-2 col-form-label">Apellido Materno</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="materno"value="<?php echo $campos['AdminApellidoMaterno'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" name="materno1-up" required="" maxlength="50">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="telefono" value="<?php echo $campos['AdminTelefono'];?>" pattern="[0-9+]{1,15}" name="telefono1-up" maxlength="10" minlength="6">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                <div class="col-sm-6">
                  <textarea name="direccion1-up" id="direccion" rows="2" class="form-control w-100"><?php echo $campos['AdminDireccion'];?></textarea>
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-6">
                  <textarea name="descripcion1-up" id="descripcion" rows="3" class="form-control w-100"><?php echo $campos['AdminDescripcion'];?></textarea>
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Genero</label>
                <div class="col-sm-6">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="optionsGenero1-up" id="gridRadios1" value="Masculino" <?php if($campos['AdminGenero']=="Masculino"){echo 'checked=""' ;} ?>>
                    <label class="form-check-label" for="Masculino">
                      <i class="fas fa-mars"></i> &nbsp;Masculino
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="optionsGenero1-up" id="Femenino" value="Femenino" <?php if($campos['AdminGenero']=="Femenino"){echo 'checked=""' ;} ?>>
                    <label class="form-check-label" for="Femenino">
                      <i class="fas fa-venus"></i> &nbsp;Femenino
                    </label>
                  </div>
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <p class="text-center pb-2 mt-4 mb-5">
                  <button type="submit" class="boton-actualizar"><i class="fas fa-edit"></i> Actualizar</button>
              </p>
              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>
      </div>
<?php			
		}else{
?>
		  <div class="alert alert-dimissible alert-warning text-center border">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
				<h4>!LO SENTIMOS!</h4>
				<p>No pudimos mostrar la información buscada</p>
			</div>
<?php
    }
  /*---USUARIOS---*/
  }elseif($datos[1]=="user"){

    require_once "./controladores/usuarioControlador.php";
    $classusuario = new usuarioControlador();
    $filesC = $classusuario->datos_usuario_controlador("Unico",$datos[2]);

    if($filesC->rowCount()>=1){
      $campos = $filesC->fetch();

      if($campos['CuentaCodigo']!= $_SESSION['codigo_cuenta_unprg']){
        if($_SESSION['privilegio_coespe']<1 || $_SESSION['privilegio_coespe']>1){
          echo $lc->forzar_cierre_sesion_controlador();
        }
      }
?>
      <div class="row">
        <div class="col-12">
          <div class="formulario-mydata mb-3">
            <h3><i class="fas fa-info-circle"></i> Información General</h3>
            <form action="<?php echo SERVERURL;?>ajax/usuarioAjax.php" method="POST" data-form="update" class="FormularioAjax needs-validation" autocomplete="off" enctype="multipart/form-data">
              
              <input type="hidden" name="codigo1-up" value="<?php echo $datos[2];?>">
              
              <div class="form-group row">
                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" readonly id="nombres" value="<?php echo $campos['UsuarioNombres'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" name="nombres-up" required="" maxlength="80">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="paterno" class="col-sm-2 col-form-label">Apellido Paterno</label>
                <div class="col-sm-6">
                  <input type="text" readonly class="form-control" id="paterno" value="<?php echo $campos['UsuarioApellidoPaterno'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" name="paterno-up" required="" maxlength="50">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="materno" class="col-sm-2 col-form-label">Apellido Materno</label>
                <div class="col-sm-6">
                  <input type="text" readonly class="form-control" id="materno" value="<?php echo $campos['UsuarioApellidoMaterno'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" name="materno-up" required="" maxlength="50">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="telefono" value="<?php echo $campos['UsuarioTelefono'];?>" pattern="[0-9+]{1,15}" name="telefono1-up" maxlength="10" minlength="6">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                <div class="col-sm-6">
                  <textarea name="direccion1-up" id="direccion" rows="2" class="form-control w-100"><?php echo $campos['UsuarioDireccion'];?></textarea>
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                <div class="col-sm-6">
                  <textarea name="descripcion1-up" id="descripcion" rows="3" class="form-control w-100"><?php echo $campos['UsuarioDescripcion'];?></textarea>
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>
              <p class="text-center pb-2 mt-4 mb-5">
                  <button type="submit" class="boton-actualizar"><i class="fas fa-edit"></i> Actualizar</button>
              </p>
              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>
      </div>

      <div class="row pb-5">
        <div class="col-12">
          <div class="formulario-mydata">
            <h3><i class="far fa-image"></i> Imagen del usuario</h3>

            <div class="imagen-actual">
              <h6>Imagen Actual</h6>
              <div class="imagen">
                <?php if($campos['UsuarioFoto']=="nulo"){
                  echo '<div class="ml-4 w-100 alert alert-primary" role="alert">
                          No has actulizado tu foto
                        </div>';
                }else{
                ?>
                  <img src="<?php echo SERVERURL; ?>adjuntos/usuarios/<?php echo $campos['UsuarioFoto']?>" alt="">
                <?php } ?>
              </div>
            </div>

            <form class="form-imagen FormularioAjax needs-validation" action="<?php echo SERVERURL;?>ajax/usuarioAjax.php" method="POST" data-form="update"  autocomplete="off" enctype="multipart/form-data">
              
              <label>Imagen Nueva</label>
              <input type="hidden" name="codigo2-up" value="<?php echo $datos[2];?>">
              <input type="file" id="archivoInput" name="foto2-up" placeholder="Cargue archivo" onchange="return validarExt()" required="">
              
              <div class="elementos">
                <label for="archivoInput">
                  <i class="fas fa-paperclip"></i>Agregar archivo(.png/.jpg/.jpeg)
                </label>
              </div>

              <div id="visorArchivo" class="visor border-danger">
              </div> 

              <p class="text-center pb-2 mt-4 mb-3">
                <button type="submit" class="boton-actualizar"><i class="fas fa-sync"></i> Actualizar Foto</button>
              </p>
              <div class="RespuestaAjax"></div>

            </form>

          </div>
        </div>
      </div>
<?php
		}else{
?>
			<div class="alert alert-dimissible alert-warning text-center">
					<button type="button" class="close" data-dismiss="alert">x</button>	
				  <i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
					<h4>LO SENTIMOS!</h4>
					<p>No pudimos mostrar la información buscada</p>
			</div>	
<?php
		}
?>
<?php
/*---ESPECIALISTA---*/	
  }elseif($datos[1]=="especialista"){
    require_once "./controladores/especialistaControlador.php";
    $classespecialista = new especialistaControlador();
    $filesC = $classespecialista->datos_especialista_controlador("Unico",$datos[2]);

    if($filesC->rowCount()>=1){
      $campos = $filesC->fetch();

      if($campos['CuentaCodigo']!= $_SESSION['codigo_cuenta_unprg']){
        if($_SESSION['privilegio_coespe']<1 || $_SESSION['privilegio_coespe']>1){
          echo $lc->forzar_cierre_sesion_controlador();
        }
      }

?>
      <div class="row">
        <div class="col-12">
          <div class="formulario-mydata mb-3">
            <h3><i class="fas fa-info-circle"></i> Información General</h3>
            <form action="<?php echo SERVERURL;?>ajax/especialistaAjax.php" method="POST" data-form="update" class="FormularioAjax needs-validation" autocomplete="off" enctype="multipart/form-data">
              
              <input type="hidden" name="codigo-up" value="<?php echo $datos[2];?>">
              
              <div class="form-group row">
                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="nombres" value="<?php echo $campos['EspecialistaNombres'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,80}" name="nombres-up" required="" maxlength="80">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="paterno" class="col-sm-2 col-form-label">Apellidos</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" id="paterno" value="<?php echo $campos['EspecialistaApellidos'];?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,50}" name="apellidos-up" required="" maxlength="50">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="materno" class="col-sm-2 col-form-label">Experiencia Laboral</label>
                <div class="col-sm-6">
                <input class="form-control" type="text" name="experiencia-up" required="" maxlength="120" value="<?php echo $campos['EspecialistaExperiencia'];?>">
                <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                <div class="col-sm-6">
                  <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" maxlength="10" minlength="6" value="<?php echo $campos['EspecialistaCelular'];?>">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="direccion" class="col-sm-2 col-form-label">Correo de contacto</label>
                <div class="col-sm-6">
                    <input class="form-control" type="email" name="correo-up" maxlength="80" required="" value="<?php echo $campos['EspecialistaCorreo'];?>"><div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Centro Laboral</label>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="centro-up" required="" maxlength="120" value="<?php echo $campos['EspecialistaCentro'];?>">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Descripción </label>
                <div class="col-sm-6">
                  <textarea name="descripción-up" class="form-control" rows="3" maxlength="400" required=""><?php echo $campos['EspecialistaDescripcion'];?></textarea>
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Departamento </label>
                <div class="col-sm-6">
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
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Especialidad </label>
                <div class="col-sm-6">
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
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <div class="form-group row">
                <label for="descripcion" class="col-sm-2 col-form-label">Link Social </label>
                <div class="col-sm-6">
                  <input class="form-control" type="text" name="link-up" required="" maxlength="120" value="<?php echo $campos['EspecialistaLink'];?>">
                  <div class="invalid-feedback">
                    Complete el campo correctamente.
                  </div>
                </div>
              </div>

              <p class="text-center pb-2 mt-4 mb-5">
                  <button type="submit" class="boton-actualizar"><i class="fas fa-edit"></i> Actualizar</button>
              </p>
              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="formulario-mydata">
            <h3><i class="far fa-image"></i> Imagen del Especialista</h3>

            <div class="imagen-actual">
              <h6>Imagen Actual</h6>
              <div class="imagen">
                <?php if($campos['EspecialistaFoto']=="nulo"){
                  echo '<div class="ml-4 w-100 alert alert-primary" role="alert">
                          No has actulizado tu foto
                        </div>';
                }else{
                ?>
                  <img src="<?php echo SERVERURL; ?>adjuntos/especialistas/foto/<?php echo $campos['EspecialistaFoto']?>" alt="">
                <?php } ?>
              </div>
            </div>

            <form class="form-imagen FormularioAjax needs-validation" action="<?php echo SERVERURL;?>ajax/especialistaAjax.php" method="POST" data-form="update"  autocomplete="off" enctype="multipart/form-data">
              
              <label>Imagen Nueva</label>
              <input type="hidden" name="codigo2-up" value="<?php echo $datos[2];?>">
              <input type="file" id="archivoInput" name="foto2-up" placeholder="Cargue archivo" onchange="return validarExt()" required="" accept=".jpg, .png, .jpeg">
              
              <div class="elementos">
                <label for="archivoInput">
                  <i class="fas fa-paperclip"></i>Agregar archivo(.png/.jpg/.jpeg)
                </label>
              </div>

              <div id="visorArchivo" class="visor border-danger">
              </div> 

              <p class="text-center pb-2 mt-4 mb-3">
                <button type="submit" class="boton-actualizar"><i class="fas fa-sync"></i> Actualizar Foto</button>
              </p>
              <div class="RespuestaAjax"></div>

            </form>

          </div>
        </div>
      </div> 

      <div class="row pb-5">
        <div class="col-12">
          <div class="formulario-mydata">
            <h3><i class="fas fa-file-pdf"></i> CV del Especialista</h3>
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
                  <input type="hidden" name="codigo4-up" value="<?php echo $datos[2];?>">
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
                    <button type="submit" class="boton-actualizar"><i class="fas fa-sync"></i> Actualizar CV</button>
                  </p>
                  <div class="RespuestaAjax"></div>
                </form>
              
          </div>
        </div>
      </div>
<?php
		}else{
?>
			<div class="alert alert-dimissible alert-warning text-center">
					<button type="button" class="close" data-dismiss="alert">x</button>	
				  <i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
					<h4>LO SENTIMOS!</h4>
					<p>No pudimos mostrar la información buscada.</p>
			</div>	
<?php
		}
?>
<?php
/*---ERROR---*/	
	}else{
?>
	<div class="alert alert-dimissible alert-danger text-center">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
		<h4>Ocurrió un error!</h4>
		<p>No podemos mostrar la información solicitada</p>
	</div>
  <?php } ?>
  </div>
</section>