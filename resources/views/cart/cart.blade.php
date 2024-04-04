@extends('layouts.app')
@section('content')

    <style>
        .container {
            padding-top: 20px;
            max-width: 900px;
            margin: 0 auto;
            color: white;
        }
        .cart-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        display: block;
        margin: 0 auto;
        }
        .coupon-card {
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
        .coupon-card * {
            text-align: right;
        }
        .cart-product-name, .cart-size, .cart-price {
            text-align: center;
        }
        a.btn.text-white {
            background-color: #1620a8;
            transition: background-color 0.3s ease, color 0.3s ease; /* Add a transition effect */
        }
        
    @media (min-width: 768px) {
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
    }

    @media (max-width: 767px) {
        .cart-item {
            border-bottom: 2px solid blue;
            padding-bottom: 10px;
            padding-top: 20px;
        }
    }
    </style>
    <div class="container">
        @php 
            $cart = \Cart::getContent()->sort();
        @endphp
        @if ($message = Session::get('success'))
                <div class="p-4 mb-3 rounded" style="background: #90EE90">
                    <p class="text-dark">{{ $message }}</p>
                </div>
        @endif
        @if (!$cart->isEmpty())
        <div class="d-none d-md-flex justify-content-between pb-5 pl-3 pr-5">
            <div>CART</div>
            <div>PRICE</div>
        </div>
        @endif
        @if($cart->isEmpty())
        <h4 class="text-center" style="padding-top:100px;padding-bottom:100px;">
            Your cart is empty. Please add items to proceed.
            <a href="{{ url('/shop') }}">Click Here!!!</a>
        </h4>
        @endif

        @if ($cart)
        @foreach ($cart as $carts)

        {{-- <img class="primary-img" src="{{ json_decode($products->photo)[0] }}" class="w-100" alt="Product Photo" id="item-image"> --}}
        @php $photoArray = json_decode($carts->attributes['photo'], true); @endphp
        <div class="cart-item">
            <div class="position-relative">
                <img src="{{ $photoArray[0] ?? ''}}" alt="Product" class="cart-image">
                <div class="position-absolute top-0 end-0 mt-0 me-2 d-block d-md-none">
                    <a href="{{ route('cart.remove', ['id' => $carts->id]) }}">
                        <i class="fa fa-times text-white" style="font-size: 19px;"></i>
                    </a>
                </div>
            </div>
            <div class="cart-product-name">{{ $carts->name }}</div>
            <div class="cart-size">{{ $carts->attributes['size'] }}</div>
            <div class="d-md-none cart-price">
                {{ number_format($carts->price, 0, ',') }} MMK
            </div>
            <div class="cart-price d-flex justify-content-between">
                <div class="d-none d-md-flex">
                    {{ number_format($carts->price, 0, ',') }} MMK
                </div>
                <div class="ml-5 d-none d-md-flex">
                    <sup>
                        <sup><a href="{{ route('cart.remove', ['id' => $carts->id]) }}"><i class="fa fa-xmark text-white" style="font-size: 19px;"></i></a></sup>
                    </sup>
                </div>
            </div>
        </div>
        
        @endforeach
        @endif
    </div>

    <!--coupon code area start-->
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <!-- Content on the left for desktop -->
            </div>
            @if (!$cart || $cart->isEmpty())
            @else
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="coupon-card">
                        <div class="coupon-content text-center text-md-right">
                            <div class="d-none d-md-flex justify-content-md-end">
                                <h4>Subtotal</h4>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Heading and value container -->
                                <div>
                                    <h4 class="d-md-none">Subtotal</h4>
                                </div>
                                <div class="text-white" style="font-size: 23px;">
                                    {{ number_format(Cart::getTotal(), 0, ',') }} MMK
                                </div>
                            </div>
                            <a href="{{url('/checkout')}}" class="btn text-white text-center text-md-right d-block d-md-inline-block d-none d-md-flex justify-content-md-end">
                                Proceed to Checkout
                            </a>
                            <a href="{{url('/checkout')}}" class="btn text-white text-center text-md-right d-block d-md-inline-block d-md-none">
                                Proceed to Checkout
                            </a>
                            <p class="text-white">We accept the following payment methods:</p>
                            <div class="d-flex justify-content-center justify-content-md-end">
                                <img src="{{ asset('assets/img/logo/kpay.png') }}" alt="Payment Logo" width="50px" height="50px">
                                <img src="{{ asset('assets/img/logo/master.jpg') }}" alt="Payment Logo" width="70px" height="50px">
                                <img src="{{ asset('assets/img/logo/card.jpg') }}" alt="Payment Logo" width="70px" height="50px">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
@endsection
@section('footer')
@include('layouts.footer', ['footerColor' => 'blue'])
@endsection