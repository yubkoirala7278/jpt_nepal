<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Applicant Registration Confirmation</title>
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
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ $message->embed(public_path('logo.png')) }}" alt="Company Logo" style="height: 100px">
            <h1>Welcome to the Japanese Proficiency Test!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Dear {{ $studentData['name'] }},</h2>
            <p>We are pleased to inform you that your registration for the Japanese Proficiency Test has been
                successfully completed. Below are the details of your registration:</p>

            <div class="details">
                <p><strong>Applicant Name:</strong> {{ $studentData['name'] }}</p>
                <p><strong>Email Address:</strong> {{ $studentData['email'] }}</p>
                <p><strong>Phone Number:</strong> {{ $studentData['phone'] }}</p>
                <p><strong>Date of Birth:</strong> {{ $studentData['dob'] }}</p>
                <p><strong>Address:</strong> {{ $studentData['address'] }}</p>
                <p><strong>Registration Number:</strong> {{ $studentData['registration_number'] }}</p>
                @if (Auth::user() && Auth::user()->hasRole('consultancy_manager'))
                    <p><strong>Consultancy Name:</strong> {{ $studentData['consultancy_name'] }}</p>
                    <p><strong>Consultancy Address:</strong> {{ $studentData['consultancy_address'] }}</p>
                    <p><strong>Consultancy Phone Number:</strong> {{ $studentData['consultancy_phone_number'] }}</p>
                @else
                    <p><strong>Test Center Name:</strong> {{ $studentData['consultancy_name'] }}</p>
                    <p><strong>Test Center Address:</strong> {{ $studentData['consultancy_address'] }}</p>
                    <p><strong>Test Ceter Phone Number:</strong> {{ $studentData['consultancy_phone_number'] }}</p>
                @endif
                <p><strong>Exam Date:</strong> {{ $studentData['exam_date'] }}</p>
                <p><strong>Exam Time:</strong> {{ $studentData['exam_duration'] }}</p>
            </div>

            <p>After completing the exam, you can check your result using your <strong>Date of Birth</strong> and
                <strong>Registration Number</strong>. Please ensure you keep these details safe and secure.</p>

            <p>If you have any questions or need assistance, please contact us at support@yourcompany.com or call us at
                (123) 456-7890. We are here to help.</p>

            <p>Thank you for choosing the <strong>Japanese Proficiency Test</strong>. We wish you all the best in your
                preparation and exam!</p>
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
