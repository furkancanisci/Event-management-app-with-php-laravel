<!DOCTYPE html>
<html>
<head>
    <title>Custom Auth in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="{{ route('explore') }}">Explore</a>
            <a class="navbar-brand mr-auto" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="navbar-brand mr-auto" href="{{ route('auth.chat') }}">Chat</a>
            <a class="navbar-brand mr-auto" href="{{ route('profile.show', Auth::user()->id) }}">Profile</a>
            <a type="button" href="{{ route('eventadd') }}" class="btn btn-primary">Etkinlik Ekle</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
            
        </div>
    </nav>
    <div class="row container">
        <div class="card-deck">
            @foreach($etkinlikler as $etkinlik)
                <div class="card">
                    <div class="row">
                        <div class="col">
                            <div class="card-body">
                                <a href="{{ route('etkinlikdetay', $etkinlik->id) }}" class="card-title">{{ $etkinlik->etkinlik_adi }}</a>
                                <p class="card-text">{{ $etkinlik->aciklama }}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">{{ $etkinlik->tarih }}</small>
                            </div>
                            @if (!$etkinlik->katilimci_var_mi)
                            <a type="button" href="{{ route('etkinlikkatil', $etkinlik->id) }}" class="btn btn-info">Etkinliğe Katıl</a>                                
                            @endif

                        </div>
                    </div>
                    
                </div>
            @endforeach
      </div>
    </div>
</body>

</html>
