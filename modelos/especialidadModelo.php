<?php 
	/*HECHO*/
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class especialidadModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_especialidad_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO especialidad(EspecialidadDescripcion, EspecialidadVigencia) 
			VALUES(:descripcion,:vigencia)");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_especialidad_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM especialidad WHERE idEspecialidad=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_especialidad_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM especialidad WHERE idEspecialidad = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idEspecialidad FROM especialidad");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idEspecialidad, EspecialidadDescripcion FROM especialidad ORDER BY EspecialidadDescripcion ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/* ACTUALIZAR */
		protected function actualizar_especialidad_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE especialidad SET EspecialidadDescripcion=:descripcion, EspecialidadVigencia=:vigencia WHERE idEspecialidad=:codigo");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":codigo",$datos['id']);
			$sql->execute();
			
			return $sql;
		}

	}