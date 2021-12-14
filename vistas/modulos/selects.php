<script>
    $(document).ready(function(){
        $("#cboDepartamento").change(function(){

            $('#cboDistrito').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');

            $("#cboDepartamento option:selected").each(function(){
                idDepartamento = $(this).val();
                $.post("../ubigeo1.php",{idDepartamento: idDepartamento},function(data){
                    $("#cboProvincia").html(data);
                })
            })
        })
        
    })
    $(document).ready(function(){
            $("#cboProvincia").change(function () {
                $("#cboProvincia option:selected").each(function () {
                    idProvincia = $(this).val();
                    $.post("../ubigeo2.php", { idProvincia: idProvincia }, function(data){
                        $("#cboDistrito").html(data);
                    });            
                });
            })
        });
</script>
<script>
    $(document).ready(function(){
        $("#cboDepartamento2").change(function(){

            $('#cboDistrito2').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');

            $("#cboDepartamento2 option:selected").each(function(){
                idDepartamento = $(this).val();
                $.post("../../../ubigeo1.php",{idDepartamento: idDepartamento},function(datos){
                    $("#cboProvincia2").html(datos);
                })
            })
        })
        
    })
    $(document).ready(function(){
            $("#cboProvincia2").change(function () {
                $("#cboProvincia2 option:selected").each(function () {
                    idProvincia = $(this).val();
                    $.post("../../../ubigeo2.php", { idProvincia: idProvincia }, function(datos){
                        $("#cboDistrito2").html(datos);
                    });            
                });
            })
        });
</script>
<script>
    $(document).ready(function(){
        $("#cboFacultad").change(function(){

            $('#cboEscuela').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');

            $("#cboFacultad option:selected").each(function(){
                idFacultad = $(this).val();
                $.post("../universidad.php",{idFacultad: idFacultad},function(data){
                    $("#cboEscuela").html(data);
                })
            })
        })
        
    });
</script>
<script>
    $(document).ready(function(){
        $("#cboFacultad2").change(function(){

            $('#cboEscuela2').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');

            $("#cboFacultad option:selected").each(function(){
                idFacultad = $(this).val();
                $.post("../../../universidad.php",{idFacultad: idFacultad},function(data){
                    $("#cboEscuela2").html(data);
                })
            })
        })
        
    });
</script>