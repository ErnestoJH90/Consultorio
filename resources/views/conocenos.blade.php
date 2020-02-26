
@extends('layout.application')

@section('content')

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/quienessomos.css">
        <title>¿Quiénes somos?</title>
    </head>
<body>
    <h1><center>¿Quiénes Somos?</center></h1>
        <img class="acoltzi" src="\images\citaonline.PNG" onmouseover="this.width=250; this.height=150;" onmouseout="this.width=276;this.height=183;" width="276" height="183 /">
        <img src="/images/citaonline.PNG" id="karla" onmouseover="this.width=250; this.height=150;" onmouseout="this.width=276;this.height=183;" width="276" height="183 /">
        <h2 class="dr">Dr.Ignacio Acoltzi González</h2>
        <h2 class="dra">Dra.Karla Acoltzi González</h2>
    <h3><center>Misión</center></h3>
        <center>Brindar una atención médico-hospitalaria a nuestros pacientes y usuarios, con los más altos estándares de calidad<p>
            integral, buscando siempre su bienestar.</center>
            
    <h3><center>Visión</center></h3>
        <center>
        <p><br>Ser un centro médico de referencia, reconocido por sus atenciones de alta calidad,<br>
               diagnósticos acertados y tratamientos efectivos.<p></center>
       <!--
    <h3><center>Valores</center></h3>
        <input type="submit" disabled class="button" value="Respeto">
        <input type="submit" disabled class="button2" value="Lealtad">
        <input type="submit" disabled class="button3" value="Confianza">
        <input type="submit" disabled class="button4" value="Comunicación">
        <input type="submit" disabled class="button5" value="Responsabilidad">
-->
</body>
</html>                                    
@stop