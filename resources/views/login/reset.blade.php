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
    <body style="background:#0000ff;">
        <div class="container">
            <div class="row justify-content-center">
              <div class="col-md-4">
                <div class="card text-white" style="background: blue; border: none;">
                  <div class="card-body">
                    <h2 class="text-center mb-5">[reset password]</h2>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-5">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="new password" name="password" required autocomplete="new-password">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        <div class="mb-5">
                            <input type="password" name="password_confirmation" class="form-control" id="password-confirm" placeholder="confirm password" required autocomplete="new-password">
                            {{ $errors->first('password_confirmation') }}
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn text-white" style="border: 1px solid #fff;">Confirm</button>
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
