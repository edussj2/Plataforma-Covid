<?php 
    /* HECHO */
	if($peticionAjax){
		require_once "../modelos/especialistaModelo.php";
	}else{
		require_once "./modelos/especialistaModelo.php";
	}

	class especialistaControlador extends especialistaModelo
	{
		/* AGREGAR */
		public function agregar_especialista_controlador(){

			/*--DATOS DEL especialista--*/
			$nombres = mainModel::limpiar_cadena($_POST['nombres-reg']);
			$apellidos = mainModel::limpiar_cadena($_POST['apellidos-reg']);
			$experiencia = mainModel::limpiar_cadena($_POST['experiencia-reg']);
			$telefono = mainModel::limpiar_cadena($_POST['telefono-reg']);
			$correo = mainModel::limpiar_cadena($_POST['correo-reg']);
			$centro = mainModel::limpiar_cadena($_POST['centro-reg']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripción-reg']);
            $departamento = mainModel::limpiar_cadena($_POST['departamento-reg']);
            $especialidad = mainModel::limpiar_cadena($_POST['categoría-reg']);
            $link = $_POST['link-reg'];

            /*--DATOS DE LA CUENTA--*/
			$email = mainModel::limpiar_cadena($_POST['email-reg']);
			$pass1 = mainModel::limpiar_cadena($_POST['pass1-reg']);
			$pass2 = mainModel::limpiar_cadena($_POST['pass2-reg']);

            
            $consulta3 = mainModel::ejecutar_consulta_simple("SELECT idEspecialista FROM especialista");
            $numero = ($consulta3->rowCount())+1;

            $codigo= mainModel::generar_codigo_aleatorio("ESPEC",10,$numero);


            $foto1 = $_FILES['foto-reg']['name'];
            $ruta1 = $_FILES['foto-reg']['tmp_name'];
            
            $foto2 = $_FILES['certificado-reg']['name'];
            $ruta2 = $_FILES['certificado-reg']['tmp_name'];

            $foto3 = $_FILES['cv-reg']['name'];
            $ruta3 = $_FILES['cv-reg']['tmp_name'];

            $fotoEspecialista="../adjuntos/especialistas/foto/".$codigo."-".$foto1;
            copy($ruta1,$fotoEspecialista);
            $nombreFoto= $codigo."-".$foto1;

            $fotoCertificado="../adjuntos/especialistas/certificado/".$codigo."-".$foto2;
            copy($ruta3,$fotoCertificado);
            $nombreCertificado= $codigo."-".$foto2;

            $fotoCV="../adjuntos/especialistas/cv/".$codigo."-".$foto3;
            copy($ruta3,$fotoCV);
            $nombreCV= $codigo."-".$foto3;
            
            /*--VALIDACIONES--*/
            if($nombres== "" || $apellidos=="" || $experiencia=="" || $telefono=="" || $correo=="" || $centro==""  || $departamento==0 || $especialidad==0 || $foto1=="" || $foto2="" || $foto3==""){

                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];

            }else{

                    $consulta1 = mainModel::ejecutar_consulta_simple("SELECT EspecialistaCorreo FROM especialista WHERE EspecialistaCorreo='$correo'");
                    
                    if($consulta1->rowCount()>=1){
                        
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo de contacto que ingresaste ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
                    
                    }else{

                        $consulta2 = mainModel::ejecutar_consulta_simple("SELECT CuentaCorreo FROM cuenta WHERE CuentaCorreo='$email'");
                        if($consulta2->rowCount()>=1){

                                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo ya se encuentra registrado, intente nuevamente","Tipo"=>"warning"];
                        
                        }else{

                            if(filter_var($correo, FILTER_VALIDATE_EMAIL)==false){
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo electrónico ingresado no es válido","Tipo"=>"warning"];
                            }else{

                                if($telefono!="" && is_numeric($telefono)==false ){
                           
                                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                                       
                                }else{
                                    
                                    if($pass1!=$pass2){

                                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Las contraseñas no coinciden, intente nuevamente","Tipo"=>"warning"];
                                    
                                    }else{

                                        if(filter_var($correo, FILTER_VALIDATE_EMAIL)==false){
                                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo electrónico de contacto ingresado no es válido","Tipo"=>"warning"];
                                        }else{
                                            if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){
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
                                                            "privilegio"=>2,
                                                            "correo"=>$email,
                                                            "clave"=>$clave,
                                                            "vigencia"=>1,
                                                            "tipo"=>"Especialista",
                                                            "avatar"=>"especialista.png"
                                                    ];
            
                                                    $guardarCuenta = mainModel::agregar_cuenta($datosCuenta);
            
                                                    if($guardarCuenta->rowCount()>=1){
                                                        $datos=[
                                                            "nombres"=>$nombres,
                                                            "apellidos"=>$apellidos,
                                                            "descripcion"=>$descripcion,
                                                            "experiencia"=>$experiencia,
                                                            "foto"=>$nombreFoto,
                                                            "cv"=>$nombreCV,
                                                            "certificado"=>$nombreCertificado,
                                                            "link"=>$link,
                                                            "correo"=>$correo,
                                                            "celular"=>$telefono,
                                                            "departamento"=>14,
                                                            "especialidad"=>$especialidad,
                                                            "centro"=>$centro,
                                                            "cuenta"=>$codigo
                                                        ];
                                                        $guardar = especialistaModelo::agregar_especialista_modelo($datos);

                                                        if($guardar->rowCount()>=1){
                                                                $alerta = ["Alerta"=>"limpiar", "Titulo"=>"ESPECIALISTA REGISTRADO","Texto"=>"Los datos se registrarón con éxito","Tipo"=>"success"];
                             
                                                        }else{
                                                            @unlink('../adjuntos/especialistas/foto/'.$nombreFoto);
                                                            @unlink('../adjuntos/especialistas/certificado/'.$nombreCertificado);
                                                            @unlink('../adjuntos/especialistas/cv'.$nombreCV);
                                                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Hubo un problema con el registro del especialista, intente nuevamente","Tipo"=>"error"];
                                                        }
                                                    }else{
                                                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo registrar los datos de la cuenta.","Tipo"=>"error"];
                                                    }
                                                }
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

        /* PAGINAR LISTA Y BUSQUEDA */
        public function paginador_especialista_controlador($pagina,$registros,$privilegio,$busqueda){
       
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
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM especialista WHERE (EspecialistaNombres LIKE '%$busqueda%' OR EspecialistaApellidos LIKE '%$busqueda%') ORDER BY EspecialistaApellidos ASC LIMIT $inicio,$registros";

                $paginaURL = "especialistaBuscar";
            }else{
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM especialista ORDER BY EspecialistaApellidos ASC LIMIT $inicio,$registros";

                $paginaURL = "especialistaLista";
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
                                    <th scope="col">Cuenta</th>
                                    <th scope="col">Detalles</th>';
            if($privilegio==1){
                $tabla .= '         <th scope="col">Perfil</th>
                                    <th scope="col">Datos</th>
                                    <th scope="col">Cuenta</th> 
                                    <th scope="col">Eliminar</th>';
            }
            
            $tabla .= '</tr></thead><tbody>';

            if($total>=1 && $pagina <= $Npaginas){

                $contador = $inicio+1;
                foreach ($datos as $rows) {
                    $query2 = mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo ='".$rows['CuentaCodigo']."'");
                    $datos2= $query2->fetch();
                    $tabla.= '<tr>
                                <th scope="row">'.$contador.'</th>
                                <td>
                                <div class="identificacion">
                                    <img src="'.SERVERURL.'adjuntos/especialistas/foto/'.$rows['EspecialistaFoto'].'" alt="" class="imagen-identifiacion">
                                    <h4>'.$rows['EspecialistaNombres'].' '.$rows['EspecialistaApellidos'].'</h4>
                                </div>
                                </td>
                                <td>'.$datos2['CuentaCorreo'].'</td>
                                <td>
                                    <a href="'.SERVERURL.'especialistaProfile/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-primary" data-toggle="tooltip" title="Información" data-placement="bottom">
                                        <i class="far fa-user-circle"></i>
                                    </a>
                                </td>';

                        if($privilegio==1){
                           $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'profile/especialista/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-primary" data-toggle="tooltip" title="Información" data-placement="bottom">
                                        <i class="far fa-user-circle"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.SERVERURL.'especialistaEditar/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Datos" data-placement="bottom">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.SERVERURL.'myaccount/especialista/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success" data-toggle="tooltip" title="Actualizar Cuenta" data-placement="bottom">
                                        <i class="fas fa-cog"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="'.SERVERURL.'ajax/especialistaAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data">
                                            <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'">
                                            <input type="hidden" name="foto" value="'.mainModel::encryption($rows['EspecialistaFoto']).'">
                                            <input type="hidden" name="cv" value="'.mainModel::encryption($rows['EspecialistaCV']).'">
                                            <input type="hidden" name="certificado" value="'.mainModel::encryption($rows['EspecialistaCertificado']).'">
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

        /* ELIMINAR */
        public function eliminar_especialista_controlador(){

            /**-----DESINCRIPTAMOS LOS DATOS ----**/
            $idCuenta = mainModel::decryption($_POST['codigo-del']);
            $privilegio = mainModel::decryption($_POST['privilegio-admin']);
 
            /**-----LIMPIAMOS LOS DATOS ----**/
            $idCuenta = mainModel::limpiar_cadena($idCuenta);
            $privilegio = mainModel::limpiar_cadena($privilegio);

            if($privilegio == 1){

                $nombreFoto=  mainModel::decryption($_POST['foto']);
                $nombreCertificado=  mainModel::decryption($_POST['certificado']);
                $nombreCV=  mainModel::decryption($_POST['cv']);

                    $eliminarespecialista = especialistaModelo::eliminar_especialista_modelo($idCuenta);

                    if($eliminarespecialista->rowCount()>=1){
                        @unlink('../adjuntos/especialistas/foto/'.$nombreFoto);
                        @unlink('../adjuntos/especialistas/certificado/'.$nombreCertificado);
                        @unlink('../adjuntos/especialistas/cv/'.$nombreCV);
                        mainModel::eliminar_bitarcora($idCuenta);
                        $eliminarCuenta = mainModel::eliminar_cuenta($idCuenta);
                        if($eliminarCuenta->rowCount()>=1){
                            $alerta = ["Alerta"=>"recargar", "Titulo"=>"ESPECIALISTA ELIMINADO","Texto"=>"Los datos se eliminarón satisfactoriamente del sistema.","Tipo"=>"success"];
                        
                        }else{
                            $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar completamente la cuenta, avisar a soporte técnico","Tipo"=>"info"];
                        }
      
                    }else{
                        $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudo eliminar el especialista, intenté nuevamente","Tipo"=>"error"];
                    }
 
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Usted no tiene permisos para realizar esta operación","Tipo"=>"error"];
            }

            return mainModel::sweet_alert($alerta);
        }

        /* DATOS */
        public function datos_especialista_controlador($tipo,$codigo){

            $codigo = mainModel::decryption($codigo);
            $tipo = mainModel::limpiar_cadena($tipo);

            return especialistaModelo::datos_especialista_modelo($tipo, $codigo);
        }

        /* ACTUALIZAR */
        public function actualizar_especialista_controlador(){

            $cuenta = mainModel::decryption($_POST['codigo-up']);
            $nombres = mainModel::limpiar_cadena($_POST['nombres-up']);
            $apellidos = mainModel::limpiar_cadena($_POST['apellidos-up']);
            $experiencia = mainModel::limpiar_cadena($_POST['experiencia-up']);
            $telefono = mainModel::limpiar_cadena($_POST['telefono-up']);
            $correo = mainModel::limpiar_cadena($_POST['correo-up']);
            $centro = mainModel::limpiar_cadena($_POST['centro-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripción-up']);
            $departamento = mainModel::limpiar_cadena($_POST['departamento-up']);
            $categoria = mainModel::limpiar_cadena($_POST['categoria-up']);
            $link = $_POST['link-up'];

            if($nombres== "" || $apellidos=="" || $centro=="" ){
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"Complete los campos requeridos","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE CuentaCodigo ='$cuenta'");

            $datosAdmin = $consulta1->fetch();

            if($correo != $datosAdmin['EspecialistaCorreo']){

                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT EspecialistaCorreo FROM especialista WHERE EspecialistaCorreo ='$correo'");

                if($consulta2->rowCount()>=1){
                    $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El correo ingresado ya ha sido registrado en el sistema, intenté nuevamente","Tipo"=>"error"];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }


            if($telefono!="" && is_numeric($telefono)==false ){          
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"El teléfono no es válido","Tipo"=>"warning"];
                return mainModel::sweet_alert($alerta);
                exit();    
            }

            $datosespecialista= ["nombres"=>$nombres,"apellidos"=>$apellidos,"descripcion"=>$descripcion,"experiencia"=>$experiencia,"link"=>$link,"correo"=>$correo,"celular"=>$telefono,"departamento"=>$departamento, "especialidad"=>$categoria, "centro"=>$centro,"codigo"=>$cuenta];

            if(especialistaModelo::actualizar_especialista_modelo($datosespecialista)->rowCount()>=1){
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"ESPECIALISTA ACTUALIZADO","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos del especialista, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

        /* LISTA DE ESPECIALISTAS PEQUEÑO */
        public function lista_corta_especialista_controlador($registros){

            $registros= mainModel::limpiar_cadena($registros);

            $datos = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista ORDER BY idEspecialista DESC LIMIT $registros");

            if($datos->rowCount()==0){
                echo'<div class="alert alert-secondary" role="alert">
                        <i class="fas fa-exclamation-circle"></i> No hay registro de especialistas en nuestra base de datos
                    </div>';
            }else{
                while ($rows = $datos->fetch()) {
                    echo '
                        <li>
                            <a href="'.SERVERURL.'/especialistaProfile/'.mainModel::encryption($rows['idEspecialista']).'">
                                  <img class="img-fluid" src="'.SERVERURL.'adjuntos/especialistas/foto/'.$rows['EspecialistaFoto'].'" alt="" data-toggle="tooltip" data-placement="bottom" title="'.$rows['EspecialistaNombres'].' '.$rows['EspecialistaApellidos'].'">
                            </a>
                        </li>
                    ';
                }
            }
            
        }

        /* ACTUALIZAR FOTO */
        public function actualizar_foto_usuario_controlador(){

            $cuenta = mainModel::decryption($_POST['codigo2-up']);
            $foto1 = $_FILES['foto2-up']['name'];
            $ruta1 = $_FILES['foto2-up']['tmp_name'];

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE CuentaCodigo='$cuenta'");
            $datosFoto = $consulta1->fetch();

            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE CuentaCodigo='$cuenta'");
            $datos = $consulta2->fetch();

            if($datosFoto['EspecialistaFoto']!="nulo"){
                $fotoAntigua=$datosFoto['EspecialistaFoto'];
            }else{
                $fotoAntigua="nulo";
            }
            $codUni=$datosFoto['CuentaCodigo'];


            $fotoColegiado="../adjuntos/especialistas/foto/".$codUni."-".$foto1;
            copy($ruta1,$fotoColegiado);
            $nombreFoto= $codUni."-".$foto1;


            $datos= ["foto"=>$nombreFoto,"codigo"=>$cuenta];

            if(especialistaModelo::actualizar_foto_especialista_modelo($datos)->rowCount()>=1){
                @unlink('../adjuntos/especialistas/foto/'.$fotoAntigua);
                $alerta = ["Alerta"=>"redirigir", "Titulo"=>"FOTO ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success","Enlace"=>"profile/especialista/".$_POST['codigo2-up']];
            }else{
                @unlink('../adjuntos/especialistas/foto/'.$nombreFoto);
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

        /**--ACTUALIZAR CV PERSONAL---**/
        public function actualizar_cv_usuario_controlador(){

            $cuenta = mainModel::decryption($_POST['codigo4-up']);
            $foto1 = $_FILES['foto4-up']['name'];
            $ruta1 = $_FILES['foto4-up']['tmp_name'];

            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE CuentaCodigo='$cuenta'");
            $datosFoto = $consulta1->fetch();

            $consulta2 = mainModel::ejecutar_consulta_simple("SELECT * FROM especialista WHERE CuentaCodigo='$cuenta'");
            $datos = $consulta2->fetch();

            if($datosFoto['EspecialistaCV']!="nulo"){
                $fotoAntigua=$datosFoto['EspecialistaCV'];
            }else{
                $fotoAntigua="nulo";
            }
            $codUni=$datosFoto['CuentaCodigo'];


            $fotoColegiado="../adjuntos/especialistas/cv/".$codUni."-".$foto1;
            copy($ruta1,$fotoColegiado);
            $nombreFoto= $codUni."-".$foto1;


            $datos= ["cv"=>$nombreFoto,"codigo"=>$cuenta];

            if(especialistaModelo::actualizar_cv_especialista_modelo($datos)->rowCount()>=1){
                @unlink('../adjuntos/especialistas/cv/'.$fotoAntigua);
                $alerta = ["Alerta"=>"recargar", "Titulo"=>"CV ACTUALIZADA","Texto"=>"Los datos fueron actualizados con éxito","Tipo"=>"success"];
            }else{
                @unlink('../adjuntos/especialistas/cv/'.$nombreFoto);
                $alerta = ["Alerta"=>"simple", "Titulo"=>"Ocurrió un error","Texto"=>"No se pudieron actualizar los datos, intenté nuevamente","Tipo"=>"error"];
            }
            return mainModel::sweet_alert($alerta);
        }

	}
    