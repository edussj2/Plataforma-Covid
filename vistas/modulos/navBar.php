<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary navbar-custom">
    <div class="container">

        <a class="navbar-brand logo-image" href="!#">
            <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/logo.png" width="130" height="40" alt="" loading="lazy">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-awesome fas fa-bars"></span>
            <span class="navbar-toggler-awesome fas fa-times"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link icono" href="<?php echo SERVERURL; ?>noticias/total/" data-toggle="tooltip" title="Noticias"><i class="fas fa-newspaper"></i> <span>Noticias</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link icono" href="<?php echo SERVERURL; ?>conferencias/" data-toggle="tooltip" title="Conferencias"><i class="fas fa-video"></i> <span>Conferencias</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link icono" href="<?php echo SERVERURL; ?>especialistas/" data-toggle="tooltip" title="Especialistas"><i class="fas fa-briefcase-medical"></i> <span>Especialistas</span></a>
                </li>
            </ul>
            <?php
            if($_SESSION['tipo_unprg']=="Administrador"){
                $tipo = "admin";
            }elseif($_SESSION['tipo_unprg']=="Usuario"){
                $tipo = "user";
            }else{
                $tipo = "especialista";
            }
            ?>
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link text-dark dropdown-toggle" href="#" id="navbarDropdown" role="button"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if($_SESSION['identificar_unprg']=="SI"){?>
                        <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $_SESSION['avatar_unprg'];?>" class="img-fluid rounded-circle avatar mr-2">
                    <?php }elseif($_SESSION['tipo_unprg']=="Usuario"){?>
                    <?php require_once "./controladores/usuarioControlador.php";
		                $clasFoto2 = new usuarioControlador();
		                $filefoto2 = $clasFoto2->datos_usuario_controlador("Unico",mainModel::encryption($_SESSION['codigo_cuenta_unprg']));
			            $campos2 = $filefoto2->fetch();
                    ?>
                        <img src="<?php echo SERVERURL; ?>adjuntos/usuarios/<?php echo $campos2['UsuarioFoto'];?>" class="img-fluid rounded-circle avatar mr-2">
                    <?php }elseif($_SESSION['tipo_unprg']=="Especialista"){
                        require_once "./controladores/especialistaControlador.php";
                        $clasFoto = new especialistaControlador();
                        $filefoto = $clasFoto->datos_especialista_controlador("Unico",mainModel::encryption($_SESSION['codigo_cuenta_unprg']));
                        $campos = $filefoto->fetch();                   
                      ?>
                        <img src="<?php echo SERVERURL; ?>adjuntos/especialistas/foto/<?php echo $campos['EspecialistaFoto'];?>" class="img-fluid rounded-circle avatar mr-2">
                      <?php } ?>
                      <?php echo $_SESSION['nombre_unprg'];?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="<?php echo SERVERURL; ?>profile/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_unprg'])?>/"><i class="fas fa-home"></i> Mi perfil</a>
                      <a class="dropdown-item" href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_unprg'])?>/"><i class="fas fa-address-card"></i> Mis datos</a>
                      <a class="dropdown-item" href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_unprg'])?>/"><i class="fas fa-cog"></i> Configuración</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item btn-cerrar-sesion" href="<?php echo $lc->encryption($_SESSION['token_unprg']);?>"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>