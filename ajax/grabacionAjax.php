<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['conferencia-reg']) || isset($_POST['codigo-del']) ){
		
		require_once "../controladores/grabacionControlador.php";
		$insgrabacion = new grabacionControlador();

		/**-----AGREGAR----**/
		if(isset($_POST['descripcion-reg']) && isset($_POST['conferencia-reg']) ){
			echo $insgrabacion->agregar_grabacion_controlador();
		}

		/**-----ELMINAR---**/
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $insgrabacion->eliminar_grabacion_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}