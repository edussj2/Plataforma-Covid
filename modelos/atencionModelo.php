<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class atencionModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_atencion_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO atencion(AtencionFecha,AtencionDescripcion,idUsuario,idEspecialista ,AtencionEstado) 
			VALUES(:fecha,:descripcion,:usuario,:especialista,:estado)");

			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":usuario",$datos['usuario']);
			$sql->bindParam(":especialista",$datos['especialista']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_atencion_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM atencion WHERE idAtencion=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_atencion_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM atencion WHERE idAtencion = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idAtencion FROM atencion");
				$sql->execute();
			}elseif($tipo=="Especial"){
				$sql = mainModel::conectar()->prepare("SELECT idAtencion FROM atencion WHERE idEspecialista=:especialista AND AtencionEstado=0");
				$sql->bindParam(":especialista",$codigo);
				$sql->execute();
			}
			return $sql;
		}


	}