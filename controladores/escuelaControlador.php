<?php 
    /*HECHO*/
	if($peticionAjax){
		require_once "../modelos/escuelaModelo.php";
	}else{
		require_once "./modelos/escuelaModelo.php";
	}

    /*HECHO*/
	class escuelaControlador extends escuelaModelo
	{
		/* AGREGAR */
		public function agregar_escuela_controlador(){

			$descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);
            $facultad = mainModel::limpiar_cadena($_POST['facultad-reg']);
            $vigencia=1;


            /*--VALIDACIONES--*/
            if($descripcion== ""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT EscuelaDescripcion FROM Escuela WHERE EscuelaDescripcion='$descripcion'");
                
                if($consulta1->rowCount()>=1){
                    
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"La descripción que ingresaste ya se encuentra registrada, intente nuevamente","Tipo"=>"warning"];
                
                }else{

                    if($vigencia >= 2){

                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"La vigencia ingresada no ess válida.","Tipo"=>"warning"];
                    
                    }else{

                        $datos=[
                                "descripcion"=>$descripcion,
                                "vigencia"=>$vigencia,
                                "facultad"=>$facultad
                                ];

                        $guardar = escuelaModelo::agregar_escuela_modelo($datos);

                        if($guardar->rowCount()>=1){
                                $alerta = ["Alerta"=>"limpiar", "Titulo"=>"ESCUELA REGISTRADA","Texto"=>"Los datos se registrarón con éxito","Tipo"=>"success"];
                        }else{
                                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la escuela, intente nuevamente","Tipo"=>"error"];
                        }
                                
                    }    
                }
            }     
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_escuela_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM escuela WHERE EscuelaDescripcion LIKE '%$busqueda%' ORDER BY EscuelaDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "escuelaBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM escuela  ORDER BY EscuelaDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "escuelaLista";
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
                                    <th scope="col">Identificación</th>
                                    <th scope="col">Facultad</th>';
            if($privilegio==1){
                $tabla .= '         <th scope="col">Editar</th> 
                                    <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM facultad WHERE idFacultad ='".$rows['idFacultad']."'");
                    $datos= $query1->fetch();

                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$rows['EscuelaDescripcion'].'</h4>
                                </div>
                                </td>
                                <td>'.$datos['FacultadDescripcion'].'</td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'escuelaEditar/'.mainModel::encryption($rows['idEscuela']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="'.SERVERURL.'ajax/escuelaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="cuenta-del" value="'.mainModel::encryption($rows['idEscuela']).'">
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
                    $tabla .= '<tr> <td colspan="6"><a href="'.SERVERURL.$paginaURL.'/" class="btn btn-info"><i class="fas fa-sync-alt"></i> Haga clic acá para actualizar el listado </a></td></tr>';
                }else{
                    $tabla .= '<tr> <td colspan="6"> NO HAY REGISTOS EN EL SISTEMA </td></tr>';
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

        /**-----CONTROLADOR FUNCION PARA ELIMIANR ADMINISTRADOR-----**/
        public function eliminar_escuela_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['cuenta-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $eliminar = escuelaModelo::eliminar_escuela_modelo($idCuenta);

                if($eliminar->rowCount()>=1){

                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"ESCUELA ELIMINADA","Texto"=>"La escuela se eliminó satisfactoriamente del sistema","Tipo"=>"success"];

                }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la escuela, intenté nuevamente","Tipo"=>"error"];
                }
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_escuela_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return escuelaModelo::datos_escuela_modelo($tipo, $codigo);
        }

        /* ACTULIZAR*/
        public function actualizar_escuela_controlador(){

            $codigo = mainModel::decryption($_POST['codigo-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-up']);
            $vigencia = mainModel::limpiar_cadena($_POST['vigencia']);
            $facultad = mainModel::limpiar_cadena($_POST['facultad-up']);

            if($descripcion== "" || $vigencia==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM escuela WHERE idEscuela ='$codigo'");

            $datos = $consulta1->fetch();

            if($descripcion != $datos['EscuelaDescripcion']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT EscuelaDescripcion FROM escuela WHERE EscuelaDescripcion ='$descripcion'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El nombre de la escuela ingresada ya ha sido registrada en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            $datos= ["descripcion"=>$descripcion,"vigencia"=>$vigencia,"facultad"=>$facultad,"id"=>$codigo];

            if(escuelaModelo::actualizar_escuela_modelo($datos)->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"ESCUELA ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos de la facultad, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

	}
    