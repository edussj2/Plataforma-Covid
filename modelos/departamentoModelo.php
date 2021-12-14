<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class departamentoModelo extends mainModel
	{
		/* DATOS */
		protected function datos_departamento_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM departamento WHERE idDepartamento = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idDepartamento FROM departamento");
				$sql->execute();
			}elseif($tipo=="Select"){
				$sql = mainModel::conectar()->prepare("SELECT idDepartamento, DepartamentoDescripcion FROM departamento ORDER BY DepartamentoDescripcion ASC"); 
				$sql->execute();
			}
			return $sql;
		}
	}