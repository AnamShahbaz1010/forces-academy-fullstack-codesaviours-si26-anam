<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';

$studentId = $_SESSION['student_id'];
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // block an email that belongs to a different student
    $checkSql = "SELECT id FROM students WHERE email = ? AND id != ?";
    $checkStmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "si", $email, $studentId);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($checkResult) > 0) {
        $error = 'That email is already used by another account.';
    } else {
        $updateSql = "UPDATE students SET full_name = ?, email = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($conn, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "ssi", $name, $email, $studentId);
        mysqli_stmt_execute($updateStmt);

        $_SESSION['student_name'] = $name;
        $success = 'Profile updated successfully!';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $pwSql = "SELECT password FROM students WHERE id = ?";
    $pwStmt = mysqli_prepare($conn, $pwSql);
    mysqli_stmt_bind_param($pwStmt, "i", $studentId);
    mysqli_stmt_execute($pwStmt);
    $current = mysqli_fetch_assoc(mysqli_stmt_get_result($pwStmt));

    if (!password_verify($_POST['current_password'], $current['password'])) {
        $error = 'Current password is incorrect.';
    } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
        $error = 'New passwords do not match.';
    } else {
        $newHashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $updatePwSql = "UPDATE students SET password = ? WHERE id = ?";
        $updatePwStmt = mysqli_prepare($conn, $updatePwSql);
        mysqli_stmt_bind_param($updatePwStmt, "si", $newHashed, $studentId);
        mysqli_stmt_execute($updatePwStmt);
        $success = 'Password updated successfully!';
    }
}

$sql = "SELECT * FROM students WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $studentId);
mysqli_stmt_execute($stmt);
$student = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <h2>My Profile</h2>

            <?php if ($error) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <?php if ($success) { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php } ?>

            <div class="stat-card p-3 mb-4" style="max-width: 400px;">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($student['full_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
                <p><strong>Roll Number:</strong> <?php echo htmlspecialchars($student['roll_number']); ?></p>
                <p class="mb-0"><strong>Class:</strong> <?php echo htmlspecialchars($student['class']); ?></p>
</div>

           <h5>Edit Profile</h5>
<form method="POST" class="mb-4" style="max-width: 400px;">
    <div class="mb-2">
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['full_name']); ?>" class="form-control" required>
    </div>
    <div class="mb-2">
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" class="form-control" required>
    </div>
    <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
</form>

<h5>Change Password</h5>
<form method="POST" style="max-width: 400px;">
    <div class="mb-2">
        <input type="password" name="current_password" placeholder="Current Password" class="form-control" required>
    </div>
    <div class="mb-2">
        <input type="password" name="new_password" placeholder="New Password" class="form-control" required>
    </div>
    <div class="mb-2">
        <input type="password" name="confirm_password" placeholder="Confirm New Password" class="form-control" required>
    </div>
    <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
</form>
        </div>
    
    </div>

</body>
</html>