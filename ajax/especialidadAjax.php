<?php
	/*HECHO*/
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['descripcion-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up'])){
		
		require_once "../controladores/especialidadControlador.php";
		$insespecialidad = new especialidadControlador();

		/* AGREGAR */
		if(isset($_POST['descripcion-reg']) ){
			echo $insespecialidad->agregar_especialidad_controlador();
		}

		/* ELMINAR */
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $insespecialidad->eliminar_especialidad_controlador();
		}

		/* ACTUALIZAR */
		if(isset($_POST['codigo-up']) && isset($_POST['descripcion-up'])){
			echo $insespecialidad->actualizar_especialidad_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}