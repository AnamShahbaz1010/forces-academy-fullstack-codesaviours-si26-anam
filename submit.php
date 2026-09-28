<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';

$assignmentId = $_GET['id'];
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['submission_file'])) {
    $file = $_FILES['submission_file'];
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $actualMimeType = finfo_file($fileInfo, $file['tmp_name']);
    finfo_close($fileInfo);

    if (!in_array($actualMimeType, $allowedTypes)) {
        $error = 'Only PDF and image files are allowed.';
    } else {
        $uniqueName = uniqid() . '_' . $file['name'];
        $destination = 'uploads/' . $uniqueName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            $studentId = $_SESSION['student_id'];
            $sql = "INSERT INTO submissions (assignment_id, student_id, file_path) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iis", $assignmentId, $studentId, $destination);
            mysqli_stmt_execute($stmt);
            $success = 'Assignment submitted successfully!';
        } else {
            $error = 'Upload failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <h2>Submit Assignment</h2>
            
            <?php if ($error) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>

            <?php if ($success) { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php } else { ?>
                <form action="submit.php?id=<?php echo $assignmentId; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="file" name="submission_file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            <?php } ?>

        </div>

    </div>

</body>
</html>