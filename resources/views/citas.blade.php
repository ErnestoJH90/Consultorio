@extends('layout.application')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contacto</title>

    <link rel="stylesheet" href="/css/tabla.css">
    <link rel="stylesheet" href="/css/font-awesome.css">

    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/scriptcontacto.js"></script>
</head>
<table  border="1"  style="margin:22 auto;" class="tabla.css">

        <h1 id="titulo"> Citas Online </h1>
        <a href="login.html"><img src="images/Logo2ab.PNG" id="Logo2" alt="#"></a>

    <tr>
        
        <th>Nombre</th>
        <th>A_Paterno</th>
        <th>A_Materno</th>
        <th>Edad</th>
        <th>Sexo</th>
        <th>Celular</th>
        <th>Doctor(a)</th>
        <th> Fecha </th>
        <th> Hora </th>
        
    </tr>
    <tr>
        
        <td><input id="Nombre" type="text" placeholder="Nombre" name="Nombre"  required></td>
        <td><input id="A.Paterno" name="A_Paterno" placeholder="A_Paterno" required></td>
        <td><input id="A.Materno" name="A_Materno" placeholder="A_Materno" required></td>
        <td><input id="Edad" type="number" min="0" max="80" placeholder="Edad" name="Edad" required></td>
        <td><select id="Sexo" name="Sexo" required>
        <option></option>
        <option>M</option>
        <option>F</option>
        </select></td>
        <td><input id="Celular" type="number" class="" placeholder="ej:241-111-22-33" name="Celular" required></td>
        <td><select id="Doctor" name="Doctor(a)" required>
        <option></option>
        <option>Dr.Ignacio Acoltzi</option>
        <option>Dra.Karla Acoltzi</option>
        </select></td>
        <td><input id="date" type="date" class="" name="Date" required></td>
        <td><input id="time" type="time" class="" name="Time" required></td>
        
    </tr>

    <p class="adj">Adjuntar archivo: <br />  
        <input class="campos" type="file" name="archivo" size="20"></p> 
<input type="submit" class="button" value="&#128076;Hacer Cita">
<input type="reset"  class="button1" value="Cancelar">
</form>
</body>

</html>
@stop 