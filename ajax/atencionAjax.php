<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['usuario-reg']) || isset($_POST['codigo-del']) ){
		
		require_once "../controladores/atencionControlador.php";
		$insatencion = new atencionControlador();

		/**-----AGREGAR----**/
		if(isset($_POST['usuario-reg']) && isset($_POST['especialista-reg']) ){
			echo $insatencion->agregar_atencion_controlador();
		}

		/**-----ELMINAR---**/
		if(isset($_POST['codigo-del'])){
			echo $insatencion->eliminar_atencion_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}