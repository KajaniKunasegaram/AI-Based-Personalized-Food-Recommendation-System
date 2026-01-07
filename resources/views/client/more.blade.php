

@extends('client.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/client/more.css') }}">

<div class="main">

    <!-- LEFT SIDEBAR -->
    <section >
        <div class="side">

            <div class="user-box"> 
                <strong>{{ session('customer_name') }}</strong> <span>{{ session('customer_email') }}</span>
            </div>
            <ul>
                <li class="active" onclick="showSection('profile')">My Account</li>
                <li onclick="showSection('support')">Need Help</li>
                <li onclick="showSection('allergy')">Allergy Information</li>
                <li onclick="showSection('delete')">Delete Account</li>
                <li>
                    <a style="text-decoration: none; " href="{{ route('customer.logout') }}" onclick="return confirm('Are you sure you want to logout?')">Logout</a>
                </li>

            </ul>
        </div>
    </section>

    <!-- RIGHT CONTENT -->
    <div class="wrapper">

        <!-- PROFILE -->
        <section class="card profile-card section" id="profile">
            <div class="card-header">
                <h2>My Account</h2>
                <p>Manage your personal information</p>
            </div>

            <div class="profile-info">
                <div>
                    <label>Name</label>
                    <input type="text" value="{{ session('customer_name') }}" readonly>
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" value="{{ session('customer_email') }}" readonly>
                </div>
            </div>
        </section>

        <!-- SUPPORT -->
        <section class="support-section section" id="support">
            <h2 class="support-title">Need Help?</h2>
            <p class="support-sub">Our team is always ready to support you</p>

            <a href="https://wa.me/447123456789" target="_blank" class="support-tile whatsapp-tile">
                <div class="icon">💬</div>
                <div class="info">
                    <h3>WhatsApp Support</h3>
                    <p>Tap to chat with us</p>
                    <span>+44 7123 456789</span>
                </div>
            </a>

            <div class="support-tile help-tile">
                <div class="icon">☎️</div>
                <div class="info">
                    <h3>Help Center</h3>
                    <p>Customer Care</p>
                    <span>+44 7700 900123</span>
                </div>
            </div>
        </section>

        <!-- ALLERGY -->
        <section class="card allergy-card section" id="allergy">
            <div class="card-header">
                <h2>Allergy Information</h2>
                <p>Please read carefully before ordering</p>
            </div>
            <ul class="allergy-list">
                <li><strong style="color:dodgerblue;">What if I have a food allergy?</strong><br><br>
                    You should leave a note for the Masterchef on the Checkout Page/Basket or contact the Masterchef directly.
                </li>
                <li><strong style="color:dodgerblue;">How do we make sure the allergy info is accurate?</strong><br><br>
                    Contact the Masterchef directly to get up-to-date info.
                </li>
                <li><strong style="color:dodgerblue;">How do I contact the Masterchef?</strong><br><br>
                    Contact details are on the Masterchef website.
                </li>
                <li><strong style="color:dodgerblue;">Does the law require all food businesses to provide information about food allergies?</strong><br><br>
                Please contact the Masterchef directly for any information regarding any food allergies.</li>
            </ul>
        </section>

        <!-- DELETE ACCOUNT -->
         <section class="card allergy-card section" id="delete">
            <div class="card-header">
                <h2>Delete Account</h2>
                <p>This action is irreversible!</p>

                <form action="{{ route('customer.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
                    @csrf
                    <button type="submit" style="background:#e03c2a;color:#fff;padding:10px 20px;border:none;border-radius:10px;cursor:pointer;">
                        Delete Account
                    </button>
                </form>
            </div>
        </section>

    </div>
</div>


<script>
function showSection(id) {
    // Hide all sections
    document.querySelectorAll('.section').forEach(s => {
        s.classList.remove('active');
    });
    // Show selected section
    document.getElementById(id).classList.add('active');

    // Remove active class from all menu items
    document.querySelectorAll('.side ul li').forEach(li => {
        li.classList.remove('active');
    });

    // Add active to clicked menu item
    document.querySelector(`.side ul li[onclick*="${id}"]`).classList.add('active');
}

// Logout function
function logout() {
    alert('Logging out...');
    // You can redirect to logout route
    // window.location.href = '/logout';
}

// On page load, show profile by default
document.addEventListener('DOMContentLoaded', () => {
    showSection('profile');
});
</script>

@endsection
