    <div class="btn-group pull-right">
								
				
				<button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModal"><span class="fa fa-plus" ></span> Nuevo <?php echo $titulo;?></button>
			</div>
			<h1 class="page-head-line"><?php echo $titulo;?> <small><i> Lista.</i></small></h1>
			<?php
				if(isset($_GET['msg'])){
					$msg=Accion::desencriptar($_GET['msg']);
					$clr=Accion::desencriptar($_GET['clr']);
					Templeta::msg($msg,$clr);
				}
			?>
			<div class="pull-right">
			<form class="form-horizontal" method="get" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmBusca" name="frmBusca" >
				
						<div class="form-group">
							<div class="col-md-8">
					<input type="text" class="form-control" id="b" name="b" placeholder="" value="<?php echo (isset($_POST['b'])?$_POST['b']:$_GET['b']);?>">
					<input type="hidden" id="p" name="p" value="Lista">
							</div>

							<div class="col-md-3">
								<button type="button" onClick="enviaFiltro('frmBusca','page-inner');" class="btn btn-default">
									<span class="fa fa-search" ></span> Buscar</button>
							</div>
							
						</div>

			</form>
			</div>

			  <table class="table table-striped table-bordered table-hover dataTable no-footer">
				<thead>
					<th>Nombres</th>
					<th>Tipo</th>
					<th>Estado</th>
					<th><span class="pull-right">Acciones</span></th>
					
				</thead>
				<?php
				while($r = $row->fetch_object()){
						$user_id=$r->id;
						$fullname=$r->nombre;
						$user_tipo=$r->tipo;
						$estado=$r->estado;
						
					?>
					<tr>
						<td><?php echo $fullname; ?></td>
						<td ><?php echo Accion::perfil($user_tipo); ?></td>
						<td><?php echo Accion::estado($estado);?></td>						
					<td>
					<span class="pull-right">
						<a class='btn btn-success' title='Editar informacion' href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina."/".$pagina;?>.php?p=Editar&id=<?php echo $user_id;?>','page-inner');">
                            <i class="fa fa-edit"></i>
                        </a>
						<a href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina."/".$pagina;?>.php?p=Eliminar&id=<?php echo $user_id;?>','page-inner');" class='btn btn-danger' title='Borrar menu'>
							<i class="fa fa-trash"></i>
						</a>
						<a href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina."/".$pagina;?>.php?p=Password&id=<?php echo $user_id;?>','page-inner');" class='btn btn-primary' title='Cambiar contrase�a' >
							<i class="fa fa-lock"></i>
						</a>
					</span>
					</td>	
					</tr>
					<?php
				}
				?>
				<tfoot>
					<td colspan=9><span class="pull-right">
					<?php
					 echo Paginacion((isset($_GET['b'])?$_GET['b']:''), $pag, $total_paginas, 'usr','page-inner',$pagina);
					?></span></td>
				</tfoot>
			  </table>
