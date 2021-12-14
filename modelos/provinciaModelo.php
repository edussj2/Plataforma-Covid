<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class provinciaModelo extends mainModel
	{
		/* DATOS*/
		protected function datos_provincia_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM provincia WHERE idProvincia = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idProvincia FROM provincia");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idProvincia, ProvinciaDescripcion FROM provincia ORDER BY provinciaDescripcion ASC"); 
				$sql->execute();
			}
			return $sql;
		}
	}