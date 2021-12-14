<?php 
	/*HECHO*/
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class escuelaModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_escuela_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO escuela(EscuelaDescripcion,EscuelaVigencia,idFacultad) 
			VALUES(:descripcion,:vigencia,:facultad)");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":facultad",$datos['facultad']);
			$sql->execute();

			return $sql;
		}
		
		/* ELIMINAR */
		protected function eliminar_escuela_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM escuela WHERE idEscuela=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_escuela_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM escuela WHERE idEscuela = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idEscuela FROM escuela");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idEscuela, EscuelaDescripcion FROM escuela WHERE EscuelaVigencia = 1 ORDER BY EscuelaDescripcion ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/* ACTUALIZAR */
		protected function actualizar_escuela_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE escuela SET EscuelaDescripcion=:descripcion, EscuelaVigencia=:vigencia, idFacultad=:facultad WHERE idEscuela=:codigo");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":facultad",$datos['facultad']);
			$sql->bindParam(":codigo",$datos['id']);
			$sql->execute();
			
			return $sql;
		}

	}