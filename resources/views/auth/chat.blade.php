<!DOCTYPE html>
<html>
<head>
    <title>Custom Auth in Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
    <form method="POST" action="{{ route('chat.send') }}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading top-bar" style="height: 50px;">
                            <div class="col-md-8 col-xs-8">
                                <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span> Etkinlikler</h3>
                            </div>
                        </div>
                        <table class="table table-striped table-hover">
                            <tbody>
                                @foreach ($etkinlikler as $etkinlik)
                                    <tr>
                                        <td>{{ $etkinlik->id }}</td>
                                        <td>
                                            <a href="{{ route('auth.chat', ['event_id' => $etkinlik->id]) }}">
                                                {{ $etkinlik->etkinlik_adi }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="chatbody">
                        <div class="panel panel-primary">
                            <div class="panel-heading top-bar" style="height: 50px;">
                                <div class="col-md-8 col-xs-8">
                                    <h3 class="panel-title">
                                        <span class="glyphicon glyphicon-comment"></span> {{ $event_id }}
                                        Chat - @if($event_id) Etkinlik Adı: {{ $etkinlik->etkinlik_adi }} @else Etkinlik Seçin @endif
                                    </h3>
                                </div>
                            </div>
                            <div class="panel-body msg_container_base">
                                @foreach ($mesajlar as $item)
                                    <div class="row msg_container base_sent">
                                        <div class="col-md-10 col-xs-10">
                                            <div class="messages msg_sent">
                                                <p>{{ $item->mesaj_metni }}</p>
                                                <time datetime="{{ $item->gonderim_zamani }}">{{ $item->gonderim_zamani }}</time>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-xs-2 avatar">
                                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if ($event_id)
                                <div class="panel-footer">
                                    <div class="input-group">
                                        <input id="btn-input" name="message" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                                        <input type="hidden" name="event_id" value="{{ $event_id }}">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary btn-sm" type="submit" id="btn-chat"><i class="fa fa-send fa-1x" aria-hidden="true"></i></button>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

</body>

</html>
