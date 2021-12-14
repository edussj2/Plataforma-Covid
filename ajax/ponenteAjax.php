<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['codigo-up'])){
		
		require_once "../controladores/ponenteControlador.php";
		$insponente = new ponenteControlador();

		if(isset($_POST['codigo-up']) && isset($_POST['nombres-up']) ){
			echo $insponente->actualizar_ponente_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}