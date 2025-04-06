@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Role</h5>
    <div class="card-body">
        <form class="form-horizontal"
            action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" accept-charset="utf-8"
            method="post">
            @csrf
            @if(isset($role))
            @method('PUT')
            @endif

            <div class="form-group">
                <label class="col-sm-2 control-label" for="name">Role Name</label>
                <div class="col-sm-6">
                    <input class="col-md-4 form-control" placeholder="Name" name="name"
                        value="{{ isset($role) ? old('name', $role->name) : '' }}" type="text" id="name" required>
                </div>
            </div>



            <div class="form-group">
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <input class="btn btn-success" name="submit" value="{{ isset($role) ? 'Update' : 'Save' }}"
                        type="submit">
                </div>
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

    $(document).ready(function() {
        $('#quote').summernote({
            placeholder: "Write detail Quote.....",
            tabsize: 2,
            height: 100
        });
    });
    // $('select').selectpicker();
</script>
@endpush