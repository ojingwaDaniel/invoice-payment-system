<!DOCTYPE html>
<html>
<head>
    <title>Account Created</title>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>Your accountant account has been created.</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Temporary Password:</strong> {{ $password }}</p>
    <p>Please login and change your password immediately.</p>
</body>
</html>
