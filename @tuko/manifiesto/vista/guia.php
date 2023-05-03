	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h1 class="page-head-line">Guias <small><i> Agregar nueva.</i></small></h1>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="POST" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmNuevoGuia" name="frmNuevoGuia" enctype="multipart/form-data">
			<input type="hidden" id="p" name="p" value="NuevoGuia">
			<input type="hidden" id="idnvg" name="idnvg" value="idnvg">
			<input type="hidden" id="idm" name="idm" value="<?php echo $_GET["id"];?>">
			<div class="form-group">
				<label class="col-sm-3 control-label">Nro Guia</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="guia" name="guia" onKeyup="return Vf.soloLetra(this)" autocomplete="off" required>
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
									   echo "<option value=".$r->id.">".$r->nombre."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">KG: </label>
				    <div class="col-sm-3">
					  <input type="number" class="form-control" min="1" id="kiloGuia" name="kiloGuia" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        </div> <!-- /form-group-->
			<div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Documento: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="documento" name="documento" required>
				      	<option value="">-- Selecciona --</option>
				      	<?php 
								   $row = Accion::traeDocumento();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id.">".$r->glosa."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">Neto: </label>
				    <div class="col-sm-3">
					  <input type="text" id="neto" name="neto" class="form-control" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
				    </div>
	        	<label for="productImage" class="col-sm-2 control-label">Adjunto: </label>
	        </div> <!-- /form-group--> 
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">IVA: </label>
				    <div class="col-sm-3">
					  <input type="text"id="iva" name="iva" class="form-control" onKeyup="return Vf.soloNumero(this)" autocomplete="off" required>
					</div>
					<div class="col-sm-6">		        
					        <input type="file" id="fileToUpload" class="form-control" placeholder="Imagen del producto" name="fileToUpload" />				      
				    </div>
	        </div> <!-- /form-group-->	    
			<div class="form-group">
	        	<label for="stock" class="col-sm-3 control-label">Total: </label>
				    <div class="col-sm-3">
					  <input type="text" id="total" name="total" class="form-control" onKeyup="Vf.netoIVA(this,'neto','iva')" autocomplete="off" required>
					</div>
					<?php echo Accion::miniBox(0,'Digite Total para calcular Neto e IVA.');?>
			</div> <!-- /form-group-->	 
			</div> 
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" onClick="enviaFrmGuia('frmNuevoGuia','page-inner','myModalGuia');" class="btn btn-success">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>