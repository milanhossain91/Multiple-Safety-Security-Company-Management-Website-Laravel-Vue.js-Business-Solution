@extends('admin.layout')
@section('title', 'Users')
@section('page_title', 'Users')
@section('page_subtitle', 'Manage admin accounts')
@section('page_actions')
    <a href="{{ url('/admin/users/create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> New User</a>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead><tr><th>Name</th><th>Email</th><th>Joined</th><th class="text-right">Actions</th></tr></thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="font-weight-bold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ optional($user->created_at)->format('d M Y') }}</td>
                        <td class="text-right">
                            <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></a>
                            @if (auth()->id() != $user->id)
                                <a href="{{ url('/admin/users/' . $user->id . '/delete') }}" onclick="return confirm('Delete this user?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
