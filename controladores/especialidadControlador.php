<?php
    /*HECHO*/
	if($peticionAjax){
		require_once "../modelos/especialidadModelo.php";
	}else{
		require_once "./modelos/especialidadModelo.php";
	}

	class especialidadControlador extends especialidadModelo
	{
		/* AGREGAR */
		public function agregar_especialidad_controlador(){

			/*--DATOS DEL especialidad--*/
			$descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);

            /*--VALIDACIONES--*/
            if($descripcion== ""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT EspecialidadDescripcion FROM especialidad WHERE EspecialidadDescripcion='$descripcion'");
                    
                    if($consulta1->rowCount()>=1){
                        
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"La descripción que ingresaste ya se encuentra registrada, intente nuevamente","Tipo"=>"warning"];
                    
                    }else{

                            $datos=[
                                    "descripcion"=>$descripcion,
                                    "vigencia"=>1
                                    ];

                            $guardarespecialidad = especialidadModelo::agregar_especialidad_modelo($datos);

                            if($guardarespecialidad->rowCount()>=1){
                                    $alerta = ["Alerta"=>"limpiar", "Titulo"=>"ESPECIALIDAD REGISTRADA","Texto"=>"Los datos fuerón registrados con éxito.","Tipo"=>"success"];
                            }else{
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la especialidad, intente nuevamente","Tipo"=>"error"];
                            }            
                    }
                
                
            }    
            
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_especialidad_controlador($pagina,$registros,$privilegio,$busqueda){
       
             /**-----LIMPIAMOS PARAMETROS RECIBIDOS-----**/
            $pagina = mainModel::limpiar_cadena($pagina);
            $registros = mainModel::limpiar_cadena($registros);
            $privilegio = mainModel::limpiar_cadena($privilegio);
            $busqueda = mainModel::limpiar_cadena($busqueda);

            $tabla = "";

            /**-----VALIDAMOS LAS PAGINAS Y EL ORDEN DE LOS REGISTROS----**/
            $pagina = (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
            $inicio = ($pagina>0) ? (($pagina * $registros) - $registros): 0;

            /**-----VALIDAMOS SI ES UNA BUSQUEDA O SI ES LA LISTA---**/
            if(isset($busqueda) && $busqueda!=""){
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM especialidad WHERE EspecialidadDescripcion LIKE '%$busqueda%' ORDER BY especialidadDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "especialidadBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM especialidad  ORDER BY EspecialidadDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "especialidadLista";
            }

             /**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
            $conexion = mainModel::conectar();
            $datos = $conexion->query($consulta);
            $datos = $datos->fetchAll();

            /**-----CALCULAMOS EL TOTAL DE REGISTROS----**/
            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            /**-----CALCULAMOS EL TOTAL DE PAGINAS----**/
            $Npaginas = ceil($total/$registros);

            /**-----GENERAMOS TABLA---**/
            $tabla .= '<div class="table-responsive">
                        <table class="table table-hover text-center tabla-especialitas">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Identificación</th>';
            if($privilegio==1){
                $tabla .= '         <th scope="col">Editar</th> 
                                    <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$rows['EspecialidadDescripcion'].'</h4>
                                </div>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'especialidadEditar/'.mainModel::encryption($rows['idEspecialidad']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="'.SERVERURL.'ajax/especialidadAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idEspecialidad']).'">
                                            <input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
                                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Eliminar" data-placement="bottom">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                            <div class="RespuestaAjax"></div>
                                        </form>
                                    </td>';
                        }

                    $tabla .= '</tr>';
                    $contador++;
                }
            }else{
                if($total>=1){
                    $tabla .= '<tr> <td colspan="7"><a href="'.SERVERURL.$paginaURL.'/" class="btn btn-info"><i class="fas fa-sync-alt"></i> Haga clic acá para actualizar el listado </a></td></tr>';
                }else{
                    $tabla .= '<tr> <td colspan="7"> NO HAY REGISTOS EN EL SISTEMA </td></tr>';
                }
            }

            $tabla .= '     </tbody>
                        </table>
                        <small class="p-2 float-right" style="color: #333;">Si estas en un dispósitivo móvil, desliza sobre la tabla para ver más detalles</small>
                    </div>';

            /**-----GENERAMOS PAGINADOR---**/
            if($total>=1 && $pagina <= $Npaginas){

                $tabla.='<nav aria-label="Page navigation" class="d-flex justify-content-center mt-2 mb-2"><ul class="pagination">';

                if($pagina==1){
                    $tabla.= '<li class="page-item"><a class="page-link inactivo"><span aria-hidden="true">&laquo;</span></a></li>';
                }else{
                    $tabla.= '<li class="page-item"><a class="page-link" href="'.SERVERURL.$paginaURL.'/'.($pagina-1).'/" ><span aria-hidden="true">&laquo;</span></a></li>';
                }

                /*BOTONES QUE MOSTRARAS*/
                $ci=0;
                $botones = 5;

                for ($i=$pagina; $i <= $Npaginas ; $i++) {
                    if($ci >=$botones){
                        break;
                    } 
                    if($pagina == $i){
                        $tabla.= '<li class="page-item"><a class="page-link activo" href="'.SERVERURL.$paginaURL.'/'.$i.'">'.$i.'</a></li>';
                    }else{
                        $tabla.= '<li class="page-item"><a class="page-link" href="'.SERVERURL.$paginaURL.'/'.$i.'">'.$i.'</a></li>';
                    }
                    $ci++;
                }

                if($pagina==$Npaginas){
                    $tabla.= '<li class="page-item"><a class="page-link inactivo"><span aria-hidden="true">&raquo;</span></a></li>';
                }else{
                    $tabla.= '<li class="page-item"><a class="page-link" href="'.SERVERURL.$paginaURL.'/'.($pagina+1).'/" ><span aria-hidden="true">&raquo;</span></a></li>';
                }

                $tabla.='</ul></nav>';
            }
            return $tabla;
        }

        /* ELIMINAR */
        public function eliminar_especialidad_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $eliminar = especialidadModelo::eliminar_especialidad_modelo($idCuenta);

                if($eliminar->rowCount()>=1){

                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"ESPECIALIDAD ELIMINADA","Texto"=>"La especialidad se eliminó satisfactoriamente del sistema","Tipo"=>"success"];

                }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la especialidad, intenté nuevamente","Tipo"=>"error"];
                }
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS DEL ADMINISTRADOR */
        public function datos_especialidad_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return especialidadModelo::datos_especialidad_modelo($tipo, $codigo);
        }

        /* ACTUALIZA R*/
        public function actualizar_especialidad_controlador(){

            $codigo = mainModel::decryption($_POST['codigo-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-up']);
            $vigencia = mainModel::limpiar_cadena($_POST['vigencia-up']);

            if($descripcion== ""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialidad WHERE idEspecialidad ='$codigo'");

            $datos = $consulta1->fetch();

            if($descripcion != $datos['EspecialidadDescripcion']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT EspecialidadDescripcion FROM especialidad WHERE EspecialidadDescripcion ='$descripcion'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El nombre de la especialidad ingresada ya ha sido registrada en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            if(is_numeric($vigencia)==true && $vigencia>=2){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"La vigencia no es válida","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $datos= ["descripcion"=>$descripcion,"vigencia"=>$vigencia,"id"=>$codigo];

            if(especialidadModelo::actualizar_especialidad_modelo($datos)->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"ESPECIALIDAD ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos de la especialidad, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

	}
    