<h1 class="page-head-line"><?php echo $titulo;?> <small><i> Nuevo.</i></small></h1>
			<?php
				if(isset($_GET['msg'])){
					$msg=Accion::desencriptar($_GET['msg']);
					$clr=Accion::desencriptar($_GET['clr']);
					Templeta::msg($msg,$clr);
				}
			?>
			<form class="form-horizontal" method="POST" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmNuevo" name="frmNuevo" >
			<input type="hidden" id="p" name="p" value="Nuevo">
			<input type="hidden" id="idnv" name="idnv" value="idnv">
			<div class="form-group">
				<label class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" onKeyup="return Vf.soloLetra(this)" placeholder="nombres" value="" required>
				  <?php echo Accion::miniBox(0,'Nombre de su '.$titulo.' completo o Empresa.');?>
				</div>
			  </div>

			  <div class="form-group">
				<label class="col-sm-3 control-label">Rut</label>
				<div class="col-sm-3">
				  <input type="text" class="form-control" id="rut" name="rut" onKeyup="return Vf.soloRut(this)" placeholder="rut" value="" required>
				</div>
				<?php echo Accion::miniBox(0,'Si no cuenta con este dato puede utilizar "1-9".');?>
			  </div>


				<div class="form-group ">
				<label class="col-sm-3 control-label">Otros Datos</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mas" name="mas" onKeyup="return soloLetra(this)" placeholder="+ datos" value="" >
				</div>
			  </div>
		  <a class="btn btn-default" href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=Lista','page-inner');">Volver</a>
			<button type="button" onClick="enviaFrmCliente('frmNuevo','page-inner');" class="btn btn-success" >Guardar <?php echo $titulo;?></button>
		  </form>