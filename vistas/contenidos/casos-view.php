<?php
    /*HECHO*/
	if($_SESSION['tipo_unprg']!="Especialista"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
?>        
<section class="pb-4">   
    <div class="container">
        <div class="row mb-5">
            <div class="contenedor-formularios mb-2">
                <div class="full-box page-header">
                    <hr>
                    <h3 class="text-left">
                        <i class="fas fa-envelope-square"></i> &nbsp; Casos &nbsp;<small>Gestión</small>
                    </h3>
                    <p class="text-justify">
                        Lista de los usuarios a los cuales se les ha brindado ayuda.
                    </p>
                </div>
<?php 
    require_once "./controladores/atencionControlador.php";
    $insatencion = new atencionControlador();
?>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 mb-5">
                            <div class="contenedor-paneles mb-5">
                                <div class="container-fluid">
                                    <div class="panel panel-info shadow">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fas fa-list"></i> &nbsp; LISTA DE ATENCIONES SIN RESPONDER</h3>
                                        </div>
                                        <div class="panel-body">
                                            <?php 
                                                $pagina = explode("/", $_GET['views']);
                                                echo $insatencion->paginador_atencion_controlador($pagina[1],15,$_SESSION['privilegio_unprg'],$_SESSION['id_unprg']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</section>