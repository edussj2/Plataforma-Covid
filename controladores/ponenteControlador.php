<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class ponenteControlador extends mainModel
	{
		/* DATOS */
		public function datos_ponente_controlador($codigo){

			$codigo = mainModel::decryption($codigo);

			return mainModel::datos_ponente($codigo);
		}

		/* ACTUALIZAR */
		public function actualizar_ponente_controlador(){

            $codigo = mainModel::decryption($_POST['codigo-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-up']);
            $nombres = mainModel::limpiar_cadena($_POST['nombres-up']);

            if($descripcion== "" || $nombres==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }
 

            $datos= ["nombres"=>$descripcion,"descripcion"=>$descripcion,"codigo"=>$codigo];

            if(mainModel::actualizar_ponente($datos)->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"PONENTE ACTUALIZADO","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos de la facultad, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
		}
	}