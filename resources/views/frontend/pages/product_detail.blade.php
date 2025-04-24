@extends('frontend.layouts.master')

@section('meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='copyright' content=''>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
<meta name="description" content="{{$product_detail->summary}}">
<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$product_detail->title}}">
<meta property="og:image" content="{{$product_detail->photo}}">
<meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','Un-ko Uneko || Product Detail')
@section('main-content')


<style>
    .product-img img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
</style>
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="">Shop Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Single -->
<section class="shop single section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <!-- Images slider -->
                            <div class="flexslider-thumbnails">
                                <ul class="slides">
                                    @php

                                    $photo=explode(',',$product_detail->photo);

                                    @endphp
                                    @foreach($photo as $data)
                                    <li data-thumb="{{$data}}" rel="adjustX:10, adjustY:">
                                        <img src="{{ asset($data) }}" alt="{{ $data }}">

                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <!-- End Images slider -->
                        </div>
                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="product-des">
                            <!-- Description -->
                            <div class="short">
                                <h4>{{$product_detail->title}}</h4>
                                <div class="rating-main">
                                    <ul class="rating">
                                        @php
                                        $rate=ceil($product_detail->getReview->avg('rate'))
                                        @endphp
                                        @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                            <li><i class="fa fa-star"></i></li>
                                            @else
                                            <li><i class="fa fa-star-o"></i></li>
                                            @endif
                                            @endfor
                                    </ul>
                                    <a href="#" class="total-review">({{$product_detail['getReview']->count()}})
                                        Review</a>
                                </div>
                                @php
                                $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                                @endphp
                                <p class="price"><span
                                        class="discount">Rs{{number_format($after_discount,2)}}</span><s>Rs{{number_format($product_detail->price,2)}}</s>
                                </p>
                                <p class="description">{!!($product_detail->summary)!!}</p>
                            </div>




                            <!--/ IBAN -->
                            <!-- Product Buy -->
                            <div class="product-buy">
                                <form action="{{route('single-add-to-cart')}}" method="POST">
                                    @csrf
                                    <div class="quantity">
                                        <h6>Quantity :</h6>
                                        <!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number"
                                                    disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                            <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                data-max="1000" value="1" id="quantity">
                                            <input type="hidden" name="selected_color" id="selectedColorInput" value="">
                                            <input type="hidden" name="selected_size" id="selectedSizeInput" value="">
                                            <input type="hidden" name="product_note" id="productNoteInput">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number"
                                                    data-type="plus" data-field="quant[1]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </div>
                                    <div class="add-to-cart mt-4">
                                        <button type="submit" class="btn">Add to cart</button>
                                        <a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn min"><i
                                                class="ti-heart"></i></a>
                                    </div>
                                </form>

                                <p class="cat">Category :<a
                                        href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a>
                                </p>
                                @if($product_detail->sub_cat_info)
                                <p class="cat mt-1">Sub Category :<a
                                        href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a>
                                </p>
                                @endif
                                <p class="availability">Stock : @if($product_detail->stock>0)<span
                                        class="badge badge-success">{{$product_detail->stock}}</span>@else <span
                                        class="badge badge-danger">{{$product_detail->stock}}</span> @endif</p>
                            </div>
                            <!--/ End Product Buy -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-info">
                            <div class="nav-main">
                                <!-- Tab Nav -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#description"
                                            role="tab">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#customization"
                                            role="tab">Customization</a>
                                    </li>
                                    @php
                                    preg_match('/src="([^"]+)"/', $product_detail->tutorial_link, $matches);
                                    $videoSrc = $matches[1] ?? null;
                                    @endphp

                                    @if($videoSrc)
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tutorial" role="tab">Tutorial</a>
                                    </li>
                                    @endif
                                </ul>
                                <!--/ End Tab Nav -->
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <!-- Description Tab -->
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="tab-single">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="single-des">
                                                    <p>{!! ($product_detail->description) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="customization" role="tabpanel">
                                    <div class="tab-single">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="product-des">

                                                    @php
                                                    $colors = isset($product_detail->color) ?
                                                    json_decode($product_detail->color) : null;
                                                    $sizes = isset($product_detail->size) ?
                                                    json_decode($product_detail->size) : null;
                                                    @endphp

                                                    @if(is_array($colors) && count($colors) > 0)
                                                    <div class="color mt-4">
                                                        <p class="mb-2 text-lg font-semibold">Available Options <span
                                                                class="font-normal">Color</span></p>
                                                        <ul class="d-flex gap-2 p-0 m-0 flex-wrap"
                                                            style="list-style: none;">
                                                            @foreach($colors as $color)
                                                            <li>
                                                                <a href="javascript:void(0);" class="color-select"
                                                                    data-color="{{ $color }}" style="background-color: {{ $color }}; display: inline-block; width: 30px; height: 30px;
                      border-radius: 50%; border: 2px solid #ddd; transition: all 0.3s ease;">
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif

                                                    @if($sizes)
                                                    <div class="size mt-4">
                                                        <p class="mb-2 text-lg font-semibold">Available Options <span
                                                                class="font-normal">Size</span></p>
                                                        <ul class="d-flex gap-2 p-0 m-0 flex-wrap"
                                                            style="list-style: none;">
                                                            @foreach($sizes as $size)
                                                            <li>
                                                                <a href="javascript:void(0);" class="size-select  border border-gray-300 rounded-md hover:bg-gray-200 transition
                      cursor-pointer d-inline-block" data-size="{{ $size }}">
                                                                    {{ $size }}
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    @endif

                                                    <div class="notes mt-4">
                                                        <p class="mb-2 text-lg font-semibold">Add a Note</p>
                                                        <textarea id="notesTextarea" rows="3" class="form-control w-100"
                                                            placeholder="Type your notes here..."></textarea>

                                                    </div>

                                                    <script>
                                                        document.querySelectorAll('.color-select').forEach(el => {
                                                            el.addEventListener('click', function() {
                                                                document.querySelectorAll('.color-select')
                                                                    .forEach(c => c.style.border =
                                                                        '2px solid #ddd');
                                                                this.style.border = '2px solid #000';

                                                                const selectedColor = this.getAttribute(
                                                                    'data-color');
                                                                document.getElementById(
                                                                        'selectedColorInput').value =
                                                                    selectedColor;
                                                            });
                                                        });


                                                        document.querySelectorAll('.size-select').forEach(el => {
                                                            el.addEventListener('click', function() {
                                                                document.querySelectorAll('.size-select')
                                                                    .forEach(s => s.classList.remove(
                                                                        'bg-dark', 'text-white'));
                                                                this.classList.add('bg-dark', 'text-white');

                                                                const selectedSize = this.getAttribute(
                                                                    'data-size');
                                                                document.getElementById('selectedSizeInput')
                                                                    .value = selectedSize;
                                                            });
                                                        });

                                                        document.getElementById('notesTextarea').addEventListener('input',
                                                            function() {
                                                                document.getElementById('productNoteInput').value = this
                                                                    .value;
                                                            });
                                                    </script>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Reviews Tab -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <div class="tab-single review-panel">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Review -->
                                                <div class="comment-review">
                                                    <div class="add-review">
                                                        <h5>Add A Review</h5>

                                                    </div>
                                                    <h4>Your Rating <span class="text-danger">*</span></h4>
                                                    <div class="review-inner">
                                                        @auth
                                                        <form method="POST"
                                                            action="{{ route('user.productreview.store') }}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="rating_box">
                                                                        <div class="star-rating">
                                                                            <div class="star-rating__wrap">
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-5" type="radio"
                                                                                    name="rate" value="5">
                                                                                <input type="hidden" name="product_id"
                                                                                    value="{{$product_detail->id}}">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-5"
                                                                                    title="5 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-4" type="radio"
                                                                                    name="rate" value="4">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-4"
                                                                                    title="4 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-3" type="radio"
                                                                                    name="rate" value="3">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-3"
                                                                                    title="3 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-2" type="radio"
                                                                                    name="rate" value="2">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-2"
                                                                                    title="2 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-1" type="radio"
                                                                                    name="rate" value="1">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-1"
                                                                                    title="1 out of 5 stars"></label>
                                                                                @error('rate')
                                                                                <span
                                                                                    class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="form-group">
                                                                        <label>Write a review</label>
                                                                        <textarea name="review" rows="6"
                                                                            placeholder=""></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="form-group button5">
                                                                        <button type="submit"
                                                                            class="btn">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        @else
                                                        <p class="text-center p-5">
                                                            You need to <a href="{{route('login.form')}}"
                                                                style="color:rgb(54, 54, 204)">Login</a> OR
                                                            <a style="color:blue"
                                                                href="{{route('register.form')}}">Register</a>
                                                        </p>
                                                        @endauth
                                                    </div>
                                                </div>

                                                <div class="ratting-main">
                                                    <div class="avg-ratting">
                                                        <h4>{{ceil($product_detail->getReview->avg('rate'))}}
                                                            <span>(Overall)</span>
                                                        </h4>
                                                        <span>Based on {{$product_detail->getReview->count()}}
                                                            Comments</span>
                                                    </div>
                                                    @foreach($product_detail['getReview'] as $data)
                                                    <!-- Single Rating -->
                                                    <div class="single-rating mb-4">
                                                        <div class="rating-author">
                                                            @if($data->user_info['photo'])
                                                            <img src="{{$data->user_info['photo']}}"
                                                                alt="{{$data->user_info['name']}}">
                                                            @else
                                                            <img src="{{asset('backend/img/avatar.png')}}"
                                                                alt="Profile.jpg">
                                                            @endif
                                                        </div>
                                                        <div class="rating-des">
                                                            <h6>{{$data->user_info['name']}}</h6>
                                                            <div class="ratings">
                                                                <ul class="rating">
                                                                    @for($i=1; $i<=5; $i++) @if($data->rate >= $i)
                                                                        <li><i class="fa fa-star"></i></li>
                                                                        @else
                                                                        <li><i class="fa fa-star-o"></i></li>
                                                                        @endif
                                                                        @endfor
                                                                </ul>
                                                                <div class="rate-count">(<span>{{$data->rate}}</span>)
                                                                </div>
                                                            </div>
                                                            <p>{{$data->review}}</p>

                                                            @if($data->reply)

                                                            <div
                                                                class="admin-reply mt-3 ms-3 ps-3 border-l-4 border-blue-500">
                                                                <div class="flex items-start gap-2">
                                                                    <div class="rating-author mb-4">
                                                                        <img src="{{asset('backend/img/avatar.png')}}"
                                                                            alt="Admin"
                                                                            class="w-[30px] h-[30px] rounded-full">
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="text-primary font-bold text-sm">Admin
                                                                        </h6>
                                                                        <p class="text-sm text-gray-600">
                                                                            {{ $data->reply }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tutorial" role="tutorial">
                                    <div class="tab-single review-panel">
                                        <div class="row">
                                            <div class="col-12">
                                                @php
                                                preg_match('/src="([^"]+)"/', $product_detail->tutorial_link, $matches);
                                                $videoSrc = $matches[1] ?? null;
                                                @endphp

                                                @if($videoSrc)
                                                <div class="video-container"
                                                    style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;max-width:100%;">
                                                    <iframe src="{{ $videoSrc }}" frameborder="0" allowfullscreen
                                                        style="position:absolute;top:0;left:0;width:100%;height:80%;">
                                                    </iframe>


                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!--/ End YouTube Video Tab -->

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!--/ End Shop Single -->

<!-- Start Most Popular -->
<div class="product-area most-popular related-product section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- {{$product_detail->rel_prods}} --}}
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($product_detail->rel_prods as $data)
                    @if($data->id !== $product_detail->id)
                    <!-- Start Single Product -->
                    <div class="single-product">
                        <div class="product-img">
                            <a href="{{ route('product-detail', $data->slug) }}">
                                @php
                                // Get the product photo, assuming it's stored as a comma-separated string
                                $photo = explode(',', $data->photo);
                                @endphp
                                <!-- Use asset() to ensure the correct path for the images -->
                                <img class="default-img" src="{{ asset($photo[0]) }}" alt="{{ $photo[0] }}">
                                <img class="hover-img" src="{{ asset($photo[0]) }}" alt="{{ $photo[0] }}">
                                <span class="price-dec">{{ $data->discount }} % Off</span>
                                {{-- <span class="out-of-stock">Hot</span> --}}
                            </a>
                            <div class="button-head">
                                <div class="product-action">
                                    <a title="Quick View" href="{{ route('product-detail', $data->slug) }}"><i
                                            class="ti-eye"></i><span>Quick View</span></a>
                                    <a title="Wishlist" href="{{route('add-to-wishlist',$product_detail->slug)}}"><i
                                            class="ti-heart"></i><span>Add to
                                            Wishlist</span></a>

                                </div>
                                <div class="product-action-2">
                                    <a title="Add to cart" href="#">Add to cart</a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h3><a href="{{ route('product-detail', $data->slug) }}">{{ $data->title }}</a></h3>
                            <div class="product-price">
                                @php
                                $after_discount = ($data->price - (($data->discount * $data->price) / 100));
                                @endphp
                                <span class="old">Rs{{ number_format($data->price, 2) }}</span>
                                <span>Rs{{ number_format($after_discount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Product -->
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Most Popular Area -->


<!-- Modal -->

<!-- Modal end -->

@endsection
@push('styles')
<style>
    /* Rating */
    .rating_box {
        display: inline-flex;
    }

    .star-rating {
        font-size: 0;
        padding-left: 10px;
        padding-right: 10px;
    }

    .star-rating__wrap {
        display: inline-block;
        font-size: 1rem;
    }

    .star-rating__wrap:after {
        content: "";
        display: table;
        clear: both;
    }

    .star-rating__ico {
        float: right;
        padding-left: 2px;
        cursor: pointer;
        color: #F7941D;
        font-size: 16px;
        margin-top: 5px;
    }

    .star-rating__ico:last-child {
        padding-left: 0;
    }

    .star-rating__input {
        display: none;
    }

    .star-rating__ico:hover:before,
    .star-rating__ico:hover~.star-rating__ico:before,
    .star-rating__input:checked~.star-rating__ico:before {
        content: "\F005";
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

{{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
type:"POST",
data:{
_token:"{{csrf_token()}}",
quantity:quantity,
pro_id:pro_id
},
success:function(response){
console.log(response);
if(typeof(response)!='object'){
response=$.parseJSON(response);
}
if(response.status){
swal('success',response.msg,'success').then(function(){
document.location.href=document.location.href;
});
}
else{
swal('error',response.msg,'error').then(function(){
document.location.href=document.location.href;
});
}
}
})
});
</script> --}}

@endpush