

@extends('layout.application')

@section('content')
<div class="container">
   
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="/images/corazon.JPG" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="/images/frecuencia.jpg" alt="Chicago" style="width:100%;">
      </div>
       <div class="item">
        <img src="/images/esqueleto.jpg" alt="" style="width:100%;">  
      </div>
   
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

   
    <div class="container text-center">
        <div id="products">
            <br><br><br><br><br><br>

            @foreach ($products as $product)
                <div class="product white-panel" style="height: 496px !important;">
                    <h3>{{ $product->name }}</h3>
                    <img src="{{ asset('images/products/' . $product->image) }}" class="img-responsive img-shirt">
                    <div class="product-info">
                        <p>{{ $product->extract }}</p>
                        <h3><span class="label label-success">Precio: ${{ $product->price }}</span></h3>
                        <p>
                            <a href="{{ route('cart.add', $product->slug) }}" class="btn btn-lg btn-block btn-outline-primary"><i class="fa fa-cart-plus"></i> Adquirir </a>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary"> <i class="fa fa-chevron-circle-right"></i> Leer mas</a>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</br>
@stop