<h3>Datos<small><i> Editar.</i></small></h3>
		  <p>fecha creacion: <b><?php echo $p->fecha;?></b></p>
			<form class="form-horizontal" method="post" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmEditar" name="frmEditar" >
				<input type="hidden" id="ided" name="ided" value="<?php echo $p->id;?>">
				<input type="hidden" id="p" name="p" value="Editar">
			<div class="form-group">
				<label class="col-sm-3 control-label">Codigo:</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="codigo" name="codigo" onKeyup="return Vf.soloLetra(this)" placeholder="codigo" value="<?php echo $p->codigo;?>" required>
				</div>
			  </div>
			  <div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Socio: </label>
				    <div class="col-sm-9">
				      <select class="form-control" id="origen" name="origen" required>
				      	<option value="">-- Selecciona --</option>
				      	<?php 
								   $row = Accion::traeOrigen();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id." ".(($p->origen==$r->id)?'Selected':'').">".$r->nombre."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	
			<div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Tipo: </label>
				    <div class="col-sm-9">
				      <select class="form-control" id="tipo" name="tipo" required>
				      	<option value="">-- Selecciona --</option>
				      	<?php 
								   $row = Accion::traeTipoManifiesto();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id." ".(($p->tipo==$r->id)?'Selected':'').">".$r->glosa."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">Cantidad: </label>
				    <div class="col-sm-5">
					  <input type="number" min="1" id="cantidad" name="cantidad" value="<?php echo $p->cantidad;?>" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        </div> <!-- /form-group-->	  
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">KG: </label>
				    <div class="col-sm-5">
					  <input type="number" min="1" id="kilo" name="kilo" value="<?php echo $p->kilo;?>" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        </div> <!-- /form-group-->	
			<button type="button" onClick="enviaFrmManifiesto('frmEditar','page-inner');" class="btn btn-success" >Guardar <?php echo $titulo;?></button>
		  </form>