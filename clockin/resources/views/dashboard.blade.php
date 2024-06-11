<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webengy Clockin - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background: #000000;
            overflow-x: hidden; /* Verhindert horizontales Scrollen */
        }
        .bg-image {
            background-size: cover;
            height: 100vh;
        }
        .buttons a {
            display: block;
            padding: 20px 40px;
            font-size: 1.5rem;
            color: #fff;
            background-color: #636b6f;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
        .buttons a:hover {
            background-color: #4a5568;
        }
        .dropdown-menu {
            display: none;
            position: absolute; /* Verhindert, dass das Dropdown die Größe des Containers beeinflusst */
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .username {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
<section class="bg-image py-3 py-md-5" style="background-image: url('https://laravel.com/assets/img/welcome/background.svg');">
    <div class="container py-4">
        <div class="p-5 mb-4 bg-light rounded-3 position-relative">
            <div class="header position-absolute top-0 end-0 mt-3 me-3">
                <div class="dropdown">
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{ route('profile') }}"
                           onclick="event.preventDefault();
                                        document.getElementById('profile-form').submit();">
                            Profil
                        </a>
                        <form id="profile-form" action="{{ route('profile') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="{{ route('settings') }}"
                           onclick="event.preventDefault();
                                        document.getElementById('settings-form').submit();">
                            Einstellungen
                        </a>
                        <form id="settings-form" action="{{ route('settings') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            Abmelden
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <div class="container-fluid py-5">
                <h1 class="display-5 fw-bold username">Hi, {{ auth()->user()->name }}</h1>
                <div class="d-flex justify-content-center mt-4">
                    <div class="buttons me-2">
                        <a href="#">Zeiterfassung</a>
                    </div>
                    <div class="buttons ms-2">
                        <a href="#">Urlaubsplanung</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Füge FontAwesome und Bootstrap JS hinzu -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.2/js/bootstrap.min.js"></script>
</body>
</html>
