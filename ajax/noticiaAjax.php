<?php
	/* HECHO */
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST['titulo-reg']) || isset($_POST['titulo2-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigoV-up']) || isset($_POST['codigo2-up']) || isset($_POST['codigo-up']) ){
		
		require_once "../controladores/noticiaControlador.php";
		$insnoticia = new noticiaControlador();

		/* AGREGAR */
		if(isset($_POST['titulo-reg']) && isset($_POST['fecha-reg'])){
			echo $insnoticia->agregar_noticia_controlador();
		}
		
		/* AGREGAR2 */
		if(isset($_POST['titulo2-reg']) && isset($_POST['fecha2-reg'])){
			echo $insnoticia->agregar2_noticia_controlador();
        }
        
        /* ELIMINAR*/
		if(isset($_POST['codigo-del'])){
			echo $insnoticia->eliminar_noticia_controlador();
		}

		/* ACTUALIZAR VIGENCIA */
		if(isset($_POST['codigoV-up'])){
			echo $insnoticia->actualizar_vigencia_noticia_controlador();
		}

		/* ACTUALIZAR IMAGEN */
		if(isset($_POST['codigo2-up'])){
			echo $insnoticia->actualizar_imagen_noticia_controlador();
		}

		/* ACTUALIZAR */
		if(isset($_POST['codigo-up'])){
			echo $insnoticia->actualizar_noticia_controlador();
		}

		
	}else{
		session_start(['name'=>'UNPRG']);
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}