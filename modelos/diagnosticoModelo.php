<?php 
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class diagnosticoModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_diagnostico_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO diagnostico(idAtencion,DiagnosticoDescripcion,DiagnosticoEstado) 
			VALUES(:atencion,:descripcion,:estado)");

			$sql->bindParam(":atencion",$datos['atencion']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":estado",$datos['estado']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_diagnostico_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM diagnostico WHERE idDiagnostico=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_diagnostico_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM diagnostico WHERE idAtencion=:codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idDiagnostico FROM diagnostico");
				$sql->execute();
			}
			return $sql;
		}

	}