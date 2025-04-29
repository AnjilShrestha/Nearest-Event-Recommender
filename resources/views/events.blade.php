@extends('layouts.frontlayout')

@section('title', 'Event find')
@section('content')
@include('layouts.searchbar')

@if($events->isEmpty())
    <div class="alert alert-warning">
        No events found near chosen location.
    </div>
@else
<h2 class="text-center m-4">Nearby Events from choosen location</h2>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" id="event-container">
     {{-- title --}}
@foreach ($events as $event)
    <div class="col">
        <div class="card h-100 shadow-sm border-0 overflow-hidden animate__animated animate__fadeIn hover-shadow transition-all" style="max-width: 400px;"> <!-- Added max-width -->
            <!-- Card Image with Payment Badge -->
            <div class="position-relative">
                <img src="{{ asset('storage/'.$event->image) }}" 
                     class="card-img-top object-fit-cover" 
                     style="height: 200px;"
                     alt="{{ $event->title }}">

                <!-- Paid/Free Badge -->
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge rounded-pill bg-{{ $event->is_paid ? 'warning' : 'success' }} bg-opacity-90 px-3 py-2 shadow-sm">
                        {{ $event->is_paid ? 'Paid' : 'Free' }}
                    </span>
                </div>
                <div class="position-absolute bottom-0 end-0 m-2">
                    @php
                        $today=now()->toDateString();
                    @endphp
                    <span class="badge rounded-pill bg-{{ $event->event_date>$today ? 'success' : 'danger' }} bg-opacity-90 px-3 py-2 shadow-sm">
                        {{ $event->event_date>$today ? 'event starting soon' : 'event ended' }}
                    </span>
                </div>
                <!-- Category Badge -->
                <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge rounded-pill bg-info bg-opacity-90 px-3 py-2 shadow-sm">
                        <i class="bi bi-tags me-1"></i>
                        {{ $event->category->categories_name ?? 'Uncategorized' }}
                    </span>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body pb-2">
                <h3 class="card-title fw-bold mb-2" style="font-size: 1.2rem;">{{ $event->title }}</h3> <!-- Reduced title size -->
                <p class="text-muted small mb-2">
                    <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                    <br>
                    <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($event->starttime)->format('g:i A') }}-{{ \Carbon\Carbon::parse($event->endtime)->format('g:i A') }}
                </p>
                <p class="text-muted mb-2">
                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $event->location }}
                    {{-- distance --}}
                    <p>
                        <i class="bi bi-arrows-fullscreen me-1"></i> {{ number_format($event->distance,2) }} km away
                    </p>
                </p>

                <!-- Participants & Price -->
                <p class="mb-2">
                    <span class="badge bg-light text-dark me-2">
                        <i class="bi bi-people-fill me-1"></i> Max: {{ $event->max_participants }}
                    </span>
                    @if($event->is_paid)
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-currency-dollar me-1"></i> {{ number_format($event->price, 2) }}
                        </span>
                    @endif
                </p>
            </div>

            <!-- Card Footer -->
            <div class="card-footer bg-transparent border-top-0 pt-0">
                <a href="{{route('event.details', $event->id) }}" 
                   class="btn btn-outline-primary w-100 rounded-pill py-2 hover-grow">
                   <i class="bi bi-info-circle me-2"></i> View Details
                </a>
            </div>
        </div>
    </div>
@endforeach
</div>
@endif
@endsection