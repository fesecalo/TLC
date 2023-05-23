<?php 
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-my-tlc.php';
	require $_SERVER['DOCUMENT_ROOT'].'/TLC'.'/config-btrace-admin-tlc.php';
	require $conf['path_host'].'/EasyPDO/conexionPDO.php';
	require $conf['path_host'].'/include/include_sesion.php';
	require $conf['path_host'].'/include/detecta_pantalla.php';

	$id=$_GET['idBoleta'];

	$db->prepare("SELECT * FROM `boletas_paquete_consolidado` WHERE id=:id  ");
	$db->execute(array(':id' => $id ));
	$sqlBoleta=$db->get_results();
	
?>

<!DOCTYPE html>

<html lang="es">

<!-- header con css -->
<?php require $conf['path_host'].'/include/include_head.php'; ?> 
<!-- fin header y css -->

<!-- java scripts -->
<?php require $conf['path_host'].'/include/java_scripts.php'; ?>   
<!-- fin java scripts-->

<script type="text/javascript">
	
function eliminarBoleta(idBoleta){
    if (confirm("Desea eliminar la boleta o consolidado <?= $sqlBoleta[0]->paquete_consolidado;?>?") == true) {
        $.ajax({
            method: "GET",
            url: "eliminar-boleta.php",
            data: { 'idBoleta': idBoleta}
        })
        .done(function( msg ) {
            console.log(msg.resultado);
            if(msg.resultado == true){
                alert( "La boleta ha sido eliminada satisfactoriamente");
            }
            alert( "La boleta ha sido eliminada satisfactoriamente");
            window.location.href = "listado-boletas-generadas.php";
        });

    } 
}	


</script>

<body>

<!-- menu-->
<?php 
	if($_SESSION['tipo_usuario']==1 || $_SESSION['tipo_usuario']==5){
		require $conf['path_host'].'/include/include_menu_admin.php';
	}elseif($_SESSION['tipo_usuario']==3){
		require $conf['path_host'].'/include/include_menu.php';
	}else{
		die("Su cuenta no tiene los privilegios para ingresar a este sitio. Contacte al administrador.");
	}
?> 
<!--menu-->

    <div class="container-fluid">
        <div class="container">
    		<div class="row">
            <!--Inicio Contenido -->
    
        	<h2>Detalles de la boleta</h2>	
        
        	<!-- tabla de datos -->
        	<?php if(empty($sqlBoleta)){ ?>
        		<center><h2>No hay detalles de la boleta</h2></center>
        	<?php }else{ ?>
        
            <link
              rel="stylesheet"
              href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css"
            >
            </div>
        </div>
    
		<div class="container">
		    
			<div class="row">
				<div class="col-xs-12">

				</div>
			</div>
			
			<div class="row">
    		    <div class="col-lg-12">
            		<div>

                      <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#detalles" aria-controls="detalles" role="tab" data-toggle="tab">Detalles</a></li>
                            <li role="presentation"><a href="#request" aria-controls="request" role="tab" data-toggle="tab">Datos Request</a></li>
                            <li role="presentation"><a href="#response" aria-controls="response" role="tab" data-toggle="tab">Datos Response</a></li>
                            <li role="presentation"><a href="#json_request" aria-controls="json_request" role="tab" title="Json Request process" data-toggle="tab">Request and Response</a></li>
                        </ul>
                    
                      <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="detalles">

                                
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Gu&iacute;a: <span><?= $sqlBoleta[0]->paquete_consolidado;?></span></h3>
                                    </div>
                                    <div class="panel-body">

                                        <?php
                                            $jsonDecodeRequest = json_decode($sqlBoleta[0]->json_request);
                                            $jsonDecodeResponse = json_decode($sqlBoleta[0]->json_response);
                                        ?>

                                        <div class="col-lg-6">
                                            <ul class="list-group">
                                                <li class="list-group-item"><b>Identificador:</b> <span><?= $sqlBoleta[0]->id;?></span></li>
                                                <li class="list-group-item"><b>Paquete &oacute; Consolidado:</b> <span><?=$sqlBoleta[0]->tipo_paquete_consolidado==1 ? "Paquete" : "Consolidado" ;?></span></li>
                                                <li class="list-group-item"><b>Folio:</b> <span><?=$sqlBoleta[0]->folio!=null ? $sqlBoleta[0]->folio : "No existe el folio" ;?></span></li>
                                                <li class="list-group-item"><b>Fecha de Procesamiento:</b> <span><?=$sqlBoleta[0]->fecha;?></span></li>
                                                <li class="list-group-item"><b>Boleta descargada:</b> <span><?= $sqlBoleta[0]->pdfBase64 == NULL ? "Si" : "No";?></span></li>
                                                <li class="list-group-item"><b>Resultado de Procesamiento:</b> 
                                                    <span class="label label-<?= !$jsonDecodeResponse->Objeto==NULL ? "info" : "danger" ;?>" <?= !$jsonDecodeResponse->Objeto==NULL ? "" : "style='background-color: red;'" ;?>>
                                                        <?= $jsonDecodeResponse->Objeto!=NULL ? "Satisfactorio" : "Hubo un error" ;?>
                                                    </span>
                                                </li>
                                                <?php 
                                                if($jsonDecodeResponse->Mensaje!=NULL){ ?>
                                                    <li class="list-group-item list-group-item-warning">
                                                        <b>Descripci&oacute;n del error:</b> 
                                                        <span class="label" style='background-color: red;'>
                                                            <?= $jsonDecodeResponse->Mensaje ? $jsonDecodeResponse->Mensaje : "" ;?>
                                                        </span>
                                                    </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            

                                            <div class="alert alert-warning" role="alert">
                                                <p>
                                                    Para intentar de nuevo el procesamiento del paquete o 
                                                    consolidado <?=$sqlBoleta[0]->paquete_consolidado?> debe eliminar la boleta.
                                                </p>

                                                <p>
                                                    Elimine la boleta haciendo click aqu&iacute;.
                                                </p>


                                            </div>

                                            <center><button onclick="eliminarBoleta(<?= $sqlBoleta[0]->id ?>);" class="button solid-color">Eliminar Boleta</button></center>

                                            <br/>
                                            <p>Recuerde que una vez hecha esta operaci&oacute;n no se podr&aacute; recuperar la informaci&oacute;n de la boleta procesada.</p>


                                            
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="panel-footer">
                                        Panel footer
                                    </div>
                                </div>
                               
                                
                                
                            </div>
                            <div role="tabpanel" class="tab-pane" id="request">
                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <center><h3>Datos de la boleta</h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>EmpresaId:</b> <span><?= $jsonDecodeRequest->EmpresaId;?></span></li>
                                            <li class="list-group-item"><b>DocumentoId:</b> <span><?= $jsonDecodeRequest->DocumentoId;?></span></li>
                                            <li class="list-group-item"><b>OrigenId:</b> <span><?= $jsonDecodeRequest->OrigenId;?></span></li>
                                            <li class="list-group-item"><b>TipoDte:</b> <span><?= $jsonDecodeRequest->TipoDte;?></span></li>
                                            <li class="list-group-item"><b>FolioDte:</b> <span><?= $jsonDecodeRequest->FolioDte;?></span></li>
                                            <li class="list-group-item"><b>TipoOperacion:</b> <span><?= $jsonDecodeRequest->TipoOperacion;?></span></li>
                                            <?php 

                                            if($jsonDecodeResponse->EsError!=NULL){ ?>
                                                <li class="list-group-item list-group-item-danger">
                                                    <b>Descripci&oacute;n del error:</b> 
                                                    <span>
                                                        <?= !$jsonDecodeResponse->ErrorDescripcion ? $jsonDecodeResponse->ErrorDescripcion : "" ;?>
                                                    </span>
                                                </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    
                                    
                                    <div class="col-lg-4">
                                        <center><h3>Receptor</h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>Rut:</b> <span><?= $jsonDecodeRequest->Receptor->Rut;?></span></li>
                                            <li class="list-group-item"><b>RazonSocial:</b> <span><?= $jsonDecodeRequest->Receptor->RazonSocial;?></span></li>
                                            <li class="list-group-item"><b>Giro:</b> <span><?= $jsonDecodeRequest->Receptor->Giro;?></span></li>
                                            <li class="list-group-item"><b>Direccion:</b> <span><?= $jsonDecodeRequest->Receptor->Direccion;?></span></li>
                                            <li class="list-group-item"><b>Comuna:</b> <span><?= $jsonDecodeRequest->Receptor->Comuna;?></span></li>
                                            <li class="list-group-item"><b>Ciudad:</b> <span><?= $jsonDecodeRequest->Receptor->Ciudad;?></span></li>
                                            <li class="list-group-item"><b>Telefono:</b> <span><?= $jsonDecodeRequest->Receptor->Telefono;?></span></li>
                                            <li class="list-group-item"><b>Correo:</b> <span><?= $jsonDecodeRequest->Receptor->Correo;?></span></li>
                                            
                                            <?php 
                                            if($jsonDecodeResponse->EsError){ ?>
                                                <li class="list-group-item list-group-item-danger"><b>Descripci&oacute;n del error:</b> <span><?= !$jsonDecodeResponse->ErrorDescripcion ? $jsonDecodeResponse->ErrorDescripcion : "" ;?></span></span></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <center><h3>Referencias</h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>numeroLinea:</b> <span><?= $jsonDecodeRequest->referencias[0]->numeroLinea;?></span></li>
                                            <li class="list-group-item"><b>tipoDte:</b> <span><?= $jsonDecodeRequest->referencias[0]->tipoDte;?></span></li>
                                            <li class="list-group-item"><b>folio:</b> <span><?= $jsonDecodeRequest->referencias[0]->folio;?></span></li>
                                            <li class="list-group-item"><b>fecha:</b> <span><?= $jsonDecodeRequest->referencias[0]->fecha;?></span></li>
                                            <li class="list-group-item"><b>razon:</b> <span><?= $jsonDecodeRequest->referencias[0]->razon;?></span></li>
                                            <li class="list-group-item"><b>tipoReferencia:</b> <span><?= $jsonDecodeRequest->referencias[0]->tipoReferencia;?></span></li>
                                            
                                            <?php 
                                            if($jsonDecodeResponse->EsError){ ?>
                                                <li class="list-group-item list-group-item-danger"><b>Descripci&oacute;n del error:</b> <span><?= !$jsonDecodeResponse->ErrorDescripcion ? $jsonDecodeResponse->ErrorDescripcion : "" ;?></span></span></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                
                                </div>
                                
                                <hr>
                                
                                <div class="row">
                                
                                    <?php if($jsonDecodeRequest->DetallesDocumento[0]){?>
                                    <div class="col-lg-3">
                                        <center><h3>Item <?= $jsonDecodeRequest->DetallesDocumento[0]->Descripcion?></h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>DetalleDocumentoId:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->DetalleDocumentoId;?></span></li>
                                            <li class="list-group-item"><b>Descripcion:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->Descripcion;?></span></li>
                                            <li class="list-group-item"><b>Cantidad:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->Cantidad;?></span></li>
                                            <li class="list-group-item"><b>Precio:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->Precio;?></span></li>
                                            <li class="list-group-item"><b>Exento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->Exento;?></span></li>
                                            <li class="list-group-item"><b>MontoItem:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->MontoItem;?></span></li>
                                            <li class="list-group-item"><b>FechaProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->FechaProducto;?></span></li>
                                            <li class="list-group-item"><b>CodigoProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->CodigoProducto;?></span></li>
                                            <li class="list-group-item"><b>DescuentoPorcentaje:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->DescuentoPorcentaje;?></span></li>
                                            <li class="list-group-item"><b>MontoDescuento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->MontoDescuento;?></span></li>
                                            
                                            <li class="list-group-item"><b>Documento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->Documento;?></span></li>
                                            <li class="list-group-item"><b>TotalLinea:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[0]->TotalLinea;?></span></li>
                                            
    
                                        </ul>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if($jsonDecodeRequest->DetallesDocumento[1]){?>
                                    <div class="col-lg-3">
                                        <center><h3>Item <?= $jsonDecodeRequest->DetallesDocumento[1]->Descripcion?></h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>DetalleDocumentoId:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->DetalleDocumentoId;?></span></li>
                                            <li class="list-group-item"><b>Descripcion:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->Descripcion;?></span></li>
                                            <li class="list-group-item"><b>Cantidad:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->Cantidad;?></span></li>
                                            <li class="list-group-item"><b>Precio:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->Precio;?></span></li>
                                            <li class="list-group-item"><b>Exento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->Exento;?></span></li>
                                            <li class="list-group-item"><b>MontoItem:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->MontoItem;?></span></li>
                                            <li class="list-group-item"><b>FechaProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->FechaProducto;?></span></li>
                                            <li class="list-group-item"><b>CodigoProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->CodigoProducto;?></span></li>
                                            <li class="list-group-item"><b>DescuentoPorcentaje:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->DescuentoPorcentaje;?></span></li>
                                            <li class="list-group-item"><b>MontoDescuento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->MontoDescuento;?></span></li>
                                            
                                            <li class="list-group-item"><b>Documento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->Documento;?></span></li>
                                            <li class="list-group-item"><b>TotalLinea:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[1]->TotalLinea;?></span></li>
                                            
    
                                        </ul>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if($jsonDecodeRequest->DetallesDocumento[2]){?>
                                    <div class="col-lg-3">
                                        <center><h3>Item <?= $jsonDecodeRequest->DetallesDocumento[2]->Descripcion?></h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>DetalleDocumentoId:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->DetalleDocumentoId;?></span></li>
                                            <li class="list-group-item"><b>Descripcion:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->Descripcion;?></span></li>
                                            <li class="list-group-item"><b>Cantidad:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->Cantidad;?></span></li>
                                            <li class="list-group-item"><b>Precio:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->Precio;?></span></li>
                                            <li class="list-group-item"><b>Exento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->Exento;?></span></li>
                                            <li class="list-group-item"><b>MontoItem:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->MontoItem;?></span></li>
                                            <li class="list-group-item"><b>FechaProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->FechaProducto;?></span></li>
                                            <li class="list-group-item"><b>CodigoProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->CodigoProducto;?></span></li>
                                            <li class="list-group-item"><b>DescuentoPorcentaje:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->DescuentoPorcentaje;?></span></li>
                                            <li class="list-group-item"><b>MontoDescuento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->MontoDescuento;?></span></li>
                                            
                                            <li class="list-group-item"><b>Documento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->Documento;?></span></li>
                                            <li class="list-group-item"><b>TotalLinea:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[2]->TotalLinea;?></span></li>
                                            
    
                                        </ul>
                                    </div>
                                    <?php } ?>
                                    
                                    <?php if($jsonDecodeRequest->DetallesDocumento[3]){?>
                                    <div class="col-lg-3">
                                        <center><h3>Item <?= $jsonDecodeRequest->DetallesDocumento[3]->Descripcion?></h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>DetalleDocumentoId:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->DetalleDocumentoId;?></span></li>
                                            <li class="list-group-item"><b>Descripcion:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->Descripcion;?></span></li>
                                            <li class="list-group-item"><b>Cantidad:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->Cantidad;?></span></li>
                                            <li class="list-group-item"><b>Precio:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->Precio;?></span></li>
                                            <li class="list-group-item"><b>Exento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->Exento;?></span></li>
                                            <li class="list-group-item"><b>MontoItem:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->MontoItem;?></span></li>
                                            <li class="list-group-item"><b>FechaProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->FechaProducto;?></span></li>
                                            <li class="list-group-item"><b>CodigoProducto:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->CodigoProducto;?></span></li>
                                            <li class="list-group-item"><b>DescuentoPorcentaje:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->DescuentoPorcentaje;?></span></li>
                                            <li class="list-group-item"><b>MontoDescuento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->MontoDescuento;?></span></li>
                                            
                                            <li class="list-group-item"><b>Documento:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->Documento;?></span></li>
                                            <li class="list-group-item"><b>TotalLinea:</b> <span><?= $jsonDecodeRequest->DetallesDocumento[3]->TotalLinea;?></span></li>
                                            
    
                                        </ul>
                                    </div>
                                    <?php } ?>
                                </div>
                                
                            
                            </div>
                            <div role="tabpanel" class="tab-pane" id="response">
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <center><h3>Objeto</h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>Folio:</b> <span><?= $jsonDecodeResponse->Objeto->Folio;?></span></li>
                                            <li class="list-group-item"><b>TipoDte:</b> <span><?= $jsonDecodeResponse->Objeto->TipoDte;?></span></li>
                                            <li class="list-group-item"><b>IdDte:</b> <span><?= $jsonDecodeResponse->Objeto->IdDte;?></span></li>
                                            <li class="list-group-item"><b>FechaRegistro:</b> <span><?= $jsonDecodeResponse->Objeto->FechaRegistro;?></span></li>
                                            <li class="list-group-item"><b>RutEmpresa:</b> <span><?= $jsonDecodeResponse->Objeto->RutEmpresa;?></span></li>
                                            <?php 
                                            if($jsonDecodeResponse->EsError){ ?>
                                                <li class="list-group-item list-group-item-danger"><b>Descripci&oacute;n del error:</b> <span><?= !$jsonDecodeResponse->ErrorDescripcion ? $jsonDecodeResponse->ErrorDescripcion : "" ;?></span></span></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    
                                    
                                    <div class="col-lg-6">
                                        <center><h3>Resultado de Procesamiento:</h3></center>
                                        <ul class="list-group">
                                            <li class="list-group-item"><b>EsError:</b> <span><?= !$jsonDecodeResponse->EsError ?  "Falso": "Verdadero";?></span></li>
                                            <li class="list-group-item"><b>ErrorDescripcion:</b> <span><?= !$jsonDecodeResponse->ErrorDescripcion ? "NULL": $jsonDecodeResponse->ErrorDescripcion ;?></span></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                                    
                            </div>
                            <div role="tabpanel" class="tab-pane" id="json_request">
                                <center><h3>Json Request Process</h3></center>
<pre>
<code>
<?= $sqlBoleta[0]->json_request == NULL ? "<center><h4>Respuesta Null</h4></center>" : $sqlBoleta[0]->json_request;?>
</code>
</pre>

                                <center><h3>Json Response Process</h3></center>

<pre>
<code>
<?= $sqlBoleta[0]->json_response == NULL ? "<center><h4>Respuesta Null</h4></center>" : $sqlBoleta[0]->json_response;?>
</code>
</pre>

                                <center><h3>Json Response PDF</h3></center>

<pre>
<code>
<?= $sqlBoleta[0]->json_response_pdf == NULL ? "<center><h4>PDF aun no descargado</h4></center>" : $sqlBoleta[0]->json_response_pdf;?>
</code>
</pre>
                            </div>

                        </div>
                    
                    </div>
                </div>
            </div>
			

            <br>
            <br>
			
			<div class="row">
    		    <div class="col-lg-12">
            		<center><a href="listado-boletas-generadas.php" class="button solid-color">VOLVER</a></center>
                </div>
            </div>


            
            

            
			
		</div>
	</div>
	<?php } ?>
	<!-- fin tabla de datos -->

	<br><br><br><br>

	<!-- INCLUDE FOOTER-->
	<?php //require $conf['path_host'].'/include/include_footer.php'; ?> 
    <!--FIN FOOTER-->  

</body>

</html>