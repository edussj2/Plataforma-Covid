<?php
	session_start(['name'=>'UNPRG']);
	$peticionAjax = true;
	require_once "../config/configGeneral.php";

	if(isset($_POST)){

		/*MOUDLO ADMINSITRADORES*/
		if(isset($_POST['busqueda_administrador'])){
			$_SESSION['busqueda_administrador']= $_POST['busqueda_administrador'];
		}

		if(isset($_POST['eliminar_busqueda_administrador'])){
			unset($_SESSION['busqueda_administrador']);
			$url = "adminBuscar";
		}

		/*MOUDLO USUARIOS*/
		if(isset($_POST['busqueda_usuario'])){
			$_SESSION['busqueda_usuario']= $_POST['busqueda_usuario'];
		}

		if(isset($_POST['eliminar_busqueda_usuario'])){
			unset($_SESSION['busqueda_usuario']);
			$url = "userBuscar";
		}

		/*MOUDLO CONFERENCIAS*/
		if(isset($_POST['busqueda_conferencia'])){
			$_SESSION['busqueda_conferencia']= $_POST['busqueda_conferencia'];
		}

		if(isset($_POST['eliminar_busqueda_conferencia'])){
			unset($_SESSION['busqueda_conferencia']);
			$url = "participantesConferencia";
		}

		/*MODULO PARA REDICIONAR*/
		if(isset($url)){
			echo '<script> window.location.href="'.SERVERURL.$url.'/"</script>';
		}else{
			echo '<script> location.reload();</script>';
		}

	}else{
		session_destroy();
		echo '<script> window.location.href="'.SERVERURL.'login/"</script>';
	}