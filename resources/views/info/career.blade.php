@extends('layouts.app')
@section('content')
  <style>
    body {
      color: #fff;
    }
  </style>
</head>
<body style="background: blue;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="text-white" style="background: blue; border: none;">
          <div class="">
            @if($careers->count() > 0)
            <h2 class="text-center mb-5">[career]</h2>
              <p class="text-center text-white mb-5" style="font-size: 22px;">
                Career Opportunities:
                <ul>
                  @foreach($careers as $career)
                    <li>{{ $career->created_at }}</li>
                    <li><h2>{{ $career->title }}</h2></li>
                    <h3>Descriptions:</h3>
                    <li>{{ $career->description }}</li>
                    <h3>Requirements:</h3>
                    <li>{{ $career->requirements }}</li>
                    <br>
                    Send Resume or CV this mail::
                    <h4>{{ $career->email }}</h4> <hr>
                  @endforeach
                </ul>
              </p>
            @else
            <h2 class="text-center" style="padding-top: 100px">[career]</h2>
              <p class="text-center text-white" style="font-size: 22px;padding-top:100px;">
                We don't have any career opportunities at the moment. Come back later for more updates! :)
              </p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
