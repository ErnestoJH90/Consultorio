function validar(){
	var Nombre, A_Paterno, A_Materno, Edad, Sexo, Celular, Doctor, Date, Time;
	Nombre= document.getElementById("Nombre").value;
	A_Paterno= document.getElementById("A_Paterno").value;
	A_Materno= document.getElementById("A_Materno").value;
	Edad= document.getElementById("Edad").value;
	Sexo= document.getElementById("Sexo").value;
	Celular= document.getElementById("Celular").value;
	Doctor= document.getElementById("Doctor").value;
	Date= document.getElementById("Date").value;
	Time= document.getElementById("Time").value;
	
	if(Nombre === "" || A_Paterno === "" || A_Materno === "" || Edad === "" || Sexo === "" || Celular === "" || Doctor === "" 
		|| Date === "" || Time ==="" ){
		alert("Favor de poner sus datos");
		return false;
	}
	else if (Nombre.length>35){
		alert("El nombre es muy largo");
		return false;
	}
	else if (A_Paterno.length>35){
		alert("El apellido es muy largo");
		return false;
	}
	else if(A_Materno.length){
		alert("El apellido es muy largo");
		return false;
	}
	else if (Edad.length>2){
		alert("Favor de poner tu edad actual");
	}
	else if (Sexo.length>1){
		alert("Solo debes seleccionar F para femenino o M para masculino GRACIAS");
	}
	else if (Celular.length>10){
		alert("Introduce tu numero a 10 digitos ");
	}
	else if (Doctor.length>35){
		alert("Selecciona el doctor de tu agrado");
	}
	else if (Date.length>8){
		alert("Fecha de tu cita");
	}
	else if (Time.length>6){
		alert("Hora de tu cita");
	}
	else if (isNaN(Celular)){
		alert("Favor de poner tu numero teléfonico");
		return false;
	}
}