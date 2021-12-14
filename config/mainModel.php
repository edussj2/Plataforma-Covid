<?php
	if($peticionAjax){
		require_once "../config/configDB.php";
	}else{
		require_once "./config/configDB.php";
	}
	class mainModel
	{
		
		/*********************************/
		/******* FUNCIONES BASICAS *******/
		/*********************************/

		/*Conectar*/
		protected function conectar(){
		    $conexion = new PDO(SGBD,USER,PASS);

		    return $conexion;
		}

		/*Consultas Simples*/
		protected function ejecutar_consulta_simple($consulta){
			$sql = self::conectar()->prepare($consulta);
			$sql->execute();
			return $sql;
		}

		/*Encryptar*/
		public static function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

		/*Desincriptar*/
		public static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
		}

		/*Código Aleatorio*/
		protected function generar_codigo_aleatorio($letra,$longitud,$num){
			for($i=1 ; $i<=$longitud; $i++){
				$numero = rand(0,9);
				$letra.= $numero;
			}

			return $letra.$num;
		}

		/*Limpiar Cadena*/
		protected function limpiar_cadena($cadena){
			$cadena = str_ireplace("<script>","", $cadena); //QUITA Y REMPLAZA SEGUN QUERRÁMOS
			$cadena = str_ireplace("</script>","", $cadena);
			$cadena = str_ireplace("<script src","", $cadena);
			$cadena = str_ireplace("<script type","", $cadena);
			$cadena = str_ireplace("SELECT *  FROM","", $cadena);
			$cadena = str_ireplace("DELETE FROM","", $cadena);
			$cadena = str_ireplace("INSERT INTO","", $cadena);
			$cadena = str_ireplace("UPDATE SET","", $cadena);
			$cadena = str_ireplace("[","", $cadena);
			$cadena = str_ireplace("]","", $cadena);
			$cadena = str_ireplace("==","", $cadena);
			$cadena = str_ireplace("DROP TABLE","", $cadena);
			$cadena = str_ireplace("SHOW TABLES","", $cadena);
			$cadena = str_ireplace("SHOW DATABASES","", $cadena);
			$cadena = str_ireplace("<?php","", $cadena);
			$cadena = str_ireplace("?>","", $cadena);
			$cadena = str_ireplace("DELETE administrador","", $cadena);
			$cadena = str_ireplace("DELETE colegiado","", $cadena);
			$cadena = str_ireplace("::","", $cadena);
			$cadena = trim($cadena);//QUITA ESPACIOS EN BLANCO
			$cadena = stripcslashes($cadena);//QUITA BARRAS INVERTIDAS
			return $cadena;
		}

		/*Verificar Fechas*/
		protected function verificar_fecha($fecha){
			$valores = explode('/', $fecha);
			if(count($valores)==3 && checkdate($valores[1], $valores[0], $valores[2])){
				return false;
			}else{
				return true;
			}
		}

        /*Alertas*/
		protected function sweet_alert($datos){
			if($datos['Alerta']=="simple"){
				$alerta = "<script>
							  swal(
								'".$datos['Titulo']."',
								'".$datos['Texto']."',
								'".$datos['Tipo']."'
							  );
						   </script>";
			}elseif ($datos['Alerta']=="recargar") {
				$alerta = "<script>
							  swal({
								title: '".$datos['Titulo']."',
								text: '".$datos['Texto']."',
								type: '".$datos['Tipo']."',
								confirmButtonText: 'Aceptar'
								}).then(function () {
									location = window.location;
								});
						   </script>";
			}elseif ($datos['Alerta']=="limpiar") {
				$alerta = "<script>
							  swal({
								title: '".$datos['Titulo']."',
								text: '".$datos['Texto']."',
								type: '".$datos['Tipo']."',
								confirmButtonText: 'Aceptar'
								}).then(function () {
									$('.FormularioAjax')[0].reset();
									$('.FormularioAjax').removeClass('was-validated');
									$('.FormularioAjax').addClass('needs-validation');
								});
						   </script>";
			}elseif ($datos['Alerta']=="redirigir") {
				$alerta = "<script>
							  swal({
								title: '".$datos['Titulo']."',
								text: '".$datos['Texto']."',
								type: '".$datos['Tipo']."',
								confirmButtonText: 'Aceptar'
								}).then(function () {
									window.location.href='".SERVERURL.$datos['Enlace']."';
								});
						   </script>";
			}
			return $alerta;
		}

		/*********************************/
		/***** Fin- FUNCIONES BASICAS ****/
		/*********************************/






		/*********************************/
		/******       CUENTA       *******/
		/*********************************/

		/*AGREGAR*/
		protected function agregar_cuenta($datos){
			$sql = self::conectar()->prepare("INSERT INTO cuenta(CuentaCodigo, CuentaPrivilegio, CuentaCorreo, CuentaClave, CuentaVigencia, CuentaTipo, CuentaAvatar) 
				VALUES(:codigo,:privilegio,:correo,:clave,:vigencia,:tipo,:avatar)");

			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->bindParam(":privilegio",$datos['privilegio']);
			$sql->bindParam(":correo",$datos['correo']);
			$sql->bindParam(":clave",$datos['clave']);
			$sql->bindParam(":vigencia",$datos['vigencia']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql->bindParam(":avatar",$datos['avatar']);
			$sql->execute();

			return $sql;
		}

		/*ELIMINAR*/
		protected function eliminar_cuenta($codigo){
			$sql = self::conectar()->prepare("DELETE FROM cuenta WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/*ACTUALIZAR*/
		protected function actualizar_cuenta($datos){
			$sql = self::conectar()->prepare("UPDATE cuenta SET CuentaCorreo=:correo, CuentaClave=:clave  WHERE CuentaCodigo=:id");

			$sql->bindParam(":id",$datos['id']);
			$sql->bindParam(":correo",$datos['correo']);
			$sql->bindParam(":clave",$datos['clave']);
			$sql->execute();

			return $sql;
		}

		/*ACTUALIZAR AVATAR*/
		protected function actualizar_avatar_cuenta($codigo,$avatar){
			$sql = self::conectar()->prepare("UPDATE cuenta SET CuentaAvatar=:avatar WHERE CuentaCodigo=:codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->bindParam(":avatar",$avatar);
			$sql->execute();

			return $sql;
		}

		/*DATOS*/
		protected function datos_cuenta($codigo,$tipo){
			$sql = self::conectar()->prepare("SELECT * FROM cuenta WHERE CuentaCodigo=:id AND CuentaTipo=:tipo");

			$sql->bindParam(":id",$codigo);
			$sql->bindParam(":tipo",$tipo);
			$sql->execute();

			return $sql;
		}

		/*********************************/
		/******   Fin - CUENTA     *******/
		/*********************************/





		/*********************************/
		/******       BITACORA     *******/
		/*********************************/

		/*GUARDAR*/
		protected function guardar_bitacora($datos){
			$sql = self::conectar()->prepare("INSERT INTO bitacora(BitacoraCodigo,BitacoraFecha,BitacoraHoraInicio,BitacoraHoraFinal,BitacoraTipo,BitacoraYear,CuentaCodigo) VALUES(:codigo,:fecha,:inicio,:final,:tipo,:year,:cuenta)");

			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->bindParam(":fecha",$datos['fecha']);
			$sql->bindParam(":inicio",$datos['inicio']);
			$sql->bindParam(":final",$datos['final']);
			$sql->bindParam(":tipo",$datos['tipo']);
			$sql->bindParam(":year",$datos['year']);
			$sql->bindParam(":cuenta",$datos['cuenta']);
			$sql->execute();

			return $sql;
		}

		/*ACTULIZAR*/
		protected function actualizar_bitarcora($codigo,$hora){
			$sql = self::conectar()->prepare("UPDATE bitacora SET BitacoraHoraFinal=:hora WHERE BitacoraCodigo = :codigo");

			$sql->bindParam(":hora",$hora);
			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/*ELIMINAR**/
		protected function eliminar_bitarcora($codigo){
			$sql = self::conectar()->prepare("DELETE FROM bitacora WHERE CuentaCodigo = :codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/*********************************/
		/****     Fin - BITACORA     *****/
		/*********************************/





		/*********************************/
		/********     PONENTE   **********/
		/*********************************/

		/*GUARDAR*/
		protected function guardar_ponente($datos){
			$sql = self::conectar()->prepare("INSERT INTO ponente(PonenteNombres,PonenteDescripcion,PonenteCodigo) VALUES(:nombres,:descripcion,:codigo)");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();

			return $sql;
		}

		/*DATOS*/
		protected function datos_ponente($codigo){
			$sql = self::conectar()->prepare("SELECT * FROM ponente WHERE idPonente=:id ");

			$sql->bindParam(":id",$codigo);
			$sql->execute();

			return $sql;
		}

		/*ACTUALIZAR*/
		protected function actualizar_ponente($datos){
			$sql = self::conectar()->prepare("UPDATE ponente SET PonenteNombres=:nombres,  PonenteDescripcion=:descripcion WHERE idPonente= :codigo");

			$sql->bindParam(":nombres",$datos['nombres']);
			$sql->bindParam(":descripcion",$datos['descripcion']);
			$sql->bindParam(":codigo",$datos['codigo']);
			$sql->execute();

			return $sql;
		}

		/*ELIMINAR*/
		protected function eliminar_ponente($codigo){
			$sql = self::conectar()->prepare("DELETE FROM ponente WHERE idPonente = :codigo");

			$sql->bindParam(":codigo",$codigo);
			$sql->execute();

			return $sql;
		}

		/*********************************/
		/******   Fin - PONENTE   ********/
		/*********************************/


		/* ACTUALIZAR ESTADO */
		protected function actualizar_atencion_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE atencion SET AtencionEstado = :estado WHERE idAtencion=:id");
			$sql->bindParam(":estado",$datos['estado']);
			$sql->bindParam(":id",$datos['id']);
			$sql->execute();
			return $sql;
		}
	}