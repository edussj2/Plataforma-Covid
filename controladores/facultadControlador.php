<?php 
	if($peticionAjax){
		require_once "../modelos/facultadModelo.php";
	}else{
		require_once "./modelos/facultadModelo.php";
	}
    /*HECHO*/
	class facultadControlador extends facultadModelo
	{
		/* AGREGAR */
		public function agregar_facultad_controlador(){

			/*--DATOS DEL facultad--*/
			$descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);
            $siglas = mainModel::limpiar_cadena($_POST['siglas-reg']);
            $vigencia=1;


            /*--VALIDACIONES--*/
            if($descripcion== "" || $siglas==""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT FacultadDescripcion FROM facultad WHERE FacultadDescripcion='$descripcion'");
                    
                    if($consulta1->rowCount()>=1){
                        
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"La descripción que ingresaste ya se encuentra registrada, intente nuevamente","Tipo"=>"warning"];
                    
                    }else{

                        $consulta2 = mainModel::ejecutar_consulta_simple("SELECT FacultadSiglas FROM facultad WHERE FacultadSiglas='$siglas'");
                        if($consulta2->rowCount()>=1){

                                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Las siglas ingresadas ya se encuentran registradas, intente nuevamente","Tipo"=>"warning"];
                        
                        }else{

                            $datos=[
                                    "descripcion"=>$descripcion,
                                    "siglas"=>$siglas,
                                    "vigencia"=>$vigencia
                                    ];

                            $guardarfacultad = facultadModelo::agregar_facultad_modelo($datos);

                            if($guardarfacultad->rowCount()>=1){
                                    $alerta = ["Alerta"=>"limpiar", "Titulo"=>"FACULTAD REGISTRADA","Texto"=>"El facultad se registró con éxito","Tipo"=>"success"];
                            }else{
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la facultad, intente nuevamente","Tipo"=>"error"];
                            }
                                    
                        }
                            
                    }
                
                
            }    
            
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_facultad_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM facultad WHERE (FacultadDescripcion LIKE '%$busqueda%' OR FacultadSiglas LIKE '%$busqueda%')) ORDER BY FacultadDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "facultadBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM facultad  ORDER BY FacultadDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "facultadLista";
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
                                    <th scope="col">Siglas</th>';
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
                                    <h4>'.$rows['FacultadDescripcion'].'</h4>
                                </div>
                                </td>
                                <td>'.$rows['FacultadSiglas'].'</td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'facultadEditar/'.mainModel::encryption($rows['idFacultad']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="'.SERVERURL.'ajax/facultadAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idFacultad']).'">
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
                    $tabla .= '<tr> <td colspan="5"><a href="'.SERVERURL.$paginaURL.'/" class="btn btn-info"><i class="fas fa-sync-alt"></i> Haga clic acá para actualizar el listado </a></td></tr>';
                }else{
                    $tabla .= '<tr> <td colspan="5"> NO HAY REGISTOS EN EL SISTEMA </td></tr>';
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
        public function eliminar_facultad_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $eliminar = facultadModelo::eliminar_facultad_modelo($idCuenta);

                if($eliminar->rowCount()>=1){

                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"FACULTAD ELIMINADA","Texto"=>"Los datos se eliminarón con éxito","Tipo"=>"success"];

                }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la facultad porque ha sido registrada para alguna escuela., intenté nuevamente","Tipo"=>"error"];
                }
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_facultad_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return facultadModelo::datos_facultad_modelo($tipo, $codigo);
        }

        /* ACTUALIZAR */
        public function actualizar_facultad_controlador(){

            $codigo = mainModel::decryption($_POST['codigo-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-up']);
            $siglas = mainModel::limpiar_cadena($_POST['siglas-up']);
            $vigencia = mainModel::limpiar_cadena($_POST['vigencia']);

            if($descripcion== "" || $siglas==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM facultad WHERE idFacultad ='$codigo'");

            $datos = $consulta1->fetch();

            if($descripcion != $datos['FacultadDescripcion']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT FacultadDescripcion FROM facultad WHERE FacultadDescripcion ='$descripcion'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El nombre de la facultad ingresada ya ha sido registrada en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            if($siglas != $datos['FacultadSiglas']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT FacultadSiglas FROM facultad WHERE FacultadSiglas ='$siglas'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El nombre de las siglas ingresadas ya han sido registradas en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

 

            $datos= ["descripcion"=>$descripcion,"siglas"=>$siglas,"vigencia"=>$vigencia,"id"=>$codigo];

            if(facultadModelo::actualizar_facultad_modelo($datos)->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"FACULTAD ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos de la facultad, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

	}
    