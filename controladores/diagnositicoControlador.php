<?php 
	if($peticionAjax){
		require_once "../modelos/diagnosticoModelo.php";
	}else{
		require_once "./modelos/diagnosticoModelo.php";
	}

	class diagnositicoControlador extends diagnosticoModelo
	{

        /* ELIMINAR */
        public function eliminar_diagnostico_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                    $eliminar = diagnosticoModelo::eliminar_diagnostico_modelo($idCuenta);

                    if($eliminar->rowCount()>=1){
                        

                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"DIAGNOSTICO ELIMINADO","Texto"=>"Los datos  se eliminarón satisfactoriamente del sistema","Tipo"=>"success"];
    
                        
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar el diagnostico, intenté nuevamente","Tipo"=>"error"];
                    }
        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_diagnostico_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return diagnosticoModelo::datos_diagnostico_modelo($tipo, $codigo);
        }

        /* AGREGAR */
        public function agregar_diagnostico_controlador(){

			$atecion = mainModel::decryption($_POST['atencion-reg']);
            $diagnostico = mainModel::limpiar_cadena($_POST['respuesta-reg']);
            $estado =1;


            /*--VALIDACIONES--*/
            if( $diagnostico=="" || $atecion==""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
                
                $datos=["atencion"=>$atecion,
                        "descripcion"=>$diagnostico,
                        "estado"=>$estado,
                        ];

                $guardar = diagnosticoModelo::agregar_diagnostico_modelo($datos);

                if($guardar->rowCount()>=1){
                        $data=[
                            "estado"=>$estado,
                            "id"=>$atecion
                        ];
                        mainModel::actualizar_atencion_modelo($data);
                        $alerta = ["Alerta"=>"recargar", "Titulo"=>"DIAGNOSTICO REGISTRADO","Texto"=>"La diagnostico se registró con éxito, espere respuesta del especialista","Tipo"=>"success"];
                }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la diagnostico, intente nuevamente","Tipo"=>"error"];
                }          
                      
            }    
            
            return mainModel::sweet_alert($alerta);
        }

    
	}
    