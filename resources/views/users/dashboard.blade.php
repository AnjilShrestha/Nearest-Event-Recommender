@extends('layouts.frontlayout')
@section('content')
<style>
    .card-metric {
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    .nav-tabs .nav-link.active {
      background-color: #f8f9fa;
      border-color: #dee2e6 #dee2e6 #fff;
    }
    .event-card img {
      height: 150px;
      object-fit: cover;
    }
  </style>
  <div class="container">
    <h2>Welcome back,{{ auth('user')->user()->name }}</h2>
    <p class="text-muted">Here's what's happening with your events</p>
  
    <!-- Metrics -->
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card card-metric text-center p-3">
          <h6>Events Attended</h6>
          <h3>{{ $endedCount}}</h3>
          <p class="text-muted">Lifetime attendance</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-metric text-center p-3">
          <h6>Upcoming Events</h6>
          <h3>{{ $upcomingCount}}</h3>
          <p class="text-muted">Events you're attending</p>
        </div>
      </div>
    </div>
  
    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="dashboardTabs">
      <li class="nav-item">
        <a class="nav-link active" href="#">Overview</a>
      </li>
    </ul>
  
    <!-- Upcoming Events -->
    <div>
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Your Upcoming Events</h5>
      </div>
  
      @forelse($upcomingEvents as $group)
      @php $event = $group->first()->event; @endphp
      <div class="card mb-3 event-card">
        <div class="row g-0">
          <div class="col-md-4">
            <img src="{{ asset('storage/'.$event->image) }}" class="img-fluid rounded-start" alt="Event Image">
          </div>
          <div class="col-md-8 d-flex flex-column justify-content-between p-3">
            <div>
              <h5 class="card-title mb-1">{{ $event->title }}</h5>
              <p class="mb-1"><i class="bi bi-calendar-event"></i> {{ $event->event_date }}</p>
              <p class="mb-1"><i class="bi bi-clock"></i> {{ $event->starttime }} - {{ $event->endtime }}</p>
              <p class="mb-0"><i class="bi bi-geo-alt"></i> {{ $event->location }}</p>
            </div>
            <div class="text-end">
              <a href="{{ route('event.details', $event->id) }}" class="btn btn-dark btn-sm">View Details</a>
            </div>
          </div>
        </div>
      </div>
  @empty
    <p>No upcoming events.</p>
  @endforelse
  
@endsection