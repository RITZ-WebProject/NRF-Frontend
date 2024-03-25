<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Primary Meta Tags -->
	<meta name="title" content="NO REPLACEMENTS FOUND">
	<meta name="description" content="Explore and shop the latest limited edition high quality fashion products made for youngsters in Myanmar.">

	<!-- Primary Meta Tags -->


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
    <link rel="stylesheet" href="{{ asset('assets/css/responsive_update.css') }}">

    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/js/owlcarousel/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/owlcarousel/dist/assets/owl.theme.default.min.css') }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.css" rel="stylesheet" />
	<style>
		.custom-radio {
			width: 15px !important;
			height: 15px !important;
			border: 1px solid blue !important;
			margin-right: 5px !important;
		}
	</style>
</head>
<body class="bg-2">
	
    <!-- header area -->

    @include('layouts.navbar')

    <div class="content-wrapper">
        @yield('content')
    </div>
    @yield('footer')

    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div> 


	<!-- all js include here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.11.0/mdb.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins.js')}}"></script>
    <script src="{{asset('assets/js/ajax-mail.js')}}"></script>
    <script src="{{ asset('assets/js/main_update.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"
    integrity="sha512-pdCVFUWsxl1A4g0uV6fyJ3nrnTGeWnZN2Tl/56j45UvZ1OMdm9CIbctuIHj+yBIRTUUyv6I9+OivXj4i0LPEYA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- owlcarousel -->
    <script src="{{ asset('assets/js/owlcarousel/dist/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">



        $(document).ready(function(){
   			$(window).on('load', function() {
  				 $('.hide-content').removeClass('hide-content');
			});


        	var owl = $('.owl-carousel');
            owl.owlCarousel({
                items:2,
                loop:true,
                margin:10,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
            $('.play').on('click',function(){
                owl.trigger('play.owl.autoplay',[1000])
            })
            $('.stop').on('click',function(){
                owl.trigger('stop.owl.autoplay')
            });

            $('#').submit(function(e) {
                e.preventDefault();
                    var formData = $(this).serialize();
                    const payment = $('input[name="payment"]:checked').val();
            
                    if (payment === "kpay") {
                        Swal.fire({
                            title: 'Are you sure you want to place the order?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#1620a8',
                            cancelButtonColor: '#ff0000',
                            confirmButtonText: 'Yes, save it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(this).unbind('submit').submit();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Are you sure you want to place the order?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#1620a8',
                            cancelButtonColor: '#ff0000',
                            confirmButtonText: 'Yes, save it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Confirming your order...',
                                    html: 'Please wait...',
                                    allowEscapeKey: false,
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    }
                                });
            
                                $.ajax({
                                    url: '{{ route('order.store') }}',
                                    type: 'POST',
                                    data: formData,
                                    success: function(response) {
                                        console.log(response);
                                        if (response.status_code == 200) {
                                            Swal.close();
                                            Swal.fire(
                                                'Saved!',
                                                'Your Order has been placed Successfully.',
                                                'success'
                                            ).then(function() {
                                                window.location.href = 'shop';
                                            });
                                        } else if (response.status_code == 403) {
                                            Swal.close();
                                            Swal.fire(
                                                'Cancelled',
                                                'Your Order Is Failed',
                                                'you have already ordered this product'
                                            );
                                        } else {
                                            Swal.close();
                                            Swal.fire(
                                                'Cancelled',
                                                'Your Order Is Failed',
                                                'error'
                                            );
                                        }
                                    },
                                    error: function(err) {
                                        console.log(err);
                                        Swal.close();
                                        Swal.fire(
                                            'Cancelled',
                                            'Your Order Is Failed',
                                            'error'
                                        );
                                    }
                                });
                            }
                        });
                }
            });
        });
        function showDetails(detailId) {
            var detail = document.getElementById(detailId);
            if (detail.style.display === "none") {
                detail.style.display = "block";
            } else {
                detail.style.display = "none";
            }
        }
	@yield('script')
    </script>
</body>

</html>
