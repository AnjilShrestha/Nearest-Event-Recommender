<!-- Edit Modal -->

<div class="modal fade edit-user-modal" id="editUserModal{{ $user->id }}" tabindex="-1" ...>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">
                    <i class="fas fa-edit mr-2"></i> Edit User
                </h5>
                <span class="close text-white" data-dismiss="modal" aria-label="Close">&times;</span>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST" id="editUserForm{{ $user->id }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="edit_name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_username" class="form-label">Username</label>
                        <input type="text" name="username" id="edit_username" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror" placeholder="Enter username">
                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="edit_password" class="form-label">Password (Leave blank to keep current)</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password">
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-2"></i> Cancel</button>
                <button type="submit" form="editUserForm{{ $user->id }}" class="btn btn-warning">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Show modal if validation errors exist
        @if(session('show_edit_modal'))
        $('#editUserModal{{ session('show_edit_modal') }}').modal('show');
        @endif
        // Reset form fields on modal close
        $('.edit-user-modal').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
        });
        
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('.text-danger').remove(); // Remove validation error
            $(this).find('.alert-danger').remove(); // Remove alert boxes
            $(this).find('input, select, textarea').removeClass('is-invalid'); // Remove red borders
        });
    });
</script>
