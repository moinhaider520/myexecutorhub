<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back!</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

    <!-- Wrapper -->
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td style="text-align:center;">
                <!-- Main Container -->
                <table width="600" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #000000; padding: 20px; text-align: center; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px;">Welcome Back to Our Service!</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333333; font-size: 20px;">Hello, {{ $user->name }}!</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                We’re excited to have you back after your free trial! Your subscription is now active, and you’re all set to enjoy our full range of services.
                            </p>
                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                Click the button below to explore your dashboard and make the most of your experience.
                            </p>

                            <!-- Call-to-Action Button -->
                            <table cellspacing="0" cellpadding="0" style="margin: 20px 0;">
                                <tr>
                                    <td style="text-align:center;">
                                        <a href="{{ route('home') }}" style="background-color: #007bff; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 16px; display: inline-block;">
                                            Explore Now
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color: #555555; font-size: 16px; line-height: 1.6;">
                                If you have any questions, our support team is here to help.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f1f1f1; text-align: center; padding: 20px;">
                            <p style="color: #888888; font-size: 14px;">
                                Best Regards,<br>{{ config('app.name') }} Team
                            </p>
                            <p style="color: #888888; font-size: 12px;">
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                            <p style="color: #888888; font-size: 12px;">
                                <a href="{{ url('/unsubscribe') }}" style="color: #007bff; text-decoration: none;">Unsubscribe</a> | 
                                <a href="{{ url('/privacy-policy') }}" style="color: #007bff; text-decoration: none;">Privacy Policy</a>
                            </p>
                        </td>
                    </tr>
                </table>
                <!-- End of Main Container -->
            </td>
        </tr>
    </table>
    <!-- End of Wrapper -->

</body>
</html>
