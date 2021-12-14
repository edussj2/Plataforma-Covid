<!-- Content page -->
<div class="container-fluid bg-light border pb-2">
    <div class="full-box page-header">
        <hr>
        <h3 class="text-left">
        <i class="fas fa-chart-bar"></i> REPORTES GENERALES <small>Excel</small>
        </h3>
        <p class="text-justify">
            Reportes dinámicos y estáticos de datos almacenados en la plataforma web exportados en archivos Excel. Para el uso de los reportes dinámicos complete el campo con la infomración deseada y haga click en generar.
        </p>
    </div>
</div>
<section class="actualizaciones-resoluciones container-fluid">
    <div class="row">
        <div class="col-xs-12 col-md-4">
        <div class="contenedor-resolucion">
        <p class="icono"><i class="fas fa-clipboard-list"></i><p>
        <h4>Reporte N° 01</h4>
        <p class="texto">Reporte general de todas los Especialistas.</p>
        <p class="descargar"><a href="<?php echo SERVERURL;?>reportesExcel/reporte01.php">Descargar &nbsp;<i class="far fa-file-excel"></i></a></p>
        </div>
        </div>
        <div class="col-xs-12 col-md-4">
        <div class="contenedor-resolucion">
            <p class="icono"><i class="fas fa-clipboard-list"></i><p>
            <h4>Reporte N° 02</h4>
            <p class="texto">Reporte general de todos los Usuarios del sistema.</p>
            <p class="descargar"><a href="<?php echo SERVERURL;?>reportesExcel/reporte02.php">Descargar &nbsp;<i class="far fa-file-excel"></i></a></p>
        </div>
    </div>
</section>


<div class="container pb-5">
    <div class="row">
    <div class="col-lg-12 mb-5 bg-light border pt-2 pb-2">
        <div class="contenedor-paneles mb-5">
        <div class="container-fluid">

            <div class="panel panel-info border">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; REPORTE 01</h3>
            </div>
            <div class="panel-body">
            <form action="<?php echo SERVERURL;?>reportesExcel/reporteDin01.php" method="POST" autocomplete="off">
		    	<fieldset>
		    		<legend><i class="fas fa-calendar-alt"></i> &nbsp; REPORTE DE ATENCIONES POR FECHA</legend>
		    		<div class="container-fluid">
		    			<div class="row">
		    				<div class="col-sm-6">
								<div class="form-group">
									<span class="control-label">Fecha Mínima</span>
								  	<input class="form-control" type="date" name="fechaMin"required=""  max="<?php echo $fechaActual; ?>">
								</div>
		    				</div>
		    				<div class="col-sm-6">
								<div class="form-group">
									<span class="control-label">Fecha Máxima</span>
								  	<input class="form-control" type="date" name="fechaMax"required=""  max="<?php echo $fechaActual; ?>" value="<?php echo $fechaActual; ?>">
								</div>
		    				</div>
		    				<div class="col-xs-12">
		    					<p style="text-align: center;">
		    						<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> Generar</button>
		    					</p>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset> 	
		    </form>
            </div>
            </div>

            <div class="panel panel-info mt-4 border">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-edit"></i>&nbsp; REPORTE 02</h3>
            </div>
            <div class="panel-body">
            <form action="<?php echo SERVERURL;?>reportesExcel/reporteDin02.php" method="POST" autocomplete="off">
		    	<fieldset>
		    		<legend><i class="fas fa-building"></i> &nbsp; REPORTE DE PARTICIPANTES POR CONFERENCIA</legend>
		    		<div class="container-fluid">
		    			<div class="row">
                        <div class="col-lg-12">
                        <div class="form-group">
                            <label>Conferencia</label>
                            <select name="conferencia-reg" class="form-control" required="">
                            <option value="-1">Seleccione una conferencia</option>
                                <?php 
                                require_once "./controladores/conferenciaControlador.php";

                                $insFacultad = new conferenciaControlador();

                                $Facultad = $insFacultad->datos_conferencia_controlador("Select",0);
                                while ($rowD = $Facultad->fetch()) {
                                    echo '<option value="'.$rowD['idConferencia'].'">'.$rowD['ConferenciaTitulo'].'</option>';
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                            Complete el campo correctamente.
                            </div>
                        </div>
                        </div>
		    				<div class="col-xs-12">
		    					<p>
		    						<button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-download"></i> Generar</button>
		    					</p>
		    				</div>
		    			</div>
		    		</div>
		    	</fieldset> 	
		    </form>
            </div>
            </div>
            
        </div>
        </div>
    </div>
   </div>
</div>    