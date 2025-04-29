<!-- Edit Modal -->
<div class="modal fade edit-category-modal" id="editCategoryModal{{ $category->id }}" tabindex="-1" ...>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                    <i class="fas fa-edit mr-2"></i> Edit Category
                </h5>
                <span class="close text-white" data-dismiss="modal" aria-label="Close">&times;</span>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.eventcategories.update', $category->id) }}" method="POST" id="editCategoryForm{{ $category->id }}">
                    @csrf
                    @method('Post')
                    <div class="form-group">
                        <label for="categories_name">Category Name</label>
                        <input type="text" name="categories_name" class="form-control" value="{{ old('categories_name', $category->categories_name) }}">
                        @error('categories_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-2"></i> Cancel</button>
                <button type="submit" form="editCategoryForm{{ $category->id }}" class="btn btn-warning">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
@if(session('show_edit_modal'))
<script>
    $(document).ready(function() {
        $('#editCategoryModal{{ session('show_edit_modal') }}').modal('show');
    });
</script>
@endif

<script>
    $(document).ready(function() {
        // Show modal if validation errors exist
        @if(session('show_edit_modal'))
            $('#editCategoryModal{{ session('show_edit_modal') }}').modal('show');
        @endif
    
            // Reset form fields on modal close
            $('.edit-category-modal').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
            });
    
        // Search functionality
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('.text-danger').remove(); // Remove validation error text
            $(this).find('.alert-danger').remove(); // Remove alert boxes
            $(this).find('input, select, textarea').removeClass('is-invalid'); // Remove red borders
        });

    });

</script>
