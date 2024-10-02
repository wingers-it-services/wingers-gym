<!DOCTYPE html>
<html lang="en" class="h-100">

<!-- Added by HTTrack -->
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
    <meta property="og:description" content="Laravel | Page Login">
    <meta property="og:image" content="../social-image.png">
    <meta name="format-detection" content="telephone=no">
    <title>Forget Password</title>

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
                                    <h4 class="text-center mb-4"> Verify Code</h4>
                                    <form class="form" id="log_in" method="POST" action="{{ route('gym.verify-google-authenticator') }}"
                                        class="needs-validation" novalidate>
                                        @csrf
                                        <div class="form-group">
                                            <label class="mb-1"><strong>Email</strong></label>
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
                                            <label class="mb-1"><strong>Enter Code</strong></label>
                                            <input type="text" class="form-control" id="google_authenticator_code" name="google_authenticator_code"
                                                placeholder="Enter Code" required>
                                            <div class="invalid-feedback">
                                                Code is required.
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Verify Code</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Back To <a class="text-primary" href='/'>Login</a>
                                        </p>
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


@include('CustomSweetAlert');

</html>