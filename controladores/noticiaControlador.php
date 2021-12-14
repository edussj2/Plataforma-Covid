<?php 
    /* HECHO */
	if($peticionAjax){
		require_once "../modelos/noticiaModelo.php";
	}else{
		require_once "./modelos/noticiaModelo.php";
	}

	class noticiaControlador extends noticiaModelo
	{
		/* AGREGAR */
		public function agregar_noticia_controlador(){

			/*--DATOS DEL noticia--*/
			$titulo = mainModel::limpiar_cadena($_POST['titulo-reg']);
			$categoria = mainModel::limpiar_cadena($_POST['categoria-reg']);
			$fecha = mainModel::limpiar_cadena($_POST['fecha-reg']);
			$enlace = $_POST['enlace-reg'];
            $noticia1 = $_POST['noticia1-reg'];
            $noticia2 = $_POST['noticia2-reg'];
            $vigencia =1;

            
            
            $foto1 = $_FILES['foto-reg']['name'];
            $ruta1 = $_FILES['foto-reg']['tmp_name'];
            if($foto1==""){
                $foto1="vacio";
            }else{
                $consulta3 = mainModel::ejecutar_consulta_simple("SELECT idNoticia FROM noticia");
                $numero = ($consulta3->rowCount())+1;
                $codigoFoto= mainModel::generar_codigo_aleatorio("NT",10,$numero);
                
                $fotoColegiado="../adjuntos/noticias/".$codigoFoto."-".$foto1;
                copy($ruta1,$fotoColegiado);
                $nombreFoto= $codigoFoto."-".$foto1;
            }


            /*--VALIDACIONES--*/
            if($titulo== "" || $fecha=="" || $enlace=="" || $foto1=="vacio" || $categoria==0){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos correctamente","Tipo"=>"warning"];

            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NoticiaEnlace FROM noticia WHERE NoticiaEnlace='$enlace'");
                if($consulta1->rowCount()>=1){
                        
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El enlace que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
            
                }else{

                   
                    $datos=[
                        "titulo" => $titulo,
                        "fecha" => $fecha,
                        "enlace" => $enlace,
                        "imagen" => $nombreFoto,
                        "descripcion" => $noticia1,
                        "descripcion2" => $noticia2,
                        "categoria" => $categoria,
                        "vigencia" => $vigencia
                     ];

                    $guardar = noticiaModelo::agregar_noticia_modelo($datos);

                    if($guardar->rowCount()>=1){

                            $alerta = ["Alerta"=>"limpiar", "Titulo"=>"NOTICIA REGISTRADA","Texto"=>"Los datos han sido registrados con éxito","Tipo"=>"success"];
                        
                    }else{
                            @unlink('../adjuntos/noticias/'.$nombreFoto);
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la noticia, intente nuevamente","Tipo"=>"error"];
                    }
                }
            }    
            
            return mainModel::sweet_alert($alerta);
        }
        
        /* AGREGAR 2*/
		public function agregar2_noticia_controlador(){

			/*--DATOS DEL noticia--*/
			$titulo = mainModel::limpiar_cadena($_POST['titulo2-reg']);
			$categoria = mainModel::limpiar_cadena($_POST['categoria2-reg']);
			$fecha = mainModel::limpiar_cadena($_POST['fecha2-reg']);
			$enlace = $_POST['enlace2-reg'];
            $noticia1 = $_POST['noticia3-reg'];
            $noticia2 = $_POST['noticia4-reg'];
            $vigencia =0;

            
            
            $foto1 = $_FILES['foto2-reg']['name'];
            $ruta1 = $_FILES['foto2-reg']['tmp_name'];
            if($foto1==""){
                $foto1="vacio";
            }else{
                $consulta3 = mainModel::ejecutar_consulta_simple("SELECT idNoticia FROM noticia");
                $numero = ($consulta3->rowCount())+1;
                $codigoFoto= mainModel::generar_codigo_aleatorio("NT",10,$numero);
                
                $fotoColegiado="../adjuntos/noticias/".$codigoFoto."-".$foto1;
                copy($ruta1,$fotoColegiado);
                $nombreFoto= $codigoFoto."-".$foto1;
            }


            /*--VALIDACIONES--*/
            if($titulo== "" || $fecha=="" || $enlace=="" || $foto1=="vacio" || $categoria==0){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos correctamente","Tipo"=>"warning"];

            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT NoticiaEnlace FROM noticia WHERE NoticiaEnlace='$enlace'");
                if($consulta1->rowCount()>=1){
                        
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El enlace que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
            
                }else{

                   
                    $datos=[
                        "titulo" => $titulo,
                        "fecha" => $fecha,
                        "enlace" => $enlace,
                        "imagen" => $nombreFoto,
                        "descripcion" => $noticia1,
                        "descripcion2" => $noticia2,
                        "categoria" => $categoria,
                        "vigencia" => $vigencia
                     ];

                    $guardar = noticiaModelo::agregar_noticia_modelo($datos);

                    if($guardar->rowCount()>=1){

                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"NOTICIA REGISTRADA","Texto"=>"Los datos han sido registrados con éxito, los administradores verficarán la noticia","Tipo"=>"success"];
                        
                    }else{
                            @unlink('../adjuntos/noticias/'.$nombreFoto);
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la noticia, intente nuevamente","Tipo"=>"error"];
                    }
                }
            }    
            
            return mainModel::sweet_alert($alerta);
		}

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_noticia_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM noticia WHERE NoticiaTitulo LIKE '%$busqueda%' ORDER BY NoticiaTitulo ASC LIMIT $inicio,$registros";

                $paginaURL = "noticiaBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM noticia ORDER BY idNoticia DESC LIMIT $inicio,$registros";

                $paginaURL = "noticiaLista";
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
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Detalles</th>';
            if($privilegio==1){
                $tabla .= '         <th scope="col">Datos</th> 
                                    <th scope="col">Vigencia</th>
                                    <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM categoria WHERE idCategoria ='".$rows['idCategoria']."'");
                    $datos= $query1->fetch();

                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$rows['NoticiaTitulo'].'</h4>
                                </div>
                                </td>
                                <td>'.$datos['CategoriaDescripcion'].'</td>
                                <td>
                                    <a href="'.SERVERURL.'noticia/'.mainModel::encryption($rows['idNoticia']).'/" class="btn btn-primary" data-toggle="tooltip" title="Información" data-placement="bottom">
                                        <i class="fas fa-newspaper"></i>
                                    </a>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'noticiaEditar/'.mainModel::encryption($rows['idNoticia']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>';
                            if($rows['NoticiaVigencia']==1){
                            $tabla.='<td>
                                        <form action="'.SERVERURL.'ajax/noticiaAjax.php" method="POST" class="FormularioAjax" data-form="update" entype="multipart/form-data">
                                            <input type="hidden" name="codigoV-up" value="'.mainModel::encryption($rows['idNoticia']).'">
                                            <input type="hidden" name="vigencia-up" value="'.mainModel::encryption($rows['NoticiaVigencia']).'">
                                            <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Visible" data-placement="bottom">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <div class="RespuestaAjax"></div>
                                        </form>
                                    </td>';
                            }else{
                            $tabla.='<td>
                                        <form action="'.SERVERURL.'ajax/noticiaAjax.php" method="POST" class="FormularioAjax" data-form="update" entype="multipart/form-data">
                                            <input type="hidden" name="codigoV-up" value="'.mainModel::encryption($rows['idNoticia']).'">
                                            <input type="hidden" name="vigencia-up" value="'.mainModel::encryption($rows['NoticiaVigencia']).'">
                                            <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Visible" data-placement="bottom">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                            <div class="RespuestaAjax"></div>
                                        </form>
                                    </td>';
                            }
                            $tabla.='<td>
                                        <form action="'.SERVERURL.'ajax/noticiaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idNoticia']).'">
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
        public function eliminar_noticia_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM noticia WHERE idNoticia='$idCuenta'");

                $datosAD = $query1->fetch();
                $foto = $datosAD['NoticiaImagen'];

                    $eliminar = noticiaModelo::eliminar_noticia_modelo($idCuenta);

                    if($eliminar->rowCount()>=1){
                        
                        @unlink('../adjuntos/noticias/'.$foto);
                        $alerta = ["Alerta"=>"recargar", "Titulo"=>"NOTICIA ELIMINADA","Texto"=>"Los datos  se eliminarón satisfactoriamente del sistema","Tipo"=>"success"];
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la noticia, intenté nuevamente","Tipo"=>"error"];
                    }
        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_noticia_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return noticiaModelo::datos_noticia_modelo($tipo, $codigo);
        }

        /* ACTUALIZAR VIGENCIA */
        public function actualizar_vigencia_noticia_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $codigo = mainModel::decryption($_POST['codigoV-up']);
            $visibilidad = mainModel::decryption($_POST['vigencia-up']);
            
            if($visibilidad ==1){
                $visibilidad =0 ;
            }else{
                $visibilidad =1;
            }
            $datos=["visibilidad"=>$visibilidad,"id"=>$codigo];
            $actualizar = noticiaModelo::actualizar_vigencia_noticia_modelo($datos);

            if($actualizar->rowCount()>=1){
                        
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"NOTICIA ACTUALIZADA","Texto"=>"Los datos  se actualizarón satisfactoriamente del sistema","Tipo"=>"success"];
    
                        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo actualizar el conferencia, intenté nuevamente".$codigo,"Tipo"=>"error"];
            }
 

            return mainModel::sweet_alert($alerta);
        }

        /* MOSTRAR TOTAL */
        public function total_noticias_controlador($pagina,$registros,$busqueda){
       
            /**-----LIMPIAMOS PARAMETROS RECIBIDOS-----**/
           $pagina = mainModel::limpiar_cadena($pagina);
           $registros = mainModel::limpiar_cadena($registros);
           $busqueda = mainModel::decryption($busqueda);

           $tabla = "";

           /**-----VALIDAMOS LAS PAGINAS Y EL ORDEN DE LOS REGISTROS----**/
           $pagina = (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
           $inicio = ($pagina>0) ? (($pagina * $registros) - $registros): 0;

           /**-----VALIDAMOS SI ES UNA BUSQUEDA O SI ES LA LISTA---**/
           if(isset($busqueda) && $busqueda!=""){
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM noticia WHERE idCategoria LIKE '%$busqueda%' AND NoticiaVigencia = 1 ORDER BY NoticiaFecha ASC LIMIT $inicio,$registros";

               $paginaURL = "noticias/total";
           }else{
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM noticia WHERE NoticiaVigencia = 1 ORDER BY NoticiaFecha DESC LIMIT $inicio,$registros";

               $paginaURL = "noticias/total";
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

           if($total>=1 && $pagina <= $Npaginas){

               $contador = $inicio+1;
               foreach ($datos as $rows) {
                $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM comentario WHERE idNoticia ='".$rows['idNoticia']."'");
                $datos= $query1->rowCount();

                $tabla.= '<div class="card rounded-0 item-noticia mb-2">
                            <div class="card-header bg-light">
                                <h3 class="titulo-noticia mb-0">'.$rows['NoticiaTitulo'].'</h3>
                            </div>
                            <div class="card-body">
                                <img src="'.SERVERURL.'adjuntos/noticias/'.$rows['NoticiaImagen'].'" class="img-noticia">
                                <p class="descripcion-noticia">'.substr($rows['NoticiaDescripcion'],0,200).'...</p>
                                <hr style="margin: 0;">   
                                <div class="detalle-noticia">
                                <p><i class="fas fa-calendar-week"></i>&nbsp;'.$rows['NoticiaFecha'].'</p>
                                <p><i class="far fa-comments"></i>&nbsp;Comentarios('.$datos.')</p>
                                <a href="'.SERVERURL.'noticia/'.mainModel::encryption($rows['idNoticia']).'" class="btn btn-primary">Leer más</a>
                                </div>
                            </div>
                        </div>';
                $contador++;
               }
           }else{
               if($total>=1){
                   $tabla .= '<a href="'.SERVERURL.$paginaURL.'/" class="btn btn-info"><i class="fas fa-sync-alt"></i> Haga clic acá para actualizar el listado </a>';
               }else{
                   $tabla .= '
                   <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>No hay noticias!</strong>  NO HAY REGISTOS EN EL SISTEMA 
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
               }
           }

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

        /* MOSTRAR MAS */
		public function mas_noticias_controlador($registros,$codigo){

            $registros= mainModel::limpiar_cadena($registros);
            $codigo= mainModel::decryption($codigo);

			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM noticia WHERE idNoticia != '$codigo' AND NoticiaVigencia = 1 ORDER BY NoticiaFecha DESC LIMIT $registros");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-secondary" role="alert">
                         <i class="fas fa-exclamation-circle"></i> No hay mas noticias
                    </div>';
            }else{
                while ($rows = $datos->fetch()) {
                    echo '
                    <div class="item-mas-noticias">
                        <img src="'.SERVERURL.'adjuntos/noticias/'.$rows['NoticiaImagen'].'">
                        <h3><a href="'.SERVERURL.'noticia/'.mainModel::encryption($rows['idNoticia']).'">'.substr($rows['NoticiaTitulo'],0,35).'...</a></h3>
                    </div>
                    ';
                }
            }	
        }

        /* ACTUALIZAR IMAGEN */
        public function actualizar_imagen_noticia_controlador(){
            
            $codigo = mainModel::decryption($_POST['codigo2-up']);
            $foto1 = $_FILES['foto2-up']['name'];
            $ruta1 = $_FILES['foto2-up']['tmp_name'];

            if($foto1 =="" || $codigo ==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
            }else{
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM noticia WHERE idNoticia='$codigo'");
                $datosFoto = $consulta1->fetch();
    
                $fotoAntigua=$datosFoto['NoticiaImagen'];
                
                $foto="../adjuntos/noticias/".$codigo."-".$foto1;
                copy($ruta1,$foto);
                $nombreFoto= $codigo."-".$foto1;
                
                $datos= ["imagen"=>$nombreFoto,"codigo"=>$codigo];

                if(noticiaModelo::actualizar_imagen_noticia_modelo($datos)->rowCount()>=1){
                    @unlink('../adjuntos/noticias/'.$fotoAntigua);
                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"IMAGEN ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
                }else{
                    @unlink('../adjuntos/noticias/'.$nombreFoto);
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
                }
            }

            return mainModel::sweet_alert($alerta);

        }
        /*ACTUALIZAR GENERAL*/
        public function actualizar_noticia_controlador(){ 

            $codigo = mainModel::decryption($_POST['codigo-up']);
            $titulo = mainModel::limpiar_cadena($_POST['titulo-up']);
            $fecha = mainModel::limpiar_cadena($_POST['fecha-up']);
            $categoria = mainModel::limpiar_cadena($_POST['categoria-up']);
            $enlace = mainModel::limpiar_cadena($_POST['enlace-up']);
            $noticia1 = mainModel::limpiar_cadena($_POST['noticia1-up']);
            $noticia2 = mainModel::limpiar_cadena($_POST['noticia2-up']);

            if($titulo== "" || $fecha=="" || $categoria==0 || $enlace==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM noticia WHERE idNoticia ='$codigo'");

            $data = $consulta1->fetch();

            if($titulo != $data['NoticiaTitulo']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT NoticiaTitulo FROM noticia WHERE NoticiaTitulo ='$titulo'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El título ingresado ya ha sido registrado en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            $datosnoticia= ["titulo"=>$titulo,"descripcion"=>$noticia1,"descripcion2"=>$noticia2,"fecha"=>$fecha,"enlace"=>$enlace,"codigo"=>$codigo];

            if(noticiaModelo::actualizar_noticia_modelo($datosnoticia)->rowCount()>=1){

                $alerta = ["Alerta"=>"recargar", "Titulo"=>"NOTICIA ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos del administrador, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }


	}
    