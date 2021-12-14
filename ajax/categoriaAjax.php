<?php
	/* HECHO */
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['descripcion-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up'])){
		
		require_once "../controladores/categoriaControlador.php";
		$inscategoria = new categoriaControlador();

		/* AGREGAR */
		if(isset($_POST['descripcion-reg']) && isset($_POST['icono-reg']) ){
			echo $inscategoria->agregar_categoria_controlador();
		}

		/* ELMINAR */
		if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
			echo $inscategoria->eliminar_categoria_controlador();
		}

		/* ACTUALIZAR */
		if(isset($_POST['codigo-up']) && isset($_POST['descripcion-up'])){
			echo $inscategoria->actualizar_categoria_controlador();
		}
		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}