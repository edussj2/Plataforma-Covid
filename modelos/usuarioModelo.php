<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class usuarioModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_usuario_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO usuario(UsuarioNombres, UsuarioApellidoPaterno, UsuarioApellidoMaterno, UsuarioTelefono, UsuarioDescripcion, UsuarioDireccion, UsuarioFoto, UsuarioNacimiento, UsuarioGenero, UsuarioTipo, CuentaCodigo, idEscuela, idDistrito) 
			VALUES(:nombres,:paterno,:materno,:telefono,:descripcion,:direccion,:foto,:nacimiento,:genero,:tipo,:cuenta,:escuela,:distrito)");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":paterno",$datos['paterno']);
			$sql->bindParam(":materno",$datos['materno']);
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":direccion",$datos['direccion']);
			$sql->bindParam(":foto",$datos['foto']);
			$sql->bindParam(":nacimiento",$datos['nacimiento']);
			$sql->bindParam(":genero",$datos['genero']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql->bindParam(":cuenta",$datos['cuenta']);
			$sql->bindParam(":escuela",$datos['escuela']);
			$sql->bindParam(":distrito",$datos['distrito']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_usuario_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM usuario WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_usuario_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE CuentaCodigo = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idUsuario FROM usuario");
				$sql->execute();
			}elseif($tipo=="Unico2"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE idUsuario = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}
			return $sql;
		}

		/* ACTUALIZAR PARCIAL */
		protected function actualizar_parcial_usuario_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE usuario SET UsuarioTelefono=:telefono, UsuarioDescripcion=:descripcion, UsuarioDireccion=:direccion WHERE CuentaCodigo=:codigo");
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":direccion",$datos['direccion']);
			$sql->execute();
			
			return $sql;
		}

		/* ACTUALIZAR FOTO*/
		protected function actualizar_foto_usuario_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE usuario SET UsuarioFoto=:foto WHERE CuentaCodigo=:codigo");
			$sql->bindParam(":foto",$datos['foto']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}

		/* ACTUALIZAR GENERAL*/
		protected function actualizar_general_usuario_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE usuario SET UsuarioNombres=:nombres, UsuarioApellidoPaterno=:apellidoP, UsuarioApellidoMaterno=:apellidoM, UsuarioTelefono=:telefono, 	UsuarioDescripcion= :descripcion, UsuarioDireccion=:direccion, UsuarioNacimiento=:nacimiento, UsuarioGenero=:genero, UsuarioTipo=:tipo, idEscuela=:escuela, idDistrito=:distrito WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":apellidoP",$datos['apellidoP']);
			$sql->bindParam(":apellidoM",$datos['apellidoM']);
			$sql->bindParam(":telefono",$datos['telefono']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":direccion",$datos['direccion']);
			$sql->bindParam(":nacimiento",$datos['nacimiento']);
			$sql->bindParam(":genero",$datos['genero']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql->bindParam(":escuela",$datos['escuela']);
			$sql->bindParam(":distrito",$datos['distrito']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}

	}