<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from htmldemo.net/tuoring/tuoring/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Mar 2023 03:31:28 GMT -->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <!-- Page Title -->
	<title>NRF</title>
	<!--Fevicon-->
	<link rel="icon" href="{{ asset('assets/img/icon/favicon2.ico') }}" type="image/x-icon" />
	<!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- font-awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- all css plugins css -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <!-- default style -->
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
    <!-- Main Style css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style_update.css') }}">
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>
<body class="bg-2">
	<!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- header area -->

    @include('layouts.navbar')

    <div class="content-wrapper">
        @yield('content')
    </div>

    {{-- @include('layouts.footer') --}}

    <!-- Quick View Content Start -->
    <div class="modal fade" id="quickk_view">
        <div class="container">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-5 mb-40">
                                <div class="shop-large-slider mb-30">
                                    <div class="pro-large-img">
                                        <img src="assets/img/shop/1.jpg" alt=""/>
                                    </div>
                                    <div class="pro-large-img">
                                        <img src="assets/img/shop/2.jpg" alt=""/>
                                    </div>
                                    <div class="pro-large-img">
                                        <img src="assets/img/shop/3.jpg" alt=""/>
                                    </div>
                                    <div class="pro-large-img">
                                        <img src="assets/img/shop/4.jpg" alt=""/>
                                    </div>
                                    <div class="pro-large-img">
                                        <img src="assets/img/shop/2.jpg" alt=""/>
                                    </div>
                                </div>
                                <div class="shop-nav">
                                    <div class="shop-nav-thumb"><img src="assets/img/shop/1.jpg" alt=""/></div>
                                    <div class="shop-nav-thumb"><img src="assets/img/shop/2.jpg" alt=""/></div>
                                    <div class="shop-nav-thumb"><img src="assets/img/shop/3.jpg" alt=""/></div>
                                    <div class="shop-nav-thumb"><img src="assets/img/shop/4.jpg" alt=""/></div>
                                    <div class="shop-nav-thumb"><img src="assets/img/shop/2.jpg" alt=""/></div>
                                </div>
                            </div>
                            <div class="col-lg-7 mb-40">
                                <div class="product-details-shop">
                                    <h3><a href="#">Products Name 003</a></h3>
                                    <div class="shop-list-price">
                                        <span class="shop-price">$130.00</span>
                                    </div>
                                    <div class="feature-btnn">
                                        <a href="#">see all feature</a>
                                    </div>
                                    <span class="aviablity mb-15"><i class="fa fa-check-circle"></i> 200 in stock</span>
                                    <div class="quantity-cart section">
                                        <div class="product-quantity">
                                            <input type="text" value="0">
                                        </div>
                                        <button class="add-to-cart">add to cart</button>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id</p>
                                    <div class="share-icons mt-40">
                                        <h3>share this product</h3>
                                        <ul>
                                            <li>
                                                <a href="#"><i class="fa fa-facebook-f"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-pinterest"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- scroll to top -->
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div> <!-- /End Scroll to Top -->


	<!-- all js include here -->
    <script src="{{asset('assets/js/vendor/modernizr-3.5.0.min.js')}}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="/assets/js/vendor/jquery-1.1/2.4.min.js"></script> --}}
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    {{-- <script src="/assets/js/plugins.js"></script> --}}
    <script src="{{asset('assets/js/ajax-mail.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAq7MrCR1A2qIShmjbtLHSKjcEIEBEEwM"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script src="{{asset('assets/js/stock-change.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"
    integrity="sha512-pdCVFUWsxl1A4g0uV6fyJ3nrnTGeWnZN2Tl/56j45UvZ1OMdm9CIbctuIHj+yBIRTUUyv6I9+OivXj4i0LPEYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    {{-- <script type="text/javascript" src="/assets/js/cart.js"></script> --}}
    <script type="text/javascript">

        //getDistrict
        $("#division_id").change(function () {
            var division_id = $(this).val();
            // console.log($("#division_id").val());
            if (division_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('getDistrict')}}?division_id=" + division_id,
                    success: function (res) {
                        console.log(res);
                        if (res) {
                            $("#district_id").empty();
                            $("#district_id").append(
                                '<option value="">Select District</option>'
                            );
                            $.each(res, function (key, value) {
                                console.log(value);
                                $("#district_id").append(
                                    '<option value="' + key + '">' + value + '</option>'
                                );
                            });
                        } else {
                            $("#district_id").empty();
                        }
                    },
                });
            } else {
                $("#division_id").empty();
                $("#district_id").empty();
            }
        });

        //getTwonship
        $("#district_id").change(function () {
            var district_id = $(this).val();
            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{url('getTownship')}}?district_id=" + district_id,
                    success: function (res) {
                        if (res) {
                            $("#township_id").empty();
                            $("#township_id").append(
                                '<option value="">Select Township</option>'
                            );
                            $.each(res, function (key, value) {
                                $("#township_id").append(
                                    '<option value="' + key + '">' + value + '</option>'
                                );
                            });
                        } else {
                            $("#township_id").empty();
                        }
                    },
                });
            } else {
                $("#township_id").empty();
                $("#district_id").empty();
            }
        });

        // address autofill in field
        $('#home_no,#street_name').keyup(function () {
            var addressArray = [$('#home_no').val(), $('#street_name').val(), $("#township_id option:selected").text(), $("#district_id option:selected").text(), $("#division_id").find(":selected").text()]

            function displayVals() {
                $('#address').text(addressArray.join(', '));
            }

            $('select').keyup(displayVals);
            displayVals();

        }).keyup();

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultSize").click();

        function openSize(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
              tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
              tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        function showDetails(detailId) {
            var detail = document.getElementById(detailId);
            if (detail.style.display === "none") {
                detail.style.display = "block";
            } else {
                detail.style.display = "none";
            }
        }



    </script>



</body>

<!-- Mirrored from htmldemo.net/tuoring/tuoring/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Mar 2023 03:32:13 GMT -->
</html>
