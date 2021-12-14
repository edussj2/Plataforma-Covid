<?php 
    /* HECHO */
	if($peticionAjax){
		require_once "../config/mainModel.php";
	}else{
		require_once "./config/mainModel.php";
	}

	class bitacoraControlador extends mainModel
	{
		/* BITACORA EN PERFIL*/
		public function listado_bitacora_controlador($registros,$codigo){

            $registros= mainModel::limpiar_cadena($registros);
            $codigo= mainModel::decryption($codigo);

			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM bitacora WHERE CuentaCodigo = '$codigo' ORDER BY id DESC LIMIT $registros");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-secondary" role="alert">
                         <i class="fas fa-exclamation-circle"></i> No hay registro de conexiones registradas de este usuario
                    </div>';
            }else{
                while ($rows = $datos->fetch()) {
                    echo '
                        <p>
                            <i class="fas fa-sign-in-alt" style="color: #4F9B48;"></i> &nbsp;Inicio: '.$rows['BitacoraFecha'].', '.$rows['BitacoraHoraInicio'].'<br>
                            <i class="fas fa-sign-out-alt"style="color: #AF2828;"></i> &nbsp;Salida: '.$rows['BitacoraFecha'].', '.$rows['BitacoraHoraFinal'].'
                        </p>
                    ';
                }
            }
			
		}
	}