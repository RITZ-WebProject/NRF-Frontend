@extends('layouts.app')

@section('content')
    <!-- contact us area -->
    <style>
        body {
          background-color: #060000; /* Set your desired background color */
          color: #fff; /* Set your desired text color */
          padding: 10px 0 0;
        }
    </style>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-white" style="background: #060000; border: none;">
                    <div class="card-body">
                        <h2 class="text-center mb-5">[Contact Us]</h2>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('contact-us.submit') }}" method="POST">
                            @csrf
                            <div class="mb-5">
                                <div class="row">
                                    <div class="col-md-6 mb-5 mb-md-0">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Your Email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                            </div>
                            <div class="mb-5">
                                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn text-white" style="background: blue;">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
