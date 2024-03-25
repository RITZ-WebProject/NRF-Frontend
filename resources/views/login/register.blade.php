@extends('layouts.app')
@section('content')
<style>
  .card-body {
    line-height: 2;
  }
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

  <body style="background: #060000;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card text-white" style="background: #060000; border: none;">
            <div class="card-body">
              <h2 class="text-center mb-5">[sign up]</h2>
              <form action="{{route('customer.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                  <input type="text" name="customer_name" class="form-control" id="name" placeholder="Full Name" required>
                  {{$errors->first('customer_name')}}
                </div>
                <div class="mb-5">
                  <input type="email" name="email" class="form-control" id="email" placeholder="Email address" required>
                  {{$errors->first('email')}}
                </div>
                <div class="mb-5">
                  <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                  {{$errors->first('password')}}
                </div>
                <div class="mb-5">
                  <input type="tel" name="phone_number" class="form-control" id="phone" placeholder="Phone number" required>
                  {{$errors->first('phone_number')}}
                </div>
                <div class="mb-4">
                  <p class="text-white text-center" style="text-transform: uppercase;">by clicking on sign up, you agree to our <a href="{{ url('terms-conditions') }}" class="text-white"> Terms and conditions</a></p>
                </div>
                <div class="text-center">
                  <button type="submit" class="btn text-white" style="background: blue;">Sign Up</button>
                </div>
              </form>
              <p class="text-center" style="text-transform: uppercase; margin-top: 15px;">Already have an account? <a href="login" class="text-white">Log in here</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>

@endsection

@section('footer')
    
@endsection

