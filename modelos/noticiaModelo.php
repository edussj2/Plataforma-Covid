<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class noticiaModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_noticia_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO noticia(NoticiaTitulo, NoticiaFecha,NoticiaLink,NoticiaImagen,NoticiaDescripcion,NoticiaDescripcion2, idCategoria,NoticiaVigencia) 
			VALUES(:titulo,:fecha,:enlace,:imagen,:descripcion,:descripcion2,:categoria,:vigencia)");

			$sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":enlace",$datos['enlace']);
			$sql->bindParam(":imagen",$datos['imagen']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":descripcion2",$datos['descripcion2']);
			$sql->bindParam(":categoria",$datos['categoria']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_noticia_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM noticia WHERE idNoticia=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_noticia_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM noticia WHERE idNoticia = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idNoticia FROM noticia");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idNoticia, NoticiaTitulo FROM noticia WHERE NoticiaVigencia=1 ORDER BY NoticiaTitulo ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/* ACTUALIZAR */
		protected function actualizar_noticia_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE noticia SET NoticiaTitulo=:titulo,NoticiaDescripcion=:descripcion,NoticiaDescripcion2=:descripcion2,NoticiaFecha=:fecha,NoticiaLink=:enlace WHERE idNoticia=:codigo");

            $sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":descripcion2",$datos['descripcion2']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":enlace",$datos['enlace']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}

		/* ACTUALIZAR IMAGEN */
		protected function actualizar_imagen_noticia_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE noticia SET NoticiaImagen=:imagen WHERE idNoticia=:codigo");

			$sql->bindParam(":imagen",$datos['imagen']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}

		/* ACTUALIZAR VIGENCIA */
		protected function actualizar_vigencia_noticia_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE noticia SET NoticiaVigencia = :visibilidad WHERE idNoticia=:id");
			$sql->bindParam(":visibilidad",$datos['visibilidad']);
			$sql->bindParam(":id",$datos['id']);
			$sql->execute();
			return $sql;
		}
	}