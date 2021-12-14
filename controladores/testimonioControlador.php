<?php 
	if($peticionAjax){
		require_once "../modelos/testimonioModelo.php";
	}else{
		require_once "./modelos/testimonioModelo.php";
	}

	class testimonioControlador extends testimonioModelo
	{

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_testimonio_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM testimonio WHERE idEspecialista = '$busqueda' ORDER BY TestimonioFecha DESC LIMIT $inicio,$registros";

                $paginaURL = "testimonioBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM testimonio ORDER BY TestimonioFecha DESC LIMIT $inicio,$registros";

                $paginaURL = "testimonioLista";
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
                                    <th scope="col">Testimonio</th>
                                    <th scope="col">Especialista</th>
                                    <th scope="col">Visbilidad</th>';
            if($privilegio==1){
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
                                <td>'.$rows['TestimonioDescripcion'].'</td>
                                <td>'.$datos['EspecialistaNombres'].'</td>';

                            if($rows['TestimonioVisibilidad']==1){
                                $tabla.='<td>
                                <form action="'.SERVERURL.'ajax/testimonioAjax.php" method="POST" class="FormularioAjax" data-form="update" entype="multipart/form-data">
                                    <input type="hidden" name="codigo-up" value="'.mainModel::encryption($rows['idTestimonio']).'">
                                    <input type="hidden" name="vigencia-up" value="'.mainModel::encryption($rows['TestimonioVisibilidad']).'">
                                    <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Visible" data-placement="bottom">
                                        <i class="far fa-eye"></i>
                                    </button>
                                    <div class="RespuestaAjax"></div>
                                </form>
                            </td>';
                            }else{
                                $tabla.='<td>
                                <form action="'.SERVERURL.'ajax/testimonioAjax.php" method="POST" class="FormularioAjax" data-form="update" entype="multipart/form-data">
                                    <input type="hidden" name="codigo-up" value="'.mainModel::encryption($rows['idTestimonio']).'">
                                    <input type="hidden" name="vigencia-up" value="'.mainModel::encryption($rows['TestimonioVisibilidad']).'">
                                    <button type="submit" class="btn btn-info" data-toggle="tooltip" title="Visible" data-placement="bottom">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                    <div class="RespuestaAjax"></div>
                                </form>
                            </td>';
                            }
                            if($privilegio==1){
                           $tabla.='
                                    
                                    <td>
                                        <form action="'.SERVERURL.'ajax/testimonioAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['idTestimonio']).'">
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
        public function eliminar_testimonio_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                    $eliminar = testimonioModelo::eliminar_testimonio_modelo($idCuenta);

                    if($eliminar->rowCount()>=1){
                        

                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"TESTIMONIO ELIMINADO","Texto"=>"Los datos  se eliminarón satisfactoriamente del sistema","Tipo"=>"success"];
    
                        
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar el testimonio, intenté nuevamente","Tipo"=>"error"];
                    }
        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* ACTUALIZAR VIGENCIA*/
        public function actualizar_testimonio_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $codigo = mainModel::decryption($_POST['codigo-up']);
            $visibilidad = mainModel::decryption($_POST['vigencia-up']);
            
            if($visibilidad ==1){
                $visibilidad =0 ;
            }else{
                $visibilidad =1;
            }
            $datos=["visibilidad"=>$visibilidad,"id"=>$codigo];
            $actualizar = testimonioModelo::actualizar_testimonio_modelo($datos);

            if($actualizar->rowCount()>=1){
                        
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"TESTIMONIO ACTUALIZADO","Texto"=>"Los datos  se actualizarón satisfactoriamente del sistema","Tipo"=>"success"];
    
                        
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo actualizar el testimonio, intenté nuevamente".$codigo,"Tipo"=>"error"];
            }
 

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_testimonio_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return testimonioModelo::datos_testimonio_modelo($tipo, $codigo);
        }

        /* AGREGAR */
        public function agregar_testimonio_controlador(){

			$usuario = mainModel::decryption($_POST['usuarioT-reg']);
            $testimonio = mainModel::limpiar_cadena($_POST['testimonioT-reg']);
            $fecha = mainModel::limpiar_cadena($_POST['fechaT-reg']);
            $especialista = mainModel::decryption($_POST['especialistaT-reg']);
            $visibilidad =0;


            /*--VALIDACIONES--*/
            if($usuario== "" || $testimonio=="" || $especialista ==""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT  idUsuario, idEspecialista FROM testimonio WHERE idUsuario='$usuario' AND idEspecialista='$especialista'");
                    
                    if($consulta1->rowCount()>=1){
                        
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted ya registro una testimonio, por favor espere verificación","Tipo"=>"info"];
                    
                    }else{

                            $datos=[
                                    "descripcion"=>$testimonio,
                                    "fecha"=>$fecha,
                                    "visibilidad"=>$visibilidad,
                                    "especialista"=>$especialista,
                                    "usuario"=>$usuario
                                    ];

                            $guardar = testimonioModelo::agregar_testimonio_modelo($datos);

                            if($guardar->rowCount()>=1){
                                    $alerta = ["Alerta"=>"recargar", "Titulo"=>"TESTIMONIO REGISTRADO","Texto"=>"El testimonio se registró con éxito, los administradores verificarán tu testimonio","Tipo"=>"success"];
                            }else{
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro del testimonio, intente nuevamente","Tipo"=>"error"];
                            }          
                    }   
            }    
            
            return mainModel::sweet_alert($alerta);
        }

        /* MOSTRAR*/
		public function total_testimonio_controlador($registros,$codigo){

            $registros= mainModel::limpiar_cadena($registros);
            $codigo= mainModel::decryption($codigo);

			$datos = mainModel::ejecutar_consulta_simple("SELECT * FROM testimonio WHERE idEspecialista = '$codigo' AND TestimonioVisibilidad=1 ORDER BY TestimonioFecha DESC LIMIT $registros");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-warning alert-dismissible fade show w-75 mx-auto" role="alert">
                <strong>No hay testimonios!</strong> No hay testimonios disponibles en estos momentos.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }else{
                while ($rows = $datos->fetch()) {
                    $datosP = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idUsuario='".$rows['idUsuario']."'");
                    $usuario = $datosP->fetch();

                    echo '<div class="swiper-slide">
                                <div class="card">
                                    <img class="card-image" src="'.SERVERURL.'adjuntos/usuarios/'.$usuario['UsuarioFoto'].'" alt="alternative">
                                    <div class="card-body">
                                        <p class="testimonial-author">'.$usuario['UsuarioNombres'].' '.$usuario['UsuarioApellidoPaterno'].'</p>
                                        <p class="testimonial-text">'.$rows['TestimonioDescripcion'].'</p>
                                    </div>
                                </div>
                            </div>';
                                
                                
                }
            }
			
        }
        
  
	}
    