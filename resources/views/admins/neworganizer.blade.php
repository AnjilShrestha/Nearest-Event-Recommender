@extends('layouts.admin')
@section('title', 'Event Organizers Update')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Event Organizers Management</h5>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search event organizers...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Company Logo</th>
                            <th>CEO Name</th>
                            <th>Username</th>
                            <th>Company Name</th>
                            <th>Company Address</th>
                            <th>Company Phone</th>
                            <th>Company Email</th>
                            <th>Company Website</th>
                            <th>Company Description</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($event_organizers as $organizer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($organizer->company_logo)
                                    <img src="{{ asset('storage/' . $organizer->company_logo) }}" 
                                         alt="{{ $organizer->company_name }} Logo"
                                         class="img-thumbnail" width="100">
                                @else
                                    <span class="text-muted">No Logo</span>
                                @endif
                            </td>
                            <td>{{ $organizer->name ?? 'N/A' }}</td>
                            <td>{{ $organizer->username ?? 'N/A' }}</td>
                            <td>{{ $organizer->company_name ?? 'N/A' }}</td>
                            <td>{{ $organizer->company_address ?? 'N/A' }}</td>
                            <td>{{ $organizer->company_phone ?? 'N/A' }}</td>
                            <td>{{ $organizer->email ?? 'N/A' }}</td>
                            <td>
                                @if($organizer->company_website)
                                    <a href="{{ $organizer->company_website }}" target="_blank">Visit</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ Str::limit($organizer->company_description, 50) ?? 'N/A' }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.eventorganizer.approve', $organizer->id) }}" 
                                   class="btn btn-success btn-sm" 
                                   title="Approve">
                                    Approve
                                </a>
                                
                                <button type="button" 
                                        class="btn btn-info btn-sm" 
                                        title="View Details">
                                    View
                                </button>
                                
                                <form action="{{ route('admin.eventorganizer.reject', $organizer->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            title="Reject" 
                                            onclick="return confirm('Are you sure you want to reject this organizer?')">
                                        Reject
                                    </button>
                                </form>
                            </td> 
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center">No event organizers found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($event_organizers->total() > 0)
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Showing {{ $event_organizers->firstItem() }} to {{ $event_organizers->lastItem() }} 
                            of {{ $event_organizers->total() }} entries
                        </div>
                        {{ $event_organizers->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection