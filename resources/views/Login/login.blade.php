<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">

    <title>Login</title>
</head>

<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <!--------------------------- Left Box ----------------------------->

            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #f5f5f5;">
                <div class="featured-image mb-3">
                    <img src="{{ asset('images/icon/logo.png') }}" class="img-fluid" style="width: 250px;">
                </div>
            </div>

            <!-------------------- ------ Right Box ---------------------------->

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Hello</h2>
                        <p>Silahkan login untuk masuk kedalam aplikasi.</p>
                        @if (session('success'))
                            <div id="successAlert" class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div id="dangerAlert" class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <form action="/login" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" id="email" name="email"
                                class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror"
                                placeholder="Email address">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" id="password" name="password"
                                class="form-control form-control-lg bg-light fs-6
                                @error('password') is-invalid @enderror"
                                placeholder="Password">
                            <span id="showPasswordIcon" class="input-group-text"><i class="fas fa-eye-slash"></i></span>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3 d-flex justify-content-between">

                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Login</button>
                        </div>
                        <div class="row">
                            <small>Tidak punya akun? <a href="{{ route('register') }}">Sign Up</a></small>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const showPasswordIcon = document.getElementById('showPasswordIcon');

        showPasswordIcon.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Ikon mata tertutup
            } else {
                passwordInput.type = 'password';
                showPasswordIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Ikon mata terbuka
            }
        });

        var successElement = document.getElementById('successAlert');
        var dangerElement = document.getElementById('dangerAlert');
        setTimeout(function() {
            successElement.style.display = 'none';
        }, 5000);

        setTimeout(function() {
            dangerElement.style.display = 'none';
        }, 5000);
    </script>

</body>

</html>
