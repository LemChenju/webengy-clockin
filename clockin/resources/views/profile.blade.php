<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Einstellungen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background: #000000;
            overflow-x: hidden;
        }
        .bg-image {
            background-size: cover;
            height: 100vh;
        }
        .buttons button {
            display: block;
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #636b6f;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
        .buttons button:hover {
            background-color: #4a5568;
        }
    </style>
</head>
<body>
<section class="bg-image py-3 py-md-5" style="background-image: url('https://laravel.com/assets/img/welcome/background.svg');">
    <div class="container py-4">
        <div class="p-5 mb-4 bg-light rounded-3 position-relative">
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold text-center">Profil Einstellungen</h1>
                <div class="d-flex justify-content-center">
                    <img src="{{ auth()->user()->profile_image ?? 'https://via.placeholder.com/150' }}" alt="Profilbild" class="rounded-circle mb-3" width="150" height="150">
                </div>
                <form action="{{ route('profile.update') }}" method="POST" id="profile-form" class="mt-3">
                    @csrf
                    <div class="form-group">
                        <label for="profile_image">Profilbild URL</label>
                        <input type="url" class="form-control" id="profile_image" name="profile_image" value="{{ auth()->user()->profile_image }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                    </div>
                    <div class="buttons mt-4">
                        <button type="submit" class="btn btn-primary">Änderungen speichern</button>
                    </div>
                </form>
                <div class="buttons mt-4">
                    <a href="{{ route('password.change') }}" class="btn btn-primary">Passwort ändern</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Füge FontAwesome und Bootstrap JS hinzu -->
<script src="{{ asset('js/settings.js') }}"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.2/js/bootstrap.min.js"></script>
</body>
</html>
