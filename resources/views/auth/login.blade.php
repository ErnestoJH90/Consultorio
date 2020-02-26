@extends('layout.application')

@section('content')
<!DOCTYPE html>
  <html lang="es">
      <head>
          <title>Iniciar Sesión</title>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-with, user-scalable=no, initial-scale=1, maximun-scale=1, minimum-scale=1">
          <link rel="stylesheet" href="/css/login.css">
        </head>
<div class="#">
    <div class="#">
        <h1 style="color: #fff;">Inicio de Sesión</h1>
    </div>
    <div class="contorno">
        <div class="contorno">
            <div class="contorno ">
                <div class="sesion">Login</div>
                <div class="contorno">
                    <form class="contorno" role="form" method="POST" action="{{ route('users.login') }}">
                        {{ csrf_field() }}

                        <div class="input-50{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="input-50"></label>

                            <div class="input-50">
                                <input id="email" type="email" class="input-50" name="email" value="{{ old('email') }}" name="Email" placeholder="&#128231; Email">

                                @if ($errors->has('email'))
                                    <span class="input-50">
                                        <strong></strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="input-50{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="input-50"></label>

                            <div class="input-50">
                                <input id="password" type="password" class="input-50" name="password" name="password"  placeholder="&#128272; Password" >

                                @if ($errors->has('password'))
                                    <span class="input-50">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                        
                                    </label>
                                </div>
                            </div>
                        </div>

                        <center><div class="#">
                            <div class="#">
                            <button type="submit" class="ent" value="Entrar">
                                   <i class="ent">Entrar</i>                              
                                </button></center>
                                <p class="hola">¿Si no cuentas con una cuenta?<a href="{{ route('users.register') }}">Crear Cuenta</p></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
