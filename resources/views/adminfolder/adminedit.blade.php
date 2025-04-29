
<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editAdminModalLabel">
                    <i class="fas fa-user-edit mr-2"></i> Edit Admin
                </h5>
                <span aria-hidden="true"class="close text-dark" data-dismiss="modal" aria-label="Close">&times;</span>
            </div>
            
            <div class="modal-body">
                @if(session('edit_error'))
                    <div class="alert alert-danger text-center">{{ session('edit_error') }}</div>
                @endif
                
                <form action="{{ route('admin.admin.update', $admin->id) }}" method="POST" id="editAdminForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" name="email" id="edit_email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_username">Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $admin->username) }}">
                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_password">Password (Leave blank to keep current)</label>
                        <input type="password" name="password" id="edit_password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password (optional)">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </form>
            </div>
            {{ session('updateerror') }}
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i> Cancel
                </button>
                <button type="submit" form="editAdminForm" class="btn btn-warning text-white">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
    // Toggle password visibility
    $('.toggle-password').click(function() {
        const passwordInput = $('#password');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
        @if($errors())
            $('#editAdminModal').modal('show');
        @endif
    // Show modal if validation errors exist

    // Clear validation messages on modal close
    $('#editAdminModal').on('hidden.bs.modal', function() {
        $('.text-danger').remove();
        $('.alert-danger').remove();
        $('input').removeClass('is-invalid');
    });
});

</script>