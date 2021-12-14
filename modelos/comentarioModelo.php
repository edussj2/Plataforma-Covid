<?php 
	/*HECHO*/
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class comentarioModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_comentario_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO comentario(idNoticia,idUsuario,ComentarioDescripcion,ComentarioFecha, ComentarioVigencia) 
			VALUES(:noticia,:usuario,:descripcion,:fecha,:vigencia)");

			$sql->bindParam(":noticia",$datos['noticia']);
			$sql->bindParam(":usuario",$datos['usuario']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->execute();

			return $sql;
		}
		
		/* ELIMINAR */
		protected function eliminar_comentario_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM comentario WHERE idComentario=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}


		/* ACTUALIZAR */
		protected function vigencia_comentario_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE comentario SET ComentarioVigencia=:vigencia WHERE idComentario=:codigo");

			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":codigo",$datos['id']);
			$sql->execute();
			
			return $sql;
		}

	}