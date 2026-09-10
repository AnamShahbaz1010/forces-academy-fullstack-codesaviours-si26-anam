<?php
session_start();
require_once 'config/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM students WHERE email = '$email'");

    if (mysqli_num_rows($result) === 0) {
        $error = "No account with that email.";
    } else {
        $student = mysqli_fetch_assoc($result);
        if (password_verify($password, $student['password'])) {
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['full_name'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Incorrect password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="container">
        <h2>Login</h2>
        <?php if ($error) { ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php } ?>
        <form action="login.php" method="POST">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Login</button>

        </form>

        <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a></p>
    </div>

</body>
</html>