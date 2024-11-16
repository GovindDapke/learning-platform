<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Platform - Guest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Header for Guest Pages (Optional) -->
    <header class="navbar navbar-light bg-light">
        <a class="navbar-brand ms-3" href="#">Learning Platform</a>
    </header>

    <!-- Main Content for Guest Pages -->
    <main class="container my-5">
        @yield('content')
    </main>

    <footer class="text-center py-3">
        <p>&copy; 2024 Learning Platform. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
