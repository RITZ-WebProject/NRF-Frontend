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
                    <li><a href="{{ url('/account') }}" class="nav-link text-white">Addresses</a></li>
                    <li><a href="{{ url('/signout') }}" class="nav-link text-white">logout</a></li>
                </ul>
            </ul>
        </div>
        
        <div class="col-sm-12 col-md-10 col-lg-10" style="background: #fff;height:600px;">
            <div class="card-body">
                <div class="tab-pane text-black test" id="address">
                    <h3 class="billing-address text-black" style="color: black;">Billing address</h3>
                    <h6 class="mb-4 text-black" style="color: black;">-- The following address will be used on the checkout page by default.</h6>
                        <div class="login">
                            <div class="login_form_container">
                                <div class="account_login_form">
                                    <form action="{{route('storeAddress')}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select class="form-control mb-4" name="country_id" id="countryDropdown" onchange="toggleDivisionInput()">
                                                    <option selected> Select Country </option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->name }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control mb-4" name="division_id_select" id="divisionDropdown" disabled>
                                                    <option selected> Select State/Division </option>
                                                    @foreach($divisions as $division)
                                                        <option value="{{ $division->id }}">{{ $division->division_name }}</option>
                                                    @endforeach
                                                </select>
                                                <input type="text" name="division_id_input" class="form-control mb-4" id="divisionInput" placeholder="Enter Your Division" style="display: none;">
                                            </div>
                                          </div>
                                          <div class="row ">
                                            <div class="col-md-6">
                                                <select class="form-control mb-4" name="district_id_select" id="districtDropdown">
                                                    <option selected> Select District </option>
                                                </select>
                                                <input type="text" name="district_id_input" class="form-control mb-4" id="districtInput" placeholder="Enter Your District" style="display: none;">
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-control mb-4" name="township_id_select" id="townshipDropdown">
                                                    <option selected> Select Township </option>
                                                </select>
                                                <input type="text" name="township_id_input" class="form-control mb-4" id="townshipInput" placeholder="Enter Your Township" style="display: none;">
                                            </div>
                                          </div>
                                          <div class="row ">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control mb-4" id="home-no" placeholder="Home no." name="home_no" required >
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control mb-4" id="street" placeholder="Street name" name="street_name"   required >
                                            </div>
                                          </div>
                                        <div class="text-center text-white">
                                            <button type="submit" class="btn text-white" style="background: blue;">Save Changes</button>
                                          </div>
                                    </form>
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