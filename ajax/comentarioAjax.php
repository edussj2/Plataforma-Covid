<?php
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['usuario-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up'])){
		
		require_once "../controladores/comentarioControlador.php";
		$inscomentario = new comentarioControlador();

		/**-----AGREGAR----**/
		if(isset($_POST['usuario-reg']) || isset($_POST['noticia-reg']) ){
			echo $inscomentario->agregar_comentario_controlador();
		}

		/**-----ELMINAR---**/
		if(isset($_POST['codigo-del'])){
			echo $inscomentario->eliminar_comentario_controlador();
		}

		/**-----ACTUALIZAR my data----**/
		if(isset($_POST['codigo-up'])){
			echo $inscomentario->actualizar_comentario_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}