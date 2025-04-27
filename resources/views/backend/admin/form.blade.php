<div class="form-group">
    <label class="col-sm-12 control-label" for="title">Name</label>
    <div class="col-sm-6">
        <input class="col-md-4 form-control" placeholder="Name" name="name" value="{{ old('name', isset($admin) ? $admin->name : null) }}" type="text" id="title">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-12 control-label" for="icon">Email</label>
    <div class="col-sm-6">
        <input class="col-md-4 form-control" placeholder="Email" name="email" value="{{ old('email', isset($admin) ? $admin->email : null) }}" type="text" id="icon">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-12 control-label" for="link">Password</label>
    <div class="col-sm-6">
        <input class="col-md-4 form-control" placeholder="Password" name="password" value="{{ old('password') }}" type="text" id="link">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-12 control-label" for="role">Role</label>
    <div class="col-sm-6">
        <select class="col-md-4 form-control" name="role_id" id="role">
            <option value="">Select Role</option>
            @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ old('role_id', isset($admin) ? $admin->role_id : null) == $role->id ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
            @endforeach
        </select>
    </div>
</div>