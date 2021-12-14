<aside  class="sidebar-container">
    <div class="menu">
        <!-- Logo de la Pedro-->
        <div class="logo-pedro">
            <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/logoUnprg.png" alt="">
        </div>
        <!-- Opciones generales-->
        <div class="opciones-generales">
            <a href="<?php echo SERVERURL; ?>profile/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_unprg'])?>/">
                <div class="nombre-foto">
                <?php if($_SESSION['identificar_unprg']=="SI"){?>
                    <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $_SESSION['avatar_unprg'];?>">
                <?php }elseif($_SESSION['tipo_unprg']=="Usuario"){?>
                <?php   require_once "./controladores/usuarioControlador.php";
		                $clasFoto = new usuarioControlador();
		                $filefoto = $clasFoto->datos_usuario_controlador("Unico",mainModel::encryption($_SESSION['codigo_cuenta_unprg']));
			            $campos = $filefoto->fetch();
                ?>
                    <img src="<?php echo SERVERURL; ?>adjuntos/usuarios/<?php echo $campos['UsuarioFoto'];?>">
                <?php }elseif($_SESSION['tipo_unprg']=="Especialista"){
                    require_once "./controladores/especialistaControlador.php";
                    $clasFoto = new especialistaControlador();
                    $filefoto = $clasFoto->datos_especialista_controlador("Unico",mainModel::encryption($_SESSION['codigo_cuenta_unprg']));
                    $campos = $filefoto->fetch();
                ?>
                    <img src="<?php echo SERVERURL; ?>adjuntos/especialistas/foto/<?php echo $campos['EspecialistaFoto'];?>">
                <?php } ?>
                    <h3 class="text-left"><?php echo $_SESSION['nombre_unprg'];?> <?php echo $_SESSION['apellidoP_unprg'];?> <?php echo $_SESSION['apellidoM_unprg'];?></h3>
                </div>
            </a>
            <a href="<?php echo SERVERURL; ?>infoCovid/">
                <div class="links-covid">
                    <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/IconoCovid1.svg">
                    <h4>Información General</h4>
                </div>
            </a>
            <a href="<?php echo SERVERURL; ?>sintomasyprecauciones/">
                <div class="links-covid">
                    <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/IconoCovid2.svg">
                    <h4>Síntomas y Precauciones</h4>
                </div>
            </a>
            <a href="<?php echo SERVERURL; ?>dataMundial/">
                <div class="links-covid">
                    <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/IconoCovid3.svg">
                    <h4>Reporte Mundial</h4>
              </div>
            </a>
            <a href="<?php echo SERVERURL; ?>saludMental/">
                <div class="links-covid">
                    <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/IconoCovid5.svg">
                    <h4>Salud Mental</h4>
                </div>
            </a>
            <a href="<?php echo SERVERURL; ?>covidVideos/">
                <div class="links-covid">
                    <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/IconoCovid4.svg">
                    <h4>CovidVideos</h4>
                </div>
            </a>
            <a href="<?php echo SERVERURL; ?>tutorial/">
                <div class="links-covid">
                    <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/IconoCovid7.svg">
                    <h4>Capacitaciones</h4>
                </div>
            </a>
        </div>

        <div class="linea mt-3"></div>
        <?php if($_SESSION['tipo_unprg']== "Administrador"){?>   
        <!-- Opciones Específicas-->
        <p class="mas-opciones">Más Opciones</p>
        <ul>    
            <li>
                <a href="<?php echo SERVERURL; ?>dashboard/"><i class="fas fa-chart-line"></i> Tablero</a>
            </li>
            <li>
                <a href="#" class="sub1-btn"><i class="fas fa-users"></i> Clientes <span class="fas fa-caret-down sub-uno"></span></a>
                <ul class="uno-show">
                  <li><a href="<?php echo SERVERURL; ?>userLista/"><i class="fas fa-graduation-cap"></i> Usuarios</a></li>
                  <li><a href="<?php echo SERVERURL; ?>adminLista/"><i class="fas fa-user-cog"></i> Administrador</a></li>
                  <li><a href="<?php echo SERVERURL; ?>especialistaLista/"><i class="fas fa-user-md"></i> Especialista</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="sub2-btn"><i class="fas fa-tools"></i> Mantenimiento <span class="fas fa-caret-down sub-dos"></span></a>
                <ul class="dos-show">
                  <li><a href="<?php echo SERVERURL; ?>facultadLista/"><i class="far fa-building"></i> Facultad</a></li>
                  <li><a href="<?php echo SERVERURL; ?>escuelaLista/"><i class="fas fa-university"></i> Escuela</a></li>
                  <li><a href="<?php echo SERVERURL; ?>especialidadLista/"><i class="fas fa-stethoscope"></i> Especialidad</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="sub3-btn"><i class="far fa-newspaper"></i>  Noticias<span class="fas fa-caret-down sub-tres"></span></a>
                <ul class="tres-show">
                  <li><a href="<?php echo SERVERURL; ?>categoriaLista/"><i class="fas fa-certificate"></i> Categoría</a></li>
                  <li><a href="<?php echo SERVERURL; ?>noticiaLista/"><i class="far fa-newspaper"></i> Noticia</a></li>
                  <li><a href="<?php echo SERVERURL; ?>comentarioLista/"><i class="far fa-comment-dots"></i> Comentarios</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="sub4-btn"><i class="far fa-calendar-check"></i>  Conferencias<span class="fas fa-caret-down sub-cuatro"></span></a>
                <ul class="cuatro-show">
                  <li><a href="<?php echo SERVERURL; ?>conferenciaLista/"><i class="fas fa-video"></i> VideoConferencia</a></li>
                  <li><a href="<?php echo SERVERURL; ?>grabacionLista/"><i class="fas fa-link"></i> Enlace de Grabacion</a></li>
                  <li><a href="<?php echo SERVERURL; ?>participantesConferencia/"><i class="fas fa-list-ol"></i> Participantes</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="sub5-btn"><i class="fas fa-user-md"></i>  Especialistas<span class="fas fa-caret-down sub-cinco"></span></a>
                <ul class="cinco-show">
                  <li><a href="<?php echo SERVERURL; ?>testimonioLista/"><i class="far fa-comment-alt"></i> Testimonios</a></li>
                  <li><a href="<?php echo SERVERURL; ?>quejaLista/"><i class="fas fa-minus-circle"></i> Quejas</a></li>
                </ul>
            </li>
            <li>
                <a href="#" class="sub6-btn"><i class="fas fa-heartbeat"></i>  Salud mental<span class="fas fa-caret-down sub-seis"></span></a>
                <ul class="seis-show">
                  <li><a href="<?php echo SERVERURL; ?>temaLista/"><i class="fas fa-heartbeat"></i> Tema</a></li>
                  <li><a href="<?php echo SERVERURL; ?>consejoLista/"><i class="fas fa-laptop-medical"></i> Consejos</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo SERVERURL; ?>atencionLista/"><i class="fas fa-laptop-medical"></i> Atenciones</a>
            </li>
            <li>
                <a href="<?php echo SERVERURL; ?>reportes/"><i class="fas fa-chart-bar"></i> Reportes</a>
            </li> 
        </ul>
        <?php } ?>
        <?php if($_SESSION['tipo_unprg']== "Especialista"){?>   
        <!-- Opciones Específicas-->
        <p class="mas-opciones">Más Opciones</p>
        <ul>    
            <?php
                require "./controladores/atencionControlador.php";
                $Iate = new atencionControlador();
                $Cate = $Iate->datos_atencion_controlador("Especial",mainModel::encryption($_SESSION['id_unprg']));
            ?>
            <li>
                <a href="<?php echo SERVERURL; ?>casos/"><i class="fas fa-envelope-square"></i> Mensajes <span class="badge badge-pill badge-danger"><?php echo $Cate->rowCount();?></span></a>
            </li>
            <li>
                <a href="#" class="sub1-btn"><i class="fas fa-id-card-alt"></i> Gestión<span class="fas fa-caret-down sub-uno"></span></a>
                <ul class="uno-show">
                  <li><a href="<?php echo SERVERURL; ?>myTestimonios/"><i class="fas fa-graduation-cap"></i> Testimonios</a></li>
                  <li><a href="<?php echo SERVERURL; ?>myQuejas/"><i class="fas fa-user-cog"></i> Quejas</a></li>
                  <li><a href="<?php echo SERVERURL; ?>myAtenciones/"><i class="fas fa-laptop-medical"></i> Atenciones</a></li>
                </ul>
            </li>
        </ul>
        <?php } ?>
        <?php if($_SESSION['tipo_unprg']== "Usuario"){?>   
        <!-- Opciones Específicas-->
        <p class="mas-opciones">Más Opciones</p>
        <ul>    
            <li>
                <a href="<?php echo SERVERURL; ?>myConsultas/"><i class="fas fa-hand-holding-heart"></i> Mis Atenciones</a>
            </li>
        </ul>
        <?php } ?>
        <!-- Footer-->
        <div class="footer text-left p-3 mt-5">
            <p><a href="#">&nbsp;Preguntas Frecuentes</a> - <a href="#">&nbsp;Páginas de ayuda</a> - <a href="#">&nbsp;Soporte Técnico</a> - 2020ECO © UNPRG</p>
        </div>

    </div>
</aside>
<!-- Fin sidebar -->

<!-- BotonSideBar-->
<div class="btn-menu" id="btn-menu">
    <span class="fas fa-plus"></span>
</div>
<!-- BotonSideBar-->