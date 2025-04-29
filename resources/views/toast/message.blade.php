@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    @if(session('success')) // <-- Add this check
        const toast = new bootstrap.Toast(document.getElementById('successToast'), {
            animation: true,
            autohide: true,
            delay: 300
        });
        toast.show();
    @endif
});
</script>
@endif

@error('field')
    
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="failureToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ $message }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var toastEl = document.getElementById('failureToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
</script>
@enderror
