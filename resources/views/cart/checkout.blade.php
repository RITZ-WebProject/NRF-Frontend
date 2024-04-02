@extends('layouts.app')
@section('content')
    <style>
        .checkout-card {
            background-color: #000;
            color: white;
        }
    </style>
    <div class="container mt-5" style="background: #000;">
        <form id="order-form" action="{{ route('order.store') }}" method="POST">
            @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card checkout-card">
                    <div class="card-body">
                        <h5 class="card-title">Billing and Shipping Information</h5>
                        <form>
                            <div class="row">
                                <!-- <div class="col-md-12 d-flex"> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fullName">Full Name</label>
                                            <input type="text" name="recipient_name" class="form-control" id="fullName" value="{{$customer->customer_name ?? ''}}" placeholder="Enter your full name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone-no">Phone Number</label>
                                            <input type="text" name="recipient_phone" value="{{$customer->phone_primary ?? ''}}" class="form-control" id="fullName" placeholder="Enter your full name">
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <select class="form-control" name="country_id" id="countryDropdown" onchange="toggleDivisionInput()">
                                            <option value="" {{ $customer->country_id == '' ? 'selected' : '' }}>Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->name }}" {{ $customer->country_id == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">State/Division</label>
                                        <select class="form-control" name="division_id_select" id="divisionDropdown" disabled>
                                            <option value="" {{ $customer->division ? ($customer->division->division_name == '' ? 'selected' : '') : '' }}>Select State/Division</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}" {{ $customer->division ? ($customer->division->division_name == $division->division_name ? 'selected' : '') : '' }}>{{ $division->division_name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="division_id_input" value="{{ $customer->division ? $customer->division->division_name : '' }}" class="form-control" id="divisionInput" placeholder="Enter Your Division" style="{{ $customer->division ? 'display: none;' : '' }}">
                                    </div>

                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select class="form-control" name="district_id_select" id="districtDropdown">
                                            <option value="">Select District</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->id }}" {{ $customer->district && $customer->district->district_name == $district->district_name ? 'selected' : '' }}>{{ $district->district_name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="district_id_input" class="form-control" value="{{ $customer->district ? $customer->district->district_name : '' }}" id="districtInput" placeholder="Enter Your District" style="{{ $customer->district ? 'display: none;' : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="township">Township</label>
                                        <select class="form-control" name="township_id_select" id="townshipDropdown">
                                            <option value="">Select Township</option>
                                            @foreach($townships as $township)
                                                <option value="{{ $township->id }}" {{ $customer->township && $customer->township->township_name == $township->township_name ? 'selected' : '' }}>{{ $township->township_name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="township_id_input" class="form-control" value="{{ $customer->township ? $customer->township->township_name : '' }}" id="townshipInput" placeholder="Enter Your Township" style="{{ $customer->township ? 'display: none;' : '' }}">
                                    </div>

                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <!-- <div class="col-md-12 d-flex"> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="street">Street Name</label>
                                            <input type="text" class="form-control" value="{{ $customer->street_name ?? ''}}" id="street" placeholder="Enter your Street name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="home-no">Home No</label>
                                            <input type="text" class="form-control" value="{{ $customer->home_no ?? ''}}" id="home-no" placeholder="Enter your Home number" required>
                                        </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Delivery Address</label>
                                            <textarea class="form-control" name="address" id="address" cols="61" rows="0" placeholder="Select Country,Select Division,Select District,Select Township,Fill street,Fill home"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card checkout-card">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
                        <table class="table table-bordered text-white">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($cart)
                                    @foreach($cart as $carts)
                                    <tr>
                                        <td class="product-name"> {{$carts['name']}}  <strong></strong></td>
                                        <td> x 1</td>
                                        <td><span class="text-uppercase">{{ $carts->attributes['size']}}</span></td>
                                        <td class="amount"> {{number_format($carts['price'],0,',')}} MMK</td>
                                    </tr>
                                    @endforeach
                                @else
                                @endif
                            </tbody>
                        </table>
                        <footer class="container mt-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <!-- Subtotal -->
                                    <div class="form-group">
                                        <label for="subtotal">Subtotal</label>
                                        <input type="text" class="form-control" id="subtotal" value="{{number_format($total,0,',')}}" readonly>
                                    </div>
                                </div>
                            </div>
                        </footer>
                        <br>
                        <button id="place-order-btn" type="submit" style="background: #180ada;" class="btn text-black btn-block">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!--Checkout page section end-->
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
@section('footer')
@include('layouts.footer', ['footerColor' => 'blue'])
@endsection