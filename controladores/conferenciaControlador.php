<?php 
	if($peticionAjax){
		require_once "../modelos/conferenciaModelo.php";
	}else{
		require_once "./modelos/conferenciaModelo.php";
	}

	class conferenciaControlador extends conferenciaModelo
	{
		/* AGREGAR */
		public function agregar_conferencia_controlador(){

			/*--DATOS DEL conferencia--*/
			$titulo = mainModel::limpiar_cadena($_POST['titulo-reg']);
			$tema = mainModel::limpiar_cadena($_POST['tema-reg']);
			$fecha = mainModel::limpiar_cadena($_POST['fecha-reg']);
			$enlaceC = $_POST['enlaceC-reg'];
			$general = $_POST['descripciónGeneral-reg'];

			/*--DATOS DE LA ponente--*/
			$nombres = mainModel::limpiar_cadena($_POST['nombres-reg']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);
            
            
            $foto1 = $_FILES['foto-reg']['name'];
            $ruta1 = $_FILES['foto-reg']['tmp_name'];
            $consulta3 = mainModel::ejecutar_consulta_simple("SELECT idConferencia FROM conferencia");
            $numero = ($consulta3->rowCount())+1;
            $codigoFoto= mainModel::generar_codigo_aleatorio("CF",10,$numero);
            
            $fotoColegiado="../adjuntos/conferencias/".$codigoFoto."-".$foto1;
            copy($ruta1,$fotoColegiado);
            $nombreFoto= $codigoFoto."-".$foto1;
            /*--VALIDACIONES--*/
            if($titulo== "" || $tema=="" || $fecha=="" || $enlaceC=="" || $nombres=="" || $foto1=""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT ConferenciaEnlace FROM conferencia WHERE ConferenciaEnlace='$enlaceC'");
                if($consulta1->rowCount()>=1){
                        
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El enlace que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
            
                }else{

                    $consulta4 = mainModel::ejecutar_consulta_simple("SELECT idPonente FROM ponente");
                    $numero = ($consulta4->rowCount())+1;
                    $codigoPonente= mainModel::generar_codigo_aleatorio("PONE",10,$numero);


                    $datosPonente=[
                        "nombres"=>$nombres,
                        "descripcion"=>$descripcion,
                        "codigo"=>$codigoPonente
                    ];

                    $guardarponente = mainModel::guardar_ponente($datosPonente);

                    if($guardarponente->rowCount()>=1){

                        $consulta5 = mainModel::ejecutar_consulta_simple("SELECT * FROM ponente WHERE PonenteCodigo='$codigoPonente'");
                        $dataP=$consulta5->fetch();
                        $idPonente = $dataP['idPonente'];

                        $datos=[
                                "titulo" => $titulo,
                                "descripcion" => $general,
                                "fecha" => $fecha,
                                "enlace" => $enlaceC,
                                "tema" => $tema,
                                "imagen" => $nombreFoto,
                                "visitas" => 0,
                                "vigencia" => 1,
                                "ponente" => $idPonente
                        ];

                        $guardarconferencia = conferenciaModelo::agregar_conferencia_modelo($datos);

                        if($guardarconferencia->rowCount()>=1){
                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"CONFERENCIA REGISTRADA","Texto"=>"Los datos han sido registrados con éxito","Tipo"=>"success"];
                        }else{
                            @unlink('../adjuntos/conferencias/'.$nombreFoto);
                            mainModel::eliminar_ponente($idPonente);
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la conferencoa, intente nuevamente","Tipo"=>"error"];
                        }
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro del ponente, intente nuevamente","Tipo"=>"error"];
                    }
                }
            }    
            
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA **/
        public function paginador_conferencia_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM conferencia WHERE ConferenciaTitulo LIKE '%$busqueda%' OR ConferenciaTema LIKE '%$busqueda%' ORDER BY ConferenciaTitulo ASC LIMIT $inicio,$registros";

                $paginaURL = "conferenciaBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM conferencia ORDER BY idConferencia DESC LIMIT $inicio,$registros";

                $paginaURL = "conferenciaLista";
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
                                    <th scope="col">Tema</th>
                                    <th scope="col">Ponente</th>
                                    <th scope="col">Detalles</th>';
            if($privilegio==1){
                $tabla .= '          
                                    <th scope="col">Ponente</th>
                                    <th scope="col">Imagen</th>
                                    <th scope="col">Vigencia</th>
                                    <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM ponente WHERE idPonente ='".$rows['idPonente']."'");
                    $datos= $query1->fetch();

                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$rows['ConferenciaTitulo'].'</h4>
                                </div>
                                </td>
                                <td>'.$rows['ConferenciaTema'].'</td>
                                <td>'.$datos['PonenteNombres'].'</td>
                                <td>
                                    <a href="'.SERVERURL.'conferencia/'.mainModel::encryption($rows['idConferencia']).'/" class="btn btn-primary" data-toggle="tooltip" title="Información" data-placement="bottom">
                                    <i class="fas fa-video"></i>
                                    </a>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'ponenteEditar/'.mainModel::encryption($datos['idPonente']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Ponente" data-placement="bottom">
                                        <i class="fas fa-cog"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.SERVERURL.'imgConferenciaEditar/'.mainModel::encryption($rows['idConferencia']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Imagen" data-placement="bottom">
                                            <i class="far fa-image"></i>
                                        </a>
                                    </td>';
                                    if($rows['ConferenciaVigencia']==1){
                                        $tabla.='<td>
                                        <form action="'.SERVERURL.'ajax/conferenciaAjax.php" method="POST" class="FormularioAjax" data-form="update" entype="multipart/form-data">
                                            <input type="hidden" name="codigoV-up" value="'.mainModel::encryption($rows['idConferencia']).'">
                                            <input type="hidden" name="vigencia-up" value="'.mainModel::encryption($rows['ConferenciaVigencia']).'">
                                            <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Visible" data-placement="bottom">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <div class="RespuestaAjax"></div>
                                        </form>
                                    </td>';
                                    }else{
                                        $tabla.='<td>
                                        <form action="'.SERVERURL.'ajax/conferenciaAjax.php" method="POST" class="FormularioAjax" data-form="update" entype="multipart/form-data">
                                            <input type="hidden" name="codigoV-up" value="'.mainModel::encryption($rows['idConferencia']).'">
                                            <input type="hidden" name="vigencia-up" value="'.mainModel::encryption($rows['ConferenciaVigencia']).'">
                                            <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Visible" data-placement="bottom">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                            <div class="RespuestaAjax"></div>
                                        </form>
                                    </td>';
                                    }
                                    $tabla.='  <td>
                                        <form action="'.SERVERURL.'ajax/conferenciaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idConferencia']).'">
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

        /* ACTUALIZAR VIGENCIA */
        public function actualizar_vigencia_conferencia_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $codigo = mainModel::decryption($_POST['codigoV-up']);
            $visibilidad = mainModel::decryption($_POST['vigencia-up']);
            
            if($visibilidad ==1){
                $visibilidad =0 ;
            }else{
                $visibilidad =1;
            }
            $datos=["visibilidad"=>$visibilidad,"id"=>$codigo];
            $actualizar = conferenciaModelo::actualizar_vigencia_conferencia_modelo($datos);

            if($actualizar->rowCount()>=1){
                        
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"CONFERENCIA ACTUALIZADO","Texto"=>"Los datos  se actualizarón satisfactoriamente del sistema","Tipo"=>"success"];
    
                        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo actualizar el conferencia, intenté nuevamente".$codigo,"Tipo"=>"error"];
            }
 

            return mainModel::sweet_alert($alerta);
        }

        /* ELIMIANR */
        public function eliminar_conferencia_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM conferencia WHERE idConferencia='$idCuenta'");

                $datosAD = $query1->fetch();
                $idPonente = $datosAD['idPonente'];
                $foto = $datosAD['ConferenciaImagen'];

                    $eliminar = conferenciaModelo::eliminar_conferencia_modelo($idCuenta);

                    if($eliminar->rowCount()>=1){
                        
                        @unlink('../adjuntos/conferencias/'.$foto);
                        $eliminarPonente = mainModel::eliminar_ponente($idPonente);

                        if($eliminarPonente->rowCount()>=1){
                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"CONFERNCIA ELIMINADA","Texto"=>"Los datos  se eliminarón satisfactoriamente del sistema","Tipo"=>"success"];
                        
                        }else{
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar completamente al ponente, avisar a soporte técnico","Tipo"=>"info"];
                        }
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la conferencia, intenté nuevamente","Tipo"=>"error"];
                    }
        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_conferencia_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return conferenciaModelo::datos_conferencia_modelo($tipo, $codigo);
        }

        /* DATOS DETALLE */
        public function datos_detalle_controlador($usuario,$conferencia){

            $conferencia = mainModel::decryption($conferencia);
            $usario = mainModel::limpiar_cadena($usuario);
            
            return conferenciaModelo::datos_detalle_conferencia_modelo($usuario,$conferencia);
        }

        /* DATOS2 DETALLE */
        public function datos2_detalle_controlador($conferencia){

            $conferencia = mainModel::decryption($conferencia);
            
            return conferenciaModelo::datos2_detalle_conferencia_modelo($conferencia);
        }

        /* AGREGAR DETALLE*/
        public function agregar_detalle_controlador(){

			$usuario = mainModel::decryption($_POST['usuarioD-reg']);
            $conferencia = mainModel::decryption($_POST['conferenciaD-reg']);
            $fecha = mainModel::limpiar_cadena($_POST['fechaD-reg']);


            /*--VALIDACIONES--*/
            if($usuario== "" || $conferencia==""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT  idUsuario, idConferencia FROM detalle_conferencia WHERE idUsuario='$usuario' AND idConferencia='$conferencia'");
                    
                    if($consulta1->rowCount()>=1){
                        
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted ya esta registrado, por favor recargué la página","Tipo"=>"info"];
                    
                    }else{

                            $datos=[
                                    "fecha"=>$fecha,
                                    "conferencia"=>$conferencia,
                                    "usuario"=>$usuario
                                    ];

                            $guardar = conferenciaModelo::agregar_detalle_modelo($datos);

                            if($guardar->rowCount()>=1){
                                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"PARTICIPACIÓN REGISTRADA","Texto"=>"La participación se registró con éxito","Tipo"=>"success"];
                            }else{
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la participación, intente nuevamente","Tipo"=>"error"];
                            }          
                    }   
            }    
            
            return mainModel::sweet_alert($alerta);
        }

        /* LISTA EVENTOS PRÓXIMOS*/
		public function futuros_eventos_controlador($registros,$codigo){

            $registros= mainModel::limpiar_cadena($registros);
            $codigo= mainModel::decryption($codigo);

			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM conferencia WHERE idConferencia != '$codigo' ORDER BY ConferenciaFecha DESC LIMIT $registros");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-secondary" role="alert">
                         <i class="fas fa-exclamation-circle"></i> No hay próximos eventos
                    </div>';
            }else{
                while ($rows = $datos->fetch()) {
                    echo '
                    <div class="post_item">
                        <img src="'.SERVERURL.'adjuntos/conferencias/'.$rows['ConferenciaImagen'].'" alt="post">
                        <div class="media-body">
                            <a href="'.SERVERURL.'conferencia/'.mainModel::encryption($rows['idConferencia']).'">
                                <h3>'.substr($rows['ConferenciaTitulo'],0,20).'...</h3>
                            </a>
                            <p>'.$rows['ConferenciaFecha'].'</p>
                        </div>
                    </div>
                    ';
                }
            }
			
        }

        /* MOSTRAR GENERAL*/
		public function total_conferencias_controlador($registros){

            $registros= mainModel::limpiar_cadena($registros);

			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM conferencia WHERE ConferenciaVigencia =1 ORDER BY ConferenciaFecha DESC LIMIT $registros");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No hay conferencias!</strong> No hay conferencias disponibles en estos momentos.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }else{
                while ($rows = $datos->fetch()) {
                    $datosP = mainModel::ejecutar_consulta_simple("SELECT * FROM ponente WHERE idPonente='".$rows['idPonente']."'");
                    $ponente = $datosP->fetch();
                    $datosD = mainModel::ejecutar_consulta_simple("SELECT * FROM detalle_conferencia WHERE idConferencia='".$rows['idConferencia']."'");
                    $numero = $datosD->rowCount();
                    $fecha_actual = strtotime(date("Y-m-d"));
                    $fecha_conferencia = strtotime($rows['ConferenciaFecha']);

                    $partes = explode('-', $rows['ConferenciaFecha']); 
                    $dia_fecha = $partes[2];

                    $monthNum  = $partes[1];
                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                    $monthName = strftime('%B', $dateObj->getTimestamp());

                    echo '<article class="blog_item">';

                        if($fecha_conferencia>$fecha_actual){

                        echo'<div class="blog_item_img">
                                <img class="card-img rounded-0" src="'.SERVERURL.'adjuntos/conferencias/'.$rows['ConferenciaImagen'].'" alt="publicaciones1">
                                  <a href="#!" class="blog_item_date">
                                      <h3>'.$dia_fecha.'</h3>
                                      <p>'.substr($monthName,0,3).'</p>
                                  </a>
                                </div>
                                <div class="blog_details">
                                <a class="d-inline-block" href="'.SERVERURL.'conferencia/'.mainModel::encryption($rows['idConferencia']).'/">
                                      <h2>'.$rows['ConferenciaTitulo'].'</h2>
                                </a>
                                <p>'.substr($rows['ConferenciaDescripcion'],0,150).'...</p>
                                <ul class="blog-info-link">
                                 <li><i class="fas fa-user-alt"></i>'.$ponente['PonenteNombres'].'</a></li>
                                 <li><i class="fas fa-users"></i>'.$numero.' participantes</a></li>
                               </ul>
                            </div>';

                        }else{
                            echo '
                                <div class="blog_item_img expirado">
                                <img class="card-img rounded-0" src="'.SERVERURL.'adjuntos/conferencias/'.$rows['ConferenciaImagen'].'" alt="publicaciones1">
                                  <a href="#!" class="blog_item_date">
                                      <h3>15</h3>
                                      <p>Jun</p>
                                  </a>
                                </div>
                                <div class="blog_details">
                                <a class="d-inline-block expirado" href="'.SERVERURL.'conferencia/'.mainModel::encryption($rows['idConferencia']).'">
                                <h2>'.$rows['ConferenciaTitulo'].'</h2>
                               </a>
                               <div class="alert alert-danger text-center" role="alert">
                               <i class="fas fa-info-circle"></i> La fecha de esta conferencia a expirado, revisar los <a href="'.SERVERURL.'/grabaciones/" style="font-weight: 900;color: #7e1521;">enlaces</a> de las grabaciones.
                             </div>
                             <ul class="blog-info-link expirado">
                                   <li><i class="fas fa-user-alt"></i>'.$ponente['PonenteNombres'].'</a></li>
                                   <li><i class="fas fa-users"></i>'.$numero.' participantes</a></li>
                                 </ul>
                                 </div>';
                            }
                                
                                
                  echo  '</article>';
                }
            }
			
        }
        
        /* ACTUALIZAR IMAGEN */
        public function actualizar_foto_conferencia_controlador(){
            
            $codigo = mainModel::decryption($_POST['codigoImg-up']);
            $foto1 = $_FILES['fotoImg-up']['name'];
            $ruta1 = $_FILES['fotoImg-up']['tmp_name'];

            if($foto1 =="" || $codigo ==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM conferencia WHERE idConferencia='$codigo'");
                $datosFoto = $consulta1->fetch();
    
                $fotoAntigua=$datosFoto['ConferenciaImagen'];
                
                $foto="../adjuntos/conferencias/".$codigo."-".$foto1;
                copy($ruta1,$foto);
                $nombreFoto= $codigo."-".$foto1;
                
                $datos= ["imagen"=>$nombreFoto,"codigo"=>$codigo];

                if(conferenciaModelo::actualizar_foto_conferencia_modelo($datos)->rowCount()>=1){
                    @unlink('../adjuntos/conferencias/'.$fotoAntigua);
                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"IMAGEN ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
                }else{
                    @unlink('../adjuntos/conferencia/'.$nombreFoto);
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
                }
            }

            return mainModel::sweet_alert($alerta);

        }

        /* PAGINAR LISTA Y BUSQUEDA DETALLE**/
        public function paginador2_conferencia_controlador($privilegio,$busqueda){
       
             /**-----LIMPIAMOS PARAMETROS RECIBIDOS-----**/
            $privilegio = mainModel::limpiar_cadena($privilegio);
            $busqueda = mainModel::limpiar_cadena($busqueda);

            $tabla = "";

            $datos = mainModel::ejecutar_consulta_simple("SELECT * FROM detalle_conferencia WHERE idConferencia= '$busqueda' ORDER BY idUsuario ASC");

            /**-----GENERAMOS TABLA---**/
            $tabla .= '<div class="table-responsive">
                        <table class="table table-hover text-center tabla-especialitas">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Conferencia</th>
                                </tr></thead><tbody>';

            if($datos->rowCount()!=0){
                $contador = 1;
                while ($rows = $datos->fetch()) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idUsuario ='".$rows['idUsuario']."'");
                    $datosU= $query1->fetch();

                    $query2 = mainModel::ejecutar_consulta_simple("SELECT * FROM conferencia WHERE idConferencia ='".$rows['idConferencia']."'");
                    $datosC= $query2->fetch();

                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$datosU['UsuarioNombres'].' '.$datosU['UsuarioApellidoPaterno']. ' '.$datosU['UsuarioApellidoMaterno'].'</h4>
                                </div>
                                </td>
                                <td>'.$rows['FechaDetalle'].'</td>
                                <td>'.$datosC['ConferenciaTitulo'].'</td>';

                    $tabla .= '</tr>';
                    $contador++;
                }
            }else{
  
                    $tabla .= '<tr> <td colspan="9"> NO HAY REGISTOS EN EL SISTEMA </td></tr>';
            }

            $tabla .= '     </tbody>
                        </table>
                        <small class="p-2 float-right" style="color: #333;">Si estas en un dispósitivo móvil, desliza sobre la tabla para ver más detalles</small>
                    </div>';

            return $tabla;
        }

	}
    