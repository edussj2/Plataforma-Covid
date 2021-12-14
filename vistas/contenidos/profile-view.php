<?php 
  /****** HECHO *****/
	$datos = explode("/", $_GET['views']);
	/*---ADMINSITRADOR---*/
	if($datos[1]=="admin"):
		if($_SESSION['tipo_unprg'] != "Administrador"){
			echo $lc->forzar_cierre_sesion_controlador();
		}
			
		require_once "./controladores/administradorControlador.php";
		$clasAdmin = new administradorControlador();

		$filesA = $clasAdmin->datos_administrador_controlador("Unico",$datos[2]);

		if($filesA->rowCount()==1){
			$campos = $filesA->fetch();

			if($campos['CuentaCodigo']!= $_SESSION['codigo_cuenta_unprg']){
        if(1!=$_SESSION['privilegio_unprg']){
          echo $lc->forzar_cierre_sesion_controlador();		
        }
      }
      require_once "./controladores/cuentaControlador.php";
      $classCta = new cuentaControlador();
			$dataCta = $classCta->datos_cuenta_controlador($datos[2],$datos[1]);
			$camposCta = $dataCta->fetch();
?>	       
      <section class="pb-5">
        <div class="container mb-5">
          <div class="row mb-4">
            <div class="col-lg-4 mb-4">
              <div class="contenedor-foto-perfil">
                <div class="primera-fila">
                  <div class="etiqueta-tipo-user">
                    <p><?php echo $camposCta['CuentaTipo'];?></p>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <img src="<?php echo SERVERURL;?>vistas/assets/avatars/<?php echo $camposCta['CuentaAvatar'];?>" alt="">
                </div>
                <div class="tercera-fila">
                  <h3><?php echo $campos['AdminNombre'];?> <?php echo $campos['AdminApellidoPaterno'];?> <?php echo $campos['AdminApellidoMaterno'];?></h3>
                </div>
              </div>
              <div class="contenedor-bitacora-perfil">
                <div class="primera-fila">
                  <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><h5><i class="fas fa-sign"></i> Últimas sesiones</h5></a>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila collapse show" id="collapseExample">
                  <div class="sesiones">
                  <?php
                      require "./controladores/bitacoraControlador.php";

                      $insBitacora = new bitacoraControlador();

                      echo $insBitacora->listado_bitacora_controlador(4,$datos[2]);  
                  ?>      
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 mb-4">
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de contacto</h5>
                    <?php if($_SESSION['codigo_cuenta_unprg'] == $camposCta['CuentaCodigo']){?>
                    <a href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($camposCta['CuentaCodigo'])?>/" class="enlace-editar"><i class="fas fa-pencil-alt"></i></a>
                    <?php }?>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-datos">
                    <div class="item-datos">
                      <p class="uno"><i class="far fa-id-badge"></i> Nombre Completo: </p>
                      <p class="dos"><?php echo $campos['AdminNombre'];?> <?php echo $campos['AdminApellidoPaterno'];?> <?php echo $campos['AdminApellidoMaterno'];?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="fas fa-street-view"></i> Ubicación: </p>
                      <p class="dos"><?php echo $campos['AdminDireccion'];?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="far fa-address-card"></i> Descripción: : </p>
                      <p class="dos"><?php echo $campos['AdminDescripcion'];?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de la cuenta</h5>
                    <?php if($_SESSION['codigo_cuenta_unprg'] == $camposCta['CuentaCodigo']){?>
                    <a href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($camposCta['CuentaCodigo'])?>/" class="enlace-editar"><i class="fas fa-pencil-alt"></i></a>
                    <?php } ?>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-datos">
                      <div class="item-datos">
                        <p class="uno"><i class="fas fa-at"></i> Correo: </p>
                        <p class="dos"><?php echo $camposCta['CuentaCorreo'];?></p>
                      </div>
                      <div class="item-datos">
                        <p class="uno"><i class="fas fa-user-cog"></i> Tipo: </p>
                        <p class="dos"><?php echo $camposCta['CuentaTipo'];?></p>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
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
  elseif ($datos[1]=="user"):
    require_once "./controladores/usuarioControlador.php";
		$clasUser = new usuarioControlador();

		$filesU = $clasUser->datos_usuario_controlador("Unico",$datos[2]);

    if($filesU->rowCount()==1){
			$campos = $filesU->fetch();
      require_once "./controladores/cuentaControlador.php";
      $classCta = new cuentaControlador();
			$dataCta = $classCta->datos_cuenta_controlador($datos[2],$datos[1]);
      $camposCta = $dataCta->fetch();
      
      require_once "./controladores/escuelaControlador.php";
      $classEscuela = new escuelaControlador();
			$dataEscuela = $classEscuela->datos_escuela_controlador("Unico",mainModel::encryption($campos['idEscuela']));
      $camposEscuela = $dataEscuela->fetch();

      require_once "./controladores/facultadControlador.php";
      $classfacultad = new facultadControlador();
			$datafacultad = $classfacultad->datos_facultad_controlador("Unico",mainModel::encryption($camposEscuela['idFacultad']));
      $camposfacultad = $datafacultad->fetch();
      
      require_once "./controladores/distritoControlador.php";
      $classdistrito = new distritoControlador();
			$datadistrito = $classdistrito->datos_distrito_controlador("Unico",mainModel::encryption($campos['idDistrito']));
      $camposdistrito = $datadistrito->fetch();
?>
      <section class="pb-5">
        <div class="container mb-5">
          <div class="row mb-4">
            <div class="col-lg-4 mb-4">
              <div class="contenedor-foto-perfil">
                <div class="primera-fila">
                  <div class="etiqueta-tipo-user">
                    <p><?php echo $campos['UsuarioTipo'];?></p>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                    <?php if($campos['UsuarioFoto']=="nulo"){?>
                          <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $camposCta['CuentaAvatar'];?>">
                    <?php }elseif($campos['UsuarioFoto']!="nulo"){?>
                      <img src="<?php echo SERVERURL;?>adjuntos/usuarios/<?php echo $campos['UsuarioFoto'];?>" alt="" >
                    <?php } ?>
                </div>
                <div class="tercera-fila">
                  <h3><?php echo $campos['UsuarioNombres'];?> <?php echo $campos['UsuarioApellidoPaterno'];?> <?php echo $campos['UsuarioApellidoMaterno'];?></h3>
                </div>
              </div>
              <div class="contenedor-bitacora-perfil">
                <div class="primera-fila">
                  <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><h5><i class="fas fa-sign"></i> Últimas sesiones</h5></a>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila collapse show" id="collapseExample">
                  <div class="sesiones">
                  <?php
                      require "./controladores/bitacoraControlador.php";

                      $insBitacora = new bitacoraControlador();

                      echo $insBitacora->listado_bitacora_controlador(4,$datos[2]);  
                  ?> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 mb-4">
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de contacto</h5>
                    <?php if($_SESSION['codigo_cuenta_unprg'] == $camposCta['CuentaCodigo']){?>
                    <a href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($camposCta['CuentaCodigo'])?>/" class="enlace-editar"><i class="fas fa-pencil-alt"></i></a>
                    <?php }?>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-datos">
                    <div class="item-datos">
                      <p class="uno"><i class="far fa-id-badge"></i> Nombre Completo: </p>
                      <p class="dos"><?php echo $campos['UsuarioNombres'];?> <?php echo $campos['UsuarioApellidoPaterno'];?> <?php echo $campos['UsuarioApellidoMaterno'];?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="fas fa-street-view"></i> Ubicación: </p>
                      <p class="dos"><?php echo $campos['UsuarioDireccion'];?>-<?php echo $camposdistrito['DistritoDescripcion'];?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="far fa-address-card"></i> Descripción: : </p>
                      <p class="dos"><?php echo $campos['UsuarioDescripcion'];?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de Estudiante</h5>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-escuela">
                    <div class="item-datos">
                      <p class="uno"><i class="fas fa-graduation-cap"></i> Escuela: </p>
                      <p class="dos"><?php echo $camposEscuela['EscuelaDescripcion']?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="fas fa-university"></i> Facultad: </p>
                      <p class="dos"><?php echo $camposfacultad['FacultadDescripcion']?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de la cuenta</h5>
                    <?php if($_SESSION['codigo_cuenta_unprg'] == $camposCta['CuentaCodigo']){?>
                    <a href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($camposCta['CuentaCodigo'])?>/" class="enlace-editar"><i class="fas fa-pencil-alt"></i></a>
                    <?php } ?>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-datos">
                      <div class="item-datos">
                        <p class="uno"><i class="fas fa-at"></i> Correo: </p>
                        <p class="dos"><?php echo $camposCta['CuentaCorreo'];?></p>
                      </div>
                      <div class="item-datos">
                        <p class="uno"><i class="fas fa-user-cog"></i> Tipo: </p>
                        <p class="dos"><?php echo $camposCta['CuentaTipo'];?></p>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
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
  elseif($datos[1]=="especialista"):
    require_once "./controladores/especialistaControlador.php";
		$clasUser = new especialistaControlador();

		$filesU = $clasUser->datos_especialista_controlador("Unico",$datos[2]);

    if($filesU->rowCount()==1){
			$campos = $filesU->fetch();
      require_once "./controladores/cuentaControlador.php";
      $classCta = new cuentaControlador();
			$dataCta = $classCta->datos_cuenta_controlador($datos[2],$datos[1]);
      $camposCta = $dataCta->fetch();
      
      require_once "./controladores/departamentoControlador.php";
      $classdepartamento = new departamentoControlador();
			$datadepartamento = $classdepartamento->datos_departamento_controlador("Unico",mainModel::encryption($campos['idDepartamento']));
      $camposdepartamento = $datadepartamento->fetch();

      require_once "./controladores/especialidadControlador.php";
      $classespecialidad = new especialidadControlador();
			$dataespecialidad = $classespecialidad->datos_especialidad_controlador("Unico",mainModel::encryption($campos['idEspecialidad']));
      $camposespecialidad = $dataespecialidad->fetch();
?>
      <section class="pb-5">
        <div class="container mb-5">
          <div class="row mb-4">
            <div class="col-lg-4 mb-4">
              <div class="contenedor-foto-perfil">
                <div class="primera-fila">
                  <div class="etiqueta-tipo-user">
                    <p><?php echo $camposCta['CuentaTipo'];?></p>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                    <?php if($campos['EspecialistaFoto']=="nulo"){?>
                          <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $camposCta['CuentaAvatar'];?>">
                    <?php }elseif($campos['EspecialistaFoto']!="nulo"){?>
                      <img src="<?php echo SERVERURL;?>adjuntos/especialistas/foto/<?php echo $campos['EspecialistaFoto'];?>" alt="" >
                    <?php } ?>
                </div>
                <div class="tercera-fila">
                  <h3><?php echo $campos['EspecialistaNombres'];?> <?php echo $campos['EspecialistaApellidos'];?></h3>
                </div>
              </div>
              <div class="contenedor-bitacora-perfil">
                <div class="primera-fila">
                  <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><h5><i class="fas fa-sign"></i> Últimas sesiones</h5></a>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila collapse show" id="collapseExample">
                  <div class="sesiones">
                  <?php
                      require "./controladores/bitacoraControlador.php";

                      $insBitacora = new bitacoraControlador();

                      echo $insBitacora->listado_bitacora_controlador(4,$datos[2]);  
                  ?> 
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8 mb-4">
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de contacto</h5>
                    <?php if($_SESSION['codigo_cuenta_unprg'] == $camposCta['CuentaCodigo']){?>
                    <a href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($camposCta['CuentaCodigo'])?>/" class="enlace-editar"><i class="fas fa-pencil-alt"></i></a>
                    <?php }?>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-datos">
                    <div class="item-datos">
                      <p class="uno"><i class="far fa-id-badge"></i> Nombre Completo: </p>
                      <p class="dos"><?php echo $campos['EspecialistaNombres'];?> <?php echo $campos['EspecialistaApellidos'];?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="fas fa-street-view"></i> Ubicación: </p>
                      <p class="dos"><?php echo $camposdepartamento['DepartamentoDescripcion'];?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="far fa-address-card"></i> Descripción: : </p>
                      <p class="dos"><?php echo $campos['EspecialistaDescripcion'];?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de Especialista</h5>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-escuela">
                    <div class="item-datos">
                      <p class="uno"><i class="fas fa-university"></i> Centro: </p>
                      <p class="dos"><?php echo $campos['EspecialistaCentro']?></p>
                    </div>
                    <div class="item-datos">
                      <p class="uno"><i class="fas fa-graduation-cap"></i> Especialidad: </p>
                      <p class="dos"><?php echo $camposespecialidad['EspecialidadDescripcion']?></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="contendor-informacion-perfil">
                <div class="primera-fila">
                  <div class="contendor-titulo-enlace">
                    <h5>Información de la cuenta</h5>
                    <?php if($_SESSION['codigo_cuenta_unprg'] == $camposCta['CuentaCodigo']){?>
                    <a href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($camposCta['CuentaCodigo'])?>/" class="enlace-editar"><i class="fas fa-pencil-alt"></i></a>
                    <?php } ?>
                  </div>
                  <div class="linea"></div>
                </div>
                <div class="segunda-fila">
                  <div class="contenedor-datos">
                      <div class="item-datos">
                        <p class="uno"><i class="fas fa-at"></i> Correo: </p>
                        <p class="dos"><?php echo $camposCta['CuentaCorreo'];?></p>
                      </div>
                      <div class="item-datos">
                        <p class="uno"><i class="fas fa-user-cog"></i> Tipo: </p>
                        <p class="dos"><?php echo $camposCta['CuentaTipo'];?></p>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
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
  else:
?>
	<div class="alert alert-dimissible alert-danger text-center">
		<button type="button" class="close" data-dismiss="alert">x</button>
		<i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
		<h4>Ocurrió un error!</h4>
		<p>No podemos mostrar la información solicitada</p>
	</div>
	<?php endif; ?>
  </div>
</section>