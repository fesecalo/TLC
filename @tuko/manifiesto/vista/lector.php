<div class="pull-left">
<form class="form-horizontal" method="POST" action="<?php echo URL_SITIO.$pagina.'/'.$pagina.'.php';?>" id="frmNuevo" name="frmNuevo" >
			<input type="hidden" id="p" name="p" value="Nuevo">
			<input type="hidden" id="venta" name="venta" value="<?php echo $p->venta;?>">
	<div class="form-group">
		<div class="col-md-3">
		<button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModalGuia"><span class="fa fa-plus" ></span> Nueva Guia</button>
		</div>
	</div>
</form>
</div>