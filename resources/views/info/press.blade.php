@extends('layouts.app')
@section('content')
  <style>
    body {
      color: #fff;
      padding: 100px 0 0;
    }
  </style>
</head>
<body style="background: blue;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card text-white" style="background: blue; border: none;">
          <div class="card-body text-center">
            <h2 class="mb-4">[press]</h2>
            <img src="{{ asset('/assets/img/lttv/press.jpg') }}" class="mx-auto mb-4" style="object-fit: cover; width: 300px;" height="200vh" alt="Image" />
            <p class="mb-4 text-white">NRF on Vice News</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
