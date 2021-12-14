<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../modelos/distritoModelo.php";
	}else{
		require_once "./modelos/distritoModelo.php";
	}

	class distritoControlador extends distritoModelo
	{
		/* DATOS */
        public function datos_distrito_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return distritoModelo::datos_distrito_modelo($tipo, $codigo);
        }

	}