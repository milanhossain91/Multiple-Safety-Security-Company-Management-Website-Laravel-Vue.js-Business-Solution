<form action="{{ $action }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Password @if($user->exists)<span class="text-muted small">(leave blank to keep current)</span>@else<span class="text-danger">*</span>@endif</label>
                        <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }} autocomplete="new-password">
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk mr-1"></i> Save User</button>
                    <a href="{{ url('/admin/users') }}" class="btn btn-light">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
