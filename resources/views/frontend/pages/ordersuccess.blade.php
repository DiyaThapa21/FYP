@extends('frontend.layouts.master')


@section('title','Checkout page')

@section('main-content')




<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-10">Invoice {{ $order->order_number }} <span
                                class="badge bg-success font-size-8 ms-2"> {{ $order->payment_status }}</span></h4>
                        <div class="mb-4">
                            <h2 class="mb-1 text-muted">UnkoUneko</h2>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1 font-size-10">Pokhara Nepal</p>
                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i> test@gmail.com</p>
                            <p><i class="uil uil-phone me-1"></i> 9876777787</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                    <p>#INV{{ $order->order_number }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Invoice Date:</h5>
                                    <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}</p>
                                </div>

                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Order No:</h5>
                                    <p>#{{ $order->order_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Billed To:</h5>
                                <h5 class="font-size-15 mb-2"> Name:-{{ $order->user->name }}</h5>
                                <p class="mb-1"> Address:- {{ $order->address1 }}, {{ $order->address2 }}</p>
                                <p class="mb-1"> Email:- {{ $order->user->email }}</p>
                                <p> Phone:- {{ $order->phone }}</p>
                            </div>
                        </div>
                        <!-- end col -->

                        <!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="py-2">
                        <h5 class="font-size-15 mt-4 text-center mb-4">Order Summary</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Item</th>
                                        <th>Image</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th class="text-end" style="width: 120px;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalAmount = 0; @endphp {{-- Initialize Total Amount --}}

                                    @foreach($order->orderItems as $key => $item)
                                    @php
                                    $itemTotal = $item->price * $item->quantity; // Calculate individual item total
                                    $totalAmount += $itemTotal; // Sum total price
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th> {{-- Auto-incrementing item number --}}
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14 mb-1">{{ $item->product->title }}
                                                </h5>
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset($item->product->photo) }}" alt="Product Image"
                                                class="img-thumbnail" style="width: 50px; height: 50px;">
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td> {{-- Format price --}}
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">Rs{{ number_format($itemTotal, 2) }}</td>

                                    </tr>
                                    @endforeach


                                    <tr>
                                        <th scope="row" colspan="5" class="border-0 text-end">Total</th>
                                        <td class="border-0 text-end">
                                            <h4 class="m-0 fw-semibold">Rs{{ number_format($totalAmount, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success me-1 ">
                                    <i class="fa fa-print"></i>
                                </a>
                                <!-- <a href="#" class="btn btn-primary w-md">Send</a> -->
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div><!-- end col -->
    </div>
</div>

<div class="text-center mt-4 mb-4">
    <a href="{{ route('home') }}" class="btn btn-primary text-white">Continue Shopping</a>
</div>

@endsection