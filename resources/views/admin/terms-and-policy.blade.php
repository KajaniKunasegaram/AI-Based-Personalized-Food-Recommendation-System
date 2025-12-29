@extends('admin.layout')

@section('title','Terms & Policy')
@section('page_title','Terms & Policy')

@section('content')
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Terms & Policy</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
         
        }

        body {
            background: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }

        .terms-container {
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .terms-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 32px;
            color: #2c3e50;
        }

        .terms-container h2 {
            margin-top: 30px;
            font-size: 24px;
            color: #34495e;
        }

        .terms-container p {
            margin: 15px 0;
            font-size: 16px;
            color: #555;
        }

        .terms-container ul {
            margin: 10px 0 10px 25px;
        }

        .terms-container ul li {
            margin-bottom: 8px;
        }

        /* Scrollable if content is long */
        .terms-container {
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Custom scrollbar */
        .terms-container::-webkit-scrollbar {
            width: 8px;
        }
        .terms-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 8px;
        }
        .terms-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 8px;
        }
        .terms-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Footer */
        .terms-footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .terms-container {
                padding: 20px;
                margin: 20px;
            }
        }

    </style>
</head>
<body>

<div class="terms-container">
    <h1>Terms & Policy</h1>

    <p>Welcome to our application. By accessing or using our service, you agree to comply with the following terms and policies. Please read them carefully.</p>

    <h2>1. Acceptance of Terms</h2>
    <p>By using our services, you accept these Terms & Policy in full. If you disagree with any part, you should not use our services.</p>

    <h2>2. User Responsibilities</h2>
    <ul>
        <li>Users must provide accurate information when required.</li>
        <li>Users must not misuse the service for illegal activities.</li>
        <li>Users are responsible for maintaining the confidentiality of their account credentials.</li>
    </ul>

    <h2>3. Privacy Policy</h2>
    <p>We respect your privacy. Your personal information will be handled according to our privacy policy and will not be shared without your consent except as required by law.</p>

    <h2>4. Intellectual Property</h2>
    <p>All content, design, and assets of this application are protected by copyright and other intellectual property laws. Unauthorized use is prohibited.</p>

    <h2>5. Limitation of Liability</h2>
    <p>We are not liable for any damages or losses resulting from the use or inability to use our services.</p>

    <h2>6. Changes to Terms</h2>
    <p>We may update these Terms & Policy at any time. Users will be notified of significant changes and continued use implies acceptance of the new terms.</p>

    <div class="terms-footer">
        © 2025 Master Chef. All rights reserved.
    </div>
</div>

</body>
</html>
@endsection
