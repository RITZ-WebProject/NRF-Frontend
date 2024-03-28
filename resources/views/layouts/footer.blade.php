  <style>
footer {
    font-family: 'Roboto', sans-serif;
    
}
.container {
        padding-top: 20px;
        max-width: 1100px;
        margin: 0 auto;
}
.social-icons {
    display: flex;
    font-size: 20px;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}
p {
    font-size: 16px;

}

@media (max-width: 768px) {
    p {
        font-size: 10px;
    }
}
  </style>
</head>
<footer class="footer pt-5" style="background-color: {{ $footerColor }}">
    <div class="container text-white">
        <div class="row d-md-none">
            <div class="col-md-12 d-flex text-center">
                <div class="col-md-6">
                    <p class="pt-3 text-white" style="font-weight: bold;">MEET US HERE</p>
                </div>
                <div class="col-md-4 social-icons">
                    <a href="https://www.facebook.com/noreplacementsfound" target="_blank" class="text-white" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/nrf.online/" target="_blank" class="text-white" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <i class="fab fa-youtube"></i>
                </div>
                <div class="col-md-2">
                    <hr style="background: white;height: 2px;">
                </div>
            </div>
        </div><br>
        <div class="row d-none d-md-flex">
            <div class="col-md-6 d-flex">
                <div class="col-md-3">
                    <h2>Info</h2>
                    <p><a href="{{url('press')}}" class="text-white">Press</a></p>
                    <p><a href="{{url('about')}}" class="text-white">About Us</a></p>
                    <p><a href="{{url('career')}}" class="text-white">Career</a></p>
                </div>
                <div class="col-md-5">
                    <h2>Help</h2>
                    <p><a href="{{url('contact')}}" class="text-white">Contact Us</a></p>
                    <p><a href="{{url('payment')}}" class="text-white">Payment Methods</a></p>
                </div>
                <div class="col-md-6">
                    <h2>Legal</h2>
                    <p><a href="{{url('terms-conditions')}}" class="text-white">Terms & Conditions</a></p>
                </div>
            </div>
            <div class="col-md-6">
                <h4 class="text-white">NEWSLETTER SIGN UP</h4>
                <p class="text-white">Sign up to our newsletter to receive information regarding exclusive collection previews, special events, and seasonal sale offers.</p>
            </div>
        </div>
        <div class="row d-md-none">
            <div class="col-md-12 d-flex">
                <div class="col-md-3">
                    <h6>Info</h6>
                    <p><a href="{{url('press')}}" class="text-white">Press</a></p>
                    <p><a href="{{url('about')}}" class="text-white">About Us</a></p>
                    <p><a href="{{url('career')}}" class="text-white">Career</a></p>
                </div>
                <div class="col-md-5">
                    <h6>Help</h6>
                    <p><a href="{{url('contact')}}" class="text-white">Contact Us</a></p>
                    <p><a href="{{url('payment')}}" class="text-white">Payment Methods</a></p>
                </div>
                <div class="col-md-6">
                    <h6>Legal</h6>
                    <p><a href="{{url('terms-conditions')}}" class="text-white">Terms & Conditions</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-12 d-md-none">
            <h6 class="px-3">NEWSLETTER SIGN UP</h6>
            <p class="px-3 text-white">Sign up to our newsletter to receive information regarding exclusive collection previews, special events, and seasonal sale offers.</p>
        </div>
        <div class="row align-items-center">
            <div class="col-md-4 d-none d-md-flex">
                <div class="col-md-6 pt-3">
                    <p class="font-weight-bold text-white">MEET US HERE</p>
                </div>
                <div class="col-md-6 social-icons pt-0">
                    <a href="https://www.facebook.com/noreplacementsfound" target="_blank" class="text-white" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.instagram.com/nrf.online/" target="_blank" class="text-white" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
            
            <div class="col-md-8 d-none d-md-block">
                <form action="{{ route('newsletter') }}" method="POST">
                    @csrf
                    <input name="email" class="text-center form-control border-0" style="background: blue;" type="text" placeholder="EMAIL ADDRESS" required>
                    <hr style="background: white;height: 2px;">
                    <p class="px-5 text-white">By registering you agree to accept the Terms & Conditions and have read the Privacy Policy.</p>
                    <div class="d-flex justify-content-end pr-5">
                        <button type="submit" class="text-white btn-sm" style="background: blue;width: 160px;">SUBSCRIBE</button>
                    </div>
                </form>
            </div>
            
            
            <div class="col-md-8 d-md-none">
                <form action="{{ route('newsletter') }}" method="POST">
                    @csrf
                    <input name="email" class="text-center text-white form-control border-0" style="background: blue;" type="text" placeholder="EMAIL ADDRESS" required>
                    <hr style="background: white;height: 2px;">
                    <p class="px-3 text-white">By registering you agree to accept the Terms & Conditions and have read the Privacy Policy.</p>
                    <div class="d-flex justify-content-end pr-4">
                        <button type="submit" class="text-white btn-sm" style="background: blue;width: 130px;">SUBSCRIBE</button>
                    </div>
                </form>
                </div>
        </div>
        <br>
        <br>
        <br>
        <p class="text-white pb-5">@2023 No Replacements Found<sup>TM</sup>, All rights reserved.</p>
        <br>
    </div>
</footer>

