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
                            <h5 class="card-title">Orders List</h5>

                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark" style="position: sticky; top: 0; background: white; z-index: 10;">
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Order No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Quantity</th>
                                            <th>Charge</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                        @php
                                        $shipping_charge = DB::table('shippings')->where('id', $order->shipping_id)->pluck('price');
                                        @endphp
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->order_number}}</td>
                                            <td>{{$order->first_name}} {{$order->last_name}}</td>
                                            <td>{{$order->email}}</td>
                                            <td>{{$order->quantity}}</td>
                                            <td>
                                                @foreach($shipping_charge as $data)
                                                Rs {{number_format($data,2)}}
                                                @endforeach
                                            </td>
                                            <td>Rs {{number_format($order->total_amount,2)}}</td>
                                            <td>
                                                @if($order->status=='new')
                                                <span class="badge badge-primary">{{$order->status}}</span>
                                                @elseif($order->status=='process')
                                                <span class="badge badge-warning">{{$order->status}}</span>
                                                @elseif($order->status=='delivered')
                                                <span class="badge badge-success">{{$order->status}}</span>
                                                @else
                                                <span class="badge badge-danger">{{$order->status}}</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('user.order.show',[$order->id]) }}" class="btn btn-sm btn-primary text-white">View</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection