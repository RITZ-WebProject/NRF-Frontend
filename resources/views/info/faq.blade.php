@extends('layouts.app')
@section('content')

    <!-- faq main wrapper start -->
    <div class="faq-main-wrapper pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="faq-inner faq-inner--one">
                        <div class="faq-title">
                            <h2 class="text-light">General Questions</h2>
                        </div>
                        <div class="accordion" id="general-question">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            How do I start?
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#general-question">
                                    <div class="card-body text-dark">
                                        Welcome to NRF! To start ordering, you will first need to register a user account and then sign into that account. Afterwards, you can head to the shop and add any product you like to your cart before checking out and confirming your order.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseTwo" aria-controls="collapseTwo">
                                            How do I register?
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#general-question">
                                    <div class="card-body text-dark">
										NRF only allows customers to order after creating a user account. To create one, go to the Login tab and press "Don't have an account? Register" to go to the register page. From there, you will need to provide a valid email and phone number to create an account.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseThree" aria-controls="collapseThree">
											How do I contact NRF customer support?
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#general-question">
                                    <div class="card-body text-dark">
										The customer support phone number and email address are located in the Contact Us section, please call or email our customer support if you have any questions.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingfive">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseFour" aria-controls="collapseFour">
                                            How do I subscribe to NRF's newsletter
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseFour" class="collapse" aria-labelledby="headingfive" data-parent="#general-question">
                                    <div class="card-body text-dark">
										NRF currently does not have a newsletter, however, you may sign up for it early by providing your email address. Follow our social media accounts for information on when we will announce the newsletter.
									</div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingsix">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseFive" aria-controls="collapseFive">
											Where can I look at NRF's in-person events?
										</button>
                                    </h5>
                                </div>

                                <div id="collapseFive" class="collapse" aria-labelledby="headingsix" data-parent="#general-question">
                                    <div class="card-body text-dark">
										Our in person events such as the pop up store and the music festivals are listed in the contact us section. There you can check the addresses of these events.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="faq-inner faq-inner--two">
                        <div class="faq-title">
                            <h2 class="text-light">Payments & Orders</h2>
                        </div>
                        <div class="accordion" id="payment">
                            <div class="card">
                                <div class="card-header" id="headingSix">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                            How do I pay for my orders?
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseSix" class="collapse show" aria-labelledby="headingSix" data-parent="#payment">
                                    <div class="card-body text-dark">
                                        NRF has two payment options: Cash on Delivery and Kbz Pay. The cash on delivery option can only be chosen for customers residing in Yangon or Mandalay, all other areas will have to use Kbz Pay. Please note that the KBZ function can only be used on mobile and requires you to have the KBZ pay app already installed on your mobile device. So if you are not in yangon or Mandalay, only order from the website using a mobile device with the KBZ app installed.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingSeven">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseSeven" aria-controls="collapseSeven">
                                            How many products can I order?
										</button>
                                    </h5>
                                </div>

                                <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#payment">
                                    <div class="card-body text-dark">
                                        You are allowed to order as many products as you wish. However, because NRF's products are of a limited edition, you may only order one of each product, for any size.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingEight">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseEight" aria-controls="collapseEight">
                                            How do I provide my delivery address?
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#payment">
                                    <div class="card-body text-dark">
										Your delivery address is filled out at the time of checkout, however, you may also enter a default delivery address specific to your account in the "My Account" tab that will be used automatically whenever you order from NRF.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingNine">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseNine" aria-controls="collapseNine">
                                            I've completed my order, now what?
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#payment">
                                    <div class="card-body text-dark">
                                        After you have successfully completed your order, a new entry will appear in the Orders section in your "My Account" tab, there you can check the current status of your order and download the invoice.
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTen">
                                    <h5 class="mb-0">
                                        <button class="accordio-heading" type="button" data-bs-toggle="collapse"       data-bs-target="#collapseTen" aria-controls="collapseTen">
                                            I cannot create an order/My order status shows "cancelled"
										</button>
                                    </h5>
                                </div>

                                <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#payment">
                                    <div class="card-body text-dark">
										Unfortunately, this means that your order couldn't be completed. A likely cause for the first case is if the product you were ordering ran out of stock before you could checkout your order. For the second case, the cancelled status means that your order was cancelled for whatever reason. If this happens, you may contact our customer support for any clarifications. If this happens while you were paying via KBZ pay, your funds may sometimes be subtracted without your order being accepted, in this case please contact NRF with proof to receive a refund.
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- faq main wrapper end -->

@endsection
