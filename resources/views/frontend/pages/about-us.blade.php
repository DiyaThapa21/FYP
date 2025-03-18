@extends('frontend.layouts.master')

@section('title','Unko-Uneko || About Us')

@section('main-content')


<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="index1.html">Home<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="/">About Us</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>



<section class="about-us section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-12">
				<div class="about-content">

					<h3>Welcome To <span>UN-KO UNEKO</span></h3>
					<p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus.</p>
					<div class="button">
						<a href="" class="btn">Our Blog</a>
						<a href="" class="btn primary">Contact Us</a>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-12">
				<div class="about-img overlay">

					<img src="{{asset('backend/img/logo.png')}}" alt="">
				</div>
			</div>
		</div>
	</div>
</section>

<section class="shop-services section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-12">

				<div class="single-service">
					<i class="ti-rocket"></i>
					<h4>Free shiping</h4>
					<p>Orders over $100</p>
				</div>

			</div>
			<div class="col-lg-3 col-md-6 col-12">

				<div class="single-service">
					<i class="ti-reload"></i>
					<h4>Free Return</h4>
					<p>Within 30 days returns</p>
				</div>

			</div>
			<div class="col-lg-3 col-md-6 col-12">

				<div class="single-service">
					<i class="ti-lock"></i>
					<h4>Secure Payment</h4>
					<p>100% secure payment</p>
				</div>

			</div>
			<div class="col-lg-3 col-md-6 col-12">

				<div class="single-service">
					<i class="ti-tag"></i>
					<h4>Best Peice</h4>
					<p>Guaranteed price</p>
				</div>

			</div>
		</div>
	</div>
</section>

@include('frontend.layouts.newsletter')
@endsection