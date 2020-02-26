function validarreg(){
    var Nombre, A_Paterno, Usuario, Correo, Clave, expression;
    Nombre= document.getElementById("Nombre").Value;
    A_Paterno= document.getElementById("A_Paterno").Value;
    Usuario= document.getElementById("Usuario").Value;
    Correo= document.getElementById("Correo").Value;
    Clave= document.getElementById("Clave").Value;
	expression = /\w+@\w+.+[a-z]/;

    if(Nombre === "" || A_Paterno === "" || Usuario === "" || Correo === "" || Clave === ""){
		alert("Favor de poner sus datos");
		return false;
    }
  
    else if (Nombre.length>35){
		alert("El nombre es muy largo");
		return false;
	}
	else if (A_Paterno.length>20){
		alert("El apellido es muy largo");
		return false;
	}
	else if(Usuario.length>10){
		alert("El usuario es muy largo");
		return false;
	}
	else if (Correo.length>50){
		alert("El correo debe contener un @");
	}
	else if (Clave.length>20){
		alert("La clave es incorrecta");
	}
	else if(!expresion.test(correo)){
		alert("El Correo No es Valido");
		return false;
	}

} 
