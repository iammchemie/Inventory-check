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

    <title>Registrasi</title>
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
                        <p>Silahkan Daftar</p>
                    </div>
                    <form action="{{ route('registration') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" id="name" name="name"
                                class="form-control form-control-lg bg-light fs-6 @error('name') is-invalid @enderror"
                                placeholder="Name" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="username" name="username"
                                class="form-control form-control-lg bg-light fs-6 @error('username') is-invalid @enderror"
                                placeholder="Username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" id="email" name="email"
                                class="form-control form-control-lg bg-light fs-6 @error('email') is-invalid @enderror"
                                placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" id="password" name="password"
                                class="form-control form-control-lg bg-light fs-6
                                @error('password') is-invalid @enderror"
                                placeholder="Password">
                            <span id="showPasswordIcon" class="input-group-text"><i class="fas fa-eye-slash"></i></span>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" id="repassword" name="repassword"
                                class="form-control form-control-lg bg-light fs-6
                                @error('repassword') is-invalid @enderror"
                                placeholder="Re Password">
                            <span id="showrePasswordIcon" class="input-group-text"><i
                                    class="fas fa-eye-slash"></i></span>
                            @error('repassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3 d-flex justify-content-between">
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" type="submit">Register</button>
                        </div>
                        <div class="row">
                            <small>Sudah punya akun? <a href="{{ route('login') }}">Back To Sign In</a></small>
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

        const repasswordInput = document.getElementById('repassword');
        const showrePasswordIcon = document.getElementById('showrePasswordIcon');

        showrePasswordIcon.addEventListener('click', function() {
            if (repasswordInput.type === 'password') {
                repasswordInput.type = 'text';
                showrePasswordIcon.innerHTML = '<i class="fas fa-eye"></i>'; // Ikon mata tertutup
            } else {
                repasswordInput.type = 'password';
                showrePasswordIcon.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Ikon mata terbuka
            }
        });
    </script>

</body>

</html>
