<?php
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
    }
    $fechaActual = date('Y-m-d');
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contenedor-formularios mb-2">
                    
                    <div class="full-box page-header">
                        <hr>
                        <h3 class="text-left">
                            <i class="fas fa-chart-line"></i> &nbsp; TABLERO
                        </h3>
                    </div>
                    <?php
                        require "./controladores/administradorControlador.php";
                        $IAdmin = new administradorControlador();
                        $CAdmin = $IAdmin->datos_administrador_controlador("Conteo",0);

                        require_once "./controladores/usuarioControlador.php";
                        $IUser = new usuarioControlador();
                        $CUser = $IUser->datos_usuario_controlador("Conteo",0);

                        require "./controladores/conferenciaControlador.php";
                        $IConf = new conferenciaControlador();
                        $CConf = $IConf->datos_conferencia_controlador("Conteo",0);

                        require "./controladores/especialistaControlador.php";
                        $IEspe = new especialistaControlador();
                        $CEspe = $IEspe->datos_especialista_controlador("Conteo",0);

                        require "./controladores/noticiaControlador.php";
                        $INoti = new noticiaControlador();
                        $CNoti = $INoti->datos_noticia_controlador("Conteo",0);

                        require "./controladores/consejoControlador.php";
                        $IConsejo = new consejoControlador();
                        $CConsejo = $IConsejo->datos_consejo_controlador("Conteo",0);

                        require "./controladores/temaControlador.php";
                        $Itema = new temaControlador();
                        $Ctema = $Itema->datos_tema_controlador("Conteo",0);
                    ?>

                    <div class="full-box text-center" style="padding: 30px 10px;">
                        <article class="full-box tile">
                            <div class="full-box tile-title text-center text-titles text-uppercase">
                                Usuarios
                            </div>
                            <div class="full-box tile-icon text-center">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="full-box tile-number text-titles">
                                <p class="full-box slowNumber"><?php echo $CUser->rowCount(); ?></p>
                                <small>Registrados</small>
                            </div>
                        </article>
                        <article class="full-box tile">
                            <div class="full-box tile-title text-center text-titles text-uppercase">
                                Administradores
                            </div>
                            <div class="full-box tile-icon text-center">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <div class="full-box tile-number text-titles">
                                <p class="full-box slowNumber"><?php echo $CAdmin->rowCount(); ?></p>
                                <small>Registrados</small>
                            </div>
                        </article>
                        <article class="full-box tile">
                            <div class="full-box tile-title text-center text-titles text-uppercase">
                                Especialistas
                            </div>
                            <div class="full-box tile-icon text-center">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <div class="full-box tile-number text-titles">
                                <p class="full-box slowNumber"><?php echo $CEspe->rowCount(); ?></p>
                                <small>Registrados</small>
                            </div>
                        </article>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container mb-5">
        <div class="row">

            <div class="col-lg-8 mb-2">
                <div class="card rounded-0">
                    <div class="card-header bg-light">
                        <h6 class="font-weight-bold mb-0"><i class="fas fa-chart-pie"></i> Estadísticas</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart" width="300" height="160"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card rounded-0">
                    <div class="card-header bg-light">
                        <h6 class="font-weight-bold mb-0"> <i class="fas fa-database"></i> Datos Generales</h6>
                    </div>
                    <div class="card-body pt-2">
                        <div class="d-flex border-bottom py-2">
                            <div class="d-flex mr-3">
                                <h2 class="align-self-center mb-0"><i class="fas fa-newspaper"></i></h2>
                            </div>
                            <div class="align-self-center">
                                <h6 class="d-inline-block mb-0 slowNumber"><?php echo $CNoti->rowCount(); ?></h6><span> NOTICIAS</span>
                                <small class="d-block text-muted">Última: <?php echo $fechaActual; ?></small>
                            </div>
                        </div>
                        <div class="d-flex border-bottom py-2">
                            <div class="d-flex mr-3">
                                <h2 class="align-self-center mb-0"><i class="fas fa-video"></i></h2>
                            </div>
                            <div class="align-self-center">
                                <h6 class="d-inline-block mb-0 slowNumber"><?php echo $CConf->rowCount(); ?></h6><span> CONFERENCIAS</span>
                                <small class="d-block text-muted">Última: <?php echo $fechaActual; ?></small>
                            </div>
                        </div>
                        <div class="d-flex border-bottom py-2">
                            <div class="d-flex mr-3">
                                <h2 class="align-self-center mb-0"><i class="fas fa-heartbeat"></i></h2>
                            </div>
                            <div class="align-self-center">
                                <h6 class="d-inline-block mb-0 slowNumber"><?php echo $Ctema->rowCount(); ?></h6><span> TEMAS</span>
                                <small class="d-block text-muted">Última: <?php echo $fechaActual; ?></small>
                            </div>
                        </div>
                        <div class="d-flex border-bottom py-2">
                            <div class="d-flex mr-3">
                                <h2 class="align-self-center mb-0"><i class="fas fa-comment-medical"></i></h2>
                            </div>
                            <div class="align-self-center">
                                <h6 class="d-inline-block mb-0 slowNumber"><?php echo $CConsejo->rowCount(); ?></h6><span> CONSEJOS</span>
                                <small class="d-block text-muted">Última: <?php echo $fechaActual; ?></small>
                            </div>
                        </div>
                        <div class="d-flex border-bottom py-2 mb-3">
                            <div class="d-flex mr-3">
                                <h2 class="align-self-center mb-0"><i class="fab fa-youtube"></i></h2>
                            </div>
                            <div class="align-self-center">
                                <h6 class="d-inline-block mb-0 slowNumber">6</h6><span> VIDEOS</span>
                                <small class="d-block text-muted">Última: <?php echo $fechaActual; ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>