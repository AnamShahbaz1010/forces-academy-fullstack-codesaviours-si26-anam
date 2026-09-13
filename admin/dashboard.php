<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';
$totalStudents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM students"))['total'];
$totalCourses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses"))['total'];
$totalAssignments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM assignments"))['total'];
$totalNotices = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
            <h2>Admin Dashboard</h2>

<div class="d-flex gap-3 mb-4" style="flex-wrap: wrap;">
    <div class="stat-card p-3" style="width: 200px;">
        <h6>Total Students</h6>
        <h3><?php echo $totalStudents; ?></h3>
    </div>
    <div class="stat-card p-3" style="width: 200px;">
        <h6>Total Courses</h6>
        <h3><?php echo $totalCourses; ?></h3>
    </div>
    <div class="stat-card p-3" style="width: 200px;">
        <h6>Total Assignments</h6>
        <h3><?php echo $totalAssignments; ?></h3>
    </div>
    <div class="stat-card p-3" style="width: 200px;">
        <h6>Total Notices</h6>
        <h3><?php echo $totalNotices; ?></h3>
    </div>
</div>
        </div>

    </div>

</body>
</html>