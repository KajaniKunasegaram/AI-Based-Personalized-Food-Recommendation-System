
@extends('client.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/client/about.css') }}">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Master Chef</title>
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Hero / Intro -->
    <!-- <section class="hero">
        <div class="container">
            <h1>Welcome to Master Chef</h1>
            <p>Delivering delicious meals made with love and fresh ingredients. Taste the difference!</p>
            <a href="#contact" class="btn">Contact Us</a>
        </div>
    </section> -->
    <section class="hero">
        <div class="hero-slider">
                <img src="{{ asset('images/client/img1.jpg') }}" class="active" alt="Slide 1">
                <img src="{{ asset('images/client/img2.png') }}" alt="Slide 2">
                <img src="{{ asset('images/client/img3.jpg') }}" alt="Slide 3">
                <img src="{{ asset('images/client/img4.jpg') }}" alt="Slide 4">
                <img src="{{ asset('images/client/img5.jpg') }}" alt="Slide 5">
        </div>

        <div class="hero-content">
            <h1>Welcome to Master Chef</h1>
            <p>Delivering delicious meals made with love and fresh ingredients. Taste the difference!</p>
            <a href="{{route('orders')}}" class="btn">Order Now</a>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mission">
        <div class="container">
            <h2  class="heading">Our Mission & Vision</h2>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-bullseye"></i>
                    <h3>Our Mission</h3>
                    <p>To provide freshly prepared meals with the highest quality ingredients and excellent service.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-eye"></i>
                    <h3>Our Vision</h3>
                    <p>To become the most trusted and loved food delivery service.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="values">
        <div class="container">
            <h2  class="heading">Why Choose Us</h2>
            <div class="cards">
                <div class="card">
                    <i class="fa-solid fa-leaf"></i>
                    <h3>Fresh Ingredients</h3>
                    <p>Only the best ingredients go into our meals.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-truck-fast"></i>
                    <h3>Fast Delivery</h3>
                    <p>Get your meals hot and on time.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-money-bill-wave"></i>
                    <h3>Affordable Prices</h3>
                    <p>Delicious food that won’t break the bank.</p>
                </div>
                <div class="card">
                    <i class="fa-solid fa-star"></i>
                    <h3>Customer Satisfaction</h3>
                    <p>We prioritize your happiness with every order.</p>
                </div>
            </div>
        </div>
    </section>

  

    <!-- Call to Action -->
    <section class="cta" id="contact">
        <div class="container">
            <h2>Ready to Order?</h2>
            <p>Contact us or place your order today!</p>
             <a href="{{route('orders')}}" class="btn" style="margin-right:20px;">Order Now</a>
            <a href="{{ route('client.contact') }}" class="btn">Get in Touch</a>
        </div>
    </section>

  <!-- Team -->
    <section class="team">
        <div class="container">
            <h2 class="heading" >Meet Our Team</h2>
            <div class="team-cards">
                <div class="team-card">
                    <img src="{{ asset('images/client/chef1.png') }}" alt="Chef John">
                    <h3>Chef John</h3>
                    <p>Head Chef & Founder</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/client/chef2.png') }}" alt="Chef Maria">
                    <h3>Chef Maria</h3>
                    <p>Pastry Specialist</p>
                </div>
                <div class="team-card">
                    <img src="{{ asset('images/client/chef1.png') }}" alt="Chef Alex">
                    <h3>Chef Alex</h3>
                    <p>Kitchen Manager</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        const slides = document.querySelectorAll('.hero-slider img');
        let current = 0;

        function showNextSlide() {
            slides[current].classList.remove('active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('active');
        }

        setInterval(showNextSlide, 2300); // 2300ms = 2.3 seconds
    </script>

</body>
</html>

@endsection