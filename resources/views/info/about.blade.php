
@extends('layouts.app')
@section('content')
  <style>
    /* body,
    .footer {
        font-family: 'Roboto', sans-serif;
    } */


    @media (min-width: 576px) {

        body{
        padding: 0;
        overflow-x: hidden;
        }
        .logo {
            display: block;
        }
        .logo {
            display: none;
        }
        .hero {
        height: 75vh;
        padding: 80px 50px;
        }
        body, .hero p {
        font-family: 'Roboto', sans-serif;
        font-size: 22px;
        text-align: justify;
        line-height: 1.5;
        }
        body, .col-lg-6 p{
        font-family: 'Roboto', sans-serif;
        font-size: 22px;
        text-align: justify;
        line-height: 1.5;
        }
        .image-container {
        position: relative;
        width: 100%;
        }
        img {
            width: 100%;
            height: auto;
            display: block;
        }
        .overlay {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(to bottom, rgba(0, 0, 255, 0), blue);
        }
        .hover {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 50%;
            background: linear-gradient(to bottom, rgba(0, 0, 255, 0), black);
        }
        .overlay-text {
        position: absolute;
        top: 0;
        left: 0;
        padding: 70px;
        color: #fff;
        font-size: 16px;
        line-height: 1.5;
        }
        .mission{
        padding: 130px 100px;
        color: #fff;
        }
        .mission,.col-lg-6 h1{
            text-align: right;
        }
        .mission,.col-lg-6 h4{
            text-align: justify;
        }
    }
    @media (max-width: 576px) {
      body{
        padding: 0;
        overflow-x: hidden;
      }
      body, .hero p {
      font-family: 'Roboto', sans-serif;
      font-size: 19px;
      text-align: justify;
      }
      body, .col-lg-6 p{
      font-family: 'Roboto', sans-serif;
      font-size: 19px;
      text-align: justify;
      }
      body, .col-lg-12 p{
      font-family: 'Roboto', sans-serif;
      font-size: 19px;
      text-align: justify;
      }

      .hero {
        height: auto !important;
        padding: 80px 10px !important;
        text-align: center;
      }
      .overlay-text{
        background: linear-gradient(to bottom, rgba(0, 0, 255, 0), blue);
        color: #fff;
        padding: 0 15px;
      }
      .overlay-text,.col-lg-6 h4{
        text-align: justify;
      }
      .mission{
        padding:0 30px;
        color: #fff;
      }

      .mission,.col-lg-6 h4{
          text-align: justify;
      }
      .hover {
        position: absolute;
        top: 50%;
        left: 0;
        width: 118%;
        height: 50%;
        background: linear-gradient(to bottom, rgba(0, 0, 255, 0), black);
        }

        #about{
            margin-left:0px;
        }

        #second_about_img
        {
            max-width: 100% !important;
        }

        #container_second_about_img{
            top: -20px !important;
            left: 0px !important;
        }
    }

    #container_second_about_img{
        top: -140px !important;
        left: 0px !important;
    }

    @media (max-width: 980px) {
        .mission{
            text-align: left !important;
            top:-200px;
        }
    }

    @media (max-width: 600px) {

        #about_logo{
            width:300px !important;
            float: left !important;
            /* margin-right:130px !important; */
        }

        #container_second_about_img{
            top: -100px !important;
            left: 0px !important;
        }

        #container_second_about_img img{
            width: 100% !important;
        }


        #about_text{
            font-size: 20px;
        }

        .mission{
            padding: 30px 50px;
            text-align: left;
            top:-50px;
        }
    }


    #second_about_img
    {
        max-width: 137%;
    }

    #about_logo{
        width:500px;
    }

    #about_text{
        /* color:red !important; */
        /* justify-content: center;
        word-spacing: 2px; */
        margin-left:20px;margin-top:10px;
    }

    #about{
        margin-top:200px;margin-left:100px;
    }




  </style>
</head>
<body class="about" style="background: gainsboro;" >
  <div class="hero " >
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-8">
          <img src="{{ asset('/assets/img/aboutus/2.png') }}" id="about_logo" alt="Your Logo">
          <h3 class="text-black text-justify" style="clear: both;" id="about_text">
            NRF™ isn’t just a brand - It’s a philosophy woven into every product we create. Embracing the notion that excellence knows no substitute, our brand has redefined the standard. Each item carries a commitment to unparalleled quality, making us the epitome of durability and craftsmanship.
          </h3>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-5"  style="background-color: #000;">
    <div class="row">
      <div class="col-lg-6 " id="container_second_about_img">
        <img src="{{ asset('/assets/img/aboutus/01.png') }}" alt="Your Image" >
        <div class="hover"></div>
      </div>
      <div class="col-lg-6  mission">
        <h1 class="">Mission</h1>
        <h4>
          To enhance the quality of life for youngsters and to change the way they see what fashion is the mission of our brand.
        </h4>
      </div>
    </div>
  </div>
  <div class="image-container" style="position: relative; background: #000;overflow-x: hidden;">
    <img src="{{ asset('/assets/img/aboutus/3.png') }}" alt="Your Image">
    <div class="overlay-text row">
      <div class="col-lg-6">
        <h1 class="text-left">Vision</h1>
        <p style="color:white">
            To offer consistent Products and Services with uncompromising quality supported by continuous improvements and innovations thereby exceeding Customer's expectation.
        </p>
      </div>
    </div>
    <div class="overlay"></div>
</div>
</body>
@endsection
@section('footer')
@include('layouts.footer', ['footerColor' => 'blue'])
@endsection
