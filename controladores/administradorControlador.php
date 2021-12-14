<?php 
    /* HECHO */
	if($peticionAjax){
		require_once "../modelos/administradorModelo.php";
	}else{
		require_once "./modelos/administradorModelo.php";
	}

	class administradorControlador extends administradorModelo
	{
		/*AGREGAR*/
		public function agregar_administrador_controlador(){

			/*--DATOS DEL ADMINISTRADOR--*/
			$dni = mainModel::limpiar_cadena($_POST['dni-reg']);
			$nombres = mainModel::limpiar_cadena($_POST['nombres-reg']);
			$paterno = mainModel::limpiar_cadena($_POST['paterno-reg']);
			$materno = mainModel::limpiar_cadena($_POST['materno-reg']);
			$telefono = mainModel::limpiar_cadena($_POST['telefono-reg']);
			$genero = mainModel::limpiar_cadena($_POST['optionsGenero']);
            $direccion = mainModel::limpiar_cadena($_POST['direccion-reg']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripción-reg']);

			/*--DATOS DE LA CUENTA--*/
			$correo = mainModel::limpiar_cadena($_POST['email-reg']);
			$pass1 = mainModel::limpiar_cadena($_POST['pass1-reg']);
			$pass2 = mainModel::limpiar_cadena($_POST['pass2-reg']);

            /*--ASIGNAMOS AVATAR--*/
			if($genero=="Masculino"){
				$avatar = "adminMasculino.png";
			}else{
                $avatar = "adminFemenino.png";
			}

            /*--VALIDACIONES--*/
            if($dni== "" || $nombres=="" || $paterno=="" || $materno=="" || $correo=="" || $pass1=="" || $pass2=="" ){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{
            
                if($pass1!=$pass2){

                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Las contraseñas no coinciden, intente nuevamente","Tipo"=>"warning"];
                
                }else{

                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM administrador WHERE AdminDNI='$dni'");
                    
                    if($consulta1->rowCount()>=1){
                        
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El DNI que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
                    
                    }else{

                        $consulta2 = mainModel::ejecutar_consulta_simple("SELECT CuentaCorreo FROM cuenta WHERE CuentaCorreo='$correo'");
                        if($consulta2->rowCount()>=1){

                                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo ingresado ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
                        
                        }else{

                            if(strlen( $dni ) != 8){

                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El DNI ingresado no es válido","Tipo"=>"warning"];
                            
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
                                                "privilegio"=>1,
                                                "correo"=>$correo,
                                                "clave"=>$clave,
                                                "vigencia"=>1,
                                                "tipo"=>"Administrador",
                                                "avatar"=>$avatar
                                        ];

                                        $guardarCuenta = mainModel::agregar_cuenta($datosCuenta);

                                        if($guardarCuenta->rowCount()>=1){
                                            $datosAdministrador=[
                                                    "dni"=>$dni,
                                                    "nombres"=>$nombres,
                                                    "paterno"=>$paterno,
                                                    "materno"=>$materno,
                                                    "telefono"=>$telefono,
                                                    "descripcion"=>$descripcion,
                                                    "genero"=>$genero,
                                                    "vigencia"=>1,
                                                    "direccion"=>$direccion,
                                                    "codigo"=>$codigo
                                            ];

                                            $guardarAdministrador = administradorModelo::agregar_administrador_modelo($datosAdministrador);

                                            if($guardarAdministrador->rowCount()>=1){
                                                $alerta = ["Alerta"=>"limpiar", "Titulo"=>"ADMINISTRADOR REGISTRADO","Texto"=>"Los datos se registrarón con éxito.","Tipo"=>"success"];
                                            }else{
                                                mainModel::eliminar_cuenta($codigo);
                                                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro del administrador, intente nuevamente","Tipo"=>"error"];
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
        public function paginador_administrador_controlador($pagina,$registros,$privilegio,$codigo,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM administrador WHERE ((CuentaCodigo != '$codigo')AND (idAdministrador != 1) AND (AdminNombre LIKE '%$busqueda%' OR AdminApellidoPaterno LIKE '%$busqueda%' OR AdminApellidoMaterno LIKE '%$busqueda%' OR 	AdminDNI LIKE '%$busqueda%')) ORDER BY AdminApellidoPaterno ASC LIMIT $inicio,$registros";

                $paginaURL = "adminBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM administrador WHERE CuentaCodigo != '$codigo' AND idAdministrador != 1 ORDER BY AdminApellidoPaterno	 ASC LIMIT $inicio,$registros";

                $paginaURL = "adminLista";
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
                                    <th scope="col">DNI</th>
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
                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <h4>'.$rows['AdminApellidoPaterno'].' '.$rows['AdminApellidoMaterno'].' '.$rows['AdminNombre'].'</h4>
                                </div>
                                </td>
                                <td>'.$rows['AdminDNI'].'</td>
                                <td>
                                    <a href="'.SERVERURL.'profile/admin/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-primary" data-toggle="tooltip" title="Información" data-placement="bottom">
                                        <i class="far fa-user-circle"></i>
                                    </a>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'adminEditar/admin/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.SERVERURL.'myaccount/admin/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Cuenta" data-placement="bottom">
                                        <i class="fas fa-cog"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="'.SERVERURL.'ajax/administradorAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="cuenta-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'">
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
        public function eliminar_administrador_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['cuenta-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $query1=mainModel::ejecutar_consulta_simple("SELECT id FROM administrador WHERE CuentaCodigo='$idCuenta'");

                $datosAD = $query1->fetch();

                if($datosAD['idAdministrador']!=1){

                    $eliminarAdministrador = administradorModelo::eliminar_administrador_modelo($idCuenta);
                    mainModel::eliminar_bitarcora($idCuenta);

                    if($eliminarAdministrador->rowCount()>=1){

                        $eliminarCuenta = mainModel::eliminar_cuenta($idCuenta);

                        if($eliminarCuenta->rowCount()>=1){
                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"ADMINISTRADOR ELIMINADO","Texto"=>"Los datos se eliminarón satisfactoriamente del sistema.","Tipo"=>"success"];
                        
                        }else{
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar completamente la cuenta, avisar a soporte técnico","Tipo"=>"info"];
                        }
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar el administrador, intenté nuevamente","Tipo"=>"error"];
                    }
                }else{
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El administrador que desea eliminar no es válido para eliminación","Tipo"=>"error"];
                }
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /*DATOS*/
        public function datos_administrador_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return administradorModelo::datos_administrador_modelo($tipo, $codigo);
        }

        /*ACTUALIZAR PARCIAL*/
        public function actualizar_parcial_administrador_controlador(){

            $cuenta = mainModel::decryption($_POST['codigo1-up']);
            $dni = mainModel::limpiar_cadena($_POST['dni1-up']);
            $nombres = mainModel::limpiar_cadena($_POST['nombres1-up']);
            $apellidoP = mainModel::limpiar_cadena($_POST['paterno1-up']);
            $apellidoM = mainModel::limpiar_cadena($_POST['materno1-up']);
            $telefono = mainModel::limpiar_cadena($_POST['telefono1-up']);
            $direccion = mainModel::limpiar_cadena($_POST['direccion1-up']);
            $genero = mainModel::limpiar_cadena($_POST['optionsGenero1-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion1-up']);

            if($dni== "" || $nombres=="" || $apellidoP=="" || $apellidoM==""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM administrador WHERE CuentaCodigo ='$cuenta'");

            $datosAdmin = $consulta1->fetch();

            if($dni != $datosAdmin['AdminDNI']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM administrador WHERE AdminDNI ='$dni'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El DNI ingresado ya ha sido registrado en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            if(strlen( $dni ) != 8){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El DNI ingresado no es válido","Tipo"=>"warning"];   
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

            $datosAdministrador= ["nombres"=>$nombres,"apellidoP"=>$apellidoP,"apellidoM"=>$apellidoM,"telefono"=>$telefono,"dni"=>$dni,"genero"=>$genero,"codigo"=>$cuenta,"descripcion"=>$descripcion, "direccion"=>$direccion];

            if(administradorModelo::actualizar_parcial_administrador_modelo($datosAdministrador)->rowCount()>=1){
                /*--ASIGNAMOS AVATAR--*/
                if($genero=="Masculino"){
                    $avatar = "adminMasculino.png";
                }else{
                    $avatar = "adminFemenino.png";
                }
                mainModel::actualizar_avatar_cuenta($cuenta,$avatar);
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"ADMINISTRADOR ACTUALIZADO","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos del administrador, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

        /*ACTUALIZAR GENERAL*/
        public function actualizar_general_administrador_controlador(){ 

            $cuenta = mainModel::decryption($_POST['codigo2-up']);
            $dni = mainModel::limpiar_cadena($_POST['dni2-up']);
            $nombres = mainModel::limpiar_cadena($_POST['nombres2-up']);
            $apellidoP = mainModel::limpiar_cadena($_POST['paterno2-up']);
            $apellidoM = mainModel::limpiar_cadena($_POST['materno2-up']);
            $telefono = mainModel::limpiar_cadena($_POST['telefono2-up']);
            $direccion = mainModel::limpiar_cadena($_POST['direccion2-up']);
            $genero = mainModel::limpiar_cadena($_POST['optionsGenero2-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion2-up']);
            $vigencia = mainModel::limpiar_cadena($_POST['vigencia-up']);

            if($dni== "" || $nombres=="" || $apellidoP=="" || $apellidoM=="" || $vigencia=""){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM administrador WHERE CuentaCodigo ='$cuenta'");

            $datosAdmin = $consulta1->fetch();

            if($dni != $datosAdmin['AdminDNI']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM administrador WHERE AdminDNI ='$dni'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El DNI ingresado ya ha sido registrado en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            if(strlen( $dni ) != 8){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El DNI ingresado no es válido","Tipo"=>"warning"];   
                return mainModel::sweet_alert($alerta);
                exit();          
            }

            if($telefono!="" && is_numeric($telefono)==false ){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            if(strlen( $telefono) < 6 && $telefono!=""){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            $datosAdministrador= ["nombres"=>$nombres,"apellidoP"=>$apellidoP,"apellidoM"=>$apellidoM,"telefono"=>$telefono,"dni"=>$dni,"genero"=>$genero,"codigo"=>$cuenta,"descripcion"=>$descripcion, "direccion"=>$direccion,"vigencia"=>$vigencia];

            if(administradorModelo::actualizar_general_administrador_modelo($datosAdministrador)->rowCount()>=1){
                /*--ASIGNAMOS AVATAR--*/
                if($genero=="Masculino"){
                    $avatar = "adminMasculino.png";
                }else{
                    $avatar = "adminFemenino.png";
                }
                mainModel::actualizar_avatar_cuenta($cuenta,$avatar);
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"ADMINISTRADOR ACTUALIZADO","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos del administrador, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }
	}
    