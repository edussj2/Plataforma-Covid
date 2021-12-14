<?php 
    /* HECHO */
	if($peticionAjax){
		require_once "../modelos/grabacionModelo.php";
	}else{
		require_once "./modelos/grabacionModelo.php";
	}

	class grabacionControlador extends grabacionModelo
	{
		/* AGREGAR */
		public function agregar_grabacion_controlador(){

			$conferencia = mainModel::limpiar_cadena($_POST['conferencia-reg']);
            $enlace = $_POST['enlace-reg'];
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);

            /*--VALIDACIONES--*/
            if($conferencia== "" || $enlace=="" || $descripcion==""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT GrabacionEnlace FROM grabacion WHERE GrabacionEnlace='$enlace'");
                    
                    if($consulta1->rowCount()>=1){
                        
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El enlace que ingresaste ya se encuentra registrada, intente nuevamente","Tipo"=>"warning"];
                    
                    }else{

                            $datos=[
                                    "enlace"=>$enlace,
                                    "descripcion"=>$descripcion,
                                    "conferencia"=>$conferencia
                                    ];

                            $guardar = grabacionModelo::agregar_grabacion_modelo($datos);

                            if($guardar->rowCount()>=1){
                                    $alerta = ["Alerta"=>"limpiar", "Titulo"=>"GRABACIÓ REGISTRADA","Texto"=>"La grabación se registró con éxito","Tipo"=>"success"];
                            }else{
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro, intente nuevamente","Tipo"=>"error"];
                            }  
                    }
            }    
            
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_grabacion_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM grabacion WHERE (GrabacionDescripcion LIKE '%$busqueda%') ORDER BY GrabacionDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "grabacionBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM grabacion  ORDER BY GrabacionDescripcion ASC LIMIT $inicio,$registros";

                $paginaURL = "grabacionLista";
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
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Descripcion</th>
                                    <th scope="col">Enlace</th>';
            if($privilegio==1){
                $tabla .= '        <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM conferencia WHERE idConferencia ='".$rows['idConferencia']."'");
                    $datos= $query1->fetch();

                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$datos['ConferenciaTitulo'].'</h4>
                                </div>
                                </td>
                                <td>'.$rows['GrabacionDescripcion'].'</td>
                                <td>
                                    <a href="'.$rows['GrabacionEnlace'].'" target="_blank" class="btn btn-info" data-toggle="tooltip" title="Grabacion" data-placement="bottom">
                                        <i class="fas fa-link"></i>
                                    </a>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <form action="'.SERVERURL.'ajax/grabacionAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idGrabacion']).'">
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
        public function eliminar_grabacion_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $eliminar = grabacionModelo::eliminar_grabacion_modelo($idCuenta);

                if($eliminar->rowCount()>=1){

                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"GRABACION ELIMINADA","Texto"=>"La escuela se eliminó satisfactoriamente del sistema","Tipo"=>"success"];

                }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la grabación, intenté nuevamente","Tipo"=>"error"];
                }
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_grabacion_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return escuelaModelo::datos_escuela_modelo($tipo, $codigo);
        }

        /* TABLA DATATABLE*/
		public function tabla_grabaciones_controlador(){
			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM grabacion ORDER BY idGrabacion DESC");

            echo '<table class="table table-hover table-responsive" id="datatableEnlace">
                    <thead class="bg-primary " style="color: #fff;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Título</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Enlace</th>
                        </tr>
                    </thead>
                    <tbody>';
            if($datos->rowCount()==0){
                echo'<tr class="p-5"> <td colspan="8" class="p-5"><i class="fas fa-info-circle"></i> NO HAY REGISTOS EN EL SISTEMA </td></tr>';
            }else{
                $contador=1;
                while ($rows = $datos->fetch()) {
                    $datosP = mainModel::ejecutar_consulta_simple("SELECT * FROM conferencia WHERE idConferencia='".$rows['idConferencia']."'");
                    $conferencia = $datosP->fetch();

                    echo '
                    <tr>
                        <th scope="row">'.$contador.'</th>
                        <td>'.$conferencia['ConferenciaTitulo'].'</td>
                        <td>'.$rows['GrabacionDescripcion'].'</td>
                        <td class="d-flex justify-content-center"><a href="'.$rows['GrabacionEnlace'].'" class="btn btn-primary" target="_blank"><i class="fas fa-link"></i></a></td>
                    </tr>
                    ';
                    $contador++;
                }
            }
            echo '</tbody></table><small class="text-muted">Si esta en un dispositivo móvil deslize la pantalla de manera horizontal en la tabla.</small>
          ';
			
        }

	}
    