
<button
    type="button"
    class="btn btn-primary btn-lg"
    data-bs-toggle="modal"
    data-bs-target="#modalId"
>
    Choose location
</button>

<!-- Modal -->
<div
    class="modal fade"
    id="modalId"
    tabindex="-1"
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    <label class="form-label">Select Location on Map</label>
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    
                    <input type="hidden" id="latitude" name="latitude" value="{{ request('latitude',27.7132) }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ request('longitude',85.3240) }}">
                    <div id="map" style="height: 300px; width: 100%;" class="border rounded"></div>
                    <small class="text-muted">Click or drag to set exact location</small>
                </div>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal"
                >
                    Close
                </button>
                <input type="submit" class="btn btn-primary" value="find">
            </div>
        </div>
    </div>
</div>

<script>
    var modalId = document.getElementById('modalId');

    modalId.addEventListener('show.bs.modal', function (event) {
        
          let button = event.relatedTarget;          
          let recipient = button.getAttribute('data-bs-whatever');
    });
</script>

<script>
    function initMap() {
        const initialCoords = {
            lat: parseFloat(document.getElementById("latitude").value) || 27.7172,
            lng: parseFloat(document.getElementById("longitude").value) || 85.3240
        };

        map = new google.maps.Map(document.getElementById("map"), {
            center: initialCoords,
            zoom: 13,
        });

        marker = new google.maps.Marker({
            position: initialCoords,
            map: map,
            draggable: true,
        });

        marker.addListener("dragend", function () {
            const position = marker.getPosition();
            document.getElementById("latitude").value = position.lat().toFixed(6);
            document.getElementById("longitude").value = position.lng().toFixed(6);
        });

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
