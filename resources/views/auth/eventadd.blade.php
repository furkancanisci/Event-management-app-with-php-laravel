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
        <form action="{{ route('eventaddpost') }}" method="POST">
                                    @csrf
            <div class="form-group">
                <label for="etkinlik_adi">Etkinlik Adı</label>
                <input type="text" class="form-control" id="etkinlik_adi" name="etkinlik_adi" >
            </div>
            <div class="form-group">
                <label for="aciklama">Açıklama</label>
                <input type="text" class="form-control" id="aciklama" name="aciklama" >
            </div>
            <div class="form-group">
                <label for="konum">Konum</label>
                <input type="text" class="form-control" id="konum" name="konum" >
            </div>
            <div class="form-group">
                <label for="tarih">Etkinlik Tarihi</label>
                <input type="date" class="form-control" id="tarih" name="tarih" >
            </div>
            <div class="form-group">
                <label for="saat">Etkinlik Saati</label>
                <input type="time" class="form-control" id="saat" name="saat" >
            </div>
            <div class="form-group">
                <label for="bitissaat">Etkinlik Bitiş Saati</label>
                <input type="time" class="form-control" id="bitissaat" name="bitissaat" >
            </div>
            <div class="form-group">
                <label for="sure">Etkinlik Süresi</label>
                <input type="text" class="form-control" id="sure" name="sure" >
            </div>
            <div class="form-group">
                <label for="kategori">Kategori</label>
                <input type="text" class="form-control" id="kategori" name="kategori" >
            </div>
            <button type="submit" class="btn btn-primary">Ekle</button>
        </form>
    </div>

</body>
</html>