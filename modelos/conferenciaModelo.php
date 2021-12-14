<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class conferenciaModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_conferencia_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO conferencia(ConferenciaTitulo,ConferenciaDescripcion,ConferenciaFecha,ConferenciaEnlace,ConferenciaTema, ConferenciaImagen,ConferenciaVisitas,ConferenciaVigencia,idPonente) 
			VALUES(:titulo,:descripcion,:fecha,:enlace,:tema,:imagen,:visitas,:vigencia,:ponente)");

			$sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":enlace",$datos['enlace']);
			$sql->bindParam(":tema",$datos['tema']);
			$sql->bindParam(":imagen",$datos['imagen']);
			$sql->bindParam(":visitas",$datos['visitas']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":ponente",$datos['ponente']);
			$sql->execute();

			return $sql;
		}

		/* AGREGAR DETALLE */
		protected function agregar_detalle_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO detalle_conferencia(FechaDetalle,idConferencia,	idUsuario) 
			VALUES(:fecha,:conferencia,:usuario)");

			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":conferencia",$datos['conferencia']);
			$sql->bindParam(":usuario",$datos['usuario']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_conferencia_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM conferencia WHERE idConferencia=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_conferencia_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM conferencia WHERE idConferencia = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idConferencia FROM conferencia");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idConferencia, ConferenciaTitulo FROM conferencia ORDER BY ConferenciaTitulo ASC"); 
				$sql->execute();
			}
			return $sql;
		}

		/* DATOS DETALLE*/
		protected function datos_detalle_conferencia_modelo($usuario,$conferencia){
			$sql = mainModel::conectar()->prepare("SELECT * FROM detalle_conferencia WHERE idUsuario = :usuario AND idConferencia =:conferencia");
			$sql->bindParam(":usuario",$usuario);
			$sql->bindParam(":conferencia",$conferencia);
			$sql->execute();
	
			return $sql;
		}

		/* DATOS DETALLE*/
		protected function datos2_detalle_conferencia_modelo($conferencia){
			$sql = mainModel::conectar()->prepare("SELECT * FROM detalle_conferencia WHERE idConferencia =:conferencia");
			$sql->bindParam(":conferencia",$conferencia);
			$sql->execute();
	
			return $sql;
		}

		/* ACTUALIZAR IMAGEN */
		protected function actualizar_foto_conferencia_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE conferencia SET ConferenciaImagen=:imagen WHERE idConferencia=:codigo");

			$sql->bindParam(":imagen",$datos['imagen']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}

		/* ACTUALIZAR VIGENCIA */
		protected function actualizar_vigencia_conferencia_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE conferencia SET ConferenciaVigencia = :visibilidad WHERE idConferencia=:id");
			$sql->bindParam(":visibilidad",$datos['visibilidad']);
			$sql->bindParam(":id",$datos['id']);
			$sql->execute();
			return $sql;
		}

		/* ACTUALIZAR */
		protected function actualizar_general_conferencia_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE conferencia SET ConferenciaTitulo=:titulo,ConferenciaDescripcion=:descripcion,ConferenciaFecha=:fecha,ConferenciaEnlace=:enlace,ConferenciaTema=:tema WHERE idConferencia=:codigo");

            $sql->bindParam(":titulo",$datos['titulo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":enlace",$datos['enlace']);
			$sql->bindParam(":tema",$datos['tema']);
			$sql->execute();
			
			return $sql;
		}
	}