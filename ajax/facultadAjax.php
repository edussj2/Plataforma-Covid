<?php
	/*HECHO*/
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['descripcion-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up'])){
		
		require_once "../controladores/facultadControlador.php";
		$insfacultad = new facultadControlador();

		/* AGREGAR */
		if(isset($_POST['descripcion-reg']) && isset($_POST['siglas-reg']) ){
			echo $insfacultad->agregar_facultad_controlador();
		}

		/* ELMINAR */
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $insfacultad->eliminar_facultad_controlador();
		}

		/* ACTUALIZAR */
		if(isset($_POST['codigo-up']) && isset($_POST['descripcion-up'])){
			echo $insfacultad->actualizar_facultad_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}