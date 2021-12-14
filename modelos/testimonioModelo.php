<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class testimonioModelo extends mainModel
	{
		/**-----FUNCION PARA AGREGAR testimonio-----**/
		protected function agregar_testimonio_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO testimonio(testimonioDescripcion,TestimonioFecha,TestimonioVisibilidad,idEspecialista,idUsuario) 
			VALUES(:descripcion,:fecha,:visibilidad,:especialista,:usuario)");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":visibilidad",$datos['visibilidad']);
			$sql->bindParam(":especialista",$datos['especialista']);
			$sql->bindParam(":usuario",$datos['usuario']);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA ELIMINAR testimonio-----**/
		protected function eliminar_testimonio_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM testimonio WHERE idTestimonio=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA OBTENER DATOS testimonio-----**/
		protected function datos_testimonio_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM testimonio WHERE idTestimonio = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idTestimonio FROM testimonio");
				$sql->execute();
			}
			return $sql;
		}

		protected function actualizar_testimonio_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE testimonio SET TestimonioVisibilidad = :visibilidad WHERE idTestimonio=:id");
			$sql->bindParam(":visibilidad",$datos['visibilidad']);
			$sql->bindParam(":id",$datos['id']);
			$sql->execute();
			return $sql;
		}

	}