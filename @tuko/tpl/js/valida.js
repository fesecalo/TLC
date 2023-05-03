var Vf = {
	// Valida el rut con su cadena completa "XXXXXXXX-X"
	validaRut : function (obj) {
		var rutCompleto = $("#"+obj).val();
		if (!/^[0-9.]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto )){
			return Vf.daMensaje(obj,'Rut no valido',false);
		}
		var tmp 	= rutCompleto.split('-');
		var digv	= tmp[1]; 
		var rut 	= tmp[0];
		if ( digv == 'K' ) digv = 'k' ;
		return Vf.daMensaje(obj,'Rut no valido',(Vf.dv(rut.replace(/\./g, "")) == digv ));
	},
	dv : function(T){
		var M=0,S=1;
		for(;T;T=Math.floor(T/10))
			S=(S+T%10*(9-M++%6))%11;
		return S?S-1:'k';
	},
	validaCorreo : function (obj){
		var mail = $("#"+obj).val();
		var caract = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
		return Vf.daMensaje(obj,'Formato correo no valido',caract.test(mail));
	},
	daMensaje : function (obj,msg,tipo){
		if (tipo==false){
			$("#msg"+obj).remove();
			$("#"+obj).css('border','1px solid #FF0000');
			$("#"+obj).after('<div id="msg'+obj+'"><label class="label label-danger"><i class="fa fa-times" ></i></label> '+msg+"</div>");
			return false;
		}else{
			$("#"+obj).css('border','1px solid #ccc');
			$("#msg"+obj).remove();
			return true;
		}

	},
	soloRut : function (obj){
		texto = obj.value;
		var actual = texto.replace(/^0+/, "");
		if (actual != '' && actual.length > 0) {
			var sinPuntos = actual.replace(/\./g, "");
			var actualLimpio = sinPuntos.replace(/-/g, "");
			var inicio = actualLimpio.substring(0, actualLimpio.length - 1);
			var rutPuntos = "";
			var i = 0;
			var j = 1;
			for (i = inicio.length - 1; i >= 0; i--) {
				var letra = inicio.charAt(i);
				rutPuntos = letra + rutPuntos;
				if (j % 3 == 0 && j <= inicio.length - 1) {
					rutPuntos = "." + rutPuntos;
				}
				j++;
			}
			var dv = actualLimpio.substring(actualLimpio.length - 1);
			if (rutPuntos != '') {
				rutPuntos = rutPuntos + "-" + dv;
			}else{
				rutPuntos = dv;
			}
		}
		rutPuntos ? obj.value= rutPuntos : obj.value= '';
	},	
	soloNumero : function (obj){
		obj.value = (obj.value + '').replace(/[^0-9]/g, '');
	},
	soloTelefono : function (obj){
		obj.value = (obj.value + '').replace(/[^0-9+ ]/g, '');
	},
	soloLetra : function (obj){
		obj.value = (obj.value + '').replace(/[^A-Za-z0-9- _]/g, '');
	},
	soloCorreo : function (obj){
		obj.value = (obj.value + '').replace(/([^a-zA-Z0-9@_.-])/g, '');
	},
	soloDireccion : function (obj){
		obj.value = (obj.value + '').replace(/[^A-Za-z0-9# -_]/g, '');
	},
	vuelto : function (pago,obj,total){
		pago.value = (pago.value + '').replace(/[^0-9]/g, '');
		var vto = pago.value-total;
		
		pago.value = formatNumber.new(pago.value);
		if(vto>=0){
			$("#"+obj).val(formatNumber.new(vto));
		}else{
			$("#"+obj).val(0);
		}
	},
	netoIVA : function (total,neto,iva){
		total.value = (total.value + '').replace(/[^0-9]/g, '');
		var iv = total.value*0.19;
		var nto = total.value-iv;
		if(iv>=0){
			$("#"+iva).val(formatNumber.new(iv));
			$("#"+neto).val(formatNumber.new(nto));
			total.value = formatNumber.new(total.value);
		}else{
			$("#"+iva).val(0);
			$("#"+neto).val(0);
		}
	},
	requerido : function (obj){
		var x = $("#"+obj).serializeArray();
		var fl = 0;
  		$.each(x, function(i, field){
			if (field.value == '' && ($("#"+field.name).prop('required'))){
				Vf.daMensaje(field.name,'Requerido',false);
				fl++;
			}else{
				Vf.daMensaje(field.name,'Requerido',true);
			}
		});
		return fl==0 ? true : false;
	}
}

var formatNumber = {
	separador: ",", // separador para los miles
	sepDecimal: '.', // separador para los decimales
	formatear:function (num){
		num +='';
		var splitStr = num.split('.');
		var splitLeft = splitStr[0];
		var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
		var regx = /(\d+)(\d{3})/;
		while (regx.test(splitLeft)) {
			splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
		}
		return this.simbol + splitLeft +splitRight;
	},
	new:function(num, simbol){
		this.simbol = simbol ||'';
			return this.formatear(num);
		}
   }