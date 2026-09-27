<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forces Academy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">

        <h1 style="color: var(--neon-cyan);">Forces Academy</h1>
        <p class="text-white mb-4">Your student portal for courses, assignments, and results.</p>

        <div>
            <a href="login.php" class="btn btn-primary me-2">Login</a>
            <a href="register.php" class="btn btn-outline-info">Register</a>
        </div>

    </div>

</body>
</html>