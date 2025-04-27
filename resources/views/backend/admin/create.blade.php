@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Admin</h5>
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('admins.store') }}" accept-charset="utf-8" method="post">
            {!! csrf_field() !!}

            @include('backend.admin.form', ['roles' => $roles])
            <div class="form-group">
                <label class="col-sm-12 control-label">&nbsp;</label>
                <div class="col-sm-10"><input class="btn btn-success" name="submit" value="Save" type="submit"
                        id="form_submit"></div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
        $('#summary').summernote({
            placeholder: "Write short description.....",
            tabsize: 2,
            height: 120
        });
    });
</script>

<script>
    $('#is_parent').change(function() {
        var is_checked = $('#is_parent').prop('checked');
        // alert(is_checked);
        if (is_checked) {
            $('#parent_cat_div').addClass('d-none');
            $('#parent_cat_div').val('');
        } else {
            $('#parent_cat_div').removeClass('d-none');
        }
    })
</script>
@endpush