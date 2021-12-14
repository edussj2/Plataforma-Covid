<?php 
	/*HECHO*/
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class facultadModelo extends mainModel
	{
		/*AGREGAR*/
		protected function agregar_facultad_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO facultad(FacultadDescripcion,FacultadSiglas,FacultadVigencia) 
			VALUES(:descripcion,:siglas,:vigencia)");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":siglas",$datos['siglas']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->execute();

			return $sql;
		}

		/*ELIMINAR*/
		protected function eliminar_facultad_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM facultad WHERE idFacultad=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/*DATOS*/
		protected function datos_facultad_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM facultad WHERE idFacultad = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idFacultad FROM facultad");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idFacultad, FacultadDescripcion FROM facultad WHERE FacultadVigencia = 1 ORDER BY FacultadDescripcion ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/*ACTUALIZAR*/
		protected function actualizar_facultad_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE facultad SET FacultadDescripcion=:descripcion, FacultadSiglas=:siglas, FacultadVigencia=:vigencia WHERE idFacultad=:codigo");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":siglas",$datos['siglas']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":codigo",$datos['id']);
			$sql->execute();
			
			return $sql;
		}

	}