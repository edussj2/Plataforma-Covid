<?php
	/* HECHO */
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['titulo-reg']) || isset($_POST['conferenciaD-reg']) || isset($_POST['codigoImg-up']) || isset($_POST['codigo-del']) || isset($_POST['codigoV-up'])){
		
		require_once "../controladores/conferenciaControlador.php";
		$insConferencia = new conferenciaControlador();

		/* AGREGAR */
		if(isset($_POST['titulo-reg']) && isset($_POST['fecha-reg'])){
			echo $insConferencia->agregar_conferencia_controlador();
		}

		/* ACTUALIZAR IMAGEN */
		if(isset($_POST['codigoImg-up'])){
			echo $insConferencia->actualizar_foto_conferencia_controlador();
		}

		/* ELIMINAR */
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $insConferencia->eliminar_conferencia_controlador();
		}

		/*REGISTRARSE*/
		if(isset($_POST['conferenciaD-reg']) && isset($_POST['usuarioD-reg'])){
			echo $insConferencia->agregar_detalle_controlador();
		}

		/*ACTUALIZAR VIGENCIA*/
		if(isset($_POST['codigoV-up'])){
			echo $insConferencia->actualizar_vigencia_conferencia_controlador();
		}

	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}