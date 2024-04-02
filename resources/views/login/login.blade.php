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
                    <h2 class="text-center mb-5">[log in]</h2>
                    <form action="{{route('authenticate')}}" method="POST">
                        @csrf
                      <div class="mb-5">
                        <input type="text" name="email" class="form-control" id="loginEmail" placeholder="email address or phone" required>
                        {{$errors->first('email')}}
                      </div>
                      <div class="mb-5">
                        <input type="password" name="password" class="form-control" id="loginPassword" placeholder="password" required>
                        {{$errors->first('password')}}
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn text-white" style="border: 1px solid #fff;">Login</button>
                      </div>
                    </form>
                    <p class="text-center" style="text-transform: uppercase; margin-top: 15px;">Don't have an account? <a href="{{url('/register')}}" class="text-white">Sign up here</a></p>
                    <p class="text-center" style="text-transform: uppercase; margin-top: 15px;">
                      <a href="{{ route('request') }}" class="text-white">Forgot your password?</a>
                  </p>

                  </div>
                </div>
              </div>
            </div>
          </div>
    </body>
@endsection
@section('footer')
    
@endsection
