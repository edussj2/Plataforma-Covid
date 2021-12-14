<?php 
	/* HECHO*/
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class administradorModelo extends mainModel
	{
		/*AGREGAR*/
		protected function agregar_administrador_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO administrador(AdminDNI,AdminNombre,AdminApellidoPaterno,AdminApellidoMaterno,AdminTelefono, AdminDescripcion,AdminGenero,AdminVigencia,AdminDireccion,CuentaCodigo) 
			VALUES(:dni,:nombres,:paterno,:materno,:telefono,:descripcion,:genero,:vigencia,:direccion,:codigo)");

			$sql->bindParam(":dni",$datos['dni']);
			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":paterno",$datos['paterno']);
			$sql->bindParam(":materno",$datos['materno']);
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":genero",$datos['genero']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":direccion",$datos['direccion']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();

			return $sql;
		}

		/*ELIMINAR*/
		protected function eliminar_administrador_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM administrador WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/*DATOS*/
		protected function datos_administrador_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM administrador WHERE CuentaCodigo = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idAdministrador FROM administrador");
				$sql->execute();
			}
			return $sql;
		}

		/*ACTUALIZAR PARCIAL*/
		protected function actualizar_parcial_administrador_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE administrador SET AdminNombre=:nombres, AdminApellidoPaterno=:apellidoP, AdminApellidoMaterno=:apellidoM, AdminTelefono=:telefono, AdminDNI = :dni, AdminGenero=:genero, AdminDescripcion=:descripcion, AdminDireccion=:direccion WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":apellidoP",$datos['apellidoP']);
			$sql->bindParam(":apellidoM",$datos['apellidoM']);
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->bindParam(":dni",$datos['dni']);
			$sql->bindParam(":genero",$datos['genero']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":direccion",$datos['direccion']);
			$sql->execute();
			
			return $sql;
		}

		/*ACTUALIZAR GENERAL*/
		protected function actualizar_general_administrador_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE administrador SET AdminNombre=:nombres, AdminApellidoPaterno=:apellidoP, AdminApellidoMaterno=:apellidoM, AdminTelefono=:telefono, AdminDNI = :dni, AdminGenero=:genero, AdminDescripcion=:descripcion, AdminDireccion=:direccion, AdminVigencia=:vigencia WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":apellidoP",$datos['apellidoP']);
			$sql->bindParam(":apellidoM",$datos['apellidoM']);
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->bindParam(":dni",$datos['dni']);
			$sql->bindParam(":genero",$datos['genero']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":direccion",$datos['direccion']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->execute();
			
			return $sql;
		}
	}