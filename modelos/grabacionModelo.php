<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class grabacionModelo extends mainModel
	{
		/**-----FUNCION PARA AGREGAR grabacion-----**/
		protected function agregar_grabacion_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO grabacion(GrabacionEnlace,GrabacionDescripcion,idConferencia) 
			VALUES(:enlace,:descripcion,:conferencia)");

			$sql->bindParam(":enlace",$datos['enlace']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":conferencia",$datos['conferencia']);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA ELIMINAR facultad-----**/
		protected function eliminar_grabacion_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM grabacion WHERE idGrabacion=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA OBTENER DATOS facultad-----**/
		protected function datos_grabacion_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM grabacion WHERE idGrabacion = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idGrabacion FROM grabacion");
				$sql->execute();
			}
			return $sql;
		}

	}