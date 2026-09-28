<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$assignmentsResult = mysqli_query($conn, "SELECT assignments.*, courses.course_name FROM assignments JOIN courses ON assignments.course_id = courses.id ORDER BY assignments.id DESC");
$coursesResult = mysqli_query($conn, "SELECT id, course_name FROM courses");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Assignments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <h2>Manage Assignments</h2>

            <h5>Add New Assignment</h5>
            <form action="add_assignment.php" method="POST" class="mb-4">
                <div class="mb-2">
                    <input type="text" name="title" placeholder="Assignment Title" class="form-control" required>
                </div>
                <div class="mb-2">
                    <textarea name="description" placeholder="Description" class="form-control" required></textarea>
                </div>
                <div class="mb-2">
                    <select name="course_id" class="form-control" required>
                        <option value="">Select Course</option>
                        <?php while ($course = mysqli_fetch_assoc($coursesResult)) { ?>
                            <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-2">
                    <input type="date" name="due_date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Assignment</button>
            </form>

            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Course</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($assignment = mysqli_fetch_assoc($assignmentsResult)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($assignment['title']); ?></td>
                            <td><?php echo htmlspecialchars($assignment['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($assignment['due_date']); ?></td>
                            <td>
                                <a href="edit_assignment.php?id=<?php echo $assignment['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="delete_assignment.php?id=<?php echo $assignment['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this assignment?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>

    </div>

</body>
</html>