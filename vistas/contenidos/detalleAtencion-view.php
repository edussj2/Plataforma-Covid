<section class="contenido-presentacion">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 presentacion">
        <h1 class="font-weight-bold mb-0">Atención</h1>
        <p class="lead text-muted">Revisa las últimas noticias positivas del Covid-19</p>
      </div>
    </div>
  </div>
</section>
<?php
  /* HECHO */
  $datos = explode("/", $_GET['views']);
  require_once "./controladores/atencionControlador.php";
  $clasAdmin = new atencionControlador();
  $fechaActual=date('Y-m-d');
  $filesA = $clasAdmin->datos_atencion_controlador("Unico",$datos[1]);

  if($filesA->rowCount()==1){
    $campos = $filesA->fetch();
    $idAtencion = mainModel::encryption($campos['idAtencion']);
      
    require_once "./controladores/usuarioControlador.php";
    $classUser = new usuarioControlador();
    $dataUser = $classUser->datos_usuario_controlador("Unico2",mainModel::encryption($campos['idUsuario']));
    $camposUser = $dataUser->fetch();

    require_once "./controladores/especialistaControlador.php";
    $classEspe = new especialistaControlador();
	$dataEspe = $classEspe->datos_especialista_controlador("Unico2",mainModel::encryption($campos['idEspecialista']));
	$camposEspe = $dataEspe->fetch();
?>
<section class="detalleContacto pb-5">
  <div class="container">
    <div class="row mb-4">
        <!-- Contenido-->
        <div class="col-lg-12 mb-3 bg-light border p-5 qp">
            <h5 class="titulo">
                <i class="fas fa-paper-plane"></i> Detalle del contacto
            </h5>
            <div class="contendor-perfil-caso">
                <div class="contenedor-caso">
                    <h4>Descripcion del Caso:</h4>
                    <p><?php echo $campos['AtencionDescripcion']?></p>
                </div>
                <div class="contenedor-perfil">
                <?php if($camposUser['UsuarioFoto']!="nulo"){?>
                <img src="<?php echo SERVERURL; ?>adjuntos/usuarios/<?php echo $camposUser['UsuarioFoto']?>" alt="">
                <?php }else{
                    require_once "./controladores/cuentaControlador.php";
                    $classcta = new cuentaControlador();
                    $datacta = $classcta->datos_cuenta_controlador(mainModel::encryption($camposUser['CuentaCodigo']),"user");
                    $camposcta = $datacta->fetch();    
                ?>
                <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $camposcta['CuentaAvatar'];?>" alt="" class="p-3">
                <?php }?>
                <div class="texto">
                    <h5>Nombre Completo</h5>
                    <a href="https://api.whatsapp.com/send?phone=<?php echo $camposUser['UsuarioTelefono'];?>&text=Voy a ayudarte de forma directa" target="_blank" class="btn btn-primary btn-sm">Contacto <i class="fab fa-whatsapp"></i></a>
                </div>
                </div>
            </div>
        </div>

        <?php if($_SESSION['tipo_unprg']=="Especialista" || $_SESSION['tipo_unprg']=="Usuario"){

                require_once "./controladores/diagnositicoControlador.php";
                $classDiag = new diagnositicoControlador();
                $dataDiag = $classDiag->datos_diagnostico_controlador("Unico",$datos[1]); 
                if($dataDiag->rowCount()==0){
        ?>
        <div class="col-lg-12 mb-3 bg-light border p-5">
            <div class="contenedor-respuesta">
            <?php if($_SESSION['tipo_unprg']=="Especialista"){?>
            <div class="diagnostico">
                <h5><i class="fas fa-reply-all"></i> Detalle del diagnostico:</h5>
            </div>
            <form class="FormularioAjax" data-form="save" action="<?php echo SERVERURL; ?>ajax/diagnosticoAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="atencion-reg" value="<?php echo $idAtencion;?>">
                <textarea name="respuesta-reg" id="" rows="10" class="form-control w-100"></textarea>
                <p>
                <button type="submit" class="btn btn-info mt-2 mb-2">Responder</button>
                </p>
                <div class="RespuestaAjax"></div>
            </form>
            <?php }?>
            </div>
        </div>
        <?php }elseif($dataDiag->rowCount()>=1){ 
            $data = $dataDiag->fetch();    
        ?>
        <div class="col-lg-12 mb-3 bg-light border p-5 qp">
            <h5 class="titulo">
            <i class="fas fa-reply-all"></i> Detalle de Respuesta
            </h5>
            <div class="contendor-perfil-caso">
            <div class="contenedor-perfil">
                <img src="<?php echo SERVERURL;?>adjuntos/especialistas/foto/<?php echo $camposEspe['EspecialistaFoto'];?>" alt="">
                <div class="texto">
                <h5><?php echo $camposEspe['EspecialistaNombres'];?> <?php echo $camposEspe['EspecialistaApellidos'];?></h5>
                </div>
            </div>
            <div class="contenedor-caso">
                <h4>Descripcion del Diagnostico:</h4>
                <p><?php echo $data['DiagnosticoDescripcion'];?></p>
            </div>
            
            </div>
            
        </div>
        <div class="col-lg-12 p-4 bg-light border">
            <a href="<?php echo SERVERURL; ?>reportePdf/informacion.php?numero=<?php echo mainModel::encryption($campos['idAtencion'])?>" target="_blank" class="btn btn-success w-100">Descargar Diagnostico <i class="fas fa-download"></i></a>
        </div>
        <?php }}?>
    </div>
  </div>
</section>
<?php 
  }else{
?>
    <div class="alert alert-dimissible alert-warning text-center border mt-3">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
			<h4>!LO SENTIMOS!</h4>
			<p>No pudimos mostrar la información buscada</p>
	  </div>
 <?php   
  }
 ?> 