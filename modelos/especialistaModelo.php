<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class especialistaModelo extends mainModel
	{
		/* AGREGAR */
		protected function agregar_especialista_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO especialista(EspecialistaNombres,EspecialistaApellidos,EspecialistaDescripcion,EspecialistaExperiencia,EspecialistaFoto, EspecialistaCV,EspecialistaCertificado,EspecialistaLink,EspecialistaCorreo,EspecialistaCelular,idDepartamento,idEspecialidad, EspecialistaCentro, CuentaCodigo) 
			VALUES(:nombres,:apellidos,:descripcion,:experiencia,:foto,:cv,:certificado,:link,:correo,:celular,:departamento,:especialidad,:centro,:cuenta)");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":apellidos",$datos['apellidos']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":experiencia",$datos['experiencia']);
			$sql->bindParam(":foto",$datos['foto']);
			$sql->bindParam(":cv",$datos['cv']);
			$sql->bindParam(":certificado",$datos['certificado']);
			$sql->bindParam(":link",$datos['link']);
			$sql->bindParam(":correo",$datos['correo']);
			$sql->bindParam(":celular",$datos['celular']);
			$sql->bindParam(":departamento",$datos['departamento']);
			$sql->bindParam(":especialidad",$datos['especialidad']);
			$sql->bindParam(":centro",$datos['centro']);
			$sql->bindParam(":cuenta",$datos['cuenta']);
			$sql->execute();

			return $sql;
		}

		/* ELIMINAR */
		protected function eliminar_especialista_modelo($codigo){
			$sql=mainModel::conectar()->prepare("DELETE FROM especialista WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/* DATOS */
		protected function datos_especialista_modelo($tipo, $codigo){
			if($tipo=="Unico"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM especialista WHERE CuentaCodigo = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}elseif($tipo=="Conteo"){
				$sql = mainModel::conectar()->prepare("SELECT idEspecialista FROM especialista");
				$sql->execute();
			}elseif($tipo=="Unico2"){
				$sql = mainModel::conectar()->prepare("SELECT * FROM especialista WHERE idEspecialista = :codigo");
				$sql->bindParam(":codigo",$codigo);
				$sql->execute();
			}
			return $sql;
		}

		/* ACTUALIZAR */
		protected function actualizar_especialista_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE especialista SET EspecialistaNombres=:nombres, EspecialistaApellidos=:apellidos,EspecialistaDescripcion=:descripcion, EspecialistaExperiencia=:experiencia, EspecialistaLink=:link, EspecialistaCorreo=:correo, EspecialistaCelular=:celular,idDepartamento=:departamento,idEspecialidad=:especialidad,EspecialistaCentro=:centro WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":apellidos",$datos['apellidos']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":experiencia",$datos['experiencia']);
			$sql->bindParam(":link",$datos['link']);
			$sql->bindParam(":correo",$datos['correo']);
			$sql->bindParam(":celular",$datos['celular']);
			$sql->bindParam(":departamento",$datos['departamento']);
			$sql->bindParam(":especialidad",$datos['especialidad']);
			$sql->bindParam(":centro",$datos['centro']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}

		/* ACTUALIZAR FOTO*/
		protected function actualizar_foto_especialista_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE especialista SET EspecialistaFoto=:foto WHERE CuentaCodigo=:codigo");
			$sql->bindParam(":foto",$datos['foto']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}

		/* ACTUALIZAR CV*/
		protected function actualizar_cv_especialista_modelo($datos){
			$sql = mainModel::conectar()->prepare("UPDATE especialista SET EspecialistaCV=:cv WHERE CuentaCodigo=:codigo");
			$sql->bindParam(":cv",$datos['cv']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();
			
			return $sql;
		}
		
	}