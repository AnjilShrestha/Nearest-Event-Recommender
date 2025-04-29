@extends('layouts.admin')
@section('title', 'Event Categories List')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Event Categories List</h5>
        </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search event categories...">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAdminModal">
                    <i class="fas fa-plus mr-2"></i> Add New Event Category
                </button>
                <!-- Add Admin Modal -->
                @include('adminfolder.addeventcategory')

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Event Category Name</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($eventcategories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $category->name }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#editAdminModal">
                                        Edit
                                    </button>
                                    @include('dialog.eventcategoryedit', ['eventcategory' => $category])
                                    <form action="{{ route('admin.eventcategory.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this event category?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
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

<!-- JavaScript for search functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    });
</script>

@endsection