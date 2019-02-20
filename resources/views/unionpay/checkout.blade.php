@extends('app')

@section('style')
    <script src="https://use.fontawesome.com/ca34b832d5.js"></script>
    <title>Pay With UnionPay Credit Card</title>

    <style type="text/css">
        .payment-page{
            margin-top: 25px;
        }
        .payment-form {
            font-family: 'Montserrat', sans-serif;
            padding-bottom: 50px;
        }

        .payment-form.dark {
            background-color: #F6F6F6;
        }

        .payment-form .content {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.075);
        }

        .payment-form .block-heading {
            margin-bottom: 40px;
            padding-top: 20px;
            text-align: center;
        }

        .payment-form .block-heading p {
            max-width: 420px;
            margin: auto;
            text-align: center;
            opacity: 0.7;
        }

        .payment-form.dark .block-heading p {
            opacity: 0.8;
        }

        .payment-form .block-heading h1,
        .payment-form .block-heading h2,
        .payment-form .block-heading h3 {
            margin-bottom: 1.2rem;
            color: #3B99E0;
        }

        .payment-form form {
            max-width: 600px;
            margin: auto;
            padding: 0;
            border-top: 2px solid #5EA4F3;
            background-color: #FFFFFF;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.075);
        }

        .payment-form .title {
            font-size: 1em;
            font-weight: 600;
            margin-bottom: 0.8em;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .payment-form .products {
            padding: 25px;
            background-color: #F7FBFF;
        }

        .payment-form .products .item {
            margin-bottom: 1em;
        }

        .payment-form .products .item-name {
            font-size: 0.9em;
            font-weight: 600;
        }

        .payment-form .products .item-description {
            font-size: 0.8em;
            opacity: 0.6;
        }

        .payment-form .products .item p {
            margin-bottom: 0.2em;
        }

        .payment-form .products .price {
            font-size: 0.9em;
            font-weight: 600;
            float: right;
        }

        .payment-form .products .total {
            font-weight: 600;
            line-height: 1;
            margin-top: 10px;
            padding-top: 19px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .payment-form .payment-option {
            padding: 25px 25px 15px;
        }

        .payment-form .payment-option label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            color: #79818A;
        }

        .payment-form .payment-option button {
            font-weight: 600;
            margin-top: 0.6em;
            background: #ececec;
            color: #fff;
            background-color: #0069d9;
        }

        .payment-form .date-separator {
            margin-top: 5px;
            margin-right: 10px;
            margin-left: 10px;
        }

        @media (min-width: 576px) {
            .payment-form .title {
                font-size: 1.2em;
            }

            .payment-form .products {
                padding: 40px;
            }

            .payment-form .products .item-name {
                font-size: 1em;
            }

            .payment-form .products .price {
                font-size: 1em;
            }
        }
    </style>

@stop

@section('content')
    <div class="container">
      <main class="page payment-page">
        <section class="payment-form dark">
          <div class="container">
            <div class="block-heading">
              <h2>Order Overview !</h2>
            </div>
            <form method="POST" action="{{ route('checkout.payment.unionpay.process', [$order->id]) }}">
              <div class="products">
                @if(session()->has('message'))
                    <div class="alert alert-primary" role="alert">
                      {{ session('message') }}
                    </div>
                @endif

                <h3 class="title">Checkout</h3>
                <div class="item">
                  <span class="price">${{ $order->amount }}</span>
                  <p class="item-name">Noise-cancelling Headphones</p>
                  <p class="item-description">Bose QuietComfort 35 headphones are designed for profitibility and comfort.</div>
                <div class="total">Total<span class="price">${{ $order->amount }}</span></div>
              </div>
              <div class="payment-option">
                <h3 class="title">Pay With UnionPay Online Payment</h3>
                <span>@csrf</span>
                <div class="row">
                  <div class="form-group col-sm-12">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        Pay Now
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </section>
      </main>
    </div>
@stop
