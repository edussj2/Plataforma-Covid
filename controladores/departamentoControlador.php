<?php 
	/* HECHO */
	if($peticionAjax){
		require_once "../modelos/departamentoModelo.php";
	}else{
		require_once "./modelos/departamentoModelo.php";
	}

	class departamentoControlador extends departamentoModelo
	{
		/* DATOS */
        public function datos_departamento_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return departamentoModelo::datos_departamento_modelo($tipo, $codigo);
        }

	}