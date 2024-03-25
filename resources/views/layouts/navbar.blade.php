<header class="header-pos" style="display:block" >
    <div class="header-menu header-transparent sticker plr-100">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-2 col-3">
                    <div class="logo">
                        <a href="{{url('/')}}"><img src="{{asset('/assets/img/NRF/white-NRF.png')}}" alt="brand-logo"></a>
                    </div>
                </div>
                <div class="col-lg-8 d-none d-lg-block">
                    <div class="main-menu">
                        <nav id="mobile-menu">
                            <ul class="text-center">
                                <li><a href="{{url('/about')}}" class="text-uppercase">ABOUT US</a></li>
                                <li><a href="{{url('/shop')}}" class="text-uppercase">STORE</a></li>
                                <li><a href="{{url('/gallery')}}" class="text-uppercase">Gallary</a></li>
                                @if(session()->get('email'))
                                    <li><a href="{{url('/account')}}" class="text-uppercase">My Account</a></li>
                                @else
                                    <li><a href="{{url('/login')}}" class="text-uppercase">Login</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2 col-9">
                    <div class="header-option-right float-right">
                        <div class="header-search">

                            <div class="header-form">
                                <form action="#">
                                    <input type="text" placeholder="search" />
                                </form>
                            </div>
                        </div>
                        <div class="user-meta d-lg-none">
                            <a href="#"><i class="fa fa-bars"></i></a>
                            <div class="menu-settings" style="z-index: 999 !important;">
                                <ul class="account-settings" style="z-index: 999 !important;">
                                    <li><a href="{{url('/about')}}" class="text-uppercase">ABOUT US</a></li>
                                    <li><a href="{{url('/shop')}}" class="text-uppercase">STORE</a></li>
                                    <li><a href="{{url('/gallery')}}" class="text-uppercase">Gallary</a></li>
                                    @if(session()->get('email'))
                                    <li><a href="{{url('/account')}}" class="text-uppercase">My Account</a></li>
                                    @else
                                        <li><a href="{{url('/login')}}" class="text-uppercase">Login</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="my-cart">
                            <div class="total-cart">
                                <a href="{{url('/cart')}}">
                                    @php
                                        $cartItems = Cart::getContent();
                                    @endphp
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>{{ $cartItems->count(); }}</span>
                                </a>
                            </div>
                            <ul>
                                @php
                                    $cart = \Cart::getContent();

                                @endphp
                                @if($cart)
                                    @foreach($cart as $carts)
                                	@php $photoArray = explode("'x'", $carts->attributes['photo']); @endphp
                                        <li>
                                            <div class="cart-img">
                                                <a href="#"><img alt="" src="{{env('PHOTO_URL').$photoArray[0]}}"></a>
                                            </div>
                                            <div class="cart-info">
                                                <h4><a href="{{ url('product-details/'.$carts->id) }}">{{ strlen($carts->name) > 10? substr($carts->name, 0, 10).'...': $carts->name}} ( {{ strtoupper(substr($carts->attributes['size'], 0, 1)) }} )</a></h4>
                                                <span>{{ number_format($carts->price, 0, ',') }} <span> x 1</span></span>
                                            </div>
                                            <div class="del-ic7on float-end">
                                                <a href="{{route('cart.remove',['id' => $carts->id])}}"><i class="fa fa-times-circle text-danger"></i></a>
                                            </div>
                                        </li>
                                    @endforeach
                                    @php $total = Cart::getTotal();@endphp
                                @endif

                                <li class="cart-border">
                                    <div class="subtotal-text">Subtotal: </div>
                                    <div class="subtotal-price">{{number_format($total), 0, ','}} mmk</div>
                                </li>
                                <li>
                                    <a class="cart-button text-light border-primary" href="{{url('/cart')}}">view cart</a>
                                    @if (!$cart || $cart->isEmpty())
                                        <a class="checkout text-light border-primary" href="#">checkout</a>
                                    @else
                                        <a class="checkout text-light border-primary" href="{{url('/checkout')}}">checkout</a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-block d-lg-none d-md-none"><div class="mobile-menu"></div></div>
            </div>
        </div>
    </div>
</header>
<script>
    function toggleSubmenu() {
        var submenu = document.querySelector('#projectsDropdown .submenu');
        submenu.style.display = (submenu.style.display === 'none' || submenu.style.display === '') ? 'block' : 'none';
    }
</script>








