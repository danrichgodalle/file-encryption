<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microm Credit Corporation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            scroll-behavior: smooth;
        }
        .navbar {
            background-color: #000;
        }
        .navbar a {
            color: white !important;
            font-size: 18px;
        }
        .navbar a:hover {
            color: #f8f9fa !important;
        }
        .nav-item .btn {
            border: 1px solid white;
            transition: 0.3s;
        }
        .nav-item .btn:hover {
            background-color: white;
            color: black !important;
        }
        #home {
            position: relative;
            background: url('image/2.jpg') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }
        #home::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        .home-content {
            position: relative;
            z-index: 1;
        }
        .btn-get-started {
            background-color: #28a745;
            color: white;
            padding: 12px 25px;
            font-size: 18px;
            border-radius: 25px;
            text-decoration: none;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .btn-get-started:hover {
            background-color: green;
            color: white;
        }
        .section {
            padding: 80px 0;
            text-align: center;
        }
        #about {
            background-color: #f8f9fa;
        }
        #team {
            background-color: white;
        }

        .team-member {
            width: 250px;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0; /* Start hidden */
            transform: translateY(30px); /* Start slightly below */
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .team-member.visible {
            opacity: 1; /* Fully visible */
            transform: translateY(0); /* Move into place */
        }

        .team-member img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }


        #benefits {
            background-color: #f8f9fa;
            padding: 50px 0;
        }
        .benefit-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .benefit-box {
            width: 260px;
            padding: 25px;
            border-radius: 15px;
            background-color: white;
            text-align: center;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .benefit-box:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 18px rgba(0, 0, 0, 0.2);
        }
        .benefit-box i {
            display: block;
            font-size: 3rem;
            margin-bottom: 15px;
        }
        footer {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .team-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        /* Navbar Icons */
        .navbar-nav .nav-item i {
            margin-right: 8px; /* Spacing sa kanan ng icon */
            font-size: 18px; /* Laki ng icon */
            transition: color 0.3s ease; /* Smooth transition sa hover */
        }

        /* Adding colors to the icons */
        .navbar-nav .nav-item:hover i {
            color: #28a745; /* Green color on hover */
        }
        .navbar-nav .nav-item i.home-icon {
            color: #3498db; /* Blue for home */
        }
        .navbar-nav .nav-item i.about-icon {
            color: #f39c12; /* Yellow for about */
        }
        .navbar-nav .nav-item i.team-icon {
            color: #e74c3c; /* Red for team */
        }
        .navbar-nav .nav-item i.benefits-icon {
            color: #9b59b6; /* Purple for benefits */
        }
        .navbar-nav .nav-item i.login-icon {
            color: #34495e; /* Dark blue for login */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Microm Credit Corp</a>
        <img src="{{ asset('image/23jpg.') }}" alt="" class="img-fluid team-img">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">
                        <i class="fas fa-home home-icon"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">
                        <i class="fas fa-info-circle about-icon"></i> About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#team">
                        <i class="fas fa-users team-icon"></i> Our Team
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#benefits">
                        <i class="fas fa-hand-holding-usd benefits-icon"></i> Loan Benefits
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-light ms-2" href="{{ url('/login') }}">
                        <i class="fas fa-sign-in-alt login-icon"></i> Login
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div id="home" class="section">
    <div class="home-content">
        <h1>Welcome to Microm Credit Corporation</h1>
        <p>We are here to help you with your financial needs.</p>
        <a href="{{ url('/loan-form') }}" class="btn-get-started">Get Started</a>
    </div>
</div>

<div id="about" class="section">
    <div class="container">
        <h2>About Us</h2>
        <p>Microm Credit Corporation is dedicated to providing financial support to individuals and businesses.</p>
    </div>
</div>

<div id="team" class="section" style="background-color: #f4f4f4; padding: 80px 0;">
    <div class="container">
        <h2>Our Team</h2>
        <div class="team-container">
            <div class="border-0 shadow-sm team-member card" data-aos="fade-up" data-aos-delay="200">
                <div class="overflow-hidden rounded">
                    <img src="{{ asset('image/1.jpg') }}" alt="CEO" class="img-fluid team-img">
                </div>
                <h4 class="mt-3">Mark David Janpin</h4>
                <p>Branch Manager</p>
            </div>
            <div class="border-0 shadow-sm team-member card" data-aos="fade-up" data-aos-delay="400">
                <div class="overflow-hidden rounded">
                    <img src="{{ asset('image/3.jpg') }}" alt="Finance Manager" class="img-fluid team-img">
                </div>
                <h4 class="mt-3">Jessica Guelas Puro</h4>
                <p>Cash Costudial</p>
            </div>
            <div class="border-0 shadow-sm team-member card" data-aos="fade-up" data-aos-delay="600">
                <div class="overflow-hidden rounded">
                    <img src="{{ asset('image/4.jpg') }}" alt="Operations Head" class="img-fluid team-img">
                </div>
                <h4 class="mt-3">Joven Agne</h4>
                <p>Supervisor1/Roving</p>
            </div>
            <div class="border-0 shadow-sm team-member card" data-aos="fade-up" data-aos-delay="800">
                <div class="overflow-hidden rounded">
                    <img src="{{ asset('image/team4.jpg') }}" alt="Customer Relations" class="img-fluid team-img">
                </div>
                <h4 class="mt-3">Danrich Godalle</h4>
                <p>Customer Relations</p>
            </div>
        </div>
    </div>
</div>

<div id="benefits" class="section">
    <div class="container">
        <h2 class="mb-4">Loan Benefits</h2>
        <div class="benefit-container">
            <div class="benefit-box"><i class="fas fa-shield-alt text-primary"></i><h4>Insurance</h4><p>Comprehensive loan insurance coverage.</p></div>
            <div class="benefit-box"><i class="fas fa-car-crash text-danger"></i><h4>Accident Insurance</h4><p>Protect yourself with accident insurance.</p></div>
            <div class="benefit-box"><i class="fas fa-hand-holding-usd text-success"></i><h4>Financial Support</h4><p>Immediate financial assistance for your needs.</p></div>
            <div class="benefit-box"><i class="fas fa-check-circle text-info"></i><h4>Easy Loan Processing</h4><p>Quick and hassle-free loan approval.</p></div>
        </div>
    </div>
</div>

<footer><p>&copy; 2025 Microm Credit Corporation. All rights reserved.</p></footer>

<!-- AOS JS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,  // Animation duration
        once: false,     // Ensure the animation happens every time the user scrolls
        offset: 200      // Trigger animation when the element is 200px away from the viewport
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
