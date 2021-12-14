<?php
	/* HECHO */
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['nombres-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up']) || isset($_POST['codigo2-up']) || isset($_POST['codigo3-up']) || isset($_POST['codigo4-up']) || isset($_POST['codigo5-up'])){
		
		require_once "../controladores/especialistaControlador.php";
		$insAdministador = new especialistaControlador();

		if(isset($_POST['nombres-reg']) && isset($_POST['email-reg']) && isset($_POST['descripción-reg']) && isset($_POST['departamento-reg'])){
			echo $insAdministador->agregar_especialista_controlador();
		}

		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $insAdministador->eliminar_especialista_controlador();
		}

		if(isset($_POST['codigo-up']) && isset($_POST['nombres-up']) && isset($_POST['apellidos-up'])){
			echo $insAdministador->actualizar_especialista_controlador();
		}

		if(isset($_POST['codigo2-up'])){
			echo $insAdministador->actualizar_foto_usuario_controlador();
		}

		if(isset($_POST['codigo4-up'])){
			echo $insAdministador->actualizar_cv_usuario_controlador();
		}


	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}