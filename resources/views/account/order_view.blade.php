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
                    <li><a href="{{ url('/account') }}" class="nav-link text-white">My Profile</a></li>
                    <li><a href="{{ url('/account') }}" class="nav-link text-white active">Orders</a></li>
                    <li><a href="{{ url('/signout') }}" class="nav-link text-white">logout</a></li>
            </ul>
        </div>
        <div class="col-sm-12 col-md-10 col-lg-10" style="background: #fff;height:600px;">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Item Summary</th>
                                            <th>Size</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total Price
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i = 1;
                                        @endphp
                                        @foreach ($order_details as $detail)
                                        	@php $photoArray = explode("'x'", $detail->product->photo); @endphp
                                            <tr class="align-middle">
                                                <td>{{ $i++ }}</td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <img src="{{ env('PHOTO_URL').$photoArray[0] }}" width="100px" height="100px" alt="" class="rounded">
                                                        </div>
                                                        <div class="col-sm-9 my-auto">
                                                            {{ $detail->product->product_name ?? '' }}

                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="text-uppercase">{{ $detail->size . " Size" }}</span></td>
                                                <td>{{ number_format($detail->price, 0, ',') }}</td>
                                                <td> x 1</td>
                                                <td>{{ number_format($detail->price, 0, ',') }} MMK </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
</section>
@endsection
