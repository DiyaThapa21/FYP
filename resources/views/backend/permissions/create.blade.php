@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Permission</h5>
    <div class="card-body">
        <form class="form-horizontal" action="{{ route('permissions.store') }}" accept-charset="utf-8" method="post">
            {!! csrf_field() !!}

            <div class="form-group">
                <label class="col-sm-2 control-label">Module</label>
                <div class="col-sm-10">
                    <select name="module" class="form-control" required id="module-select">
                        <option value="">-- Select Module --</option>
                        @foreach($modules as $module)
                        <option value="{{ $module }}">{{ ucfirst($module) }}</option>
                        @endforeach
                        <option value="custom">Other (Specify Below)</option>
                    </select>
                </div>
            </div>
            <div class="form-group" id="custom-module-group" style="display: none;">
                <label class="col-sm-2 control-label">Custom Module Name</label>
                <div class="col-sm-10">
                    <input type="text" name="custom_module" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="Name">Title</label>
                <div class="col-sm-6">
                    <input class="col-md-4 form-control" placeholder="Name" name="name" value="" type="text" id="title">
                </div>
            </div>




            <div class="form-group">
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <input class="btn btn-success" name="submit" value="Save" type="submit" id="form_submit">
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
    document.getElementById('module-select').addEventListener('change', function() {
        if (this.value === 'custom') {
            document.getElementById('custom-module-group').style.display = 'block';
        } else {
            document.getElementById('custom-module-group').style.display = 'none';
        }
    });
</script>

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