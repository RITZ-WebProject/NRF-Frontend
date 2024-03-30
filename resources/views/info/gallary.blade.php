@extends('layouts.app')

@section('content')
<style>
    .photo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Responsive grid with minimum item width of 200px */
        gap: 20px;
        margin: 0 auto; /* Center the grid horizontally */
        padding: 100px 20px; /* Add space to the left and right */
    }

    .photo {
        position: relative; /* For animation */
        overflow: hidden; /* For animation */
        cursor: pointer; /* Show pointer cursor on hover */
    }

    .photo img {
        width: 100%; /* Make images fill the entire container */
        height: auto; /* Maintain aspect ratio */
        transition: transform 0.3s ease; /* Smooth transition on hover */
    }

    .photo:hover img {
        transform: scale(1.1); /* Scale up image on hover */
        filter: brightness(80%); /* Reduce brightness on hover */
    }

    @media (min-width: 768px) {
        .photo-grid {
            grid-template-columns: repeat(4, 1fr); /* Show 4 photos per row on desktop */
        }
    }

    @media (max-width: 767px) {
        .photo-grid {
            padding: 50px 20px; /* Adjust padding for smaller screens */
        }
    }
</style>

<body style="background-color:#0000ff;">
    @if ($photos->isEmpty())
        <div class="product">
            <div class="row justify-content-center">
              <div class="col-md-12 text-center">
                <div class="card text-black" style="background: #fff; border: none;">
                  <div class="card-body" style="color: #0000ff;">
                      <h4>No photos available</h4>
                      <h4>Thank you for visiting the NRF Website</h4>
                      <h4>We look forward to welcoming you again on your next visit!</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @else
    <div class="photo-grid" style="background-color: #fff">
        @foreach($photos as $photo)
        <div class="photo">
            <img src="{{ env('Gallary_URL').$photo->photo_url }}" alt="Image">
        </div>
        @endforeach
    </div>
    @endif
</body>

@endsection

@section('footer')
@include('layouts.footer', ['footerColor' => 'blue'])
@endsection
