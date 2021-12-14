<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['titulo-reg']) || isset($_POST['codigo-del'])){
		
		require_once "../controladores/consejoControlador.php";
		$insconsejo = new consejoControlador();

		/**-----AGREGAR----**/
		if(isset($_POST['titulo-reg']) && isset($_POST['consejo-reg']) ){
			echo $insconsejo->agregar_consejo_controlador();
		}

		/**-----ELMINAR---**/
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $insconsejo->eliminar_consejo_controlador();
		}

		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}