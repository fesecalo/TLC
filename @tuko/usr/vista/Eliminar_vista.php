<h1 class="page-head-line"><?php echo $titulo;?> <small><i> eliminar.</i></small></h1>

			  <div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Atencion!</strong> Esta a punto de eliminar Al <?php echo $titulo;?> <b><?php echo $p->nombre;?></b>, ¿esta seguro de continuar?.
			</div>
			<form class="form-horizontal" method="post" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmEliminar" name="frmEliminar" >
			<input type="hidden" id="idel" name="idel" value="<?php echo $p->id;?>">
			<input type="hidden" id="nombre" name="nombre" value="<?php echo $p->nombre;?>">
			<input type="hidden" id="p" name="p" value="Eliminar">
			<a class="btn btn-default" href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=Lista','page-inner');">Volver</a>
				<button type="button" onClick="enviaFrm('frmEliminar','page-inner');" class="btn btn-danger">Eliminar <?php echo $titulo;?></button>
			</form>