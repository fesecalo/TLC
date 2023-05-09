function verificar_datepicker(fecha_date)
{
	var fecha=fecha_date.split("/");
	var dia=parseInt(fecha[0]);
	var mes=parseInt(fecha[1]);
	var ano=parseInt(fecha[2]);
	var nuevaFecha1=new Date(ano,mes-1,dia);
	var nuevaFecha1php=ano+"-"+mes+"-"+dia;
	if (!(nuevaFecha1.getFullYear() == ano && nuevaFecha1.getMonth() + 1 == mes && nuevaFecha1.getDate() == dia))
		return false;
	else
		return true;
}
