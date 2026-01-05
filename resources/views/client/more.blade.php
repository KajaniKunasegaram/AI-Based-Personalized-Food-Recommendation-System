
@extends('client.layout')

@section('content')


    <link rel="stylesheet" href="{{ asset('css/client/more.css') }}">


<div class="page">

    <!-- LEFT SIDEBAR -->
    <aside class="sidebar">
        <div class="user-box">
            <strong>kajanii</strong>
            <span>officialcarparking2025@gmail.com</span>
        </div>

        <ul class="menu">
            <li class="active">Profile</li>
            <li>Address Book</li>
            <li>Saved Cards</li>
        </ul>

        <div class="divider"></div>

        <ul class="menu">
            <li>English (United Kingdom)</li>
            <li>Support</li>
            <li>Allergy Information</li>
            <li class="logout">Logout</li>
        </ul>
    </aside>

    <!-- RIGHT CONTENT -->
    <main class="content">
        <h2>ACCOUNT</h2>

        <div class="card">
            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" value="kajanii">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Phone no</label>
                    <input type="text" placeholder="+44">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" value="officialcarparking2025@gmail.com">
                </div>
            </div>
        </div>

        <div class="offers">
            <p>RECEIVE OFFERS FROM USA FRIED CHICKEN THROUGH</p>
            <label><input type="checkbox"> Email</label>
            <label><input type="checkbox"> SMS</label>
        </div>

        <div class="card">
            <div class="advanced">
                <strong>ADVANCED OPTIONS</strong>
            </div>

            <div class="advanced-item">
                Export my data
            </div>

            <div class="advanced-item delete">
                Delete account
            </div>
        </div>
    </main>

</div>



@endsection