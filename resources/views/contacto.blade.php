
@extends('layout.application')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contacto</title>

    <link rel="stylesheet" href="/css/contacto.css">
    <link rel="stylesheet" href="/css/font-awesome.css">

    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/scriptcontacto.js"></script>
</head>
<body>
    <!--<div class="modal_Wrapp">
        <div class="mensaje_modal">
            <h3>Errores Encontrados</h3>
            <p>Escribe tu Nombre</p>
            <p>Ingrsa tu Correo</p>
            <p>Escribe tu Mensaje</p>
            <span id="btnClose">Cerrar</span>
        </div>
    </div>
-->
    <section class="form_wrap">

        <section class="contact_info">
            <section class="info_title">
            <span class="fa fa-user-circle"></span>
            <h2>INFORMACIÓsN<br>DE CONTACTO</h2>
            </section>   
            <section class="info_items">
            <p><span class="fa fa-envelope"></span>ernesto.jimenez@softtek.com</p>
            <p><span class="fa fa-mobile"></span>01-800-763-88-35</p>
            </section>
        </section>

        <form action="" class="form_contact">
            <h2>Mensaje</h2>
            <div class="user_info">
                <label for="names">Nombres *</label>
                <input type="text" id="names">

                <label for="phone">Telefono /celular</label>
                <input type="text" id="phone">

                <label for="email">E-Mail *</label>
                <input type="text" id="email">

                <label for="mensaje">Comentario*</label>
                <textarea  id="coment"></textarea>

                <input type="button" value="Enviar" id="btnSend">
            </div>
        </form>
    </section>
</body>
</html>                
@stop