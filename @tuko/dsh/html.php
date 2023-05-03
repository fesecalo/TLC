<?php
$cpm = $p->traeFiltro(1);
$crm = $p->traeFiltro(2);

$cp = $p->traeFiltroGuia(0);
$cr = $p->traeFiltroGuia(1);
$cn = $p->traeFiltroGuia(2);
$t= $cp+$cr+$cn;
$pcp = ($cp*100)/$t;
$pcr = ($cr*100)/$t;
$pcn = ($cn*100)/$t;
?>
<h1 class="page-head-line"><?php echo $titulo;?></h1>
<div class="pull-right col-md-12">
			<form class="form-horizontal" method="get" action="<?php echo URL_SITIO.$pagina."/".$pagina.'.php';?>" id="frmBusca" name="frmBusca" >
						<div class="form-group">
                        <label class="col-sm-2 control-label">
						Periodo entre :
					    </label>
                            <div class="col-md-3">
                            <input type="date" class="form-control" id="fi" name="fi" value="<?php echo (isset($_GET['fi'])?$_GET['fi']:date("Y-m")."-01");?>">
                            </div>
                            <div class="col-md-3">
                            <input type="date" class="form-control" id="ff" name="ff" value="<?php echo (isset($_GET['ff'])?$_GET['ff']:date("Y-m-d"));?>">
							</div>

							<div class="col-md-3">
								<button type="button" onClick="enviaFiltro('frmBusca','page-inner');" class="btn btn-default">
                                    <span class="fa fa-search" ></span> Buscar
                                </button>
                                <a class="btn btn-default" href="<?php echo URL_SITIO.$pagina;?>/exporta.php?fi=<?php echo (isset($_GET['fi'])?$_GET['fi']:date("Y-m")."-01");?>&ff=<?php echo (isset($_GET['ff'])?$_GET['ff']:date("Y-m-d"));?>" target="_blank">
                                    <span class="fa fa-file-excel-o" ></span> Exportar
                                </a>

							</div>
							
						</div>

			</form>
			</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-warning text-center">
                    
                    <b><i class="fa fa-plane fa-2x"></i> <?php echo $cpm;?>
                    Manifiestos En Aduana</b>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success text-center">
                    
                    <b><i class="fa fa-truck fa-2x"></i> <?php echo $crm;?>
                    Manifiestos Cerrados</b>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="alert alert-warning text-center">
                    <i class="fa fa-cubes fa-5x"></i>
                    <h3><?php echo $cp;?></h3>
                    Guias Pendientes
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-success text-center">
                    <i class="fa fa-truck fa-5x"></i>
                    <h3><?php echo $cr;?></h3>
                    Guias Cerradas Ok
                </div>
            </div>
            <div class="col-md-4">
                <div class="alert alert-danger text-center">
                    <i class="fa fa-ambulance fa-5x"></i>
                    <h3><?php echo $cn;?></h3>
                    Guias Cerradas Nok
                </div>
            </div>
        </div>
    </div>
<div class="panel panel-default">
    <div class="panel-heading">
        Comportamiento Periodo x Guias
    </div>
    <div class="panel-body">
        <div class="progress">
            <div class="progress-bar progress-bar-warning progress-bar-striped" style="width: <?php echo $pcp;?>%">
                <span class="sr-only"><?php echo $cp;?>% Complete (warning)</span>
            </div>
            <div class="progress-bar progress-bar-success" style="width: <?php echo $pcr;?>%">
                <span class="sr-only"><?php echo $cr;?>% Complete (success)</span>
            </div>
            <div class="progress-bar progress-bar-danger" style="width: <?php echo $pcn;?>%">
                <span class="sr-only"><?php echo $cn;?>% Complete (danger)</span>
            </div>
        </div>
    </div>
</div>