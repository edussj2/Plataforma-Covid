<?php
	/*HECHO*/
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['descripcion-reg']) || isset($_POST['cuenta-del']) || isset($_POST['codigo-up'])){
		
		require_once "../controladores/escuelaControlador.php";
		$insescuela = new escuelaControlador();

		/* AGREGAR */
		if(isset($_POST['descripcion-reg'])){
			echo $insescuela->agregar_escuela_controlador();
		}

		/* ELMINAR */
		if(isset($_POST['cuenta-del']) && isset($_POST['privilegio-admin'])){
			echo $insescuela->eliminar_escuela_controlador();
		}

		/* ACTUALIZAR */
		if(isset($_POST['codigo-up']) && isset($_POST['descripcion-up'])){
			echo $insescuela->actualizar_escuela_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}