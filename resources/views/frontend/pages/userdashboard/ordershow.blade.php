@extends('frontend.layouts.master')

@section('title','Un-ko Uneko || User Dashboard')

@section('main-content')

<div class="container mt-3 mb-3">
    <div class="card shadow-sm p-4 rounded-lg">
        <div class="col-md-12">
            <div class="row">

                @include('frontend.pages.userdashboard.include.sidebar')

                <div class="col-md-9">
                    <div class="card shadow-sm mt-4 rounded-lg">
                        <div class="card-body">


                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Order Information</h5>
                                    <p><strong>Order No:</strong> {{ $order->order_number }}</p>
                                    <p><strong>Order Date:</strong>
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M, Y') }}
                                    </p>
                                    <p><strong>Status:</strong> <span
                                            class="badge bg-primary">{{ ucfirst($order->status) }}</span></p>
                                    <p><strong>Payment Type:</strong>{{ ucfirst($order->payment_method) }}</p>
                                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                                </div>

                            </div>

                            <hr>

                            <h5 class="mt-4">Order Items</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalAmount = 0; @endphp
                                        @foreach($order->orderItems as $key => $item)
                                        @php
                                        $itemTotal = $item->price * $item->quantity;
                                        $totalAmount += $itemTotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->product->title }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>Rs {{ number_format($item->price, 2) }}</td>
                                            <td>Rs {{ number_format($itemTotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <p>Total Amount: Rs {{ number_format($totalAmount, 2) }}</p>
                                <p>Shipping Charge: Rs {{ number_format($order->shipping_charge, 2) }}</p>
                                <p class="mt-2">Grand Total: Rs {{ number_format($order->total_amount, 2) }}</p>
                            </div>




                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection