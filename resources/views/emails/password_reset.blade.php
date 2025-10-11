<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>

    <h1>Hello user {{ $user->name }}</h1>
    <p>You have requested for password reset</p>
    <p>Please click the link below to reset your password</p>
    <p>Token: {{ $token }}</p>
    <a href="{{ url('/password/password_reset?totken='.$token) }}">Password Reset</a>

    <p>Rememer the token is valid for 60 minutes!</p>
    <p>If you did not request the just ignore the mail</p>

    <h3>Thank you</h3>
    
</body>
</html>