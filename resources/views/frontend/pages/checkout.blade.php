@extends('frontend.layouts.master')


@section('title','Checkout page')

@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <form class="form" method="POST" action="">
            @csrf
            <div class="row">

                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h2>Make Your Checkout Here</h2>
                        <p>Please register in order to checkout more quickly</p>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>First Name<span>*</span></label>
                                    <input type="text" name="first_name" placeholder="" value="{{old('first_name')}}">
                                    @error('first_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Last Name<span>*</span></label>
                                    <input type="text" name="last_name" placeholder="" value="{{old('last_name')}}">
                                    @error('last_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Email Address<span>*</span></label>
                                    <input type="email" name="email" placeholder="" value="{{old('email')}}">
                                    @error('email')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Phone Number <span>*</span></label>
                                    <input type="number" name="phone" placeholder="" required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Country<span>*</span></label>
                                    <input type="text" name="country" id="country" value="Nepal" readonly required>

                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Address Line 1<span>*</span></label>
                                    <input type="text" name="address1" placeholder="" value="{{old('address1')}}">
                                    @error('address1')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Address Line 2</label>
                                    <input type="text" name="address2" placeholder="" value="{{old('address2')}}">
                                    @error('address2')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Postal Code<span>*</label>
                                    <input type="text" name="post_code" placeholder="" value="{{old('post_code')}}">
                                    @error('post_code')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <!--/ End Form -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>CART TOTALS</h2>
                            <div class="content">
                                <ul>
                                    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart
                                        Subtotal<span>Rs {{number_format(Helper::totalCartPrice(),2)}}</span></li>
                                    <li class="shipping">
                                        Shipping Cost
                                        @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                        <select name="shipping" class="nice-select">
                                            <option value="">Select your address</option>
                                            @foreach(Helper::shipping() as $shipping)
                                            <option value="{{$shipping->id}}" class="shippingOption"
                                                data-price="{{$shipping->price}}">{{$shipping->type}}: Rs
                                                {{$shipping->price}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @else
                                        <span>Free</span>
                                        @endif
                                    </li>

                                    @if(session('coupon'))
                                    <li class="coupon_price" data-price="{{session('coupon')['value']}}">You
                                        Save<span>Rs {{number_format(session('coupon')['value'],2)}}</span></li>
                                    @endif
                                    @php
                                    $total_amount=Helper::totalCartPrice();
                                    if(session('coupon')){
                                    $total_amount=$total_amount-session('coupon')['value'];
                                    }
                                    @endphp
                                    @if(session('coupon'))
                                    <li class="last" id="order_total_price">Total<span>Rs
                                            {{number_format($total_amount,2)}}</span></li>
                                    @else
                                    <li class="last" id="order_total_price">Total<span>Rs
                                            {{number_format($total_amount,2)}}</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="single-widget">
                            <h2>Payments</h2>
                            <div class="content">
                                <div class="checkbox">
                                    <div class="payment-options">
                                        <label><input name="payment_method" type="radio" value="cod" id="cod_payment">
                                            Cash On Delivery</label><br>
                                        <label><input name="payment_method" type="radio" value="khalti"
                                                id="khalti_payment"> Khalti</label><br>
                                        <label><input name="payment_method" type="radio" value="esewa"
                                                id="esewa_payment"> Esewa</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            .payment-options {
                                display: flex;
                                flex-direction: column;
                                /* gap: 10px; */

                            }

                            .payment-options label {
                                display: flex;
                                align-items: center;
                                gap: 8px;

                            }
                        </style>


                        <!--/ End Payment Method Widget -->
                        <!-- Button Widget -->
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <button type="button" class="btn" id="checkout-btn">Proceed to checkout</button>
                                </div>
                            </div>
                        </div>
                        <!--/ End Button Widget -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/ End Checkout -->

<!-- Start Shop Services Area  -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Free shiping</h4>
                    <p>Orders over $100</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 30 days returns</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Sucure Payment</h4>
                    <p>100% secure payment</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Best Peice</h4>
                    <p>Guaranteed price</p>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="shop-newsletter section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">

                    <div class="inner">
                        <h4>Newsletter</h4>
                        <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                        <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                            <input name="EMAIL" placeholder="Your email address" required="" type="email">
                            <button class="btn">Subscribe</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    li.shipping {
        display: inline-flex;
        width: 100%;
        font-size: 14px;
    }

    li.shipping .input-group-icon {
        width: 100%;
        margin-left: 10px;
    }

    .input-group-icon .icon {
        position: absolute;
        left: 20px;
        top: 0;
        line-height: 40px;
        z-index: 3;
    }

    .form-select {
        height: 30px;
        width: 100%;
    }

    .form-select .nice-select {
        border: none;
        border-radius: 0px;
        height: 40px;
        background: #f6f6f6 !important;
        padding-left: 45px;
        padding-right: 40px;
        width: 100%;
    }

    .list li {
        margin-bottom: 0 !important;
    }

    .list li:hover {
        background: #F7941D !important;
        color: white !important;
    }

    .form-select .nice-select::after {
        top: 14px;
    }
</style>
@endpush
@push('scripts')
<script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
<script>
    $(document).ready(function() {
        $("select.select2").select2();
        $('select.nice-select').niceSelect();

        $('.shipping select[name=shipping]').change(function() {
            let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
            let subtotal = parseFloat($('.order_subtotal').data('price'));
            let coupon = parseFloat($('.coupon_price').data('price')) || 0;
            $('#order_total_price span').text('Rs ' + (subtotal + cost - coupon).toFixed(2));
        });

        $('#checkout-btn').click(function(e) {
            e.preventDefault();

            let selectedPaymentMethod = $('input[name=payment_method]:checked').val();
            if (!selectedPaymentMethod) {
                alert('Please select a payment method.');
                return;
            }

            // Calculate dynamic total amount
            let subtotal = parseFloat($('.order_subtotal').data('price'));
            let shipping = parseFloat($('.shipping select[name=shipping]').find('option:selected').data(
                'price')) || 0;
            let coupon = parseFloat($('.coupon_price').data('price')) || 0;
            let totalAmount = subtotal + shipping - coupon;

            if (selectedPaymentMethod === 'khalti') {
                checkout.show({
                    amount: totalAmount * 100 // Khalti expects paisa
                });
            } else {
                // Dynamically set form action
                if (selectedPaymentMethod === 'cod') {
                    $('.form').attr('action', "{{ route('cart.order') }}"); // Define this route in web.php
                } else if (selectedPaymentMethod === 'esewa') {
                    $('.form').attr('action', "{{ route('esewa.pay') }}");
                }
                $('.form').submit(); // Submit form normally
            }
        });
    });

    // Khalti Config
    var config = {
        publicKey: "test_public_key_6b9f20329f55454bb9a38e4a40f136fb",
        productIdentity: "1234567890",
        productName: "lost-brother",
        productUrl: "http://localhost:8000/product-detail/lost-brother",
        paymentPreference: [
            "KHALTI",
            "EBANKING",
            "MOBILE_BANKING",
            "CONNECT_IPS",
            "SCT",
        ],
        eventHandler: {
            onSuccess(payload) {
                console.log(payload);
                if (payload.idx) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('verifyPayment') }}",
                        data: {
                            token: payload.token,
                            amount: payload.amount,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('khalti.storePayment') }}",
                                data: {
                                    response: res,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function(res) {
                                    $('.form').attr('action', "{{ route('cart.order') }}");
                                    $('input[name=payment_method][value="khalti"]').prop(
                                        'checked', true);
                                    $('.form').submit();
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error storing Khalti payment:', error);
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error verifying Khalti payment:', error);
                        }
                    });
                }
            },
            onError(error) {
                console.error('Khalti error:', error);
            },
            onClose() {
                console.log('Khalti widget closed');
            }
        }
    };

    var checkout = new KhaltiCheckout(config);
</script>
@endpush