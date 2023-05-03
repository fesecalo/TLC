
<table class="table table-striped table-bordered table-hover dataTable no-footer">
    <thead>
        <th>Guia</th>
        <th>Kilo</th>
        <th>Total</th>
        <th>Estado</th>
        <th><span class="pull-right">Acciones</span></th>
        
    </thead>
    <?php
    while($r = $rwg->fetch_object()){
            $id=$r->id;
            $codigo=$r->codigo;
            $cliente=$r->cliente;
            $kilo=$r->kilo;
            $total=$r->total;
            $estado=$r->estado;
            
        ?>
        <tr title='<?php echo Accion::cliente($cliente);?>'>
        <td><?php echo $codigo; ?></td>
            <td><?php echo $kilo; ?></td>
            <td><?php echo $total; ?></td>
            <td ><?php echo Accion::estadoGuia($estado);?></td>
        <td >
        <span class="pull-right">
        <button type='button' class="btn btn-info" data-toggle="modal" data-target="#myModalGuiaCerrar" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=EditarGuia&idc=<?php echo $id;?>&idm=<?php echo $_GET['id'];?>','myModalGuiaCerrar');" title='Cierre revision' ><i class="fa fa-file-text"></i></button>
        <button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModalGuiaEditar" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=EditarGuia&id=<?php echo $id;?>&idm=<?php echo $_GET['id'];?>','myModalGuiaEditar');" title='Editar informacion' ><i class="fa fa-edit"></i></button>
            <a href="javascript:void(0);" onClick="abreLink('<?php echo URL_SITIO.$pagina.'/'.$pagina;?>.php?p=EliminarGuia&id=<?php echo $id;?>','page-inner');" class='btn btn-danger' title='Borrar menu'>
                <i class="fa fa-trash"></i>
            </a>
        </span>
        </td>	
        </tr>
        
        <?php
    }
    ?>
</table>
