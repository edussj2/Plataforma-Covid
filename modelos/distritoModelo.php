<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class distritoModelo extends mainModel
	{
		/* DATOS*/
		protected function datos_distrito_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM distrito WHERE idDistrito = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idDistrito FROM distrito");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idDistrito, DistritoDescripcion FROM distrito ORDER BY DistritoDescripcion ASC"); 
				$sql->execute();
			}
			return $sql;
		}
	}