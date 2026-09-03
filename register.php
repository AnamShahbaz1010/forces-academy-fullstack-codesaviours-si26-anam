<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];
$roll_number = trim($_POST['roll_number']);
$class = trim($_POST['class']);
if (empty($full_name) || empty($email) || empty($password)
|| empty($roll_number) || empty($class)) {
$error = 'All fields are required.';
} elseif ($password !== $confirm) {
$error = 'Passwords do not match.';
} else {
$success = 'Looks good! (Not saved yet — database class is next.)';
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h2>Register</h2>

        <form action="register.php" method="POST">

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
            </div>

            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
            </div>

            <div class="mb-3">
                <label for="roll_number" class="form-label">Roll Number</label>
                <input type="text" class="form-control" id="roll_number" name="roll_number" placeholder="e.g. 2024-CS-101" required>
            </div>

            <div class="mb-3">
                <label for="class" class="form-label">Class</label>
                <input type="text" class="form-control" id="class" name="class" placeholder="e.g. BSCS-2A" required>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Register</button>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <?php if (isset($success)) { echo "<p style='color:green;'>$success</p>"; } ?>
        </form>
    </div>

</body>
</html>