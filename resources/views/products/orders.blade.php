@extends('layouts.app')

@section('content')
<div class="container">

    @if ($orders->count() > 0)

    <div class="input-group col-8 mx-auto">
        <span class="form-control bg-primary text-white">Fecha de compra</span>
        <span class="form-control bg-primary text-white col-2 text-center">Status</span>
        <span class="form-control bg-primary text-white col-2 text-center">Total</span>
    </div>
    @foreach ($orders as $order)
    <div class="input-group col-8 mt-1 mx-auto">
        <span class="form-control">{{ $order->created_at->format('Y-m-d') }}</span>
        <span class="form-control col-2 text-center">{{ $order->paid }}</span>
        <span class="form-control col-2 text-center">$ {{ $order->total_amount }}</span>
        <span class="d-none">$ {{ $suma += $order->total_amount }}</span>
    </div>
    @endforeach
    <div class="input-group col-8 mt-1 mx-auto">
        <span class="form-control"></span>
        <span class="form-control col-2 bg-secondary text-white">Total: $ {{ $suma }}</span>
    </div>


    @else
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Sin compras</h4>
        <p>Pase a productos y seleccione sus productos a comprar.</p>
        <hr>
        <a class="btn btn-success" href="{{ route('home') }}">Productos</a>
    </div>
    @endif
</div>

@endsection
