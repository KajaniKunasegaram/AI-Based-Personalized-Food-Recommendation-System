    <!-- <link rel="stylesheet" href="{{asset('css/admin/support.css')}}">         -->
@extends('admin.layout')

@section('title','Support')
@section('page_title','Support')

@section('content')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Support</title>
    <link rel="stylesheet" href="{{asset('css/admin/support.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
</head>
<body>

<div class="support-page">

    <div class="support-header">
        <h1>Need Help?</h1>
        <p>Contact our support team using any option below</p>
    </div>

    <div class="support-cards">
        <!-- WhatsApp -->
        <a href="https://wa.me/94771234567" target="_blank" class="support-card whatsapp">
            <i class="fab fa-whatsapp fa-3x"></i>
            <span>WhatsApp Us</span>
        </a>

        <!-- Skype -->
        <a href="skype:live:your.skype.id?chat" class="support-card skype">
            <i class="fab fa-skype fa-3x"></i>
            <span>Skype Us</span>
        </a>

        <!-- Webex -->
        <a href="https://www.webex.com/meet/yourmeetingid" target="_blank" class="support-card webex">
            <i class="fas fa-video fa-3x"></i>
            <span>Webex Us</span>
        </a>
    </div>

    <div class="support-footer">
        Support available: 9.00 AM – 6.00 PM
    </div>

</div>

</body>
</html>
@endsection