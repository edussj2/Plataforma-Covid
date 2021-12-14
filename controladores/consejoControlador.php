<?php 
    /* HECHO */
	if($peticionAjax){
		require_once "../modelos/consejoModelo.php";
	}else{
		require_once "./modelos/consejoModelo.php";
	}

	class consejoControlador extends consejoModelo
	{
		/* AGREGAR */
		public function agregar_consejo_controlador(){

			/*--DATOS DEL consejo--*/
			$titulo = mainModel::limpiar_cadena($_POST['titulo-reg']);
			$consejo = mainModel::limpiar_cadena($_POST['consejo-reg']);
			$tema = mainModel::limpiar_cadena($_POST['tema-reg']);
             
            $foto1 = $_FILES['foto-reg']['name'];
            $ruta1 = $_FILES['foto-reg']['tmp_name'];

            $consulta3 = mainModel::ejecutar_consulta_simple("SELECT idConsejo FROM consejo");
            $numero = ($consulta3->rowCount())+1;
            $codigoFoto= mainModel::generar_codigo_aleatorio("CONSEJO",10,$numero);

            $fotoColegiado="../adjuntos/consejos/".$codigoFoto."-".$foto1;
            copy($ruta1,$fotoColegiado);
            $nombreFoto= $codigoFoto."-".$foto1;

            /*--VALIDACIONES--*/
            if($titulo== "" || $consejo=="" || $foto1=""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT ConsejoTitulo FROM consejo WHERE ConsejoTitulo='$titulo'");
                if($consulta1->rowCount()>=1){
                        
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El titulo que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
            
                }else{

                    $datos=[
                        "titulo"=>$titulo,
                        "descripcion"=>$consejo,
                        "imagen"=>$nombreFoto,
                        "tema"=>$tema
                    ];

                    $guardar = consejoModelo::agregar_consejo_modelo($datos);

                    if($guardar->rowCount()>=1){
                        $alerta = ["Alerta"=>"limpiar", "Titulo"=>"CONSEJO REGISTRADO","Texto"=>"Los datos han sido registrados con éxito","Tipo"=>"success"];
                    }else{
                        @unlink('../adjuntos/consejos/'.$nombreFoto);
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro del consejo, intente nuevamente","Tipo"=>"error"];
                    }
                }
            }    
            
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_consejo_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM consejo WHERE ConsejoTitulo LIKE '%$busqueda%' ORDER BY ConsejoTitulo ASC LIMIT $inicio,$registros";

                $paginaURL = "consejoBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM consejo ORDER BY idConsejo DESC LIMIT $inicio,$registros";

                $paginaURL = "consejoLista";
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
                                    <th scope="col">Tema</th>';
            if($privilegio==1){
                $tabla .= '         
                                    <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM tema WHERE idTema ='".$rows['idTema']."'");
                    $data= $query1->fetch();
                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$rows['ConsejoTitulo'].'</h4>
                                </div>
                                </td>
                                <td>
                                    <div class="identificacion">
                                        <h4>'.$data['TemaTitulo'].'</h4>
                                    </div>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <form action="'.SERVERURL.'ajax/consejoAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idConsejo']).'">
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
                    $tabla .= '<tr> <td colspan="9"><a href="'.SERVERURL.$paginaURL.'/" class="btn btn-info"><i class="fas fa-sync-alt"></i> Haga clic acá para actualizar el listado </a></td></tr>';
                }else{
                    $tabla .= '<tr> <td colspan="9"> NO HAY REGISTOS EN EL SISTEMA </td></tr>';
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

        /* ELIMIANR */
        public function eliminar_consejo_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM consejo WHERE idConsejo='$idCuenta'");

                $datosAD = $query1->fetch();
                $foto = $datosAD['ConsejoImagen'];

                    $eliminar = consejoModelo::eliminar_consejo_modelo($idCuenta);

                    if($eliminar->rowCount()>=1){
                        
                        @unlink('../adjuntos/consejos/'.$foto);

                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"CONSEJO ELIMINADA","Texto"=>"Los datos  se eliminarón satisfactoriamente del sisconsejo","Tipo"=>"success"];
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la consejo, intenté nuevamente","Tipo"=>"error"];
                    }
        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_consejo_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return consejoModelo::datos_consejo_modelo($tipo, $codigo);
        }

        /* MOSTRAR */
		public function total_consejos_controlador($codigo){

            $codigo= mainModel::decryption($codigo);

			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM consejo WHERE idTema = '$codigo' ORDER BY ConsejoTitulo DESC");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No hay consejos!</strong> No hay consejos disponibles en estos momentos.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }else{
                while ($rows = $datos->fetch()) {

                    echo '    
                        <div class="item-consejo">
                                    <div class="imagen-consejo">
                                        <img src="'.SERVERURL.'adjuntos/consejos/'.$rows['ConsejoImagen'].'" alt="">
                                    </div>
                                    <div class="detalles-consejo">
                                        <h4>'.$rows['ConsejoTitulo'].'</h4>
                                        <p>'.$rows['ConsejoDescripcion'].'</p>
                                    </div>
                        </div>';
                }
            }
			
        }

	}
    