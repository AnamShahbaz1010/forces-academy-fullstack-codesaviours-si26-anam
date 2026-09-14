<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$courseId = $_GET['id'];
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $courseId);
mysqli_stmt_execute($stmt);
$course = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-4">
        <h2>Edit Course</h2>

        <form action="update_course.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $course['id']; ?>">

            <div class="mb-2">
                <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['course_name']); ?>" class="form-control" required>
            </div>

            <div class="mb-2">
                <textarea name="description" class="form-control"><?php echo htmlspecialchars($course['description']); ?></textarea>
            </div>

            <div class="mb-2">
                <input type="text" name="teacher_name" value="<?php echo htmlspecialchars($course['teacher_name']); ?>" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Course</button>
        </form>
    </div>

</body>
</html>