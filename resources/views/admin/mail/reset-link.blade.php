<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .email-body {
            padding: 30px 20px;
            color: #333;
            line-height: 1.6;
        }
        .email-body h2 {
            color: #667eea;
            font-size: 20px;
            margin-top: 0;
        }
        .email-body p {
            margin: 0 0 15px 0;
            color: #666;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .button:hover {
            opacity: 0.9;
        }
        .copy-link {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            word-break: break-all;
            color: #667eea;
        }
        .email-footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
            border-top: 1px solid #ddd;
        }
        .footer-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Password Reset Request</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Hello {{ $admin->name }},</h2>

            <p>We received a request to reset the password associated with your admin account. If you did not make this request, you can ignore this email or reply to let us know.</p>

            <p>To reset your password, click the button below:</p>

            <div class="button-container">
                <a href="{{ $resetUrl }}" class="button">Reset Your Password</a>
            </div>

            <p style="margin-top: 20px; font-size: 14px; color: #999;">Or copy and paste this link in your browser:</p>
            <div class="copy-link">
                {{ $resetUrl }}
            </div>

            <p style="color: #999; font-size: 13px; margin-top: 20px;">
                This password reset link will expire in 60 minutes.
            </p>

            <p>If you have any questions or need assistance, please contact our support team.</p>

            <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd;">
                Best regards,<br>
                <strong>{{ config('app.name') }} Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p style="margin: 0 0 10px 0;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
            <div class="footer-links">
                <a href="{{ route('home') }}">Website</a>
                <a href="mailto:support@example.com">Support</a>
            </div>
        </div>
    </div>
</body>
</html>
