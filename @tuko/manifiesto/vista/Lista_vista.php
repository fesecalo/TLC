    <div class="btn-group pull-right">
								
				
				<button type='button' class="btn btn-success" onClick="abreLink('<?php echo URL_SITIO.$pagina."/".$pagina;?>.php?p=Nuevo&id=nv','page-inner');"><span class="fa fa-plus" ></span> Nuevo <?php echo $titulo;?></button>
			</div>
			<h1 class="page-head-line"><?php echo $titulo;?> <small><i> Lista.</i></small></h1>
			<?php
				if(isset($_GET['msg'])){
					$msg=Accion::desencriptar($_GET['msg']);
					$clr=Accion::desencriptar($_GET['clr']);
					Templeta::msg($msg,$clr);
				}
			?>
			<div>
			<form class="form-horizontal" method="get" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmBusca" name="frmBusca" >
				
				<div class="form-group">
						<input type="hidden" id="p" name="p" value="Lista">
					
					<label class="col-sm-2 control-label">
						Buscar Por :
					</label>
					<div class="col-md-2">
					<select class="form-control" id="o" name="o" required>
						<?php 
							$selected = (isset($_POST['o'])?$_POST['o']:$_GET['o']);
						?>
						<option value="codigo" <?php echo (($selected=='codigo')?'Selected':'');?>>Manifiesto :</option>
						<option value="guia" <?php echo (($selected=='guia')?'Selected':'');?>>Guia :</option>
						<?php 
							$selected = false;
				      	?>
				      </select>
					</div>
					<div class="col-md-3">
						<input type="text" class="form-control" id="b" name="b" placeholder="Aqui el valor" value="<?php echo (isset($_POST['b'])?$_POST['b']:$_GET['b']);?>">
					</div>
					

					<label class="col-sm-1 control-label">
						Estado:
					</label>

					<div class="col-md-2">
					<select class="form-control" id="e" name="e" required>
						<?php 
							$selected = (isset($_POST['e'])?$_POST['e']:$_GET['e']);
						?>
						<option value="">Todos</option>
						<option value="1" <?php echo (($selected=='1')?'Selected':'');?>>En Aduana</option>
						<option value="2" <?php echo (($selected=='2')?'Selected':'');?>>Cerrado</option>
						<?php 
							$selected = false;
				      	?>
				      </select>
					</div>

					<div class="col-md-2">
					<button type="button" onClick="enviaFiltro('frmBusca','page-inner');" class="btn btn-default form-control">
							<span class="fa fa-filter" ></span> Filtrar</button>
					</div>
					
				</div>

			</form>
			</div><hr>
			<br>
			  <table class="table table-striped table-bordered table-hover dataTable no-footer">
				<thead>
					<th>Codigo</th>
					<th>Socio</th>
					<th>Estado</th>
					<th><span class="pull-right">Acciones</span></th>
					
				</thead>
				<?php
				while($r = $row->fetch_object()){
						$id=$r->id;
						$codigo=$r->codigo;
						$origen=$r->origen;
						$estado=$r->estado;
						
					?>
					<tr>
						<td><?php echo $codigo; ?></td>
						<td><?php echo Accion::origen($origen); ?></td>
						<td><?php echo Accion::estadoManifiesto($estado);?></td>
					<td>
					<span class="pull-right">
						<a class='btn btn-success' title='Editar informacion' href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina."/".$pagina;?>.php?p=Editar&id=<?php echo $id;?>','page-inner');">
                            <i class="fa fa-edit"></i>
                        </a>
						<a href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina."/".$pagina;?>.php?p=Eliminar&id=<?php echo $id;?>','page-inner');" class='btn btn-danger' title='Eliminar'>
							<i class="fa fa-trash"></i>
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
					 echo Paginacion((isset($_GET['b'])?$_GET['b']:'')."&o=".(isset($_GET['o'])?$_GET['o']:'')."&e=".(isset($_GET['e'])?$_GET['e']:''), $pag, $total_paginas, 'manifiesto','page-inner',$pagina);
					?></span></td>
				</tfoot>
			  </table>
