function hora () {
	 var d = new Date(); 
	 var minutos = "";
	 if (d.getMinutes() < 9){
	 	minutos = "0"+d.getMinutes();
	 }else{
	 	minutos = d.getMinutes();
	 }
	 document.write(d.getHours()+':'+minutos);
}

function dia_semana () {
	 var d = new Date(); 
	 var dia = "";
	 switch (d.getDay()) {
	 	case 1:
	 		dia = "LUNES";
	 		break;
	 	case 2:
	 		dia = "MARTES";
	 		break;
	 	case 3:
	 		dia = "MIERCOLES";
	 		break;
	 	case 4:
	 		dia = "JUEVES";
	 		break;
	 	case 5:
	 		dia = "VIERNES";
	 		break;
	 	case 6:
	 		dia = "SABADO";
	 		break;
	 	case 7:
	 		dia = "DOMINGO";
	 		break;
	 }
	 document.write('HOY ES '+dia);
}

function fecha () {
	 var d = new Date(); 
	 var mes = "";
	 switch (d.getMonth()) {
	 	case 1:
	 		mes = "ENERO";
	 		break;
	 	case 2:
	 		mes = "FEBRERO";
	 		break;
	 	case 3:
	 		mes = "MARZO";
	 		break;
	 	case 4:
	 		mes = "ABRIL";
	 		break;
	 	case 5:
	 		mes = "MAYO";
	 		break;
	 	case 6:
	 		mes = "JUNIO";
	 		break;
	 	case 7:
	 		mes = "JULIO";
	 		break;
	 	case 8:
	 		mes = "AGOSTO";
	 		break;
	 	case 9:
	 		mes = "SEPTIEMBRE";
	 		break;
	 	case 10:
	 		mes = "OCTUBRE";
	 		break;
	 	case 11:
	 		mes = "NOVIEMBRE";
	 		break;
	 	case 12:
	 		mes = "DICIEMBRE";
	 		break;
	 }

	 document.write(d.getDate()+' DE '+mes);
}