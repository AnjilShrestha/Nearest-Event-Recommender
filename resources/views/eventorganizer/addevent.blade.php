@extends('layouts.eventorganizer')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div>
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create New Event</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('eventorganizer.addevent.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Event Title*</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description*</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="event_date" class="form-label">Date*</label>
                                    <input type="date" class="form-control @error('event_date') is-invalid @enderror" 
                                           id="event_date" name="event_date" value="{{ old('event_date') }}">
                                    @error('event_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    
                                    <div class="col-md-6">
                                        <label for="starttime" class="form-label">Start Time*</label>
                                        <input type="time" class="form-control @error('starttime') is-invalid @enderror" 
                                               id="starttime" name="starttime" value="{{ old('starttime') }}">
                                        @error('starttime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="endtime" class="form-label">End Time*</label>
                                        <input type="time" class="form-control @error('endtime') is-invalid @enderror" 
                                               id="endtime" name="endtime" value="{{ old('endtime') }}">
                                        @error('endtime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="form-group mb-3">
                                    <label for="location" class="form-label">Location*</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                           id="location" name="location" value="{{ old('location') }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="feature-fields" class="form-label fw-bold mb-3">Features</label>
                                    <div id="feature-fields" class="mb-2">
                                        <div class="input-group mb-2">
                                            <input type="text" class="form-control" name="features[]" placeholder="Enter feature">
                                            <button class="btn btn-outline-danger" type="button" onclick="removeFeature(this)" disabled>
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="addFeature()">
                                        <i class="bi bi-plus-circle me-2"></i>Add Another Feature
                                    </button>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Event Category*</label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->categories_name }}</option>
                                        @endforeach
                                    </select>


                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Coordinates (hidden inputs) -->
                                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                            </div>
                            <div class="col-md-6">
                                <!-- Map -->
                                <div class="form-group mb-3">
                                    <label class="form-label">Tags (comma-separated)</label>
                                    <input type="text" name="tags" class="form-control" placeholder="e.g. music, food, outdoor" >
                                    @error('tags') <small class="invalid-feedback">{{ $message }}</small> @enderror
                                </div>
                                
                                <div class="form-group mb-3">    
                                    <label class="form-label">Select Location on Map</label>
                                    <div id="map" style="height: 300px; width: 100%;" class="border rounded"></div>
                                    <small class="text-muted">Click on the map to set the exact location</small>
                                </div>

                                <!-- Image Upload -->
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Event Image*</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*" >
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_paid" name="is_paid" 
                                               value="1" {{ old('is_paid') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_paid">Paid Event</label>
                                    </div>
                                </div>

                                <div class="form-group mb-3" id="price-field" style="display: none;">
                                    <label for="price" class="form-label">Price (Rs)*</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', 0) }}" min="0" step="0.01">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="#" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    function addFeature() {
        const container = document.getElementById('feature-fields');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-2';
        
        inputGroup.innerHTML = `
            <input type="text" class="form-control" name="features[]" placeholder="Enter feature">
            <button class="btn btn-outline-danger" type="button" onclick="removeFeature(this)">
                <i class="bi bi-trash"></i>
            </button>
        `;
        
        container.appendChild(inputGroup);
    }
    
    function removeFeature(button) {
        const inputGroups = document.querySelectorAll('#feature-fields .input-group');
        if (inputGroups.length > 1) {
            button.closest('.input-group').remove();
        }
    }
    </script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        // Toggle price field based on is_paid checkbox
        const isPaidCheckbox = document.getElementById('is_paid');
        const priceField = document.getElementById('price-field');
        
        isPaidCheckbox.addEventListener('change', function() {
            priceField.style.display = this.checked ? 'block' : 'none';
            if (!this.checked) {
                document.getElementById('price').value = '0';
            }
        });
        
        // Trigger change event on page load in case checkbox is checked
        if (isPaidCheckbox.checked) {
            priceField.style.display = 'block';
        }
    });
    function initMap()
    {
        // Initialize map
        const kathmanduCoords = { lat: 27.7172, lng: 85.3240 };

        map = new google.maps.Map(document.getElementById("map"), {
        center: kathmanduCoords,
        zoom: 13,
        });

        marker = new google.maps.Marker({
        position: kathmanduCoords,
        map: map,
        draggable: true,
        });

        // Set initial hidden inputs
        document.getElementById("latitude").value = kathmanduCoords.lat;
        document.getElementById("longitude").value = kathmanduCoords.lng;

        // Update on drag
        marker.addListener("dragend", function () {
        const position = marker.getPosition();
        document.getElementById("latitude").value = position.lat().toFixed(6);
        document.getElementById("longitude").value = position.lng().toFixed(6);
        });

        // Update on map click
        map.addListener("click", function (event) {
        const clickedLocation = event.latLng;
        marker.setPosition(clickedLocation);
        document.getElementById("latitude").value = clickedLocation.lat().toFixed(6);
        document.getElementById("longitude").value = clickedLocation.lng().toFixed(6);
        });
    }
</script>
<script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTZUs__2EwyrF5vImHIa3VpkXKDN1cWsM&callback=initMap">
    </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#category_id').select2({
            placeholder: "Select Category",
            allowClear: true
        });
    });
</script>

