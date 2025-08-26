@extends('layout')

@section('content')
<div class="container" style=" border-radius: 115px; border: 20px solid rgb(204, 211, 214); padding: 20px; background-color:rgb(112, 114, 115);">
    <h1 style="text-align: center;">Edit Profile</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="form-container">
        <!-- Include the profile update form partial -->
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="form-container">
        <!-- Include the password update form partial -->
        @include('profile.partials.update-password-form')
    </div>

    <div class="form-container">
        <!-- Include the delete account form partial -->
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
