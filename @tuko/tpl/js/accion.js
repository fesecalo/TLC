$( document ).ready(function() {
	$(document).keypress(function(e) {
		if (e.keyCode=='p'){
		$("#medioPago").focus();
		}
    });
});
function AbreVentana(url){
	window.open(url,'VER','width=100%,height=400,scrollbars=YES,resizable=NO,Menubar=NO,Titlebar=NO,Toolbar=NO')
	}

function fullVentana(url){
        var params  = 'width='+screen.width;
        params += ', height='+screen.height;
        params += ', top=0, left=0'
		params += ', fullscreen=1';
        window.open(url,"TUKO",params);
    }

function abreLink(url,obj){
	//alert(url);
	$('#'+obj).html('Cargando <img src="../inc/cargando.gif"/>');
	$('#'+obj).load(url);
}

function enviaFrm(frm,obj){
	$.ajaxSetup({ cache:false });
	$.ajax({
		url: $("#"+frm).attr('action'), 
		type: $("#"+frm).attr('method'),
		data: $("#"+frm).serialize(), // Adjuntar los campos del formulario enviado.
		dataType: "text",
		success: function(data){
			abreLink(data,obj);
		}
	}).fail( function( jqXHR, textStatus, errorThrown ) {
		alert( 'Error!!' );
	});
	return false; // Evitar ejecutar el submit del formulario.
}

function enviaGet(url,obj){
	$.ajaxSetup({ cache:false });
	$.ajax({
		url: url, 
		type: 'GET',
		dataType: "text",
		success: function(data){
			abreLink(data,obj);
		}
	}).fail( function( jqXHR, textStatus, errorThrown ) {
		alert( 'Error!!' );
	});
	return false; // Evitar ejecutar el submit del formulario.
}

function enviaFrmmultiMedia(frm,obj){
	$.ajaxSetup({ cache:false });
	var formData = new FormData(document.getElementById(frm));
    formData.append("dato", "valor");
	$.ajax({
		type: $("#"+frm).attr('method'),
		contentType:false,
		url: $("#"+frm).attr('action'),
		dataType: "html",
		data: formData,// Adjuntar los campos del formulario enviado.
		processData: false,
		success: function(data){
			abreLink(data,obj);
		}
	});
	return false; // Evitar ejecutar el submit del formulario.
}

function enviaFiltro(frm,obj){
	$.ajax({
		url: $("#"+frm).attr('action'), 
		type: $("#"+frm).attr('method'),
		data: $("#"+frm).serialize(), // Adjuntar los campos del formulario enviado.
		dataType: "html",
		success: function(data){
			$('#'+obj).html(data);
		}
	});
}

function enviaLink(lk){
	location.href=lk;
}

function enviaCodigo(obj,cod,mod){
	$("#"+obj).val(cod);
	$('#'+mod).modal('hide');
}