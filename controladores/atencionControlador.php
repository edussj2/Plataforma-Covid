<?php 
	if($peticionAjax){
		require_once "../modelos/atencionModelo.php";
	}else{
		require_once "./modelos/atencionModelo.php";
	}

	class atencionControlador extends atencionModelo
	{

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_atencion_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM atencion WHERE idEspecialista = '$busqueda' AND AtencionEstado = 0 ORDER BY AtencionFecha DESC LIMIT $inicio,$registros";

                $paginaURL = "casos";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM atencion ORDER BY AtencionFecha DESC LIMIT $inicio,$registros";

                $paginaURL = "atencionLista";
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
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Especialista</th>';
            if($privilegio<=2){
                $tabla .= '        
                                    <th scope="col">Responder</th>
                                    <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE idEspecialista ='".$rows['idEspecialista']."'");
                    $datos= $query1->fetch();

                    $query2 = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idUsuario ='".$rows['idUsuario']."'");
                    $datos2= $query2->fetch();

                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                    <div class="identificacion">
                                        <h4>'.$datos2['UsuarioNombres'].' '.$datos2['UsuarioApellidoPaterno'].'</h4>
                                    </div>
                                </td>
                                <td>'.$rows['AtencionFecha'].'</td>
                                <td>'.$datos['EspecialistaNombres'].'</td>';

                    if($privilegio<=2){
                        $tabla.='   <td>
                                        <a href="'.SERVERURL.'detalleAtencion/'.mainModel::encryption($rows['idAtencion']).'/" class="btn btn-success" data-toggle="tooltip" title="Responder" data-placement="bottom">
                                        <i class="fas fa-reply"></i>
                                    </a>
                                    </td> 
                                    <td>
                                        <form action="'.SERVERURL.'ajax/atencionAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idAtencion']).'">
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

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador2_atencion_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM atencion WHERE idEspecialista = '$busqueda'  ORDER BY AtencionFecha DESC LIMIT $inicio,$registros";

               $paginaURL = "myAtenciones";
           }else{
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM atencion ORDER BY AtencionFecha DESC LIMIT $inicio,$registros";

               $paginaURL = "atencionLista";
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
                                   <th scope="col">Usuario</th>
                                   <th scope="col">Fecha</th>
                                   <th scope="col">Especialista</th>
                                   <th scope="col">Detalles</th>';
           if($privilegio<=2){
               $tabla .= '        
                                   <th scope="col">Eliminar</th>';
           }
           
           $tabla .= '</tr></thead><tbody>';

           if($total>=1 && $pagina <= $Npaginas){

               $contador = $inicio+1;
               foreach ($datos as $rows) {
                   $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE idEspecialista ='".$rows['idEspecialista']."'");
                   $datos= $query1->fetch();

                   $query2 = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idUsuario ='".$rows['idUsuario']."'");
                   $datos2= $query2->fetch();

                   $tabla.= '<tr>
                               <th scope="row">'.$contador.'</th>
                               <td>
                                   <div class="identificacion">
                                       <h4>'.$datos2['UsuarioNombres'].' '.$datos2['UsuarioApellidoPaterno'].'</h4>
                                   </div>
                               </td>
                               <td>'.$rows['AtencionFecha'].'</td>
                               <td>'.$datos['EspecialistaNombres'].'</td>';

                   if($privilegio<=2){
                       $tabla.='   <td>
                                       <a href="'.SERVERURL.'detalleAtencion/'.mainModel::encryption($rows['idAtencion']).'/" class="btn btn-success" data-toggle="tooltip" title="Responder" data-placement="bottom">
                                       <i class="fas fa-envelope-open-text"></i>
                                   </a>
                                   </td> 
                                   <td>
                                       <form action="'.SERVERURL.'ajax/atencionAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                           <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idAtencion']).'">
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

       /* PAGINAR LISTA Y BUSQUEDA */
       public function paginador3_atencion_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
           $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM atencion WHERE idUsuario = '$busqueda'  ORDER BY AtencionFecha DESC LIMIT $inicio,$registros";

           $paginaURL = "myConsultas";
       }else{
           $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM atencion ORDER BY AtencionFecha DESC LIMIT $inicio,$registros";

           $paginaURL = "atencionLista";
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
                               <th scope="col">Usuario</th>
                               <th scope="col">Fecha</th>
                               <th scope="col">Especialista</th>
                               <th scope="col">Detalles</th>';
       if($privilegio<=2){
           $tabla .= '        
                               <th scope="col">Eliminar</th>';
       }
       
       $tabla .= '</tr></thead><tbody>';

       if($total>=1 && $pagina <= $Npaginas){

           $contador = $inicio+1;
           foreach ($datos as $rows) {
               $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE idEspecialista ='".$rows['idEspecialista']."'");
               $datos= $query1->fetch();

               $query2 = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idUsuario ='".$rows['idUsuario']."'");
               $datos2= $query2->fetch();

               $tabla.= '<tr>
                           <th scope="row">'.$contador.'</th>
                           <td>
                               <div class="identificacion">
                                   <h4>'.$datos2['UsuarioNombres'].' '.$datos2['UsuarioApellidoPaterno'].'</h4>
                               </div>
                           </td>
                           <td>'.$rows['AtencionFecha'].'</td>
                           <td>'.$datos['EspecialistaNombres'].'</td>
                           <td>
                                   <a href="'.SERVERURL.'detalleAtencion/'.mainModel::encryption($rows['idAtencion']).'/" class="btn btn-success" data-toggle="tooltip" title="Detalles" data-placement="bottom">
                                   <i class="fas fa-envelope-open-text"></i>
                               </a>
                               </td> ';

               if($privilegio<=2){
                   $tabla.='   
                               <td>
                                   <form action="'.SERVERURL.'ajax/atencionAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                       <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idAtencion']).'">
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
        public function eliminar_atencion_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                    $eliminar = atencionModelo::eliminar_atencion_modelo($idCuenta);

                    if($eliminar->rowCount()>=1){
                        

                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"ATENCIÓN ELIMINADA","Texto"=>"Los datos  se eliminarón satisfactoriamente del sistema","Tipo"=>"success"];
    
                        
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar el atencion, intenté nuevamente","Tipo"=>"error"];
                    }
        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_atencion_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return atencionModelo::datos_atencion_modelo($tipo, $codigo);
        }

        /* AGREGAR */
        public function agregar_atencion_controlador(){

			$usuario = mainModel::decryption($_POST['usuario-reg']);
            $atencion = mainModel::limpiar_cadena($_POST['mensaje-reg']);
            $fecha = mainModel::limpiar_cadena($_POST['fecha-reg']);
            $especialista = mainModel::decryption($_POST['especialista-reg']);
            $estado =0;


            /*--VALIDACIONES--*/
            if( $atencion=="" || $usuario==""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
                
                $datos=["fecha"=>$fecha,
                        "descripcion"=>$atencion,
                        "usuario"=>$usuario,
                        "especialista"=>$especialista,
                        "estado"=>$estado
                        ];

                $guardar = atencionModelo::agregar_atencion_modelo($datos);

                if($guardar->rowCount()>=1){
                        $alerta = ["Alerta"=>"recargar", "Titulo"=>"ATENCIÓN REGISTRADO","Texto"=>"La atencion se registró con éxito, espere respuesta del especialista","Tipo"=>"success"];
                }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la atencion, intente nuevamente","Tipo"=>"error"];
                }          
                      
            }    
            
            return mainModel::sweet_alert($alerta);
        }

        /* MOSTRAR*/
		public function total_atencion_controlador($registros,$codigo){


			
        }
        
  
	}
    