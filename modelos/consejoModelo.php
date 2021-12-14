<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class consejoModelo extends mainModel
	{
		/**-----FUNCION PARA AGREGAR consejo-----**/
		protected function agregar_consejo_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO consejo(ConsejoTitulo,ConsejoDescripcion,ConsejoImagen,idTema) 
			VALUES(:titulo,:descripcion,:imagen,:tema)");

			$sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":imagen",$datos['imagen']);
			$sql->bindParam(":tema",$datos['tema']);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA ELIMINAR consejo-----**/
		protected function eliminar_consejo_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM consejo WHERE idConsejo=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/**-----FUNCION PARA OBTENER DATOS consejo-----**/
		protected function datos_consejo_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM consejo WHERE idConsejo = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idConsejo FROM consejo");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idConsejo, ConsejoTitulo FROM consejo ORDER BY  consejoTitulo ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/**-----FUNCION PARA ACTUALIZAR DATOS consejo-----**/
		protected function actualizar_consejo_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE consejo SET ConsejoTitulo=:titulo,ConsejoDescripcion=:descripcion WHERE idconsejo=:codigo");

			$sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":codigo",$datos['id']);
			$sql->execute();
			
			return $sql;
		}

	}