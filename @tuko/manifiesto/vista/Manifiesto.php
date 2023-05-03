<div class="btn-group pull-right">
<a class="btn btn-default" href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=Lista','page-inner');">Volver</a>
<a class="btn btn-default" href="<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=PDF&id=<?php echo $_GET['id'];?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Generar PDF</a>
</div>
<h1 class="page-head-line"><?php echo $titulo;?></h1>
			<?php
				if(isset($_GET['msg'])){
					$msg=Accion::desencriptar($_GET['msg']);
					$clr=Accion::desencriptar($_GET['clr']);
					Templeta::msg($msg,$clr);
				}
			?>
<div class="col-sm-5">
	<?php include("vista/Editar_vista.php");?>
</div>
<div class="col-sm-7">
    <?php include("vista/lector.php");?>
    <?php include("vista/detalle.php");?>
    <?php include("vista/Nuevo_guia.php");?>
	<?php include("vista/Editar_guia2.php");?>
	<?php include("vista/Cerrar_guia2.php");?>
</div>