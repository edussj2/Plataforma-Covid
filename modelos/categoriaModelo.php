<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class categoriaModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_categoria_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO categoria(CategoriaDescripcion,CategoriaIcono,CategoriaVigencia) 
			VALUES(:descripcion,:icono,:vigencia)");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":icono",$datos['icono']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_categoria_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM categoria WHERE idCategoria=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_categoria_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM categoria WHERE idCategoria = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idCategoria FROM categoria");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idCategoria, CategoriaDescripcion FROM categoria WHERE CategoriaVigencia=1 ORDER BY CategoriaDescripcion ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/* ACTUALIZAR */
		protected function actualizar_categoria_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE categoria SET CategoriaDescripcion=:descripcion, CategoriaIcono=:icono, CategoriaVigencia=:vigencia WHERE idCategoria=:codigo");

			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":icono",$datos['icono']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":codigo",$datos['id']);
			$sql->execute();
			
			return $sql;
		}

	}