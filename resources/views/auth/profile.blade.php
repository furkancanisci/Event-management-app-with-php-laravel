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


    <div class="container">
        <h1>Profili Düzenle</h1>
        <form action="{{ route('profile.update', $kullanici->id) }}" method="POST">
                        @csrf
            <div class="form-group">
                <label for="ad">Ad</label>
                <input type="text" class="form-control" id="ad" name="ad" value="{{ $kullanici->ad }}">
            </div>
            <div class="form-group">
                <label for="soyad">Soyad</label>
                <input type="text" class="form-control" id="soyad" name="soyad" value="{{ $kullanici->soyad }}">
            </div>
            <div class="form-group">
                <label for="ilgialanlari">İlgi Alanları</label>
                <input type="text" class="form-control" id="ilgialanlari" name="ilgialanlari" value="{{ $kullanici->ilgi_alanlari }}">
            </div>
            <div class="form-group">
                <label for="cinsiyet">Cinsiyet</label>
                <input type="text" class="form-control" id="cinsiyet" name="cinsiyet" value="{{ $kullanici->cinsiyet }}">
            </div>
            <div class="form-group">
                <label for="telefon_numarasi">Telefon Numarası</label>
                <input type="text" class="form-control" id="telefon_numarasi" name="telefon_numarasi" value="{{ $kullanici->telefon_numarasi }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="{{ $kullanici->email }}">
            </div>
            
            <button type="submit" class="btn btn-primary">Güncelle</button>
        </form>
    </div>

</body>
</html>