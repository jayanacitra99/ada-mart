<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email Address</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>Please click the following link to verify your email address:</p>
    <p><a href="{{ $verificationLink }}">{{ $verificationLink }}</a></p>
    <p>If you did not request this, please ignore this email.</p>
</body>
</html>
