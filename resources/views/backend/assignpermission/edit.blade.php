@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Role</h5>
    <div class="card-body">
        <form
            action="{{ isset($role) ? route('assignpermissions.update', $role->id) : route('assignpermissions.store') }}"
            method="POST">
            @csrf
            @if(isset($role))
            @method('PUT')
            @endif

            <div class="form-group">
                <label>Select Role:</label>
                <select name="role_id" class="form-control" required {{ isset($role) ? 'disabled' : '' }}>
                    <option value="">-- Select Role --</option>
                    @foreach($roles as $r)
                    <option value="{{ $r->id }}" {{ isset($role) && $role->id == $r->id ? 'selected' : '' }}>
                        {{ $r->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="font-weight-bold">Select Permissions:</label>
                <div class="mb-3">
                    <button type="button" id="select-all" class="btn btn-info btn-sm">Select All</button>
                    <button type="button" id="deselect-all" class="btn btn-warning btn-sm">Deselect All</button>
                </div>

                @foreach($permissions as $module => $modulePermissions)
                <h4 class="mt-4">{{ ucfirst($module) }}</h4>

                <div class="row mb-3">
                    @foreach($modulePermissions as $permission)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permission_ids[]"
                                value="{{ $permission->id }}" id="perm_{{ $permission->id }}"
                                {{ isset($assignedPermissions) && in_array($permission->id, $assignedPermissions) ? 'checked' : '' }}>
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ ucfirst($permission->name) }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                <hr>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success">
                {{ isset($role) ? 'Update Permissions' : 'Assign Permissions' }}
            </button>
        </form>

        <script>
            document.getElementById('select-all').addEventListener('click', function() {
                document.querySelectorAll('input[name="permission_ids[]"]').forEach(function(checkbox) {
                    checkbox.checked = true;
                });
            });
            document.getElementById('deselect-all').addEventListener('click', function() {
                document.querySelectorAll('input[name="permission_ids[]"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            });
        </script>

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

@endpush