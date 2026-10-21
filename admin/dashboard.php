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

date_default_timezone_set('Asia/Karachi');
$hour = (int) date('G');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
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
<body class="admin-page">

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <div class="admin-hero">
                <div>
                    <span class="eyebrow"><?php echo date('l, j F Y'); ?></span>
                    <h2><?php echo $greeting; ?>, Admin</h2>
                    <p>Here is an overview of Forces Academy.</p>
                </div>
                <div class="admin-hero-icon"><i class="bi bi-shield-check"></i></div>
            </div>

            <div class="d-flex gap-3 mb-4" style="flex-wrap: wrap;">
                <div class="admin-stat a-teal">
                    <div class="stat-icon tone-teal"><i class="bi bi-people-fill"></i></div>
                    <div>
                        <div class="num"><?php echo $totalStudents; ?></div>
                        <div class="lbl">Total Students</div>
                    </div>
                </div>
                <div class="admin-stat a-sand">
                    <div class="stat-icon tone-sand"><i class="bi bi-journal-bookmark-fill"></i></div>
                    <div>
                        <div class="num"><?php echo $totalCourses; ?></div>
                        <div class="lbl">Total Courses</div>
                    </div>
                </div>
                <div class="admin-stat a-coral">
                    <div class="stat-icon tone-coral"><i class="bi bi-pencil-square"></i></div>
                    <div>
                        <div class="num"><?php echo $totalAssignments; ?></div>
                        <div class="lbl">Total Assignments</div>
                    </div>
                </div>
                <div class="admin-stat a-sage">
                    <div class="stat-icon tone-sage"><i class="bi bi-megaphone-fill"></i></div>
                    <div>
                        <div class="num"><?php echo $totalNotices; ?></div>
                        <div class="lbl">Total Notices</div>
                    </div>
                </div>
            </div>

            <div class="panel-card">
                <h5>Quick actions</h5>
                <div class="quick-actions">
                    <a href="students.php"><i class="bi bi-people-fill"></i> Manage Students</a>
                    <a href="courses.php"><i class="bi bi-journal-bookmark-fill"></i> Manage Courses</a>
                    <a href="assignments.php"><i class="bi bi-pencil-square"></i> Assignments</a>
                    <a href="results.php"><i class="bi bi-award-fill"></i> Upload Results</a>
                    <a href="notices.php"><i class="bi bi-megaphone-fill"></i> Post Notice</a>
                    <a href="fees.php"><i class="bi bi-cash-coin"></i> Fees</a>
                </div>
            </div>

        </div>

    </div>

</body>
</html>
