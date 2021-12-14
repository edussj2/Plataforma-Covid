<script>
$(document).ready(function(){
    $('.btn-cerrar-sesion').on('click', function(e){
		e.preventDefault();
		var Token=$(this).attr('href');
		swal({
		  	title: '¿Esta seguro?',
		  	text: "La sesión actual se cerrará y deberás iniciar sesión nuevamente",
		  	type: 'warning',
		  	showCancelButton: true,
		  	confirmButtonColor: '#03A9F4',
		  	cancelButtonColor: '#F44336',
		  	confirmButtonText: '<i class="fas fa-power-off"></i> Sí, salir!',
		  	cancelButtonText: '<i class="fas fa-ban"></i> No, Cancelar!'
		}).then(function () {
			$.ajax({
				url:'<?php echo SERVERURL; ?>ajax/loginAjax.php?Token='+Token,
				success:function(data){
					if(data=="true"){
						window.location.href="<?php echo SERVERURL; ?>login/";
					}else{
						swal("Ocurrió un error","No se pudo cerrar la sesión, intente nuevamente","error");
					}
				}
			});
		});
	});
});
</script>