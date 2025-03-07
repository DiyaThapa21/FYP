@extends('frontend.layouts.master')

@section('title','Un-ko Uneko || User Dashboard')

@section('main-content')

<div class="container mt-3 mb-3">
    <div class="card shadow-sm p-4 rounded-lg">
        <div class="row">


            @include('frontend.pages.userdashboard.include.sidebar')
            <div class="col-md-9">
                <div class="row">

                    <div class="col-md-4">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="ti-shopping-cart"></i> Total Orders</h5>
                                <h3 class="text-primary">12</h3>
                                <p class="text-muted">Your total completed orders</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="ti-heart"></i> Wishlist Items</h5>
                                <h3 class="text-danger">8</h3>
                                <p class="text-muted">Items saved in your wishlist</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="card shadow-sm rounded-lg">
                            <div class="card-body">
                                <h5 class="card-title"><i class="ti-comment-alt"></i> Reviews</h5>
                                <h3 class="text-success">5</h3>
                                <p class="text-muted">Reviews you have posted</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card shadow-sm mt-4 rounded-lg">
                    <div class="card-body">
                        <h5 class="card-title">Recent Orders</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#1001</td>
                                    <td>15 Feb 2024</td>
                                    <td>$120.00</td>
                                    <td><span class="badge badge-success">Completed</span></td>
                                    <td><a href="#" class="btn btn-sm btn-primary text-white">View</a></td>
                                </tr>
                                <tr>
                                    <td>#1002</td>
                                    <td>12 Feb 2024</td>
                                    <td>$85.50</td>
                                    <td><span class="badge badge-warning">Pending</span></td>
                                    <td><a href="#" class="btn btn-sm btn-primary text-white">View</a></td>
                                </tr>
                                <tr>
                                    <td>#1003</td>
                                    <td>10 Feb 2024</td>
                                    <td>$45.00</td>
                                    <td><span class="badge badge-danger">Cancelled</span></td>
                                    <td><a href="#" class="btn btn-sm btn-primary text-white">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-link text-white">View all orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection