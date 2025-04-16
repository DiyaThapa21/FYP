@extends('backend.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        background-color: #ccc;
        transition: 0.4s;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #28a745;
        /* Green for active */
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #28a745;
    }

    input:checked+.slider:before {
        transform: translateX(24px);
    }
</style>

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
        @can('create-item')<a href="{{route('product.create')}}" class="btn btn-primary btn-sm float-right"
            data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add
            Product</a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(count($products)>0)
            <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Is Featured</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>IBAN </th>
                        <th>Condition</th>
                        <!-- <th>Brand</th> -->

                        @can('added-by-product')

                        <th>Added By</th>

                        @endcan
                        <th>Stock</th>
                        <th>Photo</th>
                        <th>Status</th>
                        @can('approve-product')
                        <th>Approve / Disapprove</th>
                        @endcan
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($products as $product)
                    @php
                    $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
                    // dd($sub_cat_info);
                    $brands=DB::table('brands')->select('title')->where('id',$product->brand_id)->get();
                    @endphp
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->title}}</td>
                        <td>{{@$product->cat_info['title']}}
                            <sub>
                                {{$product->sub_cat_info->title ?? ''}}
                            </sub>
                        </td>
                        <td>{{(($product->is_featured==1)? 'Yes': 'No')}}</td>
                        <td>Rs. {{$product->price}} /-</td>
                        <td> {{$product->discount}}% OFF</td>
                        <td>{{$product->size}}</td>
                        <td>{{$product->condition}}</td>
                        @can('added-by-product')

                        <td>{{@$product->addedBy->name}}</td>
                        @endcan

                        <!-- <td>{{ ucfirst(optional($product->brand)->title) }}</td> -->
                        <td>
                            @if($product->stock>0)
                            <span class="badge badge-primary">{{$product->stock}}</span>
                            @else
                            <span class="badge badge-danger">{{$product->stock}}</span>
                            @endif
                        </td>
                        <td>
                            @if($product->photo)
                            @php
                            $photos = explode(',', $product->photo); // Split the photo string by comma
                            @endphp
                            @foreach($photos as $photo)
                            <img src="{{ asset($photo) }}" class="img-fluid zoom" style="max-width:80px"
                                alt="product-image">
                            @endforeach
                            @else
                            <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                style="max-width:80px" alt="avatar.png">
                            @endif
                        </td>

                        <td>
                            @if($product->status=='active')
                            <span class="badge badge-success">{{$product->status}}</span>
                            @else
                            <span class="badge badge-warning">{{$product->status}}</span>
                            @endif
                        </td>
                        @can('approve-product')
                        <td>
                            <form action="{{ route('product.status.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="status"
                                    value="{{ $product->status == 'active' ? 'inactive' : 'active' }}">
                                <label class="switch">
                                    <input type="checkbox" onchange="this.form.submit()"
                                        {{ $product->status == 'active' ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </form>
                        </td>
                        @endcan


                        <td>
                            @can('edit-item')<a href="{{route('product.edit',$product->id)}}"
                                class="btn btn-primary btn-sm float-left mr-1"
                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                data-placement="bottom"><i class="fas fa-edit"></i></a>
                            @endcan

                            @can('delete-item')

                            <form method="POST" action="{{route('product.destroy',[$product->id])}}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm dltBtn" data-id={{$product->id}}
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                    data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </form>@endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <span style="float:right">{{$products->links()}}</span>
            @else
            <h6 class="text-center">No Products found!!! Please create Product</h6>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    div.dataTables_wrapper div.dataTables_paginate {
        display: none;
    }

    .zoom {
        transition: transform .2s;
        /* Animation */
    }

    .zoom:hover {
        transform: scale(5);
    }
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
    $('#product-dataTable').DataTable({
        "scrollX": false "columnDefs": [{
            "orderable": false,
            "targets": [10, 11, 12]
        }]
    });

    // Sweet alert

    function deleteData(id) {

    }
</script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.dltBtn').click(function(e) {
            var form = $(this).closest('form');
            var dataID = $(this).data('id');
            // alert(dataID);
            e.preventDefault();
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
        })
    })
</script>
<script>
    $(document).ready(function() {
        $('.custom-toggle').change(function() {
            var status = $(this).is(':checked') ? 'active' : 'inactive';
            var product_id = $(this).data('id');

            $.ajax({
                url: '{{ route("product.status.update") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    id: product_id
                },
                success: function(response) {
                    if (response.success) {
                        console.log(response.message);
                    } else {
                        alert('Something went wrong!');
                    }
                },
                error: function() {
                    alert('Failed to update product status.');
                }
            });
        });
    });
</script>

@endpush