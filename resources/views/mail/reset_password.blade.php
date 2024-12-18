<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Recovery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px 10px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }
        .content h2 {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .content p {
            margin: 0 0 10px;
        }
        .content .details {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f7f7f7;
        }
        .content .details p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            padding: 15px;
            font-size: 12px;
            color: #666666;
            background-color: #f1f1f1;
        }
        .button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ $message->embed(public_path('logo.png')) }}" alt="Company Logo" style="height: 100px">
            <h1>Password Recovery Request</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Hello,</h2>
            <p>We received a request to reset the password for your account. If you made this request, you can reset your password by clicking the link below:</p>

            <!-- Recovery Link -->
            <p>
                <a href="{{ url('password/reset', $token) }}?email={{ urlencode($email) }}" target="_blank" class="button">
                    Reset Password
                </a>
            </p>

            <p>If you didn't request a password reset, please ignore this email or let us know if you have any concerns.</p>

            <p>Thank you for using our services!</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Japanese Proficiency Test. All rights reserved.  
            <br>1234 Business Street, City, State, ZIP  
            <br>Email: support@yourcompany.com | Phone: (123) 456-7890
        </div>
    </div>
</body>
</html>
