<?php
	/* HECHO*/
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['dni-reg']) || isset($_POST['cuenta-del']) || isset($_POST['codigo1-up']) || isset($_POST['codigo2-up'])){
		
		require_once "../controladores/administradorControlador.php";
		$insAdministador = new administradorControlador();

		/*AGREGAR*/
		if(isset($_POST['dni-reg']) && isset($_POST['nombres-reg']) && isset($_POST['email-reg']) && isset($_POST['pass1-reg'])){
			echo $insAdministador->agregar_administrador_controlador();
		}

		/*ELMINAR*/
		if(isset($_POST['cuenta-del']) && isset($_POST['privilegio-admin'])){
			echo $insAdministador->eliminar_administrador_controlador();
		}

		/*ACTUALIZAR PARCIAL*/
		if(isset($_POST['codigo1-up']) && isset($_POST['dni1-up'])  && isset($_POST['nombres1-up'])){
			echo $insAdministador->actualizar_parcial_administrador_controlador();
		}

		/*ACTUALIZAR GENERAL*/
		if(isset($_POST['codigo2-up']) && isset($_POST['dni2-up'])){
			echo $insAdministador->actualizar_general_administrador_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}