@extends('frontend.layouts.master')

@section('title','Un-ko Uneko || Update Password')

@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">Update Password</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Password Update Section -->
<section class="shop login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="login-form">
                    <h2>Update Your Password</h2>
                    <p>Please enter a new password</p>
                    <!-- Form -->
                    <form class="form" method="post" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ request()->route('token') }}">
                        <input type="hidden" name="email" value="{{ request()->get('email') }}">

                        <div class="row">
                            <!-- New Password -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">New Password<span>*</span></label>
                                    <input type="password" name="password" id="password" placeholder="Enter new password" required="required" value="{{ old('password') }}">
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password<span>*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your new password" required="required">
                                    @error('password_confirmation')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12">
                                <div class="form-group login-btn">
                                    <button class="btn" type="submit">Update Password</button>
                                    <a href="{{ route('login.form') }}" class="btn">Back to Login</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--/ End Form -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Password Update Section -->
@endsection

@push('styles')
<style>
    .shop.login .form .btn {
        margin-right: 0;
    }

    .btn-facebook {
        background: #39579A;
    }

    .btn-facebook:hover {
        background: #073088 !important;
    }

    .btn-github {
        background: #444444;
        color: white;
    }

    .btn-github:hover {
        background: black !important;
    }

    .btn-google {
        background: #ea4335;
        color: white;
    }

    .btn-google:hover {
        background: rgb(243, 26, 26) !important;
    }
</style>
@endpush