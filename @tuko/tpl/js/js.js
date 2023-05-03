function enviaFrmCliente(frm,obj){
	RQ=Vf.requerido(frm);
	VR=Vf.validaRut('rut');
	if(RQ && VR){
		enviaFrm(frm,obj);
	}
}
function enviaFrmManifiesto(frm,obj){
	RQ=Vf.requerido(frm);
	if(RQ){
		enviaFrm(frm,obj);
	}
}
function enviaFrmRequerido(frm,obj,mod){
	RQ=Vf.requerido(frm);
	if(RQ){
		$('#'+mod).modal('hide');
		enviaFrm(frm,obj);
	}
}
function enviaFrmUsuario(frm,obj,mod){
	RQ=Vf.requerido(frm);
	if(RQ){
		$('#'+mod).modal('hide');
		enviaFrm(frm,obj);
	}
}
function enviaFrmGuia(frm,obj,mod){
	RQ=Vf.requerido(frm);
	if(RQ){
		$('#'+mod).modal('hide');
		enviaFrm(frm,obj);
	}
}
function enviaFrmUsuarioE(frm,obj){
	RQ=Vf.requerido(frm);
	if(RQ){
		enviaFrm(frm,obj);
	}
}