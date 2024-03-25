@extends('layouts.app')
@section('content')
<style>
    body {
      color: #fff; /* Set your desired text color */
      padding:100px 0 0;
    }
 img{
        border-radius: 5px;
        margin:2px;
    }

    @media (max-width: 600px) {
        img{
        margin:8px;
    }
    }
  </style>
</head>
<body style="background: #000;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-white" style="background: #000; border: none;">
          <div class="card-body">
            <h2 class="text-center mb-5">[Payment Methods]</h2>
            <p class="text-center text-white mb-5" style="font-size: 20px;">
                <img src="{{ asset('assets/img/logo/kpay.png') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/money.jpeg') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/AYA-Pay.png') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/one-pay.png') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/mpu.jpeg') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/citiz.png') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/easy-pay.png') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/jcb.jpeg') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/ok.jpeg') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/saisai.jpeg') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/m-money.png') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/mytel.jpeg') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/mab.png') }}" alt="Payment Logo" width="50px" height="50px">
                <img src="{{ asset('assets/img/logo/master.jpg') }}" alt="Payment Logo" width="70px" height="50px">
                <img src="{{ asset('assets/img/logo/A-bank.jpeg') }}" alt="Payment Logo" width="70px" height="50px">
                <img src="{{ asset('assets/img/logo/card.jpg') }}" alt="Payment Logo" width="70px" height="50px">
                <img src="{{ asset('assets/img/logo/kbz-bank.png') }}" alt="Payment Logo" width="70px" height="50px">

                <img src="{{ asset('assets/img/logo/uab.jpeg') }}" alt="Payment Logo" width="70px" height="50px">
                <img src="{{ asset('assets/img/logo/true-money.png') }}" alt="Payment Logo" width="70px" height="50px">
                <img src="{{ asset('assets/img/logo/CB.png') }}" alt="Payment Logo" width="70px" height="50px">
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
