<?php 
    /* HECHO */
	if($peticionAjax){
		require_once "../modelos/comentarioModelo.php";
	}else{
		require_once "./modelos/comentarioModelo.php";
	}

	class comentarioControlador extends comentarioModelo
	{
        /* AGREGAR */
        public function agregar_comentario_controlador(){

            $usuario = mainModel::decryption($_POST['usuario-reg']);  
            $noticia = mainModel::decryption($_POST['noticia-reg']);
            $comentario = mainModel::limpiar_cadena($_POST['comentario-reg']);
            $fecha = mainModel::limpiar_cadena($_POST['fecha-reg']);
            $vigencia =1;


            /*--VALIDACIONES--*/
            if($comentario == "" ){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con los parámetros requeridos, COMPLETE LOS CAMPOS.","Tipo"=>"warning"];

            }else{
 
                $datos=[
                        "noticia"=>$noticia,
                        "usuario"=>$usuario,
                        "descripcion"=>$comentario,
                        "fecha"=>$fecha,
                        "vigencia"=>$vigencia
                        ];

                $guardar = comentarioModelo::agregar_comentario_modelo($datos);

                if($guardar->rowCount()>=1){
                        $alerta = ["Alerta"=>"recargar", "Titulo"=>"COMENTARIO REGISTRADO","Texto"=>"El comentario se registró con éxito","Tipo"=>"success"];
                }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro del comentario, intente nuevamente","Tipo"=>"error"];
                }          
                      
            }    
            
            return mainModel::sweet_alert($alerta);
        }

        /* MOSTRAR */
		public function total_comentario_controlador($registros,$codigo,$cuentacodigo){

            $registros= mainModel::limpiar_cadena($registros);
            $codigo= mainModel::decryption($codigo);
            $cuentacodigo= mainModel::limpiar_cadena($cuentacodigo);

			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM comentario WHERE idNoticia = '$codigo' AND ComentarioVigencia=1 ORDER BY ComentarioFecha DESC LIMIT $registros");

            if($datos->rowCount()==0){
                echo'No se han registrado comentarios. Se el primero en comentar.';
            }else{
                while ($rows = $datos->fetch()) {
                    $datosP = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idUsuario='".$rows['idUsuario']."'");
                    $usuario = $datosP->fetch();

                    $datosC = mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='".$usuario['CuentaCodigo']."'");
                    $cuenta = $datosC->fetch();

                    echo '  
                        <div class="item-comentario mb-1">
                            <div class="imagen-comentario">';
                            if($usuario['UsuarioFoto']!="nulo"){
                              echo  '<img src="'.SERVERURL.'adjuntos/usuarios/'.$usuario['UsuarioFoto'].'" alt="">';
                            }else{
                                echo'<img src="'.SERVERURL.'vistas/assets/avatars/'.$cuenta['CuentaAvatar'].'" alt="">';
                            }
                            echo'</div>
                            <div class="texto-cometario">
                                <div class="primero">
                                    <p><a href="'.SERVERURL.'profile/user/'.mainModel::encryption($usuario['CuentaCodigo']).'">'.$usuario['UsuarioNombres'].' '.$usuario['UsuarioApellidoPaterno'].'</a></p>
                                    <small>'.$rows['ComentarioFecha'].'</small>';
                                if($cuentacodigo == $usuario['CuentaCodigo']){
                                echo' <form action="'.SERVERURL.'ajax/comentarioAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idComentario']).'">
                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Eliminar" data-placement="bottom">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <div class="RespuestaAjax"></div>
                            </form>';
                                }

                    echo'       </div>
                                <p class="comentario">'.$rows['ComentarioDescripcion'].'</p>
                            </div>
                        </div>';
                                
                                
                }
            }
			
        }    
        
        /*ELIMINAR*/
        public function eliminar_comentario_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
 

            $eliminarcomentario = comentarioModelo::eliminar_comentario_modelo($idCuenta);
            mainModel::eliminar_bitarcora($idCuenta);

            if($eliminarcomentario->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"COMENTARIO ELIMINADO","Texto"=>"Los datos se eliminarón satisfactoriamente del sistema.","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar el comentario, intenté nuevamente","Tipo"=>"error"];
            }
                
           

            return mainModel::sweet_alert($alerta);
        }

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_comentario_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM comentario WHERE ComentarioDescripcion LIKE '%$busqueda%' ORDER BY ComentarioFecha ASC LIMIT $inicio,$registros";

               $paginaURL = "comentarioBuscar";
           }else{
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM comentario  ORDER BY ComentarioFecha ASC LIMIT $inicio,$registros";

               $paginaURL = "comentarioLista";
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
                                   <th scope="col">Nombre</th>
                                   <th scope="col">Comentario</th>
                                   <th scope="col">Noticia</th>';
           if($privilegio==1){
               $tabla .= '         
                                   <th scope="col">Eliminar</th>';
           }
           
           $tabla .= '</tr></thead><tbody>';

           if($total>=1 && $pagina <= $Npaginas){

               $contador = $inicio+1;
               foreach ($datos as $rows) {
                $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idUsuario ='".$rows['idUsuario']."'");
                $datos= $query1->fetch();
                $query2 = mainModel::ejecutar_consulta_simple("SELECT * FROM noticia WHERE idNoticia ='".$rows['idNoticia']."'");
                $data= $query2->fetch();
                   $tabla.= '<tr>
                               <th scope="row">'.$contador.'</th>
                               <td>
                               <div class="identificacion">
                                   <h4>'.$datos['UsuarioNombres'].'</h4>
                               </div>
                               </td>
                               <td>'.$rows['ComentarioDescripcion'].'</td>
                               <td>'.$data['NoticiaTitulo'].'</td>';

                       if($privilegio==1){
                          $tabla.='
                                   <td>
                                       <form action="'.SERVERURL.'ajax/comentarioAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                           <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idComentario']).'">
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
  
	}
    