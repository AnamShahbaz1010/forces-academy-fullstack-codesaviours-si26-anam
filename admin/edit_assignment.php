<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$assignmentId = $_GET['id'];
$sql = "SELECT * FROM assignments WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $assignmentId);
mysqli_stmt_execute($stmt);
$assignment = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$coursesResult = mysqli_query($conn, "SELECT id, course_name FROM courses");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-4">
        <h2>Edit Assignment</h2>

        <form action="update_assignment.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $assignment['id']; ?>">

            <div class="mb-2">
                <input type="text" name="title" value="<?php echo htmlspecialchars($assignment['title']); ?>" class="form-control" required>
            </div>

            <div class="mb-2">
                <textarea name="description" class="form-control" required><?php echo htmlspecialchars($assignment['description']); ?></textarea>
            </div>

            <div class="mb-2">
                <select name="course_id" class="form-control" required>
                    <?php while ($course = mysqli_fetch_assoc($coursesResult)) { ?>
                        <option value="<?php echo $course['id']; ?>" <?php echo ($course['id'] == $assignment['course_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($course['course_name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-2">
                <input type="date" name="due_date" value="<?php echo $assignment['due_date']; ?>" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Assignment</button>
        </form>
    </div>

</body>
</html> 