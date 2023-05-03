<h1 class="page-head-line"><?php echo $titulo;?> <small><i> Editar.</i></small></h1>
			<?php
				if(isset($_GET['msg'])){
					$msg=Accion::desencriptar($_GET['msg']);
					$clr=Accion::desencriptar($_GET['clr']);
					Templeta::msg($msg,$clr);
				}
			?>
		  <p>fecha creacion: <b><?php echo $p->fecha;?></b></p>
			<form class="form-horizontal" method="post" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmEditar" name="frmEditar" >
			<div class="form-group">
				<label class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombres" value="<?php echo $p->nombre;?>" required>
				  <input type="hidden" id="ided" name="ided" value="<?php echo $p->id;?>">
				  <input type="hidden" id="p" name="p" value="Editar">
				  <?php echo Accion::miniBox(0,'Nombre y Apellido de su '.$titulo.'.');?>
				</div>
			  </div>
			  <div class="form-group">
				<label class="col-sm-3 control-label">Tipo</label>
				<div class="col-sm-8">
				  <select class="form-control" id="tipo" name="tipo" required>
				   <option value="">-- Selecciona --</option>
				   <option value="1" <?php echo ($p->tipo == 1)?"selected":"";?>><?php echo Accion::perfil('1'); ?></option>
				   <option value="2" <?php echo ($p->tipo == 2)?"selected":"";?>><?php echo Accion::perfil(2); ?></option>
				</select>
				<?php echo Accion::miniBox(0,'Privilegios dentro del sistema.');?>
				</div>
			  </div>
			  <hr><br>
			  <div class="form-group">
				<label class="col-sm-3 control-label">Usuario</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="nombre de usuario ( sólo letras y números, 2-64 caracteres)" value="<?php echo $p->usuario;?>" required>
				  <?php echo Accion::miniBox(0,'Identificador para login al sistema.');?>
				</div>
			  </div>
			  
			  <a class="btn btn-default" href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=Lista','page-inner');">Volver</a>
			<button type="button" onClick="enviaFrmUsuarioE('frmEditar','page-inner');" class="btn btn-success" >Actualizar <?php echo $titulo;?></button>
		  </form>
