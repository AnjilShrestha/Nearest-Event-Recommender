@extends('layouts.frontlayout')
@section('title','Event Details')

@section('content')
    <style>
        .event-image {
            width: 50%;
            height: auto;
        }
        .details-card {
            border: 1px solid #d3d3d3;
            border-radius: 5px;
            padding: 20px;
            background-color: #f7f7f7;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .nav-tabs .nav-link {
            color: #495057;
            border: none;
            padding: 0.8rem 1.5rem;
        }
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 3px solid #0d6efd;
            background-color: transparent;
        }
        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-top: 15px;
        }
    </style>
    @include('layouts.searchbar')
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <img src="{{ asset('storage/'.$event->image) }}" alt="Event" class="event-image">
                <h2 class="mt-3">{{$event->title}}</h2>
            </div>
            <div class="col-lg-4">
                <div class="details-card">
                    <div class="card-body">
                        <h5 class="card-title">{{$event->title}}</h5>
                        
                        <h6>Organized by {{$event->organizer->company_name}}</h6>
                        <div class="d-flex align-items-center mb-2">
                            <img src="{{ asset('storage/'.$event->organizer->company_logo) }}" width="30px" class="me-2">
                            <span>{{$event->organizer->company_name}}</span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-calendar-event me-2"></i>
                            <span>{{$event->event_date}}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-clock me-2"></i>
                            <span>{{ $event->starttime }}-{{ $event->endtime }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-geo-alt me-2"></i>
                            <span>{{$event->location}}</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-tag me-2"></i>
                            <span>Rs.{{$event->price}}</span>
                        </div>
                        
                        @if(($event->event_date>today() && auth()->guard('user')->check()))
                            <div class="ticket-purchase-container mb-4">
                                <button class="btn btn-primary" onclick="showTicketQuantityBox(this)">
                                    <i class="bi bi-ticket-perforated me-2"></i>
                                    Purchase ticket
                                </button>
                                <div class="quantity-box mt-3" style="display: none;">
                                    <div class="d-flex align-items-center gap-2">
                                        <form action="{{ route('pay.esewa') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $event->id }}">
                                            <button class="btn btn-outline-danger btn-sm" type="button" onclick="decreaseQuantity(this)">−</button>
                                            <input type="number" name="quantity" class="form-control text-center quantity-input" value="1" min="1" max="10" style="width: 60px;" onchange="updateTotalPrice(this)">
                                            <button class="btn btn-outline-success btn-sm" type="button" onclick="increaseQuantity(this)">+</button>
                                            <div class="ms-3">
                                                <strong>Total:</strong> Rs.
                                                <span class="total-price">
                                                    {{ $event->price }}
                                                </span>
                                                <input type="hidden" name="totalprice" class="form-control form-control-sm total-price-input" 
                                                value="{{ $event->price }}" readonly style="width: 100px;">
                                            </div>
                                            <input type="submit" value="GetTicket" name="btn btn-primary">
                                        </form>
                                    </div>
                                    <div class="mt-2 small text-muted">(Max: 10 tickets)</div>
                                </div>
                            </div>
                        @elseif(($event->event_date>today()))
                            <a href="{{ route('user.login') }}">Proceed to login</a>
                        @else
                         <button class="btn btn-secondary" disabled>Event ended</button>
                         @endif
                    </div>
                </div>
            </div>
        </div>

        <div class=" mt-3 mb-3">
            <strong>Category:</strong>
            <span class="badge bg-secondary">{{ $event->category->categories_name }}</span>
        </div>
        <div class="tags mt-3 mb-3">
            <strong>Tags:</strong>
            @if(!empty($event->tags))
                @foreach(json_decode($event->tags, true) as $index => $tag)  
                    <span class="badge bg-secondary">{{ $tag }}</span>
                @endforeach
            @endif
            
        </div>
        <ul class="nav nav-tabs mb-4" id="eventTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true">About</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab" aria-controls="features" aria-selected="true">feature</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab" aria-controls="location" aria-selected="false">Location</button>
            </li>
        </ul>
        
        <div class="tab-content" id="eventTabsContent">
            <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
                <p>{{$event->description}}</p>
            </div>
            <div class="tab-pane fade show" id="features" role="tabpanel" aria-labelledby="features-tab">
                <p>
                    @if(!empty($event->features))
                        @foreach(json_decode($event->features, true) as $index => $feature)  
                            {{ $feature }}<br>
                        @endforeach
                    @endif
                </p>
            </div>
            <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                <div class="map-container">
                    <iframe
                        width="100%"
                        height="400"
                        frameborder="0"
                        style="border:0; border-radius: 8px;"
                        src="https://maps.google.com/maps?q={{ $event->latitude }},{{ $event->longitude }}&hl=en&z=15&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>
                <p class="mt-3"><i class="bi bi-geo-alt-fill"></i> {{$event->location}}</p>
            </div>
        </div>
    </div>
    <div>
        @include('eventcard')
    </div>
@endsection
<script>
    
    const TICKET_PRICE = {{ $event->price }};
    
    function showTicketQuantityBox(button) {
    const container = button.parentElement;
    const quantityBox = container.querySelector('.quantity-box');
    quantityBox.style.display = 'block';
    button.style.display = 'none';
}

function increaseQuantity(button) {
    const parent = button.parentElement;
    const input = parent.querySelector('.quantity-input');
    let quantity = parseInt(input.value);

    if (quantity < 10) {
        quantity++;
        input.value = quantity;
        updateTotal(input);
    }
}

function decreaseQuantity(button) {
    const parent = button.parentElement;
    const input = parent.querySelector('.quantity-input');
    let quantity = parseInt(input.value);

    if (quantity > 1) {
        quantity--;
        input.value = quantity;
        updateTotal(input);
    }
}

function updateTotal(input) {
    const parent = input.parentElement;
    const totalPriceSpan = parent.querySelector('.total-price');
    const totalPriceInput = parent.querySelector('.total-price-input');

    let quantity = parseInt(input.value);

    if (isNaN(quantity) || quantity < 1) {
        quantity = 1;
    } else if (quantity > 10) {
        quantity = 10;
    }

    input.value = quantity;

    const total = quantity * TICKET_PRICE;

    totalPriceSpan.textContent = total;
    totalPriceInput.value = total;
}
</script>