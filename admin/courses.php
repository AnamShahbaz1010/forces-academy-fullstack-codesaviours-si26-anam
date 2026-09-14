<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$coursesResult = mysqli_query($conn, "SELECT * FROM courses");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <div class="bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
            <h5>Admin Panel</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="students.php">Manage Students</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="courses.php">Manage Courses</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="assignments.php">Manage Assignments</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="results.php">Upload Results</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="notices.php">Post Notice</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="p-4" style="flex: 1;">
            <h2>Manage Courses</h2>

<h5>Add New Course</h5>
<form action="add_course.php" method="POST" class="mb-4">
    <div class="mb-2">
        <input type="text" name="course_name" placeholder="Course Name" class="form-control" required>
    </div>
    <div class="mb-2">
        <textarea name="description" placeholder="Description" class="form-control"></textarea>
    </div>
    <div class="mb-2">
        <input type="text" name="teacher_name" placeholder="Teacher Name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Course</button>
</form>

<table class="table table-dark table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Teacher</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($course = mysqli_fetch_assoc($coursesResult)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                <td><?php echo htmlspecialchars($course['description']); ?></td>
                <td><?php echo htmlspecialchars($course['teacher_name']); ?></td>
                <td>
                    <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="btn btn-primary btn-sm me-2">Edit</a>
                    <a href="delete_course.php?id=<?php echo $course['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this course?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</tabl>
        </div>

    </div>

</body>
</html>