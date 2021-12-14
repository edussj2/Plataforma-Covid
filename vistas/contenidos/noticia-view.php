<section class="pb-5">
  <div class="container">
    <div class="row mb-4">
<?php
  $fechaActual=date('Y-m-d');
  $datos = explode("/", $_GET['views']);
  require_once "./controladores/noticiaControlador.php";
  $clasAdmin = new noticiaControlador();

  $filesA = $clasAdmin->datos_noticia_controlador("Unico",$datos[1]);

  if($filesA->rowCount()==1){
    $campos = $filesA->fetch();
?> 
      <div class="col-lg-8 mb-3">
          
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-light border">
            <li class="breadcrumb-item"><a href="<?php echo SERVERURL; ?>noticias/total/" class="enlace-texto-negro"><i class="far fa-newspaper"></i> Noticias</a></li>
            <li class="breadcrumb-item"><a href="#!" class="enlace-texto-negro"><i class="far fa-flag"></i> Nacional</a></li>
            <li class="breadcrumb-item active" aria-current="page">N° <?php echo $campos['idNoticia']?></li>
          </ol>
        </nav>

        <div class="contenedor-noticia-total bg-light">
          <div class="titulo-noticia-total">
            <h2><?php echo $campos['NoticiaTitulo']?></h2>
          </div>
          <div class="imagen-noticia-total">
            <img src="<?php echo SERVERURL ?>adjuntos/noticias/<?php echo $campos['NoticiaImagen']?>">
          </div>
          <div class="detalles-notcia-total">
            <p><i class="fas fa-calendar-week"></i> <?php echo $campos['NoticiaFecha']?></p>
            <p class="creditos"><a href="<?php echo $campos['NoticiaLink']?>" target="_blank"><i class="fas fa-link"></i> Enlace</a></p>
          </div>
          <div class="texto-noticia-total">
            <p><?php echo $campos['NoticiaDescripcion']?></p>
            <p><?php echo $campos['NoticiaDescripcion2']?></p>
          </div>

          <!-- Comentarios -->
          <div class="comentarios-noticia-total">
            <h4 class="mt-2 mb-3"><i class="far fa-comments"></i> Comentarios</h4>

            <?php
              require_once "./controladores/comentarioControlador.php";

              $insProx = new comentarioControlador();

              echo $insProx->total_comentario_controlador(10,$datos[1],$_SESSION['codigo_cuenta_unprg']);  
            ?>

            <?php
            if($_SESSION['tipo_unprg']=="Usuario"){
              require_once "./controladores/usuarioControlador.php";
              $claspersona = new usuarioControlador();
              $filepersona = $claspersona->datos_usuario_controlador("Unico",mainModel::encryption($_SESSION['codigo_cuenta_unprg']));
              $camposP = $filepersona->fetch();
            ?>
            <div class="item-comentario mb-1">
              <div class="imagen-comentario">
                <?php if($_SESSION['identificar_unprg']=="SI"){?>
                <img src="<?php echo SERVERURL; ?>adjuntos/usuarios/<?php echo $camposP['UsuarioFoto'];?>" alt="">
                <?php }elseif($_SESSION['identificar_unprg']=="NO"){ ?>
                <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $_SESSION['avatar_unprg'];?>" alt="">
                <?php }?>
              </div>
              <div class="texto-cometario">
                <div class="primero">
                  <p><a href="#"><?php echo $camposP['UsuarioNombres'];?> <?php echo $camposP['UsuarioApellidoPaterno'];?></a></p>
                </div>
                <form class="FormularioAjax" data-form="save" action="<?php echo SERVERURL; ?>ajax/comentarioAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                  <input type="hidden" name="usuario-reg" value="<?php echo mainModel::encryption( $_SESSION['id_unprg']);?>">
                  <input type="hidden" name="noticia-reg" value="<?php echo $datos[1];?>">
                  <input type="hidden" name="fecha-reg" value="<?php echo $fechaActual;?>">      
                  <textarea name="comentario-reg"></textarea>
                  <input type="submit" value="Comentar" class="btn btn-primary w-100">
                  <div class="RespuestaAjax"></div>
                </form>
              </div>
            </div>
            <?php }?>
          </div>
        </div> 
        
      </div>
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
      <div class="col-lg-4">
        <div class="contenedor-mas-noticias bg-light">

          <div class="titulo-mas-noticias">
            <h4><i class="fas fa-bullhorn"></i> Últimas Noticias</h4>
          </div>
          <div class="contenedor-item-mas-noticias">
            <?php
              require_once "./controladores/noticiaControlador.php";

              $insProx = new noticiaControlador();

              echo $insProx->mas_noticias_controlador(3,$datos[1]);  
            ?>
          </div>

          <div class="card rounded-0 mb-2">
            <div class="card-header bg-light">
                <h6 class="font-weight-bold mb-0">Categorías</h6>
            </div>
            <div class="card-body pt-2">
            <?php
                require "./controladores/categoriaControlador.php";

                $inscategoria = new categoriaControlador();

                echo $inscategoria->total_categorias_controlador();  
            ?> 
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</section> 