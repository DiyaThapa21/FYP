@extends('frontend.layouts.master')

@section('title', 'Un-ko Uneko || User Dashboard')

@section('main-content')

<div class="container mt-3 mb-3">
    <div class="card shadow-sm p-4 rounded-lg">
        <div class="row">

            @include('frontend.pages.userdashboard.include.sidebar')

            <div class="col-md-9">
                <div class="card shadow-sm rounded-lg p-4 mb-4">
                    <h4 class="mb-3"><i class="ti-user"></i> Profile Details</h4>
                    <form action="{{ route('user-profile-update', auth()->id()) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email Address</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ auth()->user()->phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" value="{{ auth()->user()->city }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Postal Code</label>
                                <input type="text" name="postal_code" class="form-control"
                                    value="{{ auth()->user()->postal_code }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>House No</label>
                                <input type="text" name="house_no" class="form-control"
                                    value="{{ auth()->user()->house_no }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control"
                                    rows="3">{{ auth()->user()->address }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>

                </div>

                <div class="card shadow-sm rounded-lg p-4">
                    <h4 class="text-danger"><i class="ti-trash"></i> Delete Account</h4>
                    <p>If you delete your account, all your data will be lost and cannot be recovered.</p>
                    <form action="" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete your account?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Account</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection