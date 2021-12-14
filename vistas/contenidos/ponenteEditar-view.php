<?php
  /* HECHO */
	if($_SESSION['tipo_unprg']!="Administrador"){
		echo $lc->forzar_cierre_sesion_controlador();
	}
  $fechaActual = date('Y-m-d');
?>        
<section class="pb-4">
  <div class="container">
    <div class="row mb-5">
      <div class="contenedor-formularios mb-2">

            <div class="full-box page-header">
                <hr>
                <h3 class="text-left">
                    <i class="fas fa-video"></i> &nbsp; Conferencia &nbsp;<small>Gestión</small>
                </h3>
                <p class="text-justify">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
                </p>
            </div>

            <div class="container-fluid">
                <ul class="listado-regresar">
                    <li>
                    <a href="../../<?php SERVERURL; ?>conferenciaLista/" class="enlace-lista">
                        <i class="fas fa-arrow-circle-left"></i> REGRESAR
                    </a>
                    </li>
                </ul>
            </div>
<?php
    $datos = explode("/", $_GET['views']);
    require_once "./controladores/ponenteControlador.php";
    $clasAdmin = new ponenteControlador();

    $filesA = $clasAdmin->datos_ponente_controlador($datos[1]);

    if($filesA->rowCount()==1){
        $campos = $filesA->fetch();

        if(1 != $_SESSION['privilegio_unprg']){
        echo $lc->forzar_cierre_sesion_controlador();		
        }
?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                    <div class="contenedor-paneles mb-5">
                        <div class="container-fluid">

                        <div class="panel panel-actualizar shadow mt-4">
                            <div class="panel-heading">
                            <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; MODIFICAR PONENTE</h3>
                            </div>
                            <div class="panel-body">
                            <form action="<?php echo SERVERURL;?>ajax/ponenteAjax.php" method="POST" data-form="update" class="needs-validation FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                                <input type="hidden" name="codigo-up" value="<?php echo $datos[1];?>">
                                
                                <fieldset>
                                    <legend><i class="far fa-user-circle"></i> &nbsp; Datos del Ponente</legend>
                                    <div class="container-fluid pt-2">
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Nombre Completo *</label>
                                            <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,120}" class="form-control" type="text" name="nombres-up" required="" maxlength="120" value="<?php echo $campos['PonenteNombres'];?>" >
                                            <div class="invalid-feedback">
                                            Complete el campo correctamente.
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Descripción *</label>
                                            <textarea name="descripcion-up" class="form-control" rows="2" maxlength="200"><?php echo $campos['PonenteDescripcion'];?></textarea>
                                            <div class="invalid-feedback">
                                            Complete el campo correctamente.
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </fieldset>
                                <br>

                                <p class="text-center" style="margin-top: 10px;">
                                <button type="submit" class="boton-actualizar"><i class="fas fa-edit"></i> Actualizar</button>
                                </p>
                                <div class="RespuestaAjax"></div>
                            </form>
                            </div>
                        </div>
                        
                        </div>
                    </div>
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
      </div>
    </div>
  </div>
</section> 