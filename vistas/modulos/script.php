<script src="<?php echo SERVERURL; ?>vistas/js/jquery-3.2.1.js"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="<?php echo SERVERURL; ?>vistas/DataTables/datatables.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="<?php echo SERVERURL; ?>vistas/js/bootstrap.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/js/swiper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
<script src="<?php echo SERVERURL; ?>vistas/js/slowNumber.js" type="text/javascript"></script>    
<script src="<?php echo SERVERURL; ?>vistas/js/sweetalert2.min.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/js/jquery.magnific-popup.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/ckeditor/ckeditor.js"></script>
<script src="<?php echo SERVERURL; ?>vistas/js/main.js"></script>

<script type="text/javascript">
            $.ajax({
                url : "https://api.covid19api.com/summary",
                type : "GET",
                dataType : "JSON",
                success : function(data){
                    console.log(data);
                    console.log(data.Global);

                    $.each(data.Global,function(key, value){
                        $('#nuevos-fallecidos').append(	"<h3>" +  data.Global.NewDeaths + "</h3>");
                        return false;
                    });	

                    $.each(data.Global,function(key, value){
                        $('#nuevos-infectados').append(	"<h3>" +  data.Global.NewConfirmed + "</h3>");
                        return false;
                    });	

                    $.each(data.Global,function(key, value){
                        $('#nuevos-recuperados').append(	"<h3>" +  data.Global.NewRecovered + "</h3>");
                        return false;
                    });	

                    $.each(data.Global,function(key, value){
                        $('#total-muertes').append(	"<h3>" +  data.Global.TotalDeaths + "</h3>");
                        return false;
                    });	

                    $.each(data.Global,function(key, value){
                        $('#total-infectados').append(	"<h3>" +  data.Global.TotalConfirmed + "</h3>");
                        return false;
                    });	

                    $.each(data.Global,function(key, value){
                        $('#total-recuperados').append(	"<h3>" +  data.Global.TotalRecovered + "</h3>");
                        return false;
                    });	

                    var nro=1;
                    $.each(data.Countries,function(key, value){
                        $('#countries-wise').append("<tr>" + 
                                                    "<td>" +  nro + "</td>" +
                                                    "<td>" + value.Country + "</td>" +
                                                    "<td>" + value.NewConfirmed + "</td>" +
                                                    "<td>" + value.NewDeaths + "</td>" +
                                                    "<td>" + value.NewRecovered + "</td>" +
                                                    "<td>" + value.TotalConfirmed + "</td>" +
                                                    "<td>" + value.TotalDeaths + "</td>" +
                                                    "<td>" + value.TotalRecovered	 + "</td>" +
                                                    "</tr>");
                        nro++;
                    });

                }
            });
</script>