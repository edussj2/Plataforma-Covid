<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class loginModelo extends mainModel
	{

		/* INICIAR SESIÓN */
		protected function iniciar_sesion_modelo($datos){
			$sql = mainModel::conectar()->prepare("SELECT * FROM cuenta WHERE CuentaCorreo = :usuario AND CuentaClave = :clave AND CuentaVigencia =1");

			$sql->bindParam(":usuario",$datos['usuario']);
			$sql->bindParam(":clave",$datos['clave']);
			$sql->execute();

			return $sql;
		}

		/* CERRAR SESIÓN */
		protected function cerrar_sesion_modelo($datos){
			if ($datos['usuario']!="" && $datos['token_S']==$datos['token']) {

				$Abitacora = mainModel::actualizar_bitarcora($datos['codigo'],$datos['hora']);

				if($Abitacora->rowCount()==1){
					session_unset();
					session_destroy();
					$respuesta = "true";
				}else{
					$respuesta = "false";
				}
			}else{
				$respuesta = "false";
			}

			return $respuesta;
		}
	}