
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h1 class="page-head-line">Guias <small><i> Cerrar.</i></small></h1>
		  </div>
		<form class="form-horizontal" method="POST" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmCerrarGuia" name="frmCerrarGuia" >
		<div class="modal-body">
			<input type="hidden" id="p" name="p" value="EditarGuia">
			<input type="hidden" id="idcg" name="idcg" value="<?php echo $_GET["idc"];?>">
			<input type="hidden" id="idm" name="idm" value="<?php echo $_GET["idm"];?>">
			<div class="form-group">
				<label class="col-sm-3 control-label">Comentario</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="observacion" name="observacion" onKeyup="return Vf.soloLetra(this)" autocomplete="off" value="<?php echo $p->observacion;?>" required>
				</div>
			  </div>
			  
			<div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label" >Estado: </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="estado" name="estado" required>
				      	<option value="0">Pendiente</option>
				      	<?php 
								   $row = Accion::traeRevisado();

								   while($r = $row->fetch_object()){
									   echo "<option value=".$r->id." ".(($p->estado==$r->id)?'Selected':'').">".$r->glosa."</option>";
								   } // while
				      	?>
				      </select>
				    </div>
	        </div>
			
		</div> 
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" onClick="enviaFrmGuia('frmCerrarGuia','page-inner','myModalGuiaCerrar');" class="btn btn-success">Guardar datos</button>
		 </div>
		</form>
		</div>
	  </div>