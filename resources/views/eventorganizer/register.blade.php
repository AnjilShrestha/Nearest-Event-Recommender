@extends('layouts.frontlayout')
@section('title', 'Event Organizer Registration')
@section('content')
<div class="container">
    <h2>Register</h2>
    <form method="POST" action="{{ route('eventorganizer.register.post') }}" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Username *</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Password *</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Confirm Password *</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Company Name</label>
                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Company Website</label>
                <input type="url" name="company_website" class="form-control" value="{{ old('company_website') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Company Phone</label>
                <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone') }}">
            </div>

            <div class="col-md-12 mb-3">
                <label>Company Address</label>
                <input type="text" name="company_address" class="form-control" value="{{ old('company_address') }}">
            </div>

            <div class="col-md-12 mb-3">
                <label>Company Description</label>
                <textarea name="company_description" class="form-control">{{ old('company_description') }}</textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label>Company Logo</label>
                <input type="file" name="company_logo" class="form-control" id="company_logo_input" accept="image/*">
                <br>
                <img id="logo_preview" src="#" alt="Logo Preview" class="rounded-circle mt-2" style="display: none; height: 150px; width: 150px; object-fit: cover;">
            </div>
            
            

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </div>
        </div>
    </form>
</div>
<script>
    document.getElementById('company_logo_input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const logoPreview = document.getElementById('logo_preview');
                logoPreview.src = e.target.result;
                logoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
