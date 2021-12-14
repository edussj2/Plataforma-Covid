<?php
	/* HECHO */
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['paterno-reg']) || isset($_POST['cuenta-del'])|| isset($_POST['codigo1-up']) || isset($_POST['codigo2-up']) || isset($_POST['codigo3-up'])|| isset($_POST['codigo4-up'])){
		
		require_once "../controladores/usuarioControlador.php";
		$insusuario = new usuarioControlador();

		/* AGREGAR */
		if(isset($_POST['nombres-reg']) && isset($_POST['paterno-reg']) && isset($_POST['email-reg']) ){
			echo $insusuario->agregar_usuario_controlador();
		}

		/* ELIMINAR */
		if(isset($_POST['cuenta-del']) && isset($_POST['privilegio-admin'])){
			echo $insusuario->eliminar_usuario_controlador();
		}

		/* ACTULIZAR PARCIALMENTE */
		if(isset($_POST['codigo1-up'])){
			echo $insusuario->actualizar_parcial_usuario_controlador();
		}

		/* ACTULIZAR GENERAL */
		if(isset($_POST['codigo3-up'])){
			echo $insusuario->actualizar_general_usuario_controlador();
		}

		/* ACTULIZAR FOTO */
		if(isset($_POST['codigo2-up'])){
			echo $insusuario->actualizar_foto_usuario_controlador();
		}

		/* ACTULIZAR FOTO DESDE EL ADMINISTRADOR */
		if(isset($_POST['codigo4-up'])){
			echo $insusuario->actualizar2_foto_usuario_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}