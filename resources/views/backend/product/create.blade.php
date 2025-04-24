@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Product</h5>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="post" action="{{route('product.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{old('title')}}"
                    class="form-control">
                @error('title')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
                <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
                @error('summary')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="col-form-label">Description</label>
                <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
                @error('description')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="is_featured">Is Featured</label><br>
                <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
            </div>
            {{-- {{$categories}} --}}

            <div class="form-group">
                <label for="cat_id">Category <span class="text-danger">*</span></label>
                <select name="cat_id" id="cat_id" class="form-control">
                    <option value="">--Select any category--</option>
                    @foreach($categories as $key=>$cat_data)
                    <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group d-none" id="child_cat_div">
                <label for="child_cat_id">Sub Category</label>
                <select name="child_cat_id" id="child_cat_id" class="form-control">
                    <option value="">--Select any category--</option>
                    {{-- @foreach($parent_cats as $key=>$parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
                    @endforeach --}}
                </select>
            </div>
            <div class="form-group">
                <label class="col-form-label">Colors</label>
                <div id="color-wrapper">
                    <div class="d-flex align-items-center mb-2">
                        <input type="color" name="colors[]" class="form-control form-control-color mr-2"
                            value="#000000">
                        <button type="button" class="btn btn-sm btn-danger remove-color">X</button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary" id="add-color">Add Color</button>
                @error('colors')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="sizes" class="col-form-label">Sizes</label>
                <select name="sizes[]" id="sizes" class="form-control select2" multiple>
                    <option value="S" {{ in_array('S', old('sizes', [])) ? 'selected' : '' }}>S</option>
                    <option value="M" {{ in_array('M', old('sizes', [])) ? 'selected' : '' }}>M</option>
                    <option value="L" {{ in_array('L', old('sizes', [])) ? 'selected' : '' }}>L</option>
                    <option value="XL" {{ in_array('XL', old('sizes', [])) ? 'selected' : '' }}>XL</option>
                </select>
                @error('sizes')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="col-form-label">Price(NRS) <span class="text-danger">*</span></label>
                <input id="price" type="number" name="price" placeholder="Enter price" value="{{old('price')}}"
                    class="form-control">
                @error('price')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="discount" class="col-form-label">Discount(%)</label>
                <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount"
                    value="{{old('discount')}}" class="form-control">
                @error('discount')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="condition">Condition</label>
                <select name="condition" class="form-control">
                    <option value="">--Select Condition--</option>
                    <option value="default">Default</option>
                    <option value="new">New</option>
                    <option value="hot">Hot</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Quantity <span class="text-danger">*</span></label>
                <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"
                    value="{{old('stock')}}" class="form-control">
                @error('stock')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                <input id="inputPhoto" type="file" name="photo" class="form-control">
                <div id="holder" style="margin-top: 15px; max-height: 100px;"></div>
                @error('photo')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="discount" class="col-form-label">Tutorial Link</label>
                <textarea class="form-control" name="tutorial_link"></textarea>
                @error('tutorial_link')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                <select name="status" class="form-control">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                @error('status')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
        $('#summary').summernote({
            placeholder: "Write short description.....",
            tabsize: 2,
            height: 100
        });
    });

    $(document).ready(function() {
        $('#description').summernote({
            placeholder: "Write detail description.....",
            tabsize: 2,
            height: 150
        });
    });
    // $('select').selectpicker();
</script>

<script>
    $('#cat_id').change(function() {
        var cat_id = $(this).val();
        // alert(cat_id);
        if (cat_id != null) {
            // Ajax call
            $.ajax({
                url: "/admin/category/" + cat_id + "/child",
                data: {
                    _token: "{{csrf_token()}}",
                    id: cat_id
                },
                type: "POST",
                success: function(response) {
                    if (typeof(response) != 'object') {
                        response = $.parseJSON(response)
                    }
                    // console.log(response);
                    var html_option = "<option value=''>----Select sub category----</option>"
                    if (response.status) {
                        var data = response.data;
                        // alert(data);
                        if (response.data) {
                            $('#child_cat_div').removeClass('d-none');
                            $.each(data, function(id, title) {
                                html_option += "<option value='" + id + "'>" + title +
                                    "</option>"
                            });
                        } else {}
                    } else {
                        $('#child_cat_div').addClass('d-none');
                    }
                    $('#child_cat_id').html(html_option);
                }
            });
        } else {}
    })
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        // Add Color Field
        $('#add-color').click(function() {
            $('#color-wrapper').append(`
                <div class="d-flex align-items-center mb-2">
                    <input type="color" name="colors[]" class="form-control form-control-color mr-2" value="#000000">
                    <button type="button" class="btn btn-sm btn-danger remove-color">X</button>
                </div>
            `);
        });

        // Remove Color Field
        $(document).on('click', '.remove-color', function() {
            $(this).closest('.d-flex').remove();
        });
    });
</script>
@endpush