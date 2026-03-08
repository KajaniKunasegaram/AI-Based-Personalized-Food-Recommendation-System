@extends('client.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/client/contact.css') }}">

<div class="contact-page">

    <!-- LEFT: Contact Form -->
    <div class="cp-left">

        <div class="cp-label">GET IN TOUCH</div>
        <h1 class="cp-title">We'd love to<br><em>hear from you</em></h1>
        <p class="cp-subtitle">Questions, feedback, or just want to say hello — drop us a message and we'll get back to you shortly.</p>

        @if(session('success'))
            <div class="success-msg" id="successMsg">
                <span class="success-icon">✓</span>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('client.contact.submit') }}" method="POST" class="cp-form">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder=" " required>
                    <label for="name">Full Name</label>
                    <div class="form-line"></div>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder=" " required>
                    <label for="email">Email Address</label>
                    <div class="form-line"></div>
                </div>
            </div>

            <div class="form-group">
                <input type="text" name="subject" id="subject" placeholder=" " required>
                <label for="subject">Subject</label>
                <div class="form-line"></div>
            </div>

            <div class="form-group">
                <textarea name="message" id="message" placeholder=" " required></textarea>
                <label for="message">Your Message</label>
                <div class="form-line"></div>
            </div>

            <button type="submit" class="submit-btn">
                <span>Send Message</span>
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>

    <!-- RIGHT: Info Panel -->
    <div class="cp-right">

        <!-- Contact Details -->
        <div class="info-block">
            <div class="info-icon-wrap"><i class="fa-solid fa-location-dot"></i></div>
            <div>
                <div class="info-label">Address</div>
                <div class="info-value">15 Baker Street, London<br>W1U 3BW, United Kingdom</div>
            </div>
        </div>

        <div class="info-block">
            <div class="info-icon-wrap"><i class="fa-solid fa-phone"></i></div>
            <div>
                <div class="info-label">Phone</div>
                <div class="info-value">+44 7700 900123</div>
            </div>
        </div>

        <div class="info-block">
            <div class="info-icon-wrap"><i class="fa-solid fa-envelope"></i></div>
            <div>
                <div class="info-label">Email</div>
                <div class="info-value">hello@masterchef.co.uk</div>
            </div>
        </div>

        <!-- Divider -->
        <div class="cp-divider">
            <span>Opening Hours</span>
        </div>

        <!-- Hours Table -->
        <div class="hours-table">
            <div class="hours-row header">
                <div>Day</div>
                <div>Pickup</div>
                <div>Delivery</div>
            </div>
            @foreach($days as $day)
                <div class="hours-row">
                    <div class="day-name">{{ $day }}</div>

                    <div>
                        @php $pickup = $shiftsData[$day]->firstWhere('service_type', 'Pickup'); @endphp
                        @if($pickup && $pickup->is_open)
                            <span class="open-time">{{ date('g:i A', strtotime($pickup->open_time)) }} – {{ date('g:i A', strtotime($pickup->close_time)) }}</span>
                        @else
                            <span class="closed-tag">Closed</span>
                        @endif
                    </div>

                    <div>
                        @php $delivery = $shiftsData[$day]->firstWhere('service_type', 'Delivery'); @endphp
                        @if($delivery && $delivery->is_open)
                            <span class="open-time">{{ date('g:i A', strtotime($delivery->open_time)) }} – {{ date('g:i A', strtotime($delivery->close_time)) }}</span>
                        @else
                            <span class="closed-tag">Closed</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const msg = document.getElementById('successMsg');
        if (msg) {
            setTimeout(() => {
                msg.style.opacity = '0';
                msg.style.transition = 'opacity 0.5s ease';
                setTimeout(() => msg.remove(), 500);
            }, 3000);
        }
    });
</script>

@endsection