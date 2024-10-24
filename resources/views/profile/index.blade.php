@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $page->title }}</h3>
                </div>

                <div class="card-body">
                    <!-- Profile Picture Section -->
                    <div class="text-center mb-4">
                        <img id="profile-pic" src="{{ Auth::user()->avatar ? url('storage/' . Auth::user()->avatar) : url('user.jpg') }}" class="rounded-circle" width="200" height="200" alt="Profile Picture">
                        <div class="mt-2 mb-5">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editProfileModal">
                                <i class="fas fa-edit"></i> Ganti Foto
                            </button>
                        </div>
                    </div>

                    <!-- AJAX Notification Alerts -->
                    <div id="notification-success" class="alert alert-success" style="display:none"></div>
                    <div id="notification-error" class="alert alert-danger" style="display:none"></div>

                    <!-- Form for Data Pengguna and Ubah Password -->
                    <form id="profile-form" method="POST" action="{{ url('profile/update_pengguna', Auth::user()->user_id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Data Pengguna Section -->
                        <div class="container border-container">
                            <h5>Data Pengguna</h5>
                            <div class="form-group mt-4">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ Auth::user()->username }}" required>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ Auth::user()->nama }}" required>
                            </div>
                        </div>

                        <!-- Ubah Password Section -->
                        <div class="container border-container mt-4">
                            <h5>Ubah Password</h5>
                            <div class="form-group mt-4">
                                <label for="current_password">Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" toggle="#current_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <small id="error-current_password" class="error-text form-text text-danger">
                                    @error('current_password') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" toggle="#new_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <small id="error-new_password" class="error-text form-text text-danger">
                                    @error('new_password') {{ $message }} @enderror
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Verifikasi Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm_password" name="new_password_confirmation">
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" toggle="#confirm_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <small id="error-confirm_password" class="error-text form-text text-danger">
                                    @error('new_password_confirmation') {{ $message }} @enderror
                                </small>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-primary" id="submit-btn">Simpan</button>
                        </div>
                    </form>

                    <!-- Modal for changing profile picture -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-body">
                                @include('profile.edit_profile')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('.toggle-password').click(function() {
            let input = $($(this).attr("toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        // Handle AJAX form submission for profile updates
        $('#profile-form').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting the traditional way

            let formData = $(this).serialize();
            let actionUrl = $(this).attr('action');

            $.ajax({
                type: 'POST',
                url: actionUrl,
                data: formData,
                success: function(response) {
                    $('#notification-success').html(response.message).fadeIn().delay(3000).fadeOut();
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'An error occurred';
                    $('#notification-error').html(errorMessage).fadeIn().delay(3000).fadeOut();
                }
            });
        });
    });
</script>

<!-- CSS Styling -->
<style>
    .border-container {
        border: 1px solid black;
        border-radius: 0 10px 10px 10px;
        padding: 20px;
    }

    .form-group input {
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
    }

    .alert {
        display: none;
        margin-bottom: 20px;
    }
</style>
@endsection