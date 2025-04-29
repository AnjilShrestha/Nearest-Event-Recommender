<div class="modal fade" id="addCategoryModal" tabindex="-1" ...>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addCategoryModalLabel">
                    Add New Event Category
                </h5>
                <i class="bi bi-x-lg"></i>

            </div>
            
            <div class="modal-body">
                <form action="{{ route('admin.eventcategories.post') }}" method="POST" id="categoryForm">
                    @csrf
                    <div class="form-group">
                        <label for="categories_name" class="form-label">Category Name</label>
                        <input type="text" name="categories_name" class="form-control" placeholder="Enter category name" value="{{ old('categories_name') }}">
                        @error('categories_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="bi bi-times mr-2"></i> Cancel
                </button>
                <button type="submit" form="categoryForm" class="btn btn-primary">
                    <i class="bi bi-save mr-2"></i> Add Category
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

    // Show modal if validation errors exist
    @if(session('show_add_modal'))
        $('#addCategoryModal').modal('show');
    @endif

    // Clear validation messages on modal close
    $('#addCategoryModal').on('hidden.bs.modal', function() {
        $('.text-danger').remove();
        $('.alert-danger').remove();
        $('input').removeClass('is-invalid');
    });
    // Reset form fields on modal close
    $('#addCategoryModal').on('hidden.bs.modal', function() {
        $('#categoryForm')[0].reset();
    });
});

</script>