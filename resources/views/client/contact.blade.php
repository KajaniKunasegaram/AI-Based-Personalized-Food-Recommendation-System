@extends('client.layout')

@section('content')

<link rel="stylesheet" href="{{ asset('css/client/contact.css') }}">
<div class="contact-page-grid">

    <div class="contact-container">
        <div class="contact-card">
            <div class="contact-header">
                <h2>Contact Us</h2>
                <p>If you have any questions or feedback, send us a message below!</p>
            </div>

            <div class="contact-content">
                <!-- Contact Form -->
                <div class="contact-form">
                    @if(session('success'))
                        <div class="success-msg" id="successMsg">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('client.contact.submit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" placeholder="Your full name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="Your email" required>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" id="subject" placeholder="Subject" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" placeholder="Your message" required></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="business-hours-card">
        <h3><i class="fa-regular fa-clock"></i> Opening Hours</h3>

        <div class="hours-table">
            <div class="hours-row header">
                <div>Day</div>
                <div>Pickup</div>
                <div>Delivery</div>
            </div>
            @foreach($days as $day)
                <div class="hours-row">
                    <div>{{ $day }}</div>

                    <div>
                        @php
                            $pickup = $shiftsData[$day]->firstWhere('service_type', 'Pickup'); // make sure case matches
                        @endphp
                        @if($pickup && $pickup->is_open)
                            {{ date('g:i A', strtotime($pickup->open_time)) }} - {{ date('g:i A', strtotime($pickup->close_time)) }}
                        @else
                            Closed
                        @endif
                    </div>

                    <div>
                        @php
                            $delivery = $shiftsData[$day]->firstWhere('service_type', 'Delivery'); // make sure case matches
                        @endphp
                        @if($delivery && $delivery->is_open)
                            {{ date('g:i A', strtotime($delivery->open_time)) }} - {{ date('g:i A', strtotime($delivery->close_time)) }}
                        @else
                            Closed
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="contact-card" style="margin-top:30px;"> 
            <div class="contact-info">
                <h3 style="color:#e03c2a;">Contact Details</h3>
                <p><strong>Address:</strong> 15 Baker Street, London, W1U 3BW, United Kingdom</p>
                <p><strong>Phone:</strong> +44 7700 900123</p>
                <p><strong>Email:</strong> masterchef.co.uk</p>
            </div>
        </div>
    </div>
</div>
   



<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const msg = document.getElementById('successMsg');
        if(msg){
            setTimeout(() => {
                msg.style.opacity = '0';      // fade out
                msg.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    msg.remove();             // remove from DOM
                }, 500);
            }, 3000); // 3 seconds
        }
    });
</script>
@endsection
