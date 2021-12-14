/*=======ToolTip =========*/
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})
/*=======ToolTip =========*/

/* ==== Preloader ==== */
$(window).on('load', function() {
	var preloaderFadeOutTime = 500;
	function hidePreloader() {
		var preloader = $('.spinner-wrapper');
		setTimeout(function() {
			preloader.fadeOut(preloaderFadeOutTime);
		}, 500);
	}
	hidePreloader();
});
/* ==== Preloader ==== */


/* ==== Validaciones bootstrap ==== */
(function() {
	'use strict';
	window.addEventListener('load', function() {
	  // Fetch all the forms we want to apply custom Bootstrap validation styles to
	  var forms = document.getElementsByClassName('needs-validation');
	  // Loop over them and prevent submission
	  var validation = Array.prototype.filter.call(forms, function(form) {
		form.addEventListener('submit', function(event) {
		  if (form.checkValidity() === false) {
			event.preventDefault();
			event.stopPropagation();
		  }
		  form.classList.add('was-validated');
		}, false);
	  });
	}, false);
	
  })();
/* ==== Validaciones bootstrap ==== */


$(document).ready(function(){

	/* ====   Datable enlace ====*/
	$('#datatableEnlace').DataTable({
		language: {
			search: "Buscar:",
			lengthMenu:	"Mostrar _MENU_ Elementos",
			info: "_START_ / _END_ total: _TOTAL_ elementos",
			infoEmpty:      "",
			infoFiltered:   "",
			infoPostFix:    "",
			loadingRecords: "Cargando",
			zeroRecords:    "No hay búsquedas relacionadas",
			emptyTable:     "Aucune donnée disponible dans le tableau",
			paginate: {
				first:      "Primero",
				previous:   "Atrás",
				next:       "Siguiente",
				last:       "Último"
			}
		}
	});
	/* ====   Datable enlace ====*/

	/* ==== SIDE BAR ==== */
	$('#btn-menu').click(function(){

		if( $('.btn-menu span').attr('class') == 'fas fa-plus' ){

			$('.btn-menu span').removeClass('fas fa-plus').addClass('fas fa-minus').css({'color':'#fff'});
			$('.sidebar-container').css({'display':'block'});
			$('.sidebar-container').css({'width':'80vw'});
			$('.sidebar-container').css({'position':'fixed'});
			$('.sidebar-container').css({'z-index':'999'});
			$('.btn-menu').css({'z-index':'1000'});

		}else{
			$('.btn-menu span').removeClass('fas fa-minus').addClass('fas fa-plus').css({'color':'#fff'});
			$('.sidebar-container').css({'display':'none'});
		}

	});
	/* ==== SIDE BAR ==== */

	/* ==== SUB MENU ===*/
	$('.sub1-btn').click(function(){
		$('.sidebar-container .menu ul .uno-show').toggleClass("show1");
		$('.sidebar-container .menu ul .sub-uno').toggleClass("rotate");
	});
	$('.sub2-btn').click(function(){
		$('.sidebar-container .menu ul .dos-show').toggleClass("show2");
		$('.sidebar-container .menu ul .sub-dos').toggleClass("rotate");
	});
	$('.sub3-btn').click(function(){
		$('.sidebar-container .menu ul .tres-show').toggleClass("show3");
		$('.sidebar-container .menu ul .sub-tres').toggleClass("rotate");
	});
	$('.sub4-btn').click(function(){
		$('.sidebar-container .menu ul .cuatro-show').toggleClass("show4");
		$('.sidebar-container .menu ul .sub-cuatro').toggleClass("rotate");
	});
	$('.sub5-btn').click(function(){
		$('.sidebar-container .menu ul .cinco-show').toggleClass("show5");
		$('.sidebar-container .menu ul .sub-cinco').toggleClass("rotate");
	});
	$('.sub6-btn').click(function(){
		$('.sidebar-container .menu ul .seis-show').toggleClass("show6");
		$('.sidebar-container .menu ul .sub-seis').toggleClass("rotate");
	});
	/* ==== SUB MENU ===*/

	/* ==== SUB MENU ACTIVADO ===*/
	$('.sidebar-container .menu ul li').click(function(){
		$(this).addClass("activado").siblings().removeClass("activado");
	});
	/* ==== SUB MENU ACTIVADO ===*/

	/* ==== VIA AJAX ===*/
	$('.FormularioAjax').submit(function(e){
		e.preventDefault();
	
		var form=$(this);
	
		var tipo=form.attr('data-form');
		var accion=form.attr('action');
		var metodo=form.attr('method');
		var respuesta=form.children('.RespuestaAjax');
	
		var msjError="<script>swal('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
		var formdata = new FormData(this);
	
	
		var textoAlerta;
		if(tipo==="save"){
			textoAlerta="Los datos que enviaras quedaran almacenados en el sistema";
		}else if(tipo==="delete"){
			textoAlerta="Los datos serán eliminados completamente del sistema";
		}else if(tipo==="update"){
			textoAlerta="Los datos del sistema serán actualizados";
		}else if(tipo="buscar"){
			textoAlerta="Se buscarán los datos en el sistema";
		}else{
			textoAlerta="¿Quieres realizar la operación solicitada?";
		}
	
		swal({
				title: "¿Estás seguro?",   
				text: textoAlerta,   
				type: "question",   
				showCancelButton: true,     
				confirmButtonText: "Aceptar",
				cancelButtonText: "Cancelar"
		}).then(function () {
			$.ajax({
				type: metodo,
				url: accion,
				data: formdata ? formdata : form.serialize(),
				cache: false,
				contentType: false,
				processData: false,
				xhr: function(){
					var xhr = new window.XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(evt) {
					  if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						percentComplete = parseInt(percentComplete * 100);
						if(percentComplete<100){
							respuesta.html('<p class="text-center">Procesado... ('+percentComplete+'%)</p><div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: '+percentComplete+'%;">'+percentComplete+'</div></div>');
						  }else{
							  respuesta.html('<p class="text-center"></p>');
						  }
					  }
					}, false);
					return xhr;
				},
				success: function (data) {
					respuesta.html(data);
				},
				error: function() {
					respuesta.html(msjError);
				}
			});
			return false;
		});
	});
	/* ==== VIA AJAX ===*/


	
	/* =========Login ======*/
	$('#pass-btn').click(function(){
		$('.container-login').addClass('pass-mode');
	});
	$('#sign-in-btn').click(function(){
		$('.container-login').removeClass('pass-mode');
	});
	/* =========Login ======*/


	/* === Video Lightbox - Magnific Popup === */
	$('.popup-youtube, .popup-vimeo').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,
		fixedContentPos: false,
		iframe: {
			patterns: {
				youtube: {
					index: 'youtube.com/', 
					id: function(url) {        
						var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
						if ( !m || !m[1] ) return null;
						return m[1];
					},
					src: 'https://www.youtube.com/embed/%id%?autoplay=1'
				},
				vimeo: {
					index: 'vimeo.com/', 
					id: function(url) {        
						var m = url.match(/(https?:\/\/)?(www.)?(player.)?vimeo.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/);
						if ( !m || !m[5] ) return null;
						return m[5];
					},
					src: 'https://player.vimeo.com/video/%id%?autoplay=1'
				}
			}
		}
	});
	/* === Video Lightbox - Magnific Popup === */
	
});

/* ==== Tertimonios ==== */
var cardSlider = new Swiper('.card-slider', {
	autoplay: {
        delay: 4000,
        disableOnInteraction: false
	},
    loop: true,
    navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev'
	}
	
});
/* ==== Tertimonios ==== */



function validarExt()
{
	var archivoInput  = document.getElementById('archivoInput');
	var archivoRuta = archivoInput.value;
	var extPermitidas = /(.PNG|.png|.jpg|.JPG|.jpeg)$/i;

	if(!extPermitidas.exec(archivoRuta)){
		alert('Asegurese de seleccionar archivos válidos');
		archivoInput.value='';
		return false;
	}else{
		if(archivoInput.files && archivoInput.files[0]){
			var visor = new FileReader();
			visor.onload=function(e)
			{
				document.getElementById('visorArchivo').innerHTML=
				'<div class="w-100 border pt-2 pb-2 pl-2"><embed src="'+e.target.result+'" width="100" height="100"></div>';
			};
			visor.readAsDataURL(archivoInput.files[0]);
		}
	}
}

