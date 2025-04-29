<style>
    .search-container {
        width: 100%;
        max-width: 640px; 
    }
    .search-input {
        border-radius: 20px 0 0 20px;
        border-right: none;
        padding: 8px 15px;
    }
    .search-btn {
        border-radius: 0 20px 20px 0;
        background-color: #f8f9fa;
        border-left: none;
    }
    .search-btn:hover {
        background-color: #e9ecef;
    }
    .mic-btn {
        background: none;
        border: none;
        color: #333;
        margin-left: 10px;
    }
    .mic-btn:hover {
        color: #0d6efd;
    }
    .location-select {
        border-radius: 20px 0 0 20px;
        padding: 8px 15px;
    }
    </style>
    <div class="container m-5">
        <div class="d-flex justify-content-center">
            <div class="search-container">
                <div>
                    <form action="{{ route('search') }}" method="post" class="input-group" id="locationForm">
                        @csrf
                        <select id="locationDropdown" name="location" class="form-select location-select">
                            <option value="">-- Select a Location --</option>
                            <option value="Kathmandu"
                                data-latitude="27.644"
                                data-longitude="85.371472567303">
                                Kathmandu
                            </option>
                        </select>
                    
                        <input type="text" class="form-control search-input" id="search" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary search-btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('locationForm').addEventListener('submit', function(event) {
            const form = event.target;
            const locationDropdown = document.getElementById('locationDropdown');
            const selectedOption = locationDropdown.options[locationDropdown.selectedIndex];
    
            // Create hidden inputs only if they don't already exist
            if (!form.querySelector('input[name="latitude"]')) {
                const latitudeInput = document.createElement('input');
                latitudeInput.type = 'hidden';
                latitudeInput.name = 'latitude';
                latitudeInput.value = selectedOption.getAttribute('data-latitude') || '';
                form.appendChild(latitudeInput);
            }
    
            if (!form.querySelector('input[name="longitude"]')) {
                const longitudeInput = document.createElement('input');
                longitudeInput.type = 'hidden';
                longitudeInput.name = 'longitude';
                longitudeInput.value = selectedOption.getAttribute('data-longitude') || '';
                form.appendChild(longitudeInput);
            }
        });
    </script>
    