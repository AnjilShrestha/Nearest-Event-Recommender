@extends('layouts.admin')
@section('title', 'Admin Management')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Admin</h5>
        </div>   
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3">
                    <a href="{{ route('admin.addadmin') }}" class="text-white">
                        <i class="bi bi-plus mr-2"></i> Add New Admin
                    </a>
                </button>

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->username }}</td>
                            <td>
                                <a href="{{ route('admin.editadmin', $admin->id) }}" >
                                    <button type="button" class="btn btn-warning">Edit</button>
                                </a>
                                <form action="{{ route('admin.deleteadmin', $admin->id) }}" method="POST">
                                    @csrf
                                    @method('post')
                                    <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this admin?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $admins->links() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection