<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class quejaModelo extends mainModel
	{
		/**-----FUNCION PARA AGREGAR queja-----**/
		protected function agregar_queja_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO queja(idEspecialista,idUsuario, QuejaDescripcion,QuejaFecha) 
			VALUES(:especialista,:usuario,:descripcion,:fecha)");

			$sql->bindParam(":especialista",$datos['especialista']);
			$sql->bindParam(":usuario",$datos['usuario']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA ELIMINAR queja-----**/
		protected function eliminar_queja_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM queja WHERE idQueja=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA OBTENER DATOS queja-----**/
		protected function datos_queja_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM queja WHERE idQueja = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idQueja FROM queja");
				$sql->execute();
			}
			return $sql;
		}

	}