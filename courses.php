<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';
$result = mysqli_query($conn, "SELECT * FROM courses");
$courseCount = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <div class="bg-dark text-white p-3" style="width: 220px; min-height: 100vh;">
            <h5>Forces Academy</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link text-white" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="courses.php">My Courses</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="assignments.php">Assignments</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="results.php">My Results</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="notices.php">Notices</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="p-4" style="flex: 1;">
            <h2>My Courses</h2>

<?php if ($courseCount === 0) { ?>
    <p>No courses have been added yet. Check back soon!</p>
<?php } else { ?>
    <div class="row">
        <?php while ($course = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($course['course_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($course['description']); ?></p>
                        <p class="card-text"><small>Teacher: <?php echo htmlspecialchars($course['teacher_name']); ?></small></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
        </div>

    </div>

</body>
</html>