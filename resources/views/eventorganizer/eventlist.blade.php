@extends('layouts.eventorganizer')
@section('title', 'Event Organized list')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-users mr-2"></i>Event list</h5>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search event organizers...">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary mb-3">
                <a href="{{ route('eventorganizer.addevent') }}" class="text-white">
                    <i class="fas fa-plus mr-2"></i> Add New Event
                </a>
            </button>

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%">#</th>
                            <th>Event title</th>
                            <th> Event Category</th>
                            <th>Event Date</th>
                            <th>Event Start Time</th>
                            <th>Event End Time</th>
                            <th>Event location</th>
                            <th>image</th>
                            <th>Feautures</th>
                            <th>Tags</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                        <tr>
                            
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->category->categories_name }}</td>
                            <td>{{ $event->event_date }}</td>
                            <td>{{ $event->starttime }}</td>
                            <td>{{ $event->endtime }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$event->image) }}" alt="Event Image" class="img-fluid" />
                            </td>
                            <td>{{ $event->features }}</td>
                            <td>{{ $event->tags }}</td>
                            <td>
                                 <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('eventorganizer.event.edit', $event->id) }}" class="btn btn-primary" title="Edit">
                                        Edit
                                    </a>
                                {{--<button type="button" class="btn btn-info" title="View Details" >
                                        View
                                    </button> --}}
                                    <form action="{{ route('eventorganizer.event.delete', $event->id) }}" method="POST" class="btn btn-danger">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"  class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class=" row mt-3">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <div class="text-muted">
                        Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} entries
                    </div>
                </div>
                {{ $events->links() }}
            
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