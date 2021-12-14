<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['usuarioQ-reg']) || isset($_POST['codigo-del'])){
		
		require_once "../controladores/quejaControlador.php";
		$insqueja = new quejaControlador();

		/**-----AGREGAR----**/
		if(isset($_POST['usuarioQ-reg']) && isset($_POST['especialistaQ-reg']) ){
			echo $insqueja->agregar_queja_controlador();
		}

		/**-----ELMINAR---**/
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $insqueja->eliminar_queja_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}