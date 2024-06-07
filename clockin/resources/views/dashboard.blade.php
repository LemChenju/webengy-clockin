<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Webengy Clockin - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
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
      <div class="container py-4">

        <div class="p-5 mb-4 bg-light rounded-3">
          <div class="container-fluid py-5">

            @session('success')
                <div class="alert alert-success" role="alert"> 
                  {{ $value }}
                </div>
            @endsession

            <h1 class="display-5 fw-bold">Hi, {{ auth()->user()->name }}</h1>
            <p class="col-md-8 fs-4">Welcome to your personal dashboard.</p>
            


            <div class="col-md-1">
              <button class="btn btn-primary btn-lg" type="button" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
              </button>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>