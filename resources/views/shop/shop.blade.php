@extends('layouts.app')
@section('content')
	@if ($message = Session::get('error'))
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="p-4 mb-3 rounded mx-auto" style="background-color: #fff;">
                    <p class="text-center" style="color:#ff0000"><i class="fa fa-exclamation mx-2"></i>{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    <style>
        .category-list {
             list-style: none;
             padding: 0;
         }
 
         .category-item {
             display: inline-block;
             margin-right: 10px; 
         }
 
         .category-link {
             text-decoration: none;
             color: white;
             background-color: black;
             padding: 8px 12px; /* Adjust padding for better spacing */
             border-radius: 5px; /* Add rounded corners */
         }
 
         .category-link:hover {
             background-color: darkslategray; /* Change color on hover */
         }
 
 
         .hero {
             padding-top: 20px;
             margin: 0 auto;
             
         }

        @media (min-width: 769px) {
        .hero{
             padding-left: 70px;
             padding-right: 70px;
         }
        .custom-image {
            position: relative;
            padding-top: 0;
            padding-bottom: 15px;
            left: -120px;
            max-width: 200%;
            max-height: 350px;
            width: 250px;
            }
        .btn-custom{
            width: 200px;
            position: relative;
            left: -130px;
            top: 60px;
        }
        .modal-lg {
            max-width: 450px;
            max-height: 450px;
        }
        .dropdown{
            padding-top: 20px;
        }
        .dropdown-menu{
            font-size: 18px;
            background: transparent;
            line-height: 1;
        }
        .modal-body .item-card .image-overlay {
            content: "";
            position: absolute;
            top: 0;
            left: -109px;
            right: 67px;
            bottom: 30px;
            background-color: rgba(17, 116, 237, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .modal-body .item-card:hover .image-overlay {
            opacity: 1;
        }
        .dropdown-item::before {
            content: "";
            position: absolute;
            right:-15px;
            top: 50%;
            width: 50px;
            height: 4px;
            background: blue;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.2s, transform 0.2s;
        }

        .dropdown-item:hover::before {
            opacity: 1;
            transform: translateY(-10%);
        }

        .dropdown-menu:not(:hover) .dropdown-item {
            filter: none;
            background: transparent;
        }
        .product{
            padding: 70px 70px;
        }
    }   
    
        @media (max-width: 767px) {
            .col-6 {
                padding: 0;
                margin: 0;
            }
            .modal-lg {
                max-width: 500px;
                max-height: 300px;
            }
            .custom-image {
                max-width: 100%;
                max-height: 300px;
                width: 80%;
                height: 260px;
            }
        .dropdown-menu{
            font-size: 20px;
            background: transparent;
            line-height: 0.7;
            }
        .btn-custom{
            width: 300px;
            text-align: center;
            margin: 0 auto;
        }
        .modal-body .item-card .image-overlay {
            content: "";
            position: absolute;
            top: 0;
            left: 42px;
            right: 42px;
            bottom: 16px;
            background-color: rgba(17, 116, 237, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        .modal-body .item-card:hover .image-overlay {
            opacity: 1;
        }
        .dropdown-item::before {
            content: "";
            position: absolute;
            right:0;
            top: 50%;
            width: 100px;
            height: 4px;
            background: blue;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.2s, transform 0.2s;
        }

        .dropdown-item:hover::before {
            opacity: 1;
            transform: translateY(-10%);
        }

        .dropdown-menu:not(:hover) .dropdown-item {
            filter: none;
            background: transparent;
        }
        .product{
            padding: 50px 0;
        }
        .product h4{
            font-size: 15px;
        }
    }
        .item-description {
            text-transform: uppercase;
            font-weight: bold;
            text-align: center; 
            padding-top: 20px;
            font-size: 12px;
        }
        .blue-chevron {
            color: blue;
        }
        .white-chevron {
            color: white;
        }
        .size-text {
            font-size: 20px;
            color: white;
            left: 0;
        } 
    .dropdown-item {
        position: relative;
        padding-right: 30px;
        filter: blur(2px);
    }
    .dropdown-item:hover {
        filter: none;
        background: #000;
    }
    #selectedSize {
            transition: opacity 0.3s, transform 0.3s;
        }

    @keyframes slide-up {
        from {
            transform: translateY(10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    </style>
</head>
<body>
    <div class="hero" style="background-color: #fff;">
        @if (!$productList->isEmpty())
        <div class="text-center pt-5">
             <ul class="category-list">
                 <li class="category-item">
                     <a href="{{ route('shop') }}" class="category-link">All</a>
                 </li>
                 @foreach($categoryList as $category)
                     <li class="category-item">
                         <a href="{{ route('category', $category) }}" class="category-link">{{ $category->name }}</a>
                     </li>
                 @endforeach
             </ul>
         </div>
        @endif
         
        <div class="row" style="padding-top:100px;padding-bottom:100px;">
            @forelse ($productList as $key => $products)
                <div class="col-md-3 col-6">
                    <div class="bg-image hover-overlay" data-toggle="modal" data-target="#exampleModal{{$key}}">
                        @php
                            $photoArray = explode("'x'", $products->photo);
                        @endphp
                        <img class="primary-img" src="{{ env('PHOTO_URL') . $photoArray[0] }}" class="w-100" alt="Item {{ $key + 1 }}" id="item-image">
                        <a href="#!">
                            <div class="mask" style="background-color: hsla(217, 89%, 51%, 0.5) !important;"></div>
                        </a>
                    </div>
                    <p class="item-description text-black">
                        {{ $products->product_name }} <br>{{ number_format($products->price, 0, ',') }} MMK
                    </p>
                </div>
    
                @if (($key + 1) % 4 == 0)
                    </div>
                    @if (($key + 1) < count($productList))
                        <div class="row justify-content-center">
                    @endif
                @endif
            @empty
                <div class="container product">
                  <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                      <div class="card text-black" style="background: #fff; border: none;">
                        <div class="card-body">
                            <h4 class="text-black">No products available</h4>
                            <h4 class="text-black">Thank you for visiting the NRF Website</h4>
                            <h4 class="text-black">We look forward to welcoming you again on your next visit!</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            @endforelse
        </div>
    </div>
    @foreach ($productList as $key => $products)
    <div class="modal fade" id="exampleModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: #000;">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="text-center mb-3 item-card">
                                    @php
                                        $photoArray = explode("'x'", $products->photo);
                                    @endphp
                                    <img class="primary-img custom-image" src="{{ env('PHOTO_URL') . $photoArray[0] }}" class="w-100" alt="Item {{ $key + 1 }}" id="item-image" style="object-fit: cover;">
                                    <div class="image-overlay"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="dropdown">
                                            <button class="btn btn-block" type="button" id="dropdownMenuButton{{$key}}" data-bs-toggle="dropdown" aria-expanded="false" style="background: #000;display: flex;justify-content: space-between;">
                                                <span class="size-text" id="selectedSize{{$key}}">Size</span>
                                                <i id="chevronIcon{{$key}}" class="fa-solid fa-chevron-down white-chevron" style="float: right; font-size: 20px;"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$key}}">
                                                <li><a class="dropdown-item" style="color: white;" href="#" onclick="setSize('Small', {{$key}})">Small</a></li>
                                                <li><a class="dropdown-item" style="color: white;font-weight: 400;" href="#" onclick="setSize('Medium', {{$key}})">Medium</a></li>
                                                <li><a class="dropdown-item" href="#" style="font-weight: 600; color: white;" onclick="setSize('Large', {{$key}})">Large</a></li>
                                                <li><a class="dropdown-item" href="#" style="font-weight: 700; color: white;" onclick="setSize('XLarge', {{$key}})">XLarge</a></li>
                                                {{-- <li><a class="dropdown-item" href="#" style="font-weight: 800; color: white;" onclick="setSize('XXLarge', {{$key}})">XXLarge</a></li>
                                                <li><a class="dropdown-item" href="#" style="font-weight: 900; color: white;" onclick="setSize('XXXLarge', {{$key}})">XXXLarge</a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <br><br><br><br><br>
                                <div class="row mt-5 mt-md-0">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <a href="#" id="addToCartLink{{$key}}">
                                                <button class="btn btn-custom" style="background: #17055f; border: 2px solid #fff; color: #fff; opacity: 0.8;" onclick="addToCart('{{$products->product_name}}', {{$products->id}}, {{$key}})">Add To Cart</button>
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
    @endforeach
    
    <script>
        const dropdownButtons = document.querySelectorAll('[id^="dropdownMenuButton"]');
        const chevronIcons = document.querySelectorAll('[id^="chevronIcon"]');
        const selectedSizes = document.querySelectorAll('[id^="selectedSize"]');
        
        dropdownButtons.forEach((button, index) => {
            button.addEventListener('click', function () {
                if (chevronIcons[index].classList.contains('fa-chevron-down')) {
                    chevronIcons[index].classList.remove('fa-chevron-down', 'white-chevron');
                    chevronIcons[index].classList.add('fa-chevron-up', 'blue-chevron');
                } else {
                    chevronIcons[index].classList.remove('fa-chevron-up', 'blue-chevron');
                    chevronIcons[index].classList.add('fa-chevron-down', 'white-chevron');
                }
            });
        });
    
        function setSize(size, key) 
        {
            selectedSizes[key].textContent = size;
            var dropdownElement = document.querySelector('.dropdown');
            var bsDropdown = new bootstrap.Dropdown(dropdownElement);
            bsDropdown.hide();
        }

        var productData = {!! json_encode($productList->items()) !!};
        var productsById = {};

        for (let key in productData) {
            if (productData.hasOwnProperty(key)) {
                const product = productData[key];
                productsById[product.id] = product;
            }
        }


        function addToCart(productName, id, key) {
            const selectedSize = selectedSizes[key].textContent;
            if (selectedSize === 'Size') {
                alert('Please select a size before adding to cart.');
                return;
            }

            const stockQuantity = productData[key][selectedSize.toLowerCase() + '_quantity'];
            if (parseInt(stockQuantity) === 0) {
                alert(`Sorry, ${productName} in size ${selectedSize} is out of stock.`);
                return;
            }

            const addToCartLink = document.getElementById(`addToCartLink${key}`);
            addToCartLink.href = `{{ route('add-to-cart', ['id' => ':id', 'size' => ':size']) }}`
                .replace(':id', id)
                .replace(':size', selectedSize);

            alert(`${productName} + ${selectedSize} is added to your cart.`);
        }
        $(document).ready(function () {
            $('.bg-image').click(function () {
                var imageSrc = $(this).find('img').attr('src');
                $('#exampleModal .primary-img').attr('src', imageSrc);
            });
        });
    </script>
    
 @endsection
 @section('footer')
 @include('layouts.footer', ['footerColor' => 'black'])
 @endsection
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
 
 