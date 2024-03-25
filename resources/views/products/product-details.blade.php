@extends('layouts.app')
@section('content')

    <!-- product details area -->
    <div class="product-details-area pt-60">
        <div class="container">
			@if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row mb-40">
                <div class="col-lg-5 mb-20 d-flex justify-content-center align-items-center">
                    <!-- test -->

                    @php
                        $photoArray = explode("'x'", $products->photo);

                    @endphp

                    <div class="owl-carousel" style='z-index: 0 !important;'>
                    	@foreach ($photoArray as $photo)
                    	    <div class="" style="height: 350px">
                            	<img src="{{ env('PHOTO_URL').$photo }}" alt="" class="rounded h-100 w-auto " style="object-fit: cover;">
                    	    </div>
                    	@endforeach
                    </div>

                    <!-- test -->
                </div>

                <div class="col-lg-7 mb-40">
                    @if (session("info"))
                        <div class="alert alert-success">
                            {{session("info")}}
                        </div>
                    @endif
                    <div class="product-details-shop">
                        <h3 class="" style="font-weight: bold; color: #0D6EFD;">{{$products->product_name}}</h3>
                        <div class="shop-list-price">
                            <span class="shop-price text-light">{{ number_format($products->price, 0, ',') }} MMK</span>
                        </div>
                        <p class="text-light">{{$products->description}}</p>
                        <div>
                            <span class="" style="font-weight: bold;">Available Sizes : </span>
                            <br><br>
                            <div class="tab">

                               @if($products->size_type != 'normal')
                                    <button class="btn tablinks size-btn mb-1 active" id="defaultSize" style="margin-right:5px">{{ucfirst($products->size_type . " Size")}}</button>
                                @else
                                    <button class="btn tablinks size-btn mb-1 active" id="defaultSize" onclick="openSize(event,'small')" style="margin-right:5px">Small</button>
                                    <button class="btn tablinks size-btn mb-1" onclick="openSize(event,'medium')" style="margin-right:5px">Medium</button>
                                    <button class="btn tablinks size-btn mb-1" onclick="openSize(event,'large')" style="margin-right:5px">Large</button>
                                    <button class="btn tablinks size-btn mb-1" onclick="openSize(event,'xlarge')" style="margin-right:5px">Extra Large</button>
                                @endif
                            </div>
                        </div>
                        <br>

                        @php
                            $cart = \Cart::getContent();
                            // dd($cart);
                            $sizes = ['small','medium','large','xlarge'];
                        @endphp


                        @if($products->size_type != 'normal')
                        <div>
                            <span class="aviablity mb-15 mt-9" id="small_stock" style="color:#0D6EFD; font-size:12px"><i class="fa fa-check-circle"></i>  in stock</span>
                            @if($ordered)
                             		<a class="in-cart disabled" style='height:40px; display:inline-block'>Already Ordered</a>
                            @elseif($cart->get($products->id) === null)
                                    @if($products->small_quantity > 0)
                                        <a href="{{route('add-to-cart', ['id'=> $products->id, 'size' => $products->size_type])}}"><button class="add-to-cart" id="{{$size}}_button">add to cart</button></a>
                                    @else
                                    	<a class="out-of-stock disabled danger" style='height:40px; display:inline-block'>OUT OF STOCK</a>
                                    @endif
                            @else
                                <a class="in-cart disabled" style='height:40px; display:inline-block'>In Cart</a>
                            @endif
                        </div>
                        @else
                            @foreach ($sizes as $size)
                                @php $quantity = $size . '_quantity';
                                @endphp
                                <div id="{{$size}}" class="tabcontent hide-content">
                                    <span class="aviablity mb-15 mt-9" id="{{$size}}_stock" style="color:#0D6EFD; font-size:12px"><i class="fa fa-check-circle"></i>  in stock</span>
                                	@if($ordered)
                                 		<a class="in-cart disabled" style='height:40px; display:inline-block'>Already Ordered</a>
                                	@elseif($cart->get($products->id) === null)
                                        @if($products->$quantity > 0)
                                            <a href="{{route('add-to-cart', ['id'=> $products->id, 'size' => $size])}}"><button class="add-to-cart" id="{{$size}}_button">add to cart</button></a>
                                        @else
                                        	<a class="out-of-stock disabled danger" style='height:40px; display:inline-block'>OUT OF STOCK</a>
                                        @endif
                                    @else
                                        <a class="in-cart disabled" style='height:40px; display:inline-block'>In Cart</a>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <span class="product-details-cat mt-30 text-light">
                            Categories:
                            <a href="../shop?category={{$products->name}}" class="rounded">{{ $products->name }}</a>
                        </span>
                        <div class="share-icons mt-40" hidden>
                            <h3>share this product</h3>
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/noreplacementsfound/" target="_blank"><i class="fa fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/nrf.online/" target="_blank"><i class="fa fa-instagram"></i></a>
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



@endsection

@section('script')
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
@endsection


