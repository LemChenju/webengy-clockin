<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webengy Clockin - Profil</title>
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
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .form-group {
            width: 100%;
            max-width: 400px;
            margin-bottom: 15px;
        }
        .buttons a, .buttons button {
            display: block;
            width: 100%;
            padding: 50px 100px;
            font-size: 3rem;
            color: #fff;
            background: linear-gradient(45deg, #1d2671, #c33764);
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .buttons a:hover, .buttons button:hover {
            background: linear-gradient(45deg, #c33764, #1d2671);
            transform: scale(1.05);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }
        .btn-small {
            padding: 15px 30px;
            font-size: 1.5rem;
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
                        <form id="profile-form" action="{{ route('profile') }}" method="GET" class="d-none">
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
            <div class="container-fluid py-5 form-container">
                <div class="row mt-4">
                    <div class="col buttons mt-4">
                        <a href="{{ route('password.change') }}" class="btn btn-primary">Einstempeln</a>
                    </div>
                    <div class="col buttons mt-4">
                        <a href="{{ route('password.change') }}" class="btn btn-primary">Ausstempeln</a>
                    </div>
                </div>
                <div class="buttons mt-4">
                    <a href="{{ route('password.change') }}" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.5rem;">Stempelhistorie Anzeigen</a>
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
