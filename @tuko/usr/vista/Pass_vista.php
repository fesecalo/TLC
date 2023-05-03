<h1 class="page-head-line"><?php echo $titulo;?> <small><i> Password.</i></small></h1>
			<?php
				if(isset($_GET['msg'])){
					$msg=Accion::desencriptar($_GET['msg']);
					$clr=Accion::desencriptar($_GET['clr']);
					Templeta::msg($msg,$clr);
				}
			?>
		  <h1><i class="fa fa-user"></i> <?php echo $p->nombre;?></h1>
		  <?php echo Accion::miniBox(0,'Al modificar su clave, pedira cambio de clave en proximo login de este usuario');?>
			<form class="form-horizontal" method="post" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmEditarP" name="frmEditarP" >
			<input type="hidden" id="idpass" name="idpass" value="<?php echo $p->id;?>">
			<input type="hidden" id="nombre" name="nombre" value="<?php echo $p->nombre;?>">
			<input type="hidden" id="p" name="p" value="Password">
			  <div class="form-group">
				<label class="col-sm-4 control-label">Nueva contraseña</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="clavea" name="clavea" value="0000" placeholder="Nueva contraseña" title="Contraseña ( min . 6 caracteres)" required>
					<input type="hidden" id="usuario" name="usuario" value="<?php echo $p->usuario;?>">
					<?php echo Accion::miniBox(0,'Ya esta escrita 0000 (cuatro ceros).');?>
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-4 control-label">Repite contraseña</label>
				<div class="col-sm-8">
				  <input type="password" class="form-control" id="clavear" name="clavear" value="0000" placeholder="Repite contraseña" required>
				  <?php echo Accion::miniBox(0,'Debe coincidir con Nueva contraseña.');?>
				</div>
			  </div>
			  <a class="btn btn-default" href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=Lista','page-inner');">Volver</a>
			<button type="button" onClick="enviaFrm('frmEditarP','page-inner');" class="btn btn-success" >Actualizar datos</button>
		  </form>
	</div>
