<?php 
	if($peticionAjax){
		require_once "../modelos/temaModelo.php";
	}else{
		require_once "./modelos/temaModelo.php";
	}

	class temaControlador extends temaModelo
	{
		/* AGREGAR */
		public function agregar_tema_controlador(){

			/*--DATOS DEL tema--*/
			$titulo = mainModel::limpiar_cadena($_POST['titulo-reg']);
             
            $foto1 = $_FILES['foto-reg']['name'];
            $ruta1 = $_FILES['foto-reg']['tmp_name'];

            $consulta3 = mainModel::ejecutar_consulta_simple("SELECT idTema FROM tema");
            $numero = ($consulta3->rowCount())+1;
            $codigoFoto= mainModel::generar_codigo_aleatorio("TEMA",10,$numero);

            $fotoColegiado="../adjuntos/temas/".$codigoFoto."-".$foto1;
            copy($ruta1,$fotoColegiado);
            $nombreFoto= $codigoFoto."-".$foto1;

            /*--VALIDACIONES--*/
            if($titulo== "" || $foto1=""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT TemaTitulo FROM tema WHERE TemaTitulo='$titulo'");
                if($consulta1->rowCount()>=1){
                        
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El titulo que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
            
                }else{

                    $datos=[
                        "titulo"=>$titulo,
                        "imagen"=>$nombreFoto
                    ];

                    $guardar = temaModelo::agregar_tema_modelo($datos);

                    if($guardar->rowCount()>=1){
                        $alerta = ["Alerta"=>"limpiar", "Titulo"=>"TEMA REGISTRADO","Texto"=>"Los datos han sido registrados con éxito","Tipo"=>"success"];
                    }else{
                        @unlink('../adjuntos/temas/'.$nombreFoto);
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro deL tema, intente nuevamente","Tipo"=>"error"];
                    }
                }
            }    
            
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_tema_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM tema WHERE TemaTitulo LIKE '%$busqueda%' ORDER BY TemaTitulo ASC LIMIT $inicio,$registros";

                $paginaURL = "temaBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM tema ORDER BY idTema DESC LIMIT $inicio,$registros";

                $paginaURL = "temaLista";
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
                                    <th scope="col">Titulo</th>';
            if($privilegio==1){
                $tabla .= '         <th scope="col">Datos</th> 
                                    <th scope="col">Imagen</th>
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
                                    <h4>'.$rows['TemaTitulo'].'</h4>
                                </div>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'temaEditar/'.mainModel::encryption($rows['idTema']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.SERVERURL.'imgtemaEditar/'.mainModel::encryption($rows['idTema']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Imagen" data-placement="bottom">
                                            <i class="far fa-image"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="'.SERVERURL.'ajax/temaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idTema']).'">
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

        /* ELIMINAR */
        public function eliminar_tema_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM tema WHERE idTema='$idCuenta'");

                $datosAD = $query1->fetch();
                $foto = $datosAD['TemaImagen'];

                    $eliminar = temaModelo::eliminar_tema_modelo($idCuenta);

                    if($eliminar->rowCount()>=1){
                        
                        @unlink('../adjuntos/temas/'.$foto);

                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"CONFERNCIA ELIMINADA","Texto"=>"Los datos  se eliminarón satisfactoriamente del sistema","Tipo"=>"success"];
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la tema, intenté nuevamente","Tipo"=>"error"];
                    }
        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_tema_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return temaModelo::datos_tema_modelo($tipo, $codigo);
        }

        /* MOSTRAR*/
		public function total_temas_controlador(){


			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM tema ORDER BY TemaTitulo DESC");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No hay temas!</strong> No hay temas disponibles en estos momentos.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }else{
                while ($rows = $datos->fetch()) {
                    $datosD = mainModel::ejecutar_consulta_simple("SELECT * FROM consejo WHERE idTema='".$rows['idTema']."'");
                    $numero = $datosD->rowCount();

                    echo '<a href="'.SERVERURL.'temaMental/'.mainModel::encryption($rows['idTema']).'">
                                <div class="item-tema-salud">
                                    <div class="imagen-tema">
                                        <img src="'.SERVERURL.'adjuntos/temas/'.$rows['TemaImagen'].'" alt="">
                                    </div>
                                    <div class="descripcion-tema">
                                        <p class="numero-consejos">'.$numero.' CONSEJOS</p>
                                        <h4 class="titulo-tema">'.$rows['TemaTitulo'].'</h4>
                                    </div>
                                </div>
                              </a>';
                }
            }
			
        }
        
        /* ACTUALIZAR IMAGEN */
        public function actualizar_foto_tema_controlador(){
            
            $codigo = mainModel::decryption($_POST['codigoImg-up']);
            $foto1 = $_FILES['fotoImg-up']['name'];
            $ruta1 = $_FILES['fotoImg-up']['tmp_name'];

            if($foto1 =="" || $codigo ==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM tema WHERE idtema='$codigo'");
                $datosFoto = $consulta1->fetch();
    
                $fotoAntigua=$datosFoto['temaImagen'];
                
                $foto="../adjuntos/temas/".$codigo."-".$foto1;
                copy($ruta1,$foto);
                $nombreFoto= $codigo."-".$foto1;
                
                $datos= ["imagen"=>$nombreFoto,"codigo"=>$codigo];

                if(temaModelo::actualizar_foto_tema_modelo($datos)->rowCount()>=1){
                    @unlink('../adjuntos/temas/'.$fotoAntigua);
                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"IMAGEN ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
                }else{
                    @unlink('../adjuntos/tema/'.$nombreFoto);
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
                }
            }

            return mainModel::sweet_alert($alerta);

        }

	}
    