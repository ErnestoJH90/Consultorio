@extends('layout.application')

@section('content')
<!DOCTYPE html>
  <html lang="es">
      <head>
          <meta charset="UTF-8">
          <title>Register</title>
          <link rel="stylesheet" href="/css/register.css">
      <script language="JavaScript" type="/text/javascript" src="/js/validarreg.js"></script>
       </head> 
  </html>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="cue">Register</div>
                <div class="panel-body">
                    <form class="form-register" role="form" method="POST" action="{{ route('users.register') }}">
                        {{ csrf_field() }}

                        <div class="input-48{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="input-48"></label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" name="Nombre" placeholder="Nombre" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="input-482{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="input-482"></label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" name="A_Paterno" placeholder="Apellido" required>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="input-100{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username" class="input-100"></label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}"name="Usuario"   placeholder="&#128587; Usuario"   required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn-registrar">
                                    <i class="fa fa-btn fa-user"></i> Register
                                </button>
                            </div>
                        </div>
                        <div class="input-100{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="input-100"></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" name="Correo Electronico" placeholder="&#128231; Correo Electronco" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       

                         <div class="input-100{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="input-100"></label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ old('address') }}"name="Dirección" placeholder="&#128231; Dirección" required>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="input-48{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="input-48"></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" name="Clave"placeholder="&#128272; Contraseña">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="input-481{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="input-481"></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"name="Clave" placeholder="&#128272; Confirmar">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <p class="link">¿Ya cuentas con una cuenta?<a href="{{ route('users.login') }}">Iniciar Sesión</p></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
