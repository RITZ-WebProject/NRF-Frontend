


@extends('layouts.app')
@section('content')
<style>
    .form-control::placeholder {
      text-align: center; 
      text-transform: uppercase;
    }
  </style>
  
  @if(session('success'))
  <div class="alert alert-success">
      {{ session('success') }}
  </div>
  @endif
  
  @if(session('fail'))
  <div class="alert alert-danger">
      {{ session('fail') }}
  </div>
  @endif
  
  
    <body style="background:blue;">
        <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-4">
                <div class="card text-white" style="background: blue; border: none;">
                  <div class="card-body">
                    <h2 class="text-center mb-5">[send email]</h2>
                    <form action="{{ route('password.request') }}" method="GET">
                        @csrf
                        <div class="mb-5">
                            <input type="email" name="email" class="form-control" id="loginEmail" placeholder="email address" required>
                            {{ $errors->first('email') }}
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn text-white" style="border: 1px solid #fff;">Send</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </body>
@endsection
@section('footer')
    
@endsection
