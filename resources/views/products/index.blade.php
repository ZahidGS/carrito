@extends('layouts.app')

@section('content')
<div class="container">

    @if (asset($products))
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($products as $product)

                <div class="col mb-3">
                    <div class="card">
                        <img src="/storage/images/products/{{ $product->picture }}" class="card-img-top img-fluid" alt="...">
                        <div class="card-body">
                            <h2 class="card-title">$ {{ $product->price }}</h2>
                            <h3 class="card-title">Producto: {{ $product->name }}</h3>
                            <p class="card-text">Stock: {{ $product->stock }}</p>
                            <a href="{{ route('add_product_to_cart', $product) }}" class="btn btn-primary">Agregar al carrito</a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    @else
    <div class="alert alert-danger" role="alert">
        No hay productos en la tienda!
    </div>
    @endif


</div>
@endsection
