@extends('layouts.app')
@section('content')
<style>
    .form-control::placeholder {
      text-align: center;
      text-transform: uppercase;
    }
    @media (max-width: 768px) {
        .desktop{
            padding: 0;
        }
        .test{
            padding: 20px;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            display: inline-block;
            margin-right: 10px;
        }
        li:hover {
            background-color: #d7d7e8; 
            color: #fff; 
        }
    }
    @media (min-width: 768px) {
        .desktop{
            padding-top: 70px;
        }
        .test{
            padding: 50px;
        }
        ul.dashboard-list li:hover {
            color: #fff; 
            border-left: 3px solid #fff; 
            border-bottom: 3px solid #fff;
        }
    }
</style>
<body style="background: blue">
    <div class="desktop row">
        <div class="col-sm-12 col-md-2 col-lg-2 p-5">
            <ul role="tablist" class="nav flex-column dashboard-list text-center">
                <ul role="tablist" class="nav flex-column dashboard-list">
                    <li><a href="{{ url('/account') }}" class="nav-link text-white">My Profile</a></li>
                    <li><a href="{{ url('/account') }}" class="nav-link text-white active">Orders</a></li>
                    <li><a href="{{ url('/signout') }}" class="nav-link text-white">logout</a></li>
                </ul>
            </ul>
        </div>
       <div class="col-sm-12 col-md-10 col-lg-10" style="background: #fff;height:600px;">
                <div class="card-body">
                    <form action="{{ route('update-profile') }}" method="POST">
                        @csrf
                        <div class="container">
                            <div class="col-md-5">
                                <h3 class="mb-4 text-center" style="color: black;">My Profile</h3>
                                <input type="text" class="form-control mb-4 text-center" id="name" name="name" value="{{$customer->customer_name}}" placeholder="Your Name" required>
                                <input type="tel" class="form-control mb-4 text-center" id="phoneNumber" name="phone" value="{{$customer->phone_primary}}" placeholder="Phone Number" required>
                                <input type="email" class="form-control mb-4 text-center" id="email" name="email" value="{{$customer->email}}" placeholder="Your Email" required>
                                <input type="password" class="form-control mb-4 text-center" id="oldPassword" name="oldpassword"  placeholder="Old Password" required>
                                <input type="password" class="form-control mb-4 text-center" id="newPassword" name="newPassword"  placeholder="New Password" required>
                                <div class="text-center">
                                    <button type="submit" class="btn text-white" style="background: blue;">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection
