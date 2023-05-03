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
				<label class="col-sm-3 control-label">Codigo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="codigo" name="codigo" onKeyup="return Vf.soloLetra(this)" placeholder="codigo" value="" required>
				</div>
			  </div>
			  <div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Socio: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="origen" name="origen" required>
				      	<option value="">-- Selecciona --</option>
				      	<?php 
								   $row = Accion::traeOrigen();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id.">".$r->nombre."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	
			<div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Tipo: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="tipo" name="tipo" required>
				      	<option value="">-- Selecciona --</option>
				      	<?php 
								   $row = Accion::traeTipoManifiesto();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id.">".$r->glosa."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">Cantidad: </label>
				    <div class="col-sm-8">
					  <input type="number" min="1" id="cantidad" name="cantidad" value="0" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        </div> <!-- /form-group-->	  
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">KG: </label>
				    <div class="col-sm-8">
					  <input type="number" min="1" id="kilo" name="kilo" value="0" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        </div> <!-- /form-group-->	  
		  <a class="btn btn-default" href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=Lista','page-inner');">Volver</a>
			<button type="button" onClick="enviaFrmManifiesto('frmNuevo','page-inner');" class="btn btn-success" >Guardar <?php echo $titulo;?></button>
		  </form>