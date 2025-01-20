<!DOCTYPE html>
<html>
<head>
    <title>Custom Auth in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- Leaflet Routing Machine CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<!-- Leaflet Routing Machine JS -->

</head>

<body>

<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
<!-- Page Content -->
<div class="container">

    <!-- Portfolio Item Heading -->
    <h1 class="my-4">{{ $etkinlik->etkinlik_adi }}
    </h1>
  
    <!-- Portfolio Item Row -->
    <div class="row">
  
      <div class="col-md-8">
      <div id="map"></div>
      </div>
  
      <div class="col-md-4">
        <h3 class="my-3">{{ $etkinlik->aciklama }}</h3>
        <h3 class="my-3">Event Details</h3>
        <ul>
          <li>{{ $etkinlik->konum }}</li>
          <li>{{ $etkinlik->kategori }}</li>
          <li>{{ $etkinlik->created_at }}</li>
        </ul>
      </div>
  
    </div>
    <!-- /.row -->
  
    <!-- Related Projects Row -->
    <h3 class="my-4">Related Projects</h3>
  
    <div class="row">
    @foreach ($ilgiliEtkinlikler as $et)
    <div class="col-md-3 col-sm-6 mb-4">
        <a href="#">
              <img class="img-fluid" src="https://via.placeholder.com/500x300" alt="">
            </a>
            <ul>
            <a href="{{ route('etkinlikdetay', $et->id) }}">{{ $et->etkinlik_adi }}</a>
          <li>{{ $et->konum }}</li>
          <li>{{ $et->kategori }}</li>
          <li>{{ $et->created_at }}</li>
        </ul>
          </div>
  
    @endforeach
   
  
    </div>
    <!-- /.row -->
  
  </div>
  <!-- /.container -->
  <?php
// Etkinlik konumunu veritabanından çekme (örnek)
$etkinlikKonumu = $etkinlik->konum; // Veritabanında "40.0456, 29.1516151" formatında saklanıyor

// Konum bilgisini parçalama
list($enlem, $boylam) = explode(', ', $etkinlikKonumu);
?>
<!-- Leaflet CSS -->
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<!-- Leaflet Routing Machine CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<!-- Leaflet Routing Machine JS -->
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<!-- Leaflet Routing Machine Language Support -->
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine-languages.js"></script>

<script>
    // PHP değişkenlerini JavaScript'e aktarma
    var etkinlikKonumu = [<?php echo $enlem; ?>, <?php echo $boylam; ?>]; 
    var kullaniciKonumu = [40.8225, 29.9219]; // Kocaeli Üniversitesi Konumu
    
    var map = L.map('map').setView(etkinlikKonumu, 13); 
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
       attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map); 
    
    var marker = L.marker(etkinlikKonumu).addTo(map)
       .bindPopup('<b><?php echo $etkinlik->etkinlik_adi; ?></b><br>Tarih: <?php echo $etkinlik->tarih; ?><br>Saat: <?php echo $etkinlik->saat; ?><br>Açıklama: <?php echo $etkinlik->aciklama; ?>').openPopup();
    
    // Sabit kullanıcı konumunu kullanarak rota çiz
    var control = L.Routing.control({
        waypoints: [
            L.latLng(kullaniciKonumu),
            L.latLng(etkinlikKonumu)
        ],
        show: true
    }).addTo(map);

    // Rota çizimi tamamlandıktan sonra zoom seviyesini ayarla
    control.on('routesfound', function(e) {
        var bounds = L.latLngBounds([kullaniciKonumu, etkinlikKonumu]);
        map.fitBounds(bounds, {
            padding: [50, 50], // Harita kenarlarında biraz boşluk bırakmak için
            maxZoom: 13 // Maksimum zoom seviyesini ayarla
        });
    });
</script>





  </body>
  <style> #map { height: 400px; width: 100%; } </style>
</html>