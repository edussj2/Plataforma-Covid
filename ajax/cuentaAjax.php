<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['codigo-cuenta-up'])){
		
		require_once "../controladores/cuentaControlador.php";
		$insCuenta = new cuentaControlador();

		if(isset($_POST['codigo-cuenta-up']) && isset($_POST['correo-muestra']) && isset($_POST['emailLog-up']) && isset($_POST['passwordLog-up'])){
			echo $insCuenta->actualizar_cuenta_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}