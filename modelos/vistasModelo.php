<?php

	class vistasModelo 
	{
		/********* MODELO OBTENER VISTAS ***********/
		protected static function obtener_vistas_modelo($vistas){
			$listaBlanca = ["dashboard","adminBuscar","adminEditar","adminLista","adminNuevo","mydata","myaccount","userNuevo","userLista","userEditar","userBuscar","facultadLista","facultadNuevo","facultadEditar","escuelaNuevo","escuelaEditar","escuelaLista","conferencia","conferencias","conferenciaNueva","conferenciaLista","imgConferenciaEditar","grabaciones","grabacionNueva","grabacionLista","noticiaNueva","noticiaLista","noticiaEditar","categoriaNueva","categoriaLista","categoriaEditar","noticia","noticias","profile","especialidadLista","especialidadNuevo","especialidadEditar","especialistaNuevo","especialistaEditar","testimonioLista","especialistaLista","quejaLista","saludMental","sintomasyprecauciones","temaMental","facultadNuevo","facultadEditar","facultadLista","escuelaNuevo","escuelaEditar","escuelaLista","preguntasFrecuentes","infoCovid","dataMundial","especialistaProfile","especialistas","participantesConferencia","temaNuevo","temaLista","consejoNuevo","consejoLista","comentarioLista","ponenteEditar","tutorial","myTestimonios","myQuejas","casos","detalleAtencion","myAtenciones","myConsultas","atencionLista","reportes","covidVideos"];

			if (in_array($vistas, $listaBlanca)) {
				if(is_file("./vistas/contenidos/".$vistas."-view.php")){
					$contenido = "./vistas/contenidos/".$vistas."-view.php";
				}else{
                    $contenido="404";
				}
			}elseif($vistas=="login" || $vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}