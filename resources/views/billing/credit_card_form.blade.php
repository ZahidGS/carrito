@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mx-auto" style="width: 30rem;">
        <h5 class="card-header">Registro de tarjeta en Stripe</h5>
        <div class="card-body">
            <form role="form" action="{{ route('billing.process_credit_card') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="card_number">{{ __("Número de la tarjeta") }}</label>
                    <div class="input-group">
                        <input type="text" name="card_number" placeholder="{{ __("Número de la tarjeta") }}"
                            class="form-control" required value="{{
                            old('card_number') ?
                            old('card_number') :
                            (auth()->user()->card_last_four ? '************' . auth()->user()->card_last_four : null)
                        }}" />
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-cc-visa mx-1">VISA o </i>
                                <i class="fa fa-cc-mastercard mx-1">MASTERCARD</i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>
                                <span class="hidden-xs">{{ __("Fecha expiración") }}</span>
                            </label>
                            <div class="input-group">
                                <input type="number" placeholder="{{ __("MM") }}" name="card_exp_month"
                                    class="form-control" required />
                                <input type="number" placeholder="{{ __("YY") }}" name="card_exp_year"
                                    class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group mb-4">
                            <label>CVC</label>
                            <input type="text" name="cvc" required class="form-control">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block rounded-pill shadow-sm">
                    Guardar tarjeta
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
