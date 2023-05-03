	<!-- Modal -->
	<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h1 class="page-head-line"><?php echo $titulo;?> <small><i> Agregar nuevo.</i></small></h1>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="POST" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmNuevo" name="frmNuevo" >
			<input type="hidden" id="p" name="p" value="Nuevo">
			<input type="hidden" id="idnv" name="idnv" value="idnv">
			<div class="modal-body">
			  <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Nombres</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombres" value="" required>
				  <?php echo Accion::miniBox(0,'Nombre y Apellido de su '.$titulo.'.');?>
				</div>
			  </div>
	        </div> <!-- /form-group-->	
			<div class="form-group">
				<label for="user_tipo" class="col-sm-3 control-label">Tipo</label>
				<div class="col-sm-8">
				  <select class="form-control" id="tipo" name="tipo" required>
				   <option value="">-- Selecciona --</option>
				   <option value="1"><?php echo Accion::perfil(1); ?></option>
				   <option value="2"><?php echo Accion::perfil(2); ?></option>
				  </select>
				  <?php echo Accion::miniBox(0,'Privilegios dentro del sistema.');?>
				</div>
			  </div>
			  <hr><br>
			  <div class="form-group">
				<label for="user_name" class="col-sm-3 control-label">Usuario</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="" pattern="[a-zA-Z0-9]{2,64}" title="nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
				  <?php echo Accion::miniBox(0,'Identificador para login al sistema.');?>
				</div>
			  </div>
			  <div class="form-group">
				<label for="user_password_new" class="col-sm-3 control-label">Contraseña</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="clave" name="clave" placeholder="Contraseña" value="1234" pattern=".{6,}" title="Contraseña ( min . 6 caracteres)" required>
				  <?php echo Accion::miniBox(0,'Clave de acceso para login al sistema.');?>
				</div>
			  </div>
			  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="button" onClick="enviaFrmUsuario('frmNuevo','page-inner','myModal');" class="btn btn-success">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
