<!DOCTYPE html>
<html>
<head>
    <title>Two-Factor Authentication Code</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>Your two-factor authentication code is:</p>
    <h2>{{ $twoFactorCode }}</h2>
    <p>This code will expire in 10 minutes.</p>
</body>
</html>
