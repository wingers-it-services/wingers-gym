<!DOCTYPE html>
<html lang="en" class="h-100">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="ZY4pR8wIEdrTLWxVivLo4lvqoE0UPbxm6RtBU20w">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="">
    <meta name="keywords"
        content="Fitness solution, Healthier lifestyle, Fito, Personalized programs,  Exercise, Nutrition, Motivation, Fitness journey, DexignZone">
    <meta name="description" content="Some description for the page">

    <meta property="og:title" content="Fito - A Comprehensive Fitness Solution for a Healthier Lifestyle | DexignZone">
    <meta property="og:description" content="Laravel | Page Register">
    <meta property="og:image" content="../social-image.png">
    <meta name="format-detection" content="telephone=no">
    <title>Wingers Gym Register </title>

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon icon -->
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
                                        <img src="{{asset('images/logo.png')}}" alt="Register"
                                            style="width: 350px; max-width: 100%; height: auto;">
                                    </div>
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form id="log_in" method="post" action="/register" enctype="multipart/form-data" class="needs-validation"
                                        novalidate>
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1" for="gym_name"><strong>GYM Name</strong></label>
                                            <input type="text" class="form-control" name="gym_name"
                                                placeholder="Gym Name" required>
                                            <div class="invalid-feedback">
                                                Gym Name is required.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1" for="email"><strong>Email</strong></label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Email" required>
                                            <small id="emailError" class="text-danger" style="display:none;">
                                                Please enter a valid email address.
                                            </small>
                                            <div class="invalid-feedback">
                                                Email is required.
                                            </div>
                                        </div>
                                        <div class="form-group position-relative">
                                            <label class="mb-1" for="password"><strong>Password</strong></label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password" required>
                                            <div class="invalid-feedback">
                                                Password is required.
                                            </div>
                                            <small id="passwordError" class="text-danger" style="display:none;">
                                                Password must be at least 8 characters long.
                                            </small>
                                            <span class="show-pass eye" id="togglePassword"
                                                onclick="togglePasswordVisibility()">
                                                <i class="fa fa-eye-slash" id="eye-slash"></i>
                                                <i class="fa fa-eye" id="eye" style="display:none;"></i>
                                            </span>

                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="/">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
    Scripts
    ***********************************-->
    <script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/custom.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/deznav-init.js')}}" type="text/javascript"></script>
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }


                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var eyeSlash = document.getElementById("eye-slash");
            var eye = document.getElementById("eye");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeSlash.style.display = "none";
                eye.style.display = "inline";
            } else {
                passwordField.type = "password";
                eyeSlash.style.display = "inline";
                eye.style.display = "none";
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('passwordError');

            passwordInput.addEventListener('input', function () {
                if (passwordInput.value.length < 8) {
                    passwordError.style.display = 'block';
                    passwordError.innerHTML = 'Password must be at least 8 characters long.';
                } else {
                    passwordError.style.display = 'none';
                }
            });

            document.querySelector('form').addEventListener('submit', function (event) {
                let isValid = true; // Track validity status

                if (passwordInput.value.length < 8) {
                    event.preventDefault(); // Prevent form submission
                    passwordError.style.display = 'block';
                    passwordError.innerHTML = 'Password must be at least 8 characters long.'; // Show error message
                    isValid = false;
                } else {
                    passwordError.style.display = 'none';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailError');

            // Regular expression for email validation
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            // Real-time validation as the user types
            emailInput.addEventListener('input', function () {
                if (!emailPattern.test(emailInput.value)) {
                    emailError.style.display = 'block';
                    emailError.innerHTML = 'Please enter a valid email address.';
                } else {
                    emailError.style.display = 'none';
                }
            });

            // Validate on form submit
            document.querySelector('form').addEventListener('submit', function (event) {
                let isValid = true;

                // Check if email is valid before submitting
                if (!emailPattern.test(emailInput.value)) {
                    event.preventDefault(); // Prevent form submission if invalid
                    emailError.style.display = 'block';
                    emailError.innerHTML = 'Please enter a valid email address.';
                    isValid = false;
                }

                if (isValid) {
                    emailError.style.display = 'none';
                }
            });
        });



    </script>

    {{-- Custom sweetAlert --}}
    @include('CustomSweetAlert');



</body>

</html>