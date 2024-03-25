<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="NO REPLACEMENTS FOUND">
	<meta name="description" content="Explore and shop the latest limited edition high quality fashion products made for youngsters in Myanmar.">
	<title>NRF - Listen to the Vision</title>
	<link rel="icon" href="{{asset('/assets/img/icon/favicon2.ico')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/default.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/responsive.css')}}">
    <style>
        .bg_video{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            z-index:-1;
            object-fit:cover;
        }

		@media screen and (max-width: 500px) {
            .bg_video {
                object-fit: contain;
            }
        }
    </style>
</head>
<body class="bg-2">
    @include('layouts.navbar')

    <div class="content-wrapper" style="margin-top:115px">
        <video autoplay muted loop class="bg_video">
            <source src="assets/img/NRF/for_website_compressed.mp4" type="video/mp4">
        </video>
    </div>
    <div class="scroll-top not-visible">
        <i class="fa fa-angle-up"></i>
    </div>
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('/assets/js/ajax-mail.js')}}"></script>
    <script src="{{asset('/assets/js/main.js')}}"></script>
</body>
</html>

