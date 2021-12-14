<?php 
	/*HECHO */
	if($peticionAjax){
		require_once "../modelos/provinciaModelo.php";
	}else{
		require_once "./modelos/provinciaModelo.php";
	}

	class provinciaControlador extends provinciaModelo
	{
		/* DATOS */
        public function datos_provincia_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return provinciaModelo::datos_provincia_modelo($tipo, $codigo);
        }

	}