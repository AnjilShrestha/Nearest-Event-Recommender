@extends('layouts.admin')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css" integrity="sha384-NvKbDTEnL+A8F/AA5Tc5kmMLSJHUO868P+lDtTpJIeQdGYaUIuLr4lVGOEA1OcMy" crossorigin="anonymous">
@section('title', 'Event Categories List')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Event Categories List</h5>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('admin.eventcategories') }}" method="GET" class="input-group">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search event categories...">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="bi bi-plus"></i>Add Event Category
                    </button>
                </div>
            </div>
            @include('admins.addeventcategory')

            @if($event_categories->isEmpty())
                <div class="alert alert-info">No event categories found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th width="5%">#</th>
                                <th>Title</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($event_categories as $category)
                            <tr>
                                <td>{{ ($event_categories->currentPage() - 1) * $event_categories->perPage() + $loop->iteration }}</td>
                                <td>{{ $category->categories_name }}</td>
                                <td class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                         Edit
                                    </button>
                                    <form action="{{ route('admin.eventcategories.delete', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                             Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @include('admins.editeventcategory', ['category' => $category])
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class=" mt-5">
                    {{ $event_categories->links('pagination::bootstrap-5') }}
                </div>
                @endif
        </div>
    </div>
</div>
@endsection