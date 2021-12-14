<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['atencion-reg']) || isset($_POST['codigo-del']) ){
		
		require_once "../controladores/diagnositicoControlador.php";
		$insdiagnositico = new diagnositicoControlador();

		/**-----AGREGAR----**/
		if(isset($_POST['atencion-reg']) ){
			echo $insdiagnositico->agregar_diagnostico_controlador();
		}

		/**-----ELMINAR---**/
		if(isset($_POST['codigo-del'])){
			echo $insdiagnositico->eliminar_diagnositico_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}