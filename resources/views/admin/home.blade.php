@extends('admin.template')

@section('content')

    <div class="container text-center">
        <div class="page-header">
            <h1><i class="fa fa-rocket"></i> Sistema De Citas Medicas - Panel de Control</h1>
        </div>
        
        <h2>Bienvenido(a) {{ Auth::user()->name }} al Panel de administración Citas Medicas.</h2><hr>
        
        <div class="row">
            
            <div class="col-md-6">
                <div class="panel">
                    <i class="fa fa-list-alt icon-home"></i>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-warning btn-block btn-home-admin" id="categorias">CATEGORÍAS</a>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="panel">
                    <i class="fa fa-shopping-cart  icon-home"></i>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-warning btn-block btn-home-admin" id="categorias">PRODUCTOS</a>
                </div>
            </div>
                    
        </div>
        
        <div class="row">
            
            <div class="col-md-6">
                <div class="panel">
                    <i class="fa fa-cc-paypal  icon-home"></i>
                    <a href="#" class="btn btn-warning btn-block btn-home-admin" id="categorias">PEDIDOS</a>
                </div>
            </div> 
            
            <div class="col-md-6">
                <div class="panel">
                    <i class="fa fa-users  icon-home"></i>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-warning btn-block btn-home-admin" id="categorias">USUARIOS</a>
                </div>
            </div>
                    
        </div>
        
    </div>
    <hr>

@stop