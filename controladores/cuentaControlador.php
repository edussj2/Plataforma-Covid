<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class cuentaControlador extends mainModel
	{
		/*DATOS*/
		public function datos_cuenta_controlador($codigo,$tipo){

			$codigo = mainModel::decryption($codigo);
			$tipo = mainModel::limpiar_cadena($tipo);

			if($tipo=="admin"){
				$tipo="Administrador";
			}elseif($tipo=="user"){
				$tipo="Usuario";
			}elseif($tipo=="especialista"){
				$tipo="Especialista";
			}

			return mainModel::datos_cuenta($codigo,$tipo);
		}

		/*ACTUALIZAR*/
		public function actualizar_cuenta_controlador(){

			$codigo = mainModel::decryption($_POST['codigo-cuenta-up']);
			$tipo = mainModel::decryption($_POST['tipo-cuenta-up']);
			
			$consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo = '$codigo'");
			$datosCuenta = $consulta1->fetch();

			$usuario = mainModel::limpiar_cadena($_POST['emailLog-up']);
			$clave = mainModel::limpiar_cadena($_POST['passwordLog-up']);
			$clave = mainModel::encryption($clave);

			if(filter_var($usuario, FILTER_VALIDATE_EMAIL)==false){
				$alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo electrónico ingresado en confirmación de identidad no es válido","Tipo"=>"warning"];
		        return mainModel::sweet_alert($alerta);
		        exit();	
			}

			/**--VALIDAMOS LAS CREDENCIALES PARA PODER ACTUALIZAR--**/
			if($usuario != "" && $clave != ""){
				if(isset($_POST['privilegio-up'])){
					$consulta2 = mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaCorreo='$usuario' AND CuentaClave='$clave'");
				}else{
                    $consulta2 = mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaCorreo='$usuario' AND CuentaClave='$clave' AND CuentaCodigo='$codigo'");
				}

				if($consulta2->rowCount()==0){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Las credenciales ingresadas no son válidas para efectuar esta operación.","Tipo"=>"error"];
	                return mainModel::sweet_alert($alerta);
	                exit();
				}
			}else{
               $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Porfavor ingrese el correo y la contraseña para efectuar esta operación.","Tipo"=>"error"];
               return mainModel::sweet_alert($alerta);
               exit();
			}

			$nombreUsuario = mainModel::limpiar_cadena($_POST['correo-muestra']);


			if(filter_var($nombreUsuario, FILTER_VALIDATE_EMAIL)==false){
				$alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo electrónico ingresado para el cambio, no es válido","Tipo"=>"warning"];
		        return mainModel::sweet_alert($alerta);
		        exit();	
			}

			if($nombreUsuario != $datosCuenta['CuentaCorreo']){
				$consulta3 =mainModel::ejecutar_consulta_simple("SELECT CuentaCorreo FROM cuenta WHERE CuentaCorreo = '$nombreUsuario'");
				if($consulta3->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Este correo ya esta registrado o no es válido, intenté de nuevo porfavor.","Tipo"=>"error"];
		            return mainModel::sweet_alert($alerta);
		            exit();
				}
			}

			$newpass1 = mainModel::limpiar_cadena($_POST['newPass-up']);
			$newpass2 = mainModel::limpiar_cadena($_POST['newPass2-up']);

			if($newpass1!="" || $newpass2 != ""){
				if($newpass1 == $newpass2){
					$cuentaClave = mainModel::encryption($newpass1);
				}else{
					 $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Las contraseñas no coinciden, intenté nuevamente porfavor.","Tipo"=>"error"];
		            return mainModel::sweet_alert($alerta);
		            exit();
				}
			}else{
				$cuentaClave = $datosCuenta['CuentaClave'];
			}

			$datosUpdate = ["id"=>$codigo,"correo"=>$nombreUsuario,"clave"=>$cuentaClave];

			if(mainModel::actualizar_cuenta($datosUpdate)){
				if(!isset($_POST['privilegio-up'])){
					session_start(['name'=>'UNPRG']);
					$_SESSION['usuario_unprg']=$nombreUsuario;
				}	
				$alerta = ["Alerta"=>"recargar", "Titulo"=>"Cuenta Actualizada","Texto"=>"Se actualizaron los datos de la cuenta con éxito","Tipo"=>"success"];
			}else{
				$alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos de la cuenta, intenté en unos momentos.","Tipo"=>"error"];
		    }
		    return mainModel::sweet_alert($alerta);
		}
	}