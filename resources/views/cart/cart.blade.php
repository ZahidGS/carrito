@extends('layouts.app')

@section('content')
@inject('cart', 'App\Services\Cart')
<div class="container">

    @if ($cart->getContent()->count() > 0)

    <div class="input-group col-8 mx-auto">
        <span class="form-control bg-primary text-white">Producto</span>
        <span class="form-control bg-primary text-white col-2 text-center">Precio</span>
        <span class="form-control bg-primary text-white col-2 text-center">Stock</span>
        <span class="form-control bg-primary text-white col-2"></span>
    </div>
    @foreach ($cart->getContent() as $product)
    <div class="input-group col-8 mt-1 mx-auto">
        <span class="form-control">{{ $product->name }}</span>
        <span class="form-control col-2 text-center">$ {{ $product->price }}</span>
        <span class="form-control col-2 text-center">{{ $product->stock }}</span>
        <span class="form-control col-2"> <a href="{{ route('remove_product_from_cart', $product) }}"
                class="btn btn-danger btn-sm">Eliminar</a> </span>
    </div>
    @endforeach
    <div class="input-group col-8 mt-1 mx-auto">
        <span class="form-control"></span>
        <span class="form-control col-2 bg-secondary text-white">Total: $ {{ $cart->totalAmount() }}</span>
        <span class="form-control col-4"></span>
    </div>

    @if($cart->hasProducts())
    <div class="row">
        <div class="col-1 my-2 mx-auto">
            <form method="POST" action="{{ route('process_checkout') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    {{ __("Pagar") }}
                </button>
            </form>
        </div>
    </div>
    @endif
    @else
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Carrito vacío</h4>
        <p>Pase a productos y seleccione sus productos a comprar.</p>
        <hr>
        <a class="btn btn-success" href="{{ route('home') }}">Productos</a>
    </div>
    @endif
</div>

@endsection
