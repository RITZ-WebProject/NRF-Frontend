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
                    <li><a href="#account-details" data-bs-toggle="tab" class="nav-link active text-white">My Profile</a></li>
                    <li><a href="#orders" data-bs-toggle="tab" class="nav-link text-white">Orders</a></li>
                    <li><a href="#address" data-bs-toggle="tab" class="nav-link text-white">Addresses</a></li>
                    <li><a href="{{url('/signout')}}" class="nav-link text-white">logout</a></li>
                </ul>
        </div>
        <div class="col-sm-12 col-md-10 col-lg-10" style="background: #fff;height:600px;">
            <div class="tab-content dashboard_content">
                <div class="tab-pane fade test" id="orders">
                    <h3 class="text-black">Order History</h3>
                    <div class="lion_table_area table-responsive">
                        <table class="table">
                            <thead class="text-white" style="background: #000">
                                <tr>
                                    <th style="text-align:center">Order</th>
                                    <th style="text-align:center">Download</th>
                                    <th style="text-align:center">Date</th>
                                    <th style="text-align:center">Total Price (MMK)</th>
                                    <th style="text-align:center">Status</th>
                                    <th style="text-align:center">View</th>

                                </tr>
                            </thead>
                            <tbody class="text-black">
                                @php $i=1;
                                @endphp

                                @foreach($invoices as $order)
                                    <tr class="align-middle">
                                        <td class="text-black">{{$i}}</td>
                                        <td><a href="invoice/{{$order->id}}" class="view" style="color: #0000ff"> <i class="fa fa-download"></i>   Your Invoice</a></td>
                                        <td class="text-black">{{date('d-m-Y', strtotime($order->created_at))}}</td>
                                        <td class="text-black">{{number_format($order->total_price, 0, ',')}}</td>
                                        <td class="text-black">
                                            @if ($order->status == 'pending')
                                            <span style="color:#FFC000">{{$order->status}}</span>
                                            @elseif ($order->status == 'success')
                                            <span style="color:#7CFC00">{{$order->status}}</span>
                                            @elseif ($order->status == 'delivering')
                                            <span style="color:#0D6EFD">{{$order->status}}</span>
                                            @else
                                            <span style="color:#FF0000">{{$order->status}}</span>
                                            @endif
                                        </td>

                                        <td><a href="order_details/{{$order->id}}" style="color: #0000ff;"><i class="fa fa-eye"></i></a></td>

                                    </tr>
                                @php $i++ @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="downloads" >
                    <h3>Downloads</h3>
                    <div class="lion_table_area table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Downloads</th>
                                    <th>Expires</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->id }}</td>
                                    <td>May 10, 2018</td>
                                    <td><span class="danger">Expired</span></td>
                                    <td><a href="/invoice/{{$invoice->id}}" class="view">Click Here To Download Your File</a>
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="tab-pane text-black test" id="address">
                    <h3 class="billing-address">Billing address</h3>
                    <h6 class="mb-4">-- </h6>
                    <div class="login">
                        <div class="login_form_container">
                            <div class="account_login_form">
                                <div class="container">
                                    <div class="col-md-5">
                                        <div class="address-info">
                                            <p class="text-dark mb-2"><strong>Country:</strong> {{$addresses->name}}</p>
                                            <p class="text-dark mb-2"><strong>Division:</strong> {{$addresses->division_name}}</p>
                                            <p class="text-dark mb-2"><strong>District:</strong> {{$addresses->district_name}}</p>
                                            <p class="text-dark mb-2"><strong>Township:</strong> {{$addresses->township_name}}</p>
                                            <p class="text-dark mb-2"><strong>Street:</strong> {{$addresses->street_name}}</p>
                                            <p class="text-dark mb-2"><strong>Home No:</strong> {{$addresses->home_no}}</p>
                                        </div>
                                        <a href="address/">
                                            <button class="btn btn-sm text-uppercase text-white" style="background: #0000ff;">
                                                <i class="fa fa-pencil"></i> Edit Address
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active test" id="account-details">
                    <div class="login">
                        <div class="login_form_container">
                            <div class="account_login_form">
                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            @if(session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            @if(session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                            @endif

                                            <div class="card-body text-center">
                                                <div class="container">
                                                    <div class="col-md-5">
                                                        <h3>My Profile</h3>
                                                        <img src="{{ asset('assets/img/NRF/user.png') }}" class="img-lg rounded-circle mb-2" width="92px" height="92px" alt="profile image"/>
                                                        <h4>{{$account->customer_name}}</h4>
                                                        <p class="text-dark mb-2" style="font-weight:bold">{{$account->email}}</p>
                                                        <p class="text-dark mb-2" style="font-weight:bold">{{$account->phone_primary}}</p>
                                                        <a href="account/{{ $account->id }}">
                                                            <button class="btn btn-sm  text-uppercase text-white text-center" style="background: #0000ff;"><i class="fa fa-pencil "></i> Edit Profile</button>
                                                        </a>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
@section('script')
        function toggleDivisionInput() {
            var countryDropdown = document.getElementById('countryDropdown');
            var divisionDropdown = document.getElementById('divisionDropdown');
            var divisionInput = document.getElementById('divisionInput');
            var districtDropdown = document.getElementById('districtDropdown');
            var townshipDropdown = document.getElementById('townshipDropdown');
            
            if (countryDropdown.value === 'Myanmar') {
                divisionDropdown.disabled = false;
                divisionDropdown.style.display = 'block';
                divisionInput.style.display = 'none';
                
                districtDropdown.disabled = false;
                districtDropdown.style.display = 'block';
                districtInput.style.display = 'none';

                townshipDropdown.disabled = false;
                townshipDropdown.style.display = 'block';
                townshipInput.style.display = 'none';
            } else {
                divisionDropdown.disabled = true;
                divisionDropdown.style.display = 'none';
                divisionInput.style.display = 'block';
                
                districtDropdown.disabled = true;
                districtDropdown.style.display = 'none';
                districtInput.style.display = 'block';

                townshipDropdown.disabled = true;
                townshipDropdown.style.display = 'none';
                townshipInput.style.display = 'block';
            }
        }
            // Add an event listener to the country dropdown
            $("#countryDropdown").change(function () {
                toggleDistrictInput();
            });
                    // Add an event listener to the division dropdown
                    $("#divisionDropdown").change(function () {
                        var division_id = $(this).val();
                        
                        if (division_id) {
                            $.ajax({
                                type: "GET",
                                url: "{{ url('getDistrict') }}?division_id=" + division_id,
                                success: function (res) {
                                    if (res) {
                                        $("#districtDropdown").empty();
                                        $("#districtDropdown").append('<option value="">Select District</option>');
                                        $.each(res, function (key, value) {
                                            $("#districtDropdown").append('<option value="' + key + '">' + value + '</option>');
                                        });
                                    } else {
                                        $("#districtDropdown").empty();
                                    }
                                },
                            });
                        } else {
                            $("#districtDropdown").empty();
                        }
                    });
                    
                // Add an event listener to the country dropdown
                $("#countryDropdown").change(function () {
                    toggleDivisionInput();
                    $("#divisionDropdown").trigger("change");
                });
                // Add an event listener to the district dropdown
                $("#districtDropdown").change(function () {
                    var district_id = $(this).val();
                    
                    if (district_id) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('getTownship') }}?district_id=" + district_id,
                            success: function (res) {
                                if (res) {
                                    $("#townshipDropdown").empty();
                                    $("#townshipDropdown").append('<option value="">Select Township</option>');
                                    $.each(res, function (key, value) {
                                        $("#townshipDropdown").append('<option value="' + key + '">' + value + '</option>');
                                    });
                                } else {
                                    $("#townshipDropdown").empty();
                                }
                            },
                        });
                    } else {
                        $("#townshipDropdown").empty();
                    }
                }); 
            
                $(document).ready(function() {
                    $('[data-toggle="popover"]').popover();
                    
                    function updateDeliveryAddress() {
                        var country = $("#countryDropdown option:selected").text();
                        var division = $("#divisionDropdown").is(":visible") ? $("#divisionDropdown").find("option:selected").text() : $("#divisionInput").val();
                        var district = $("#districtDropdown").is(":visible") ? $("#districtDropdown").find("option:selected").text() : $("#districtInput").val();
                        var township = $("#townshipDropdown").is(":visible") ? $("#townshipDropdown").find("option:selected").text() : $("#townshipInput").val();
                        var streetName = $("#street").val();
                        var homeNo = $("#home-no").val();
                        
                        var deliveryAddress = homeNo + ", " + streetName + ", " + township + ", " + district + ", " + division + ", " + country;
                        
                        $("#address").val(deliveryAddress);
                    }
                    
                    $("#countryDropdown, #divisionDropdown, #districtDropdown, #townshipDropdown, #street, #home-no").on("change input", function() {
                        updateDeliveryAddress();
                    });
                    
                    // Add change event listener to the country dropdown for toggling input fields
                    $("#countryDropdown").on("change", function() {
                        toggleFields();
                    });
                    
                    // Initial call to toggleFields to set the initial state
                    toggleFields();
                    
                    // Function to toggle the visibility of division, district, and township fields based on the selected country
                    function toggleFields() {
                        var selectedCountry = $("#countryDropdown option:selected").text();
                        
                        // Reset input fields
                        $("#divisionInput, #districtInput, #townshipInput").val("");
                        
                        if (selectedCountry === "Myanmar") {
                            $("#divisionDropdown, #districtDropdown, #townshipDropdown").show();
                            $("#divisionInput, #districtInput, #townshipInput").hide();
                        } else {
                            $("#divisionDropdown, #districtDropdown, #townshipDropdown").hide();
                            $("#divisionInput, #districtInput, #townshipInput").show();
                        }
                        
                        // Trigger an immediate update of the delivery address
                        updateDeliveryAddress();
                    }
                });  
@endsection

