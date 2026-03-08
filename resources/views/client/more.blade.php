@extends('client.layout')

@section('content')
<link rel="stylesheet" href="{{ asset('css/client/more.css') }}">

<div class="more-page">

    <!-- LEFT SIDEBAR -->
    <aside class="sidebar-panel">

        <!-- User Avatar & Info -->
        <div class="user-profile">
            <div class="user-avatar">
                {{ strtoupper(substr(session('customer_name', 'U'), 0, 1)) }}
            </div>
            <div class="user-details">
                <strong>{{ session('customer_name') }}</strong>
                <span>{{ session('customer_email') }}</span>
            </div>
        </div>

        <!-- Nav Menu -->
        <nav class="side-nav">
            <ul>
                <li class="active" onclick="showSection('profile')">
                    <i class="fa-regular fa-user"></i>
                    <span>My Account</span>
                </li>
                <li onclick="showSection('support')">
                    <i class="fa-regular fa-circle-question"></i>
                    <span>Need Help</span>
                </li>
                <li onclick="showSection('allergy')">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Allergy Info</span>
                </li>
                <li onclick="showSection('delete')">
                    <i class="fa-regular fa-trash-can"></i>
                    <span>Delete Account</span>
                </li>
                <li class="logout-item">
                    <a href="{{ route('customer.logout') }}" onclick="return confirm('Are you sure you want to logout?')">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- RIGHT CONTENT -->
    <div class="content-panel">

        <!-- PROFILE -->
        <section class="content-section section" id="profile">
            <div class="section-header">
                <div class="section-label">ACCOUNT</div>
                <h2 class="section-title">My <em>Account</em></h2>
                <p class="section-sub">Manage your personal information</p>
            </div>

            <div class="profile-grid">
                <div class="field-group">
                    <input type="text" value="{{ session('customer_name') }}" readonly>
                    <label>Full Name</label>
                    <div class="field-line active-line"></div>
                </div>
                <div class="field-group">
                    <input type="email" value="{{ session('customer_email') }}" readonly>
                    <label>Email Address</label>
                    <div class="field-line active-line"></div>
                </div>
            </div>
        </section>

        <!-- SUPPORT -->
        <section class="content-section section" id="support">
            <div class="section-header">
                <div class="section-label">SUPPORT</div>
                <h2 class="section-title">Need <em>Help?</em></h2>
                <p class="section-sub">Our team is always ready to assist you</p>
            </div>

            <div class="support-tiles">
                <a href="https://wa.me/447123456789" target="_blank" class="support-tile whatsapp-tile">
                    <div class="tile-icon">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div class="tile-info">
                        <h3>WhatsApp Support</h3>
                        <p>Tap to chat with us instantly</p>
                        <span>+44 7123 456789</span>
                    </div>
                    <i class="fa-solid fa-arrow-up-right-from-square tile-arrow"></i>
                </a>

                <div class="support-tile help-tile">
                    <div class="tile-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div class="tile-info">
                        <h3>Help Center</h3>
                        <p>Customer Care Line</p>
                        <span>+44 7700 900123</span>
                    </div>
                    <i class="fa-solid fa-headset tile-arrow"></i>
                </div>
            </div>
        </section>

        <!-- ALLERGY -->
        <section class="content-section section" id="allergy">
            <div class="section-header">
                <div class="section-label">SAFETY</div>
                <h2 class="section-title">Allergy <em>Information</em></h2>
                <p class="section-sub">Please read carefully before ordering</p>
            </div>

            <div class="allergy-list">
                <div class="allergy-item">
                    <div class="allergy-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <div>
                        <strong>What if I have a food allergy?</strong>
                        <p>You should leave a note for the Masterchef on the Checkout Page/Basket or contact the Masterchef directly.</p>
                    </div>
                </div>
                <div class="allergy-item">
                    <div class="allergy-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <div>
                        <strong>How do we make sure the allergy info is accurate?</strong>
                        <p>Contact the Masterchef directly to get up-to-date info.</p>
                    </div>
                </div>
                <div class="allergy-item">
                    <div class="allergy-icon"><i class="fa-solid fa-address-book"></i></div>
                    <div>
                        <strong>How do I contact the Masterchef?</strong>
                        <p>Contact details are on the Masterchef website.</p>
                    </div>
                </div>
                <div class="allergy-item">
                    <div class="allergy-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                    <div>
                        <strong>Does the law require all food businesses to provide allergy information?</strong>
                        <p>Please contact the Masterchef directly for any information regarding food allergies.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- DELETE ACCOUNT -->
        <section class="content-section section" id="delete">
            <div class="section-header">
                <div class="section-label">DANGER ZONE</div>
                <h2 class="section-title">Delete <em>Account</em></h2>
                <p class="section-sub">This action is permanent and cannot be undone</p>
            </div>

            <div class="delete-card">
                <div class="delete-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <div>
                        <strong>Are you absolutely sure?</strong>
                        <p>Deleting your account will permanently remove all your data, order history, and preferences. This cannot be reversed.</p>
                    </div>
                </div>
                <form action="{{ route('customer.delete') }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete your account?');">
                    @csrf
                    <button type="submit" class="delete-btn">
                        <i class="fa-regular fa-trash-can"></i>
                        Delete My Account
                    </button>
                </form>
            </div>
        </section>

    </div>
</div>

<script>
function showSection(id) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(id).classList.add('active');

    document.querySelectorAll('.side-nav ul li').forEach(li => li.classList.remove('active'));
    document.querySelector(`.side-nav ul li[onclick*="${id}"]`).classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
    showSection('profile');
});
</script>

@endsection