<!-- filepath: c:\Users\jhonner\OneDrive\Desktop\file-back up\resources\views\clients\dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
</head>
<body>
    <h1>Welcome, {{ Auth::guard('client')->user()->name }}!</h1>
    <p>This is your client dashboard.</p>

    <!-- Logout Form -->
    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">
            Logout
        </button>
    </form>
</body>
</html>