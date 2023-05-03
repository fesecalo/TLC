
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h1 class="page-head-line">Guias <small><i> Editar.</i></small></h1>
		  </div>
		<form class="form-horizontal" method="POST" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmEditarGuia" name="frmEditarGuia" >
		<div class="modal-body">
			<input type="hidden" id="p" name="p" value="EditarGuia">
			<input type="hidden" id="idedg" name="idedg" value="<?php echo $_GET["id"];?>">
			<input type="hidden" id="idm" name="idm" value="<?php echo $_GET["idm"];?>">
			<div class="form-group">
				<label class="col-sm-3 control-label">Nro Guia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="guia" name="guia" onKeyup="return Vf.soloLetra(this)" autocomplete="off" value="<?php echo $p->codigo;?>" required>
				</div>
			  </div>
			  <div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Cliente: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="cliente" name="cliente" required>
				      	<option value="">-- Selecciona --</option>
				      	<?php 
								   $rw = Accion::traeCliente();

								   while($r = $rw->fetch_object()){
									   echo "<option value=".$r->id." ".(($p->cliente==$r->id)?'Selected':'').">".$r->nombre."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">KG: </label>
				    <div class="col-sm-3">
					  <input type="number" class="form-control" min="1" id="kiloGuia" value="<?php echo $p->kilo;?>" name="kiloGuia" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        </div> <!-- /form-group-->
			<hr><br>
			<div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Documento: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="documento" name="documento" required>
				      	<option value="">-- Selecciona --</option>
				      	<?php 
								   $row = Accion::traeDocumento();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id." ".(($p->documento==$r->id)?'Selected':'').">".$r->glosa."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div>
			<div class="form-group">
				<label class="col-sm-3 control-label">Nro:</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="din" name="din" value="<?php echo $p->din;?>" onKeyup="return Vf.soloLetra(this)" autocomplete="off" required>
				</div>
	        	<label for="stock" class="col-sm-1 control-label">Total: </label>
				    <div class="col-sm-3">
					  <input type="text" id="totalDin" name="totalDin" value="<?php echo $p->totalDin;?>" class="form-control" onKeyup="return Vf.soloNumero(this)"  autocomplete="off" required>
					</div>
			</div>
			<hr><br> <!-- /form-group-->
			<div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Tipo: </label>
				    <div class="col-sm-3">
				      <select class="form-control" id="tipo" name="tipo" required>
					  <option value="">Selecciona</option>
				      	<?php 
								   $row = Accion::traeTipoGuia();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id." ".(($p->tipo==$r->id)?'Selected':'').">".$r->glosa."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
					<label for="stock" class="col-sm-1 control-label">Nro: </label>
				    <div class="col-sm-4">
					  <input type="text" id="nroTipo" name="nroTipo" value="<?php echo $p->nroTipo;?>" class="form-control" onKeyup="return Vf.soloNumero(this)"  autocomplete="off" required>
					</div>
	        </div>
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">Neto: </label>
				    <div class="col-sm-3">
					  <input type="text" id="neto" name="neto" class="form-control" value="<?php echo $p->neto;?>" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        	<label for="stock" class="col-sm-1 control-label">IVA: </label>
				    <div class="col-sm-3">
					  <input type="text"id="iva" name="iva" class="form-control" value="<?php echo $p->iva;?>" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        </div> <!-- /form-group-->	    
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">Total: </label>
				    <div class="col-sm-3">
					  <input type="text" id="total" name="total" class="form-control" value="<?php echo $p->total;?>" onKeyup="Vf.netoIVA(this,'neto','iva')" autocomplete="off" required>
					</div>
					<?php echo Accion::miniBox(0,'Digite Total para calcular Neto e IVA.');?>
			</div> <!-- /form-group-->	 
		</div> 
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" onClick="enviaFrmGuia('frmEditarGuia','page-inner','myModalGuiaEditar');" class="btn btn-success">Guardar datos</button>
		 </div>
		</form>
		</div>
	  </div>