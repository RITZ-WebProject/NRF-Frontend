
@extends('layouts.app')
@section('content')

    <style type="text/css">
        ul{
            margin:0;
            padding: 0;
            list-style: none;
        }

        a{
            color: #333;
        }

        a:hover,
        a:active{
            text-decoration: none;
        }

        h1{
            text-align: center;
            font-size:6vw;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin:30px 0;
        }

        p{
            margin:0 10px 10px 10px;
            word-wrap : break-word;
        }

        .flipLeft{
            animation-name: flipLeft;
            animation-duration:0.5s;
            animation-fill-mode:forwards;
            perspective-origin: left center;
            opacity: 0;
        }

        #banner{
            height:800px;
        }

        #banner_text{
            position: absolute;
            bottom:50%;
            left:0px;
            font-size:25px;
            color:aliceblue;
            text-align: center;
            width:100%;

        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 10px;
        }

        .image {
            position: relative;
            overflow: hidden;
        }

        .image img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .image:hover img {
            transform: scale(1.1);
        }

        .image img:hover {
            cursor: pointer;
        }

        .image img:focus {
            outline: none;
        }

        .image img::selection {
            background-color: transparent;
        }

        .image img::-moz-selection {
            background-color: transparent;
        }

        @media screen and (max-width: 680px) {
            #banner{
                height:450px;
            }

            #banner_text{
                bottom:10%;
            }
        }

        @keyframes flipLeft{
            from {
                transform: perspective(600px) translate3d(0, 0, 0) rotateY(30deg);
                opacity: 0;
            }

            to {
                transform: perspective(600px) translate3d(0, 0, 0) rotateY(0deg);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="about" style="background: black;" >

    <div style="position: relative">
        <img style="width:100%;object-fit: cover; margin:20px 20px;" id="banner"  src="{{ asset('/assets/img/bg/gallary_banner.png') }}" id="about_logo" alt="Your Logo">
        <div  id="banner_text">
            <h4 style="text-align: center">Heavy Weight Boxy Basics</h4>
            <h4 style="text-align: center">Material : 100% Heavy Weight Cotton</h4>
            <p  style="font-size: 17px;margin-top:30px;color:aliceblue;text-align: center;">These pieces of clothing express young agility, freedom, and culture, allowing any youngster whoever wears them to express themselves properly. </p>
        </div>
    </div>

    <div class="wrapper" style="margin-left:100px;margin-right:100px;" >
        <div class="gallery" style="margin-bottom: 20px;">
            @foreach($photos as $photo)
                <span class="image">
                    <img style="border-radius: 5%" src="{{ env('Gallary_URL').$photo->photo_url }}"  alt="Image 1">
                </span>
            @endforeach

        </div>

    </div>
</body>
@endsection
@section('footer')
@include('layouts.footer', ['footerColor' => 'black'])
@endsection
