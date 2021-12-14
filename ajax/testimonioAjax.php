<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['usuarioT-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up'])){
		
		require_once "../controladores/testimonioControlador.php";
		$instestimonio = new testimonioControlador();

		/**-----AGREGAR----**/
		if(isset($_POST['usuarioT-reg']) && isset($_POST['especialistaT-reg']) ){
			echo $instestimonio->agregar_testimonio_controlador();
		}

		/**-----ELMINAR---**/
		if(isset($_POST['codigo-del'])){
			echo $instestimonio->eliminar_testimonio_controlador();
		}

		/**-----ACTUALIZAR vigencia----**/
		if(isset($_POST['codigo-up'])){
			echo $instestimonio->actualizar_testimonio_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}