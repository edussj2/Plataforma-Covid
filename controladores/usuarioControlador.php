<?php 
    /* HECHO*/
	if($peticionAjax){
		require_once "../modelos/usuarioModelo.php";
	}else{
		require_once "./modelos/usuarioModelo.php";
	}

	class usuarioControlador extends usuarioModelo
	{
		/*AGREGAR*/
		public function agregar_usuario_controlador(){

			/*--DATOS DE LA PERSONA--*/
			$nombres = mainModel::limpiar_cadena($_POST['nombres-reg']);
			$apellidoP = mainModel::limpiar_cadena($_POST['paterno-reg']);
			$apellidoM = mainModel::limpiar_cadena($_POST['materno-reg']);
			$telefono = mainModel::limpiar_cadena($_POST['telefono-reg']);
            $nacimiento = mainModel::limpiar_cadena($_POST['fecha-reg']);
			$descripcion = mainModel::limpiar_cadena($_POST['descripción-reg']);
            $genero = mainModel::limpiar_cadena($_POST['optionsGenero']);
            $direccion = mainModel::limpiar_cadena($_POST['direccion-reg']);
            $escuela = mainModel::limpiar_cadena($_POST['cboEscuela']);
            $tipo = mainModel::limpiar_cadena($_POST['tipo-reg']);
            $distrito = mainModel::limpiar_cadena($_POST['cboDistrito']);


            /*--DATOS DE LA CUENTA--*/
			$correo = mainModel::limpiar_cadena($_POST['email-reg']);
			$pass1 = mainModel::limpiar_cadena($_POST['pass1-reg']);
			$pass2 = mainModel::limpiar_cadena($_POST['pass2-reg']);
			$privilegio = 3;


            /*--ASIGNAMOS AVATAR--*/
			if($genero=="Masculino"){
				$avatar = "userMasculino.png";
			}else{
                $avatar = "userFemenino.png";
			}

            /*--VALIDACIONES--*/
            if($nombres=="" || $apellidoP=="" || $apellidoM=="" || $correo=="" || $pass1=="" || $pass2=="" || $nacimiento=="" || $direccion=="" || $distrito==-1 || $escuela==-1){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                if($pass1!=$pass2){

                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Las contraseñas que ingresaste no coinciden, intente nuevamente","Tipo"=>"warning"];
                
                }else{

                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT UsuarioTelefono FROM usuario WHERE UsuarioTelefono='$telefono'");
                    
                    if($consulta1->rowCount()>=1){
                        
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
                    
                    }else{

                        $consulta2 = mainModel::ejecutar_consulta_simple("SELECT CuentaCorreo FROM cuenta WHERE CuentaCorreo='$correo'");
                        if($consulta2->rowCount()>=1){

                                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo ingresado ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
                        
                        }else{

                            if(strlen( $telefono ) < 6 && $telefono!=""){

                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono ingresado no es válido","Tipo"=>"warning"];
                            
                            }else{

                                if(filter_var($correo, FILTER_VALIDATE_EMAIL)==false){
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo electrónico ingresado no es válido","Tipo"=>"warning"];
                                }else{

                                if($telefono!="" && is_numeric($telefono)==false ){
                           
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                                       
                                }else{

                                        $consulta3 = mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta");
                                        $numero = ($consulta3->rowCount())+1;

                                        $codigo= mainModel::generar_codigo_aleatorio("UNPRG",10,$numero);

                                        $clave = mainModel::encryption($pass1);

                                        $datosCuenta=[
                                                "codigo"=>$codigo,
                                                "privilegio"=>3,
                                                "correo"=>$correo,
                                                "clave"=>$clave,
                                                "vigencia"=>1,
                                                "tipo"=>"Usuario",
                                                "avatar"=>$avatar
                                        ];

                                        $guardarCuenta = mainModel::agregar_cuenta($datosCuenta);

                                        if($guardarCuenta->rowCount()>=1){

                                            $foto1 = $_FILES['foto-reg']['name'];
                                            $ruta1 = $_FILES['foto-reg']['tmp_name'];
                                            if($foto1 != ""){
                                                $fotoColegiado="../adjuntos/usuarios/".$codigo."-".$foto1;
                                                copy($ruta1,$fotoColegiado);
                                                $nombreFoto= $codigo."-".$foto1;
                                            }else{
                                                $nombreFoto="nulo";
                                            }

                                            $datos=[
                                                    "nombres" => $nombres,
                                                    "paterno" => $apellidoP,
                                                    "materno" => $apellidoM,
                                                    "telefono" => $telefono,
                                                    "descripcion" => $descripcion,
                                                    "direccion" => $direccion,
                                                    "foto" => $nombreFoto,
                                                    "nacimiento" => $nacimiento,
                                                    "genero" => $genero,
                                                    "tipo" => $tipo,
                                                    "cuenta" => $codigo,
                                                    "escuela" => $escuela,
                                                    "distrito" => $distrito
                                            ];

                                            $guardarusuario = usuarioModelo::agregar_usuario_modelo($datos);

                                            if($guardarusuario->rowCount()>=1){
                                                $alerta = ["Alerta"=>"limpiar", "Titulo"=>"USUARIO REGISTRADO","Texto"=>"Los datos se registrarón con éxito.","Tipo"=>"success"];
                                            }else{
                                                @unlink('../adjuntos/usuarios/'.$nombreFoto);
                                                mainModel::eliminar_cuenta($codigo);
                                                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro del usuario, intente nuevamente".$distrito." ".$escuela,"Tipo"=>"error"];
                                            }
                                        }else{
                                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro de la cuenta, intente nuevamente","Tipo"=>"error"];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } 

            return mainModel::sweet_alert($alerta);
		}

        /*PAGINAR LISTA Y BUSQUEDA*/
        public function paginador_usuario_controlador($pagina,$registros,$privilegio,$codigo,$busqueda){
       
            /**-----LIMPIAMOS PARAMETROS RECIBIDOS-----**/
           $pagina = mainModel::limpiar_cadena($pagina);
           $registros = mainModel::limpiar_cadena($registros);
           $privilegio = mainModel::limpiar_cadena($privilegio);
           $codigo = mainModel::limpiar_cadena($codigo);
           $busqueda = mainModel::limpiar_cadena($busqueda);

           $tabla = "";

           /**-----VALIDAMOS LAS PAGINAS Y EL ORDEN DE LOS REGISTROS----**/
           $pagina = (isset($pagina) && $pagina>0) ? (int)$pagina : 1;
           $inicio = ($pagina>0) ? (($pagina * $registros) - $registros): 0;

           /**-----VALIDAMOS SI ES UNA BUSQUEDA O SI ES LA LISTA---**/
           if(isset($busqueda) && $busqueda!=""){
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((CuentaCodigo != '$codigo') AND (UsuarioNombres LIKE '%$busqueda%' OR UsuarioApellidoPaterno LIKE '%$busqueda%' OR UsuarioApellidoMaterno LIKE '%$busqueda%' OR UsuarioCodigo LIKE '%$busqueda%')) ORDER BY UsuarioApellidoPaterno ASC LIMIT $inicio,$registros";

               $paginaURL = "userBuscar";
           }else{
               $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE CuentaCodigo != '$codigo' ORDER BY UsuarioApellidoPaterno ASC LIMIT $inicio,$registros";

               $paginaURL = "userLista";
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
                                   <th scope="col">Correo</th>
                                   <th scope="col">Detalles</th>';
           if($privilegio==1){
               $tabla .= '         <th scope="col">Datos</th> 
                                   <th scope="col">Cuenta</th>
                                   <th scope="col">Eliminar</th>';
           }
           
           $tabla .= '</tr></thead><tbody>';

           if($total>=1 && $pagina <= $Npaginas){

               $contador = $inicio+1;
               foreach ($datos as $rows) {
                    $query1 = mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo ='".$rows['CuentaCodigo']."'");
                    $datos= $query1->fetch();
                   $tabla.= '<tr>
                               <th scope="row">'.$contador.'</th>
                               <td>
                               <div class="identificacion">
                                   <h4>'.$rows['UsuarioApellidoPaterno'].' '.$rows['UsuarioApellidoMaterno'].' '.$rows['UsuarioNombres'].'</h4>
                               </div>
                               </td>
                               <td>'.$datos['CuentaCorreo'].'</td>
                               <td>
                                   <a href="'.SERVERURL.'profile/user/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-primary" data-toggle="tooltip" title="Información" data-placement="bottom">
                                       <i class="far fa-user-circle"></i>
                                   </a>
                               </td>';

                       if($privilegio==1){
                          $tabla.='
                                   <td>
                                       <a href="'.SERVERURL.'userEditar/user/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                           <i class="fas fa-pencil-alt"></i>
                                       </a>
                                   </td>
                                   <td>
                                       <a href="'.SERVERURL.'myaccount/user/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Cuenta" data-placement="bottom">
                                       <i class="fas fa-cog"></i>
                                       </a>
                                   </td>
                                   <td>
                                       <form action="'.SERVERURL.'ajax/usuarioAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                           <input type="hidden" name="cuenta-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'">
                                           <input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
                                           <input type="hidden" name="foto-del" value="'.$rows['UsuarioFoto'].'">
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

        /*ELIMINAR*/
        public function eliminar_usuario_controlador(){

            $idCuenta = mainModel::decryption($_POST['cuenta-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
            $foto = mainModel::limpiar_cadena($_POST['foto-del']);

            if($privilegio == 1){

                $eliminar = usuarioModelo::eliminar_usuario_modelo($idCuenta);

                if($eliminar->rowCount()==1){

                    @unlink('../adjuntos/usuarios/'.$foto);
                    mainModel::eliminar_bitarcora($idCuenta);
                    $eliminarCuenta = mainModel::eliminar_cuenta($idCuenta);

                    if($eliminarCuenta->rowCount()==1){
                         $alerta = ["Alerta"=>"recargar", "Titulo"=>"USUARIO ELIMINADO","Texto"=>"Los datos se eliminarón satisfactoriamente del sistema.","Tipo"=>"success"];
                    }else{
                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar la cuenta, avisar a soporte técnico","Tipo"=>"warning"];
                    }


                }else{
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar el USUARIO, revise si tiene estudios o pagos registrados antes de realizar esta operación, e intenté nuevamente","Tipo"=>"error"];
                }

            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

         /*DATOS*/
        public function datos_usuario_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return usuarioModelo::datos_usuario_modelo($tipo, $codigo);
        }

        /*ACTUALIZAR PARCIAL*/
        public function actualizar_parcial_usuario_controlador(){

            $cuenta = mainModel::decryption($_POST['codigo1-up']);
            $telefono = mainModel::limpiar_cadena($_POST['telefono1-up']);
            $direccion = mainModel::limpiar_cadena($_POST['direccion1-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion1-up']);

            if($telefono!="" && is_numeric($telefono)==false ){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            if(strlen($telefono) < 6 && $telefono!=""){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            $datos= ["telefono"=>$telefono,"codigo"=>$cuenta,"descripcion"=>$descripcion, "direccion"=>$direccion];

            if(usuarioModelo::actualizar_parcial_usuario_modelo($datos)->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"USUARIO ACTUALIZADO","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

        /**--ACTUALIZAR FOTO PERSONAL---**/
        public function actualizar_foto_usuario_controlador(){

            $cuenta = mainModel::decryption($_POST['codigo2-up']);
            $foto1 = $_FILES['foto2-up']['name'];
            $ruta1 = $_FILES['foto2-up']['tmp_name'];

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE CuentaCodigo='$cuenta'");
            $datosFoto = $consulta1->fetch();

            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='$cuenta'");
            $datos = $consulta2->fetch();

            if($datosFoto['UsuarioFoto']!="nulo"){
                $fotoAntigua=$datosFoto['UsuarioFoto'];
            }else{
                $fotoAntigua="nulo";
            }
            $codUni=$datosFoto['CuentaCodigo'];


            $fotoColegiado="../adjuntos/usuarios/".$codUni."-".$foto1;
            copy($ruta1,$fotoColegiado);
            $nombreFoto= $codUni."-".$foto1;


            $datos= ["foto"=>$nombreFoto,"codigo"=>$cuenta];

            if(usuarioModelo::actualizar_foto_usuario_modelo($datos)->rowCount()>=1){
                @unlink('../adjuntos/usuarios/'.$fotoAntigua);
                $alerta = ["Alerta"=>"redirigir", "Titulo"=>"FOTO ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success","Enlace"=>"profile/user/".$_POST['codigo2-up']];
                session_start(['name'=>'UNPRG']);
                $_SESSION['identificar_unprg']="NO";
            }else{
                @unlink('../adjuntos/usuarios/'.$nombreFoto);
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

        /**--ACTUALIZAR FOTO DESDE ADMIN---**/
        public function actualizar2_foto_usuario_controlador(){

            $cuenta = mainModel::decryption($_POST['codigo4-up']);
            $foto1 = $_FILES['foto4-up']['name'];
            $ruta1 = $_FILES['foto4-up']['tmp_name'];

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE CuentaCodigo='$cuenta'");
            $datosFoto = $consulta1->fetch();

            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='$cuenta'");
            $datos = $consulta2->fetch();

            if($datosFoto['UsuarioFoto']!="nulo"){
                $fotoAntigua=$datosFoto['UsuarioFoto'];
            }else{
                $fotoAntigua="nulo";
            }
            $codUni=$datosFoto['CuentaCodigo'];


            $fotoColegiado="../adjuntos/usuarios/".$codUni."-".$foto1;
            copy($ruta1,$fotoColegiado);
            $nombreFoto= $codUni."-".$foto1;


            $datos= ["foto"=>$nombreFoto,"codigo"=>$cuenta];

            if(usuarioModelo::actualizar_foto_usuario_modelo($datos)->rowCount()>=1){
                @unlink('../adjuntos/usuarios/'.$fotoAntigua);
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"FOTO ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                @unlink('../adjuntos/usuarios/'.$nombreFoto);
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

        /*ACTUALIZAR GENERAL*/
        public function actualizar_general_usuario_controlador(){

            $codigo = mainModel::decryption($_POST['codigo3-up']);
            $nombres = mainModel::limpiar_cadena($_POST['nombres-up']);
            $paterno = mainModel::limpiar_cadena($_POST['paterno-up']);
            $materno = mainModel::limpiar_cadena($_POST['materno-up']);
            $telefono = mainModel::limpiar_cadena($_POST['telefono-up']);
            $fecha = mainModel::limpiar_cadena($_POST['fecha-up']);
            $direccion = mainModel::limpiar_cadena($_POST['direccion-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripción-up']);
            $genero = mainModel::limpiar_cadena($_POST['optionsGeneroup']);
            $distrito = mainModel::limpiar_cadena($_POST['cboDistrito2']);
            $escuela = mainModel::limpiar_cadena($_POST['cboEscuela2']);
            $tipo = mainModel::limpiar_cadena($_POST['tipo-up']);
 
            
            $fecha_actual = strtotime(date("Y-m-d"));
            $fechaNueva = strtotime($fecha);

            if($nombres=="" || $paterno=="" || $materno=="" || $fecha=="" || $direccion=="" || $distrito==-1 || $escuela==-1){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Completa los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            if($telefono!="" && is_numeric($telefono)==false ){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            if(strlen($telefono) < 6 && $telefono!=""){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            if($fechaNueva > $fecha_actual){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"La fecha no es válida","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            $datos= ["nombres"=>$nombres,
                     "apellidoP"=>$paterno,
                     "apellidoM"=>$materno, 
                     "telefono"=>$telefono,
                     "descripcion"=>$descripcion,
                     "direccion"=>$direccion,
                     "nacimiento"=>$fecha,
                     "genero"=>$genero,
                     "tipo"=>$tipo,
                     "escuela"=>$escuela,
                     "distrito"=>$distrito,
                     "codigo"=>$codigo
                    ];

            if(usuarioModelo::actualizar_general_usuario_modelo($datos)->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"USUARIO ACTUALIZADO","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }
        
	}
    