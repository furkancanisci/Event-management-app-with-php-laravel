<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">

<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Register User</h3>
                    <div class="card-body">

                        <form action="{{ route('register.custom') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Name" id="name" class="form-control" name="name"
                                    required autofocus>
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Surname" id="surname" class="form-control" name="surname"
                                    required autofocus>
                                @if ($errors->has('surname'))
                                <span class="text-danger">{{ $errors->first('surname') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Telefon Numarası" id="phone" class="form-control" name="phone"
                                    required autofocus>
                                @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="İlgi Alanları" id="ilgialanlari" class="form-control" name="ilgialanlari"
                                    required autofocus>
                                @if ($errors->has('ilgialanlari'))
                                <span class="text-danger">{{ $errors->first('ilgialanlari') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="text" placeholder="Konum" id="konum" class="form-control" name="konum"
                                    required autofocus>
                                @if ($errors->has('konum'))
                                <span class="text-danger">{{ $errors->first('konum') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                Doğum Tarihi
                                <input type="date" placeholder="Birthdate" id="birthdate" class="form-control" name="birthdate"
                                    required autofocus>
                                @if ($errors->has('birthdate'))
                                <span class="text-danger">{{ $errors->first('birthdate') }}</span>
                                @endif
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cinsiyet" id="erkeksecim" value="erkek">
                                <label class="form-check-label" for="erkeksecim">
                                    Erkek
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="cinsiyet" id="kizsecim" value="kiz" checked>
                                <label class="form-check-label" for="kizsecim">
                                    Kız
                                </label>
                            </div>


                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email_address" class="form-control"
                                    name="email" required autofocus>
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control"
                                    name="password" required>
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="remember"> Remember Me</label>
                                </div>
                            </div>

                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Sign up</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>