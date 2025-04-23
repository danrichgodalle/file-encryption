<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    <style>
        /* CSS */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .vh-100 {
            min-height: 100vh;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .divider:after, .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .bg-primary {
            background-color: #007bff !important;
        }

        .form-outline input {
            border-radius: 1rem;
        }

        .form-outline label {
            font-size: 1rem;
        }

        .social-button i {
            font-size: 1.25rem;
        }

        .footer {
            background-color: #007bff;
            color: white;
            padding: 1rem 0;
        }

        .footer a {
            color: white;
        }

        .footer i {
            font-size: 1.5rem;
        }

           /* Styled Return Button */
    .return-btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 1.1rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        background-color: #007bff;
        color: white;
        border-radius: 30px;
        transition: background-color 0.3s, transform 0.3s;
        margin-top: 20px; /* Added margin-top */
    }

    .return-btn:hover {
        background-color: blue;
        transform: scale(1.05);
    }

    .return-btn:focus {
        outline: none;
    }
    </style>
</head>

<body>

    <!-- Return to Home Button -->
    <a href="{{ url('/') }}" class="return-btn">Return to Home</a>

    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                        class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <div class="px-4 py-4 text-center footer">
            Copyright © 2025. All rights reserved.
        </div>
    </section>

    @fluxScripts

</body>

</html>
