<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../modelos/loginModelo.php";
	}else{
		require_once "./modelos/loginModelo.php";
	}

	class loginControlador extends loginModelo
	{
		
		/* INICIAR SESIÓN */
		public function iniciar_sesion_controlador(){
			$usuario = mainModel::limpiar_cadena($_POST['usuario']);
			$clave = mainModel::limpiar_cadena($_POST['clave']);

			$clave = mainModel::encryption($clave);

			$datosLogin = ["usuario"=> $usuario,"clave"=>$clave];

			$datosCuenta = loginModelo::iniciar_sesion_modelo($datosLogin);

			if($datosCuenta->rowCount()==1){
				$row = $datosCuenta->fetch();

				$fechaActual = date("Y-m-d");
				$yearActual = date("Y");
				$horaActual = date("h:i:s a");

				$consulta1= mainModel::ejecutar_consulta_simple("SELECT id FROM bitacora");

				$numero = ($consulta1->rowCount())+1;

				$codigoBitacora = mainModel::generar_codigo_aleatorio("CB",8,$numero);

                $datosBitacora=["codigo"=>$codigoBitacora,
                                "fecha"=>$fechaActual,
                                "inicio"=>$horaActual,
                                "final"=>"Sin registro",
                                "tipo"=>$row['CuentaTipo'],
                                "year"=>$yearActual,
                                "cuenta"=>$row['CuentaCodigo']];

				$guardarBitacora = mainModel::guardar_bitacora($datosBitacora);

				if($guardarBitacora->rowCount()>=1){

					if($row['CuentaTipo'] == "Administrador"){
						$query = mainModel::ejecutar_consulta_simple("SELECT * FROM administrador WHERE CuentaCodigo ='".$row['CuentaCodigo']."'");
					}elseif($row['CuentaTipo'] == "Usuario"){
						$query = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE CuentaCodigo ='".$row['CuentaCodigo']."'");
					}elseif($row['CuentaTipo'] == "Especialista"){
						$query = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE CuentaCodigo ='".$row['CuentaCodigo']."'");
					}

					if($query->rowCount()==1){
						$userData= $query->fetch();
						session_start(['name'=>'UNPRG']);

					   if($row['CuentaTipo'] == "Administrador"){
							$_SESSION['id_unprg']=$userData['idAministrador'];
							$_SESSION['nombre_unprg']=$userData['AdminNombre'];
							$_SESSION['apellidoP_unprg']=$userData['AdminApellidoPaterno'];
							$_SESSION['apellidoM_unprg']=$userData['AdminApellidoMaterno'];
							$_SESSION['avatar_unprg']=$row['CuentaAvatar'];
							$_SESSION['identificar_unprg']="SI";
						}else if($row['CuentaTipo'] == "Usuario"){
							$_SESSION['id_unprg']=$userData['idUsuario'];
							$_SESSION['nombre_unprg']=$userData['UsuarioNombres'];	
							$_SESSION['apellidoP_unprg']=$userData['UsuarioApellidoPaterno'];
							$_SESSION['apellidoM_unprg']=$userData['UsuarioApellidoMaterno'];
							if($userData['UsuarioFoto']=="nulo"){
								$_SESSION['avatar_unprg']=$row['CuentaAvatar'];
								$_SESSION['identificar_unprg']="SI";
							}else{
								$_SESSION['avatar_unprg']=$userData['UsuarioFoto'];
								$_SESSION['identificar_unprg']="NO";
							}
						}else if($row['CuentaTipo'] == "Especialista"){
							$_SESSION['id_unprg']=$userData['idEspecialista'];
							$_SESSION['nombre_unprg']=$userData['EspecialistaNombres'];	
							$_SESSION['apellidoP_unprg']=$userData['EspecialistaApellidos'];
							$_SESSION['apellidoM_unprg']="";
							if($userData['EspecialistaFoto']=="nulo"){
								$_SESSION['avatar_unprg']=$row['CuentaAvatar'];
								$_SESSION['identificar_unprg']="SI";
							}else{
								$_SESSION['avatar_unprg']=$userData['EspecialistaFoto'];
								$_SESSION['identificar_unprg']="ESPECIAL";
							}
						}

						$_SESSION['usuario_unprg']=$row['CuentaCorreo'];
						$_SESSION['tipo_unprg']=$row['CuentaTipo'];
                        $_SESSION['privilegio_unprg']=$row['CuentaPrivilegio'];     
						$_SESSION['codigo_cuenta_unprg']=$row['CuentaCodigo'];
						$_SESSION['codigo_bitacora_unprg']=$codigoBitacora;
						$_SESSION['token_unprg']=md5(uniqid(mt_rand(),true));

						if($row['CuentaTipo']=="Administrador"){
							$url = SERVERURL."dashboard/";
						}else{
							$url = SERVERURL."noticias/total/";
						}

						return $urlLocation='<script> window.location="'.$url.'"</script>';

					}else{
						 $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, intente nuevamente.","Tipo"=>"warning"];
                   		return mainModel::sweet_alert($alerta);
					}

				}else{
                   $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, intente nuevamente.","Tipo"=>"warning"];
                   return mainModel::sweet_alert($alerta);
				}
			}else{
               $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Las credenciales no son válidas o su cuenta esta deshabilitada.","Tipo"=>"error"];
               return mainModel::sweet_alert($alerta);
			}
		}

		/* CERRAR SESIÓN */
		public function cerrar_sesion_controlador(){
			session_start(['name'=>'UNPRG']);
			$token = mainModel::decryption($_GET['Token']);
			$hora = date("h:i:s a");
			$datos=["usuario"=>$_SESSION['usuario_unprg'], "token_S"=>$_SESSION['token_unprg'],"token"=>$token,"codigo"=>$_SESSION['codigo_bitacora_unprg'],"hora"=>$hora];

			return loginModelo::cerrar_sesion_modelo($datos);
		}

		/* FORZAR CIERRE DE SESIÓN */
		public function forzar_cierre_sesion_controlador(){
			session_unset();
			session_destroy();
			$redirect = '<script> window.location.href="'.SERVERURL.'login/"</script>';
			return $redirect;
		}

		/* REDICCIONAR USUARIO */
		public function redireccionar_usuario_controlador($tipo){
			if($tipo == "Administrador"){
				$redirect = '<script> window.location.href="'.SERVERURL.'dashboard/"</script>';
			}else{
				$redirect = '<script> window.location.href="'.SERVERURL.'noticias/"</script>';
			}
			
			return $redirect;
		}

		/* RECUPERAR CUENTA */
		public function recuperar_cuenta_controlador(){
			$correo = $_POST['correoInstitucional'];
			$consulta1= mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCorreo='$correo'");

			if($consulta1->rowCount()>=1){

				$alerta = ["Alerta"=>"simple", "Titulo"=>"Recuperación Exitosa","Texto"=>"Se envio a su correo su contraseña actual.","Tipo"=>"info"];
				return mainModel::sweet_alert($alerta);
				$datos->$consulta1->fetch();
				$clave= mainModel::decryption($datos['CuentaClave']);

				$destino = $correo;
				$nombre = $_POST['nombre'];
				$correo = "spunprg@gmail.com";
				$asunto = "Recuperar tu Contraseña - PlataformaCovid";
				$mensaje = "Tu contaseña es: ".$clave;
			
				$contenido = "Nombre:" .$nombre. "\nCorreo:" .$correo. "\nMensaje:" .$mensaje;
				mail($destino, $asunto, $contenido);
				
			}else{
				$alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Este correo no es válido.","Tipo"=>"warning"];
				return mainModel::sweet_alert($alerta);
                    
			}
		}
	}