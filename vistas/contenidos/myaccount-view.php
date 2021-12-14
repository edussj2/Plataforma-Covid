<section>
    <div class="container">
        <div class="row mb-5">
            <div class="contenedor-formularios mb-2">

                <div class="full-box page-header">
                    <hr>
                    <h3 class="text-left">
                        <i class="fas fa-cog"></i> &nbsp; Mi Cuenta
                    </h3>
                    <p class="text-justify">
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
                    </p>
                </div>
<?php 
	$datos = explode("/", $_GET['views']);
	/*---ADMINSITRADOR---*/
	if($datos[1]=="admin"):
		if($_SESSION['tipo_unprg'] != "Administrador"){
			echo $lc->forzar_cierre_sesion_controlador();
		}
			
		require_once "./controladores/cuentaControlador.php";
		$insCta = new cuentaControlador();
		$cta = $insCta->datos_cuenta_controlador($datos[2],$datos[1]);

		if($cta->rowCount()==1){
			$campos=$cta->fetch();
?>	
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <div class="contenedor-paneles mb-5">
                            <div class="container-fluid">
                                <div class="panel panel-actualizar shadow">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp;MODIFICAR CUENTA</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form class="FormularioAjax needs-validation" novalidate action="<?php echo SERVERURL;?>ajax/cuentaAjax.php" method="POST" data-form="update" autocomplete="off" enctype="multipart/form-data">
                                            <?php 
                                                if($_SESSION['codigo_cuenta_unprg']  != $campos['CuentaCodigo']){
                                                    if($_SESSION['tipo_unprg'] != "Administrador"){
                                                        echo $lc->forzar_cierre_sesion_controlador();
                                                    }
                                                    else{
                                                        echo '<input type="hidden" name="privilegio-up" value="verdadero">';
                                                    }
                                                }
                                            ?>
                                            <input type="hidden" name="codigo-cuenta-up" value="<?php echo $datos[2]; ?>">
                                            <input type="hidden" name="tipo-cuenta-up" value="<?php echo $lc->encryption($datos[1]) ?>">
                                            
                                            <fieldset>
                                                <legend><i class="fas fa-info-circle"></i> &nbsp;Información de la cuenta</legend>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Correo</label>
                                                                <input class="form-control" type="email" name="correo-muestra" maxlength="80" required=""  value="<?php echo $campos['CuentaCorreo']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br>

                                            <fieldset>
                                                <legend><i class="fas fa-unlock-alt"></i> &nbsp;Actualizar Contraseña</legend>
                                                <p>La contraseña es una parte importante de su cuenta, se recomienda usar una contraseña segura combinando mayúsculas y minúsculas,
                                                </p>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Nueva contraseña *</label>
                                                                <input class="form-control" type="password" name="newPass-up" maxlength="20" minlength="6">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Repita la nueva contraseña *</label>
                                                                <input class="form-control" type="password" name="newPass2-up" maxlength="20" minlength="6">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br>

                                            <fieldset>
                                                <legend><i class="fas fa-key"></i> &nbsp;Confirmación de la cuenta</legend>
                                                <p>
                                                    Para poder actualizar los datos de la cuenta por favor ingrese su correo y contraseña actual.
                                                </p>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Correo *</label>
                                                                <input class="form-control" type="email" name="emailLog-up" maxlength="120" required="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Contraseña *</label>
                                                                <input class="form-control" type="password" name="passwordLog-up" maxlength="20" required="" minlength="5">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

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
            <div class="alert alert-dimissible alert-warning text-center border">
                <button type="button" class="close" data-dismiss="alert">x</button>	
                <i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
                <h4>LO SENTIMOS!</h4>
                <p>No pudimos mostrar la información buscada</p>
            </div>
<?php
        }
    /*---USUARIO---*/
    elseif ($datos[1]=="user"):
        require_once "./controladores/cuentaControlador.php";
        $insCta = new cuentaControlador();
        $cta = $insCta->datos_cuenta_controlador($datos[2],$datos[1]);

        if($cta->rowCount()==1){
            $campos=$cta->fetch();
?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <div class="contenedor-paneles mb-5">
                            <div class="container-fluid">
                                <div class="panel panel-actualizar shadow">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp;MODIFICAR CUENTA</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form class="FormularioAjax needs-validation" novalidate action="<?php echo SERVERURL;?>ajax/cuentaAjax.php" method="POST" data-form="update" autocomplete="off" enctype="multipart/form-data">
                                            <?php 
                                                if($_SESSION['codigo_cuenta_unprg']  != $campos['CuentaCodigo']){
                                                    if($_SESSION['tipo_unprg'] != "Administrador"){
                                                        echo $lc->forzar_cierre_sesion_controlador();
                                                    }
                                                    else{
                                                        echo '<input type="hidden" name="privilegio-up" value="verdadero">';
                                                    }
                                                }
                                            ?>
                                            <input type="hidden" name="codigo-cuenta-up" value="<?php echo $datos[2]; ?>">
                                            <input type="hidden" name="tipo-cuenta-up" value="<?php echo $lc->encryption($datos[1]) ?>">
                                            
                                            <fieldset>
                                                <legend><i class="fas fa-info-circle"></i> &nbsp;Información de la cuenta</legend>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Correo</label>
                                                                <input class="form-control" type="email" readonly="" name="correo-muestra" maxlength="80" required=""  value="<?php echo $campos['CuentaCorreo']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br>

                                            <fieldset>
                                                <legend><i class="fas fa-unlock-alt"></i> &nbsp;Actualizar Contraseña</legend>
                                                <p>La contraseña es una parte importante de su cuenta, se recomienda usar una contraseña segura combinando mayúsculas y minúsculas,
                                                </p>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Nueva contraseña *</label>
                                                                <input class="form-control" type="password" name="newPass-up" maxlength="20" minlength="6">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Repita la nueva contraseña *</label>
                                                                <input class="form-control" type="password" name="newPass2-up" maxlength="20" minlength="6">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br>

                                            <fieldset>
                                                <legend><i class="fas fa-key"></i> &nbsp;Confirmación de la cuenta</legend>
                                                <p>
                                                    Para poder actualizar los datos de la cuenta por favor ingrese su correo y contraseña actual.
                                                </p>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Correo *</label>
                                                                <input class="form-control" type="email" name="emailLog-up" maxlength="120" required="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Contraseña *</label>
                                                                <input class="form-control" type="password" name="passwordLog-up" maxlength="20" required="" minlength="5">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

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
            <div class="alert alert-dimissible alert-warning text-center border">
                <button type="button" class="close" data-dismiss="alert">x</button>	
                <i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
                <h4>LO SENTIMOS!</h4>
                <p>No pudimos mostrar la información buscada, porfavor recargué la página</p>
            </div>	
	<?php
		}
	/*-- ESPECIALISTA --*/	
    elseif($datos[1]=="especialista"):
        require_once "./controladores/cuentaControlador.php";
        $insCta = new cuentaControlador();
        $cta = $insCta->datos_cuenta_controlador($datos[2],$datos[1]);

        if($cta->rowCount()==1){
            $campos=$cta->fetch();
    ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 mb-5">
                        <div class="contenedor-paneles mb-5">
                            <div class="container-fluid">
                                <div class="panel panel-actualizar shadow">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp;MODIFICAR CUENTA</h3>
                                    </div>
                                    <div class="panel-body">
                                        <form class="FormularioAjax needs-validation" novalidate action="<?php echo SERVERURL;?>ajax/cuentaAjax.php" method="POST" data-form="update" autocomplete="off" enctype="multipart/form-data">
                                            <?php 
                                                if($_SESSION['codigo_cuenta_unprg']  != $campos['CuentaCodigo']){
                                                    if($_SESSION['tipo_unprg'] != "Administrador"){
                                                        echo $lc->forzar_cierre_sesion_controlador();
                                                    }
                                                    else{
                                                        echo '<input type="hidden" name="privilegio-up" value="verdadero">';
                                                    }
                                                }
                                            ?>
                                            <input type="hidden" name="codigo-cuenta-up" value="<?php echo $datos[2]; ?>">
                                            <input type="hidden" name="tipo-cuenta-up" value="<?php echo $lc->encryption($datos[1]) ?>">
                                            
                                            <fieldset>
                                                <legend><i class="fas fa-info-circle"></i> &nbsp;Información de la cuenta</legend>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Correo</label>
                                                                <input class="form-control" type="email" readonly="" name="correo-muestra" maxlength="80" required=""  value="<?php echo $campos['CuentaCorreo']; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br>

                                            <fieldset>
                                                <legend><i class="fas fa-unlock-alt"></i> &nbsp;Actualizar Contraseña</legend>
                                                <p>La contraseña es una parte importante de su cuenta, se recomienda usar una contraseña segura combinando mayúsculas y minúsculas,
                                                </p>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Nueva contraseña *</label>
                                                                <input class="form-control" type="password" name="newPass-up" maxlength="20" minlength="6">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Repita la nueva contraseña *</label>
                                                                <input class="form-control" type="password" name="newPass2-up" maxlength="20" minlength="6">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br>

                                            <fieldset>
                                                <legend><i class="fas fa-key"></i> &nbsp;Confirmación de la cuenta</legend>
                                                <p>
                                                    Para poder actualizar los datos de la cuenta por favor ingrese su correo y contraseña actual.
                                                </p>
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Correo *</label>
                                                                <input class="form-control" type="email" name="emailLog-up" maxlength="120" required="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Contraseña *</label>
                                                                <input class="form-control" type="password" name="passwordLog-up" maxlength="20" required="" minlength="5">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

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
            <div class="alert alert-dimissible alert-warning text-center border">
                <button type="button" class="close" data-dismiss="alert">x</button>	
                <i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
                <h4>LO SENTIMOS!</h4>
                <p>No pudimos mostrar la información buscada, porfavor recargué la página</p>
            </div>	
    <?php 
    }
    /*-- ERROR --*/
    else: 
    ?>
        <div class="alert alert-dimissible alert-warning text-center">
            <button type="button" class="close" data-dismiss="alert">x</button>	
            <i class="fas fa-exclamation-triangle" style="font-size:4rem;"></i>
            <h4>LO SENTIMOS!</h4>
            <p>No pudimos mostrar la información buscada, porfavor recargué la página</p>
        </div>
	<?php endif; ?>
            </div>
        </div>
    </div>
</section>