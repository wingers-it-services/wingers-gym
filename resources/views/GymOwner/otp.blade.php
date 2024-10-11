<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="ZY4pR8wIEdrTLWxVivLo4lvqoE0UPbxm6RtBU20w">
    <meta name="author" content="DexignZone">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gym Authentication</title>
    <link rel="icon" type="image/png" href="{{asset('images/favicon.png')}}">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-4">
                                        <img src="{{asset('images/logo.png')}}" alt="Register" style="width: 350px; max-width: 100%; height: auto;">
                                    </div>
                                    <h2>Set up Google Authenticator</h2>
                                    <p>Scan the QR code below using the Google Authenticator app:</p>
                                    <div class="text-center mb-4">{{ $QRImageUrl }}</div>

                                    <p>Alternatively, enter this code manually: {{ $secretKey }}</p>

                                    <h4 class="text-center mb-4">Verify Otp</h4>
                                    <form class="form" id="log_in" method="POST" action="{{ route('gym.otp.verify') }}" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="form-group position-relative">
                                            <label class="mb-1"><strong>OTP</strong></label>
                                            <input type="number" class="form-control" id="otp" name="otp" placeholder="Otp" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Verify Otp</button>
                                        </div>
                                    </form>

                                    <div class="new-account mt-3">
                                        <p>Back To <a class="text-primary" href='/'>Login</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/custom.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/deznav-init.js')}}" type="text/javascript"></script>
</body>

<script>
    function togglePassword(fieldId, eyeSlashId, eyeId) {
        var field = document.getElementById(fieldId);
        var eyeSlash = document.getElementById(eyeSlashId);
        var eye = document.getElementById(eyeId);

        if (field.type === "password") {
            field.type = "text";
            eyeSlash.style.display = "none";
            eye.style.display = "inline";
        } else {
            field.type = "password";
            eyeSlash.style.display = "inline";
            eye.style.display = "none";
        }
    }

    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })();

    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');

        passwordInput.addEventListener('input', function() {
            if (passwordInput.value.length < 8) {
                passwordError.style.display = 'block';
                passwordError.innerHTML = 'Password must be at least 8 characters long.';
            } else {
                passwordError.style.display = 'none';
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            if (passwordInput.value.length < 8) {
                event.preventDefault();
                passwordError.style.display = 'block';
                passwordError.innerHTML = 'Password must be at least 8 characters long.';
            }
        });
    });
</script>

@include('CustomSweetAlert');

</html>