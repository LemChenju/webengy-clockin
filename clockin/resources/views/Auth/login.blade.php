<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Webengy Clockin - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style type="text/css">
    body{
      background: #000000;
    }
    .bg-image {
      background-size: cover;
      height: 100vh;
    }
  </style>
</head>
<body>
  <section class="bg-image py-3 py-md-5" style="background-image: url('https://laravel.com/assets/img/welcome/background.svg');">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <div class="card border border-light-subtle rounded-3 shadow-sm mt-5">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="text-center mb-3">
                <h1>Webengy Clockin</h1>
              </div>
              <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Melden Sie sich mit ihrem Account an</h2>
              <form method="POST" action="{{ route('login.action') }}">
                @csrf

                @session('error')
                    <div class="alert alert-danger" role="alert">
                        {{ $value }}
                    </div>
                @endsession

                <div class="row gy-2 overflow-hidden">
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="name@example.com" required>
                      <label for="email" class="form-label">{{ __('Email Addresse') }}</label>
                    </div>
                    @error('email')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-12">
                    <div class="form-floating mb-3">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" value="" placeholder="Password" required>
                      <label for="password" class="form-label">{{ __('Passwort') }}</label>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-12">
                    <div class="d-flex gap-2 justify-content-between">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="rememberMe" id="rememberMe">
                        <label class="form-check-label text-secondary" for="rememberMe">
                          Angemeldet bleiben
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid my-3">
                      <button class="btn btn-primary btn-lg" type="submit">{{ __('Anmelden') }}</button>
                    </div>
                  </div>
                  <div class="col-12">
                    <p class="m-0 text-secondary text-center">Haben Sie noch keinen Account? Registrieren Sie sich <a href="{{ route('register') }}" class="link-primary text-decoration-none"> hier</a></p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
