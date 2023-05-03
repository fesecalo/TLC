<h1 class="page-head-line">Guia <small><i> eliminar.</i></small></h1>

			  <div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Atencion!</strong> Esta a punto de eliminar la guia <b><?php echo $p->codigo;?></b>, ¿esta seguro de continuar?.
			</div>
			<form class="form-horizontal" method="post" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmEliminar" name="frmEliminar" >
			<input type="hidden" id="idelg" name="idelg" value="<?php echo $p->id;?>">
			<input type="hidden" id="codigo" name="codigo" value="<?php echo $p->codigo;?>">
			<input type="hidden" id="idm" name="idm" value="<?php echo $p->manifiesto;?>">
			<input type="hidden" id="p" name="p" value="EliminarGuia">
			<a class='btn btn-success' title='Editar informacion' href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=Editar&id=<?php echo $p->id;?>','page-inner');">Volver</a>
				<button type="button" onClick="enviaFrm('frmEliminar','page-inner');" class="btn btn-danger">Eliminar Guia</button>
			</form>