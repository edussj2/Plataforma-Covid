<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class temaModelo extends mainModel
	{
		/**-----FUNCION PARA AGREGAR tema-----**/
		protected function agregar_tema_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tema(TemaTitulo,TemaImagen) 
			VALUES(:titulo,:imagen)");

			$sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":imagen",$datos['imagen']);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA ELIMINAR tema-----**/
		protected function eliminar_tema_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM tema WHERE idTema=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA OBTENER DATOS tema-----**/
		protected function datos_tema_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM tema WHERE idTema = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idTema FROM tema");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idTema, TemaTitulo FROM tema ORDER BY  TemaTitulo ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/**-----FUNCION PARA ACTUALIZAR DATOS tema-----**/
		protected function actualizar_tema_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE tema SET TemaTitulo=:titulo WHERE idTema=:codigo");

			$sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":codigo",$datos['id']);
			$sql->execute();
			
			return $sql;
		}

	}