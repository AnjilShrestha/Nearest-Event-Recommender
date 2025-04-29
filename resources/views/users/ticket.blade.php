@extends('layouts.frontlayout')
@section('content')
  <div>
    <!-- Ticket purchase history -->
    <div>
      <div class="justify-content-between align-items-center mb-2">
        <h5>Your ticket purchase history</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-bordered mb-0">
            <thead class="thead-light">
                <tr>
                    <th width="5%">#</th>
                    <th>Event name</th>
                    <th>Event date</th>
                    <th>Event time</th>
                    <th>Number of tickets</th>
                    <th>Transaction number</th>
                    <th>Payment method</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{$ticket->event->title}}</td>
                  <td>{{$ticket->event->event_date}}</td>
                  <td>{{$ticket->event->starttime}}-{{$ticket->event->endtime}}</td>
                  <td>{{$ticket->quantity}}</td>
                  <td>{{$ticket->transaction_id}}</td>
                  <td>{{$ticket->payment_method}}</td>
                  @php
                    $statusClass = match($ticket->payment_status) {
                        'paid' => 'bg-success',
                        'pending' => 'bg-warning',
                        'failed' => 'bg-danger',
                        default => 'bg-secondary'
                      };
                  @endphp

                  <td><span class="badge {{ $statusClass }}">{{ $ticket->payment_status }}</span></td>
                </tr>
                @empty
                No ticket purchased
                @endforelse
            </tbody>
        </table>
        <div class="mt-5 ">
            {{ $tickets->links('pagination::bootstrap-5') }}
        </div>
    </div>  

@endsection