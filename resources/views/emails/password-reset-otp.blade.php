<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
        }
        .content {
            padding: 20px 0;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 5px;
            text-align: center;
            margin: 30px 0;
            padding: 15px;
            background-color: #f0f7ff;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Password Reset OTP</h1>
        </div>
        <div class="content">
            <p>Hello {{ $name }},</p>
            <p>You've requested to reset your password. Please use the following 5-digit OTP code to verify your identity:</p>
            
            <div class="otp-code">{{ $otp }}</div>
            
            <p>This code will expire in 15 minutes for security reasons.</p>
            <p>If you didn't request a password reset, please ignore this email or contact our support team if you have concerns.</p>
            <p>Thank you,<br>The NutriTrack Team</p>
        </div>
        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
            <p>&copy; {{ date('Y') }} NutriTrack. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 