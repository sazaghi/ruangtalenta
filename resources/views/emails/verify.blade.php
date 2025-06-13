<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; margin: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 6px; overflow: hidden;">
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #ffffff;">
                <img src="{{ asset('images/logo-dark.png') }}" alt="Logo" style="max-width: 150px;">
            </td>
        </tr>
        <tr>
            <td style="padding: 30px; color: #333333;">
                <h2 style="margin-top: 0;">Hi {{ $user->name }},</h2>
                <p>Thanks for signing up, we just need to verify your email address:</p>

                <p style="text-align: center; margin: 30px 0;">
                    <a href="{{ $url }}" style="background-color: #4CAF50; color: white; text-decoration: none; padding: 12px 24px; border-radius: 4px; display: inline-block; font-weight: bold;">
                        Verify your email address
                    </a>
                </p>

                <p>If you have any issues confirming your email we will be happy to help you. You can contact us on <a href="mailto:support@freelancer.com" style="color: #0066cc;">support@freelancer.com</a>.</p>

                <p style="margin-top: 30px;">Regards,<br><strong>The Freelancer Team.</strong></p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; font-size: 12px; text-align: center; color: #777; background-color: #f4f4f4;">
                &copy; {{ date('Y') }} Your Company. All rights reserved.<br>
                <a href="#" style="color: #777; text-decoration: underline;">Privacy Policy</a> | <a href="#" style="color: #777; text-decoration: underline;">Terms and Conditions</a><br>
                <a href="mailto:support@yourcompany.com" style="color: #777;">support@yourcompany.com</a>
            </td>
        </tr>
    </table>
</body>
</html>
