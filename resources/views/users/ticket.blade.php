@extends('layouts.frontlayout')
@section('content')
  <div class="container py-5">
    <h2>Welcome back,{{ auth('user')->user()->name }}</h2>
    <p class="text-muted">Here's what's happening with your events</p>
  

  
    <!-- Ticket purchase history -->
    <div>
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5>Your ticket purchase history</h5>
      </div>
  
      @forelse($payments as $payment)
        tabl
      @empty
      No ticket purchased
      @endforelse
  
      
  

@endsection