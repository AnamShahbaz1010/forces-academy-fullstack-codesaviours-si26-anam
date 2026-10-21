<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM courses");
$row = mysqli_fetch_assoc($result);
$totalCourses = $row['total'];

date_default_timezone_set('Asia/Karachi');
$hour = (int) date('G');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');

$result2 = mysqli_query($conn, "SELECT * FROM notices ORDER BY created_at DESC LIMIT 1");
$latestNotice = mysqli_fetch_assoc($result2);
$result3 = mysqli_query($conn, "SELECT * FROM notices ORDER BY created_at DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4 flex-grow-1">

            <div class="hero">
                <div>
                    <span class="hero-chip">📅 <?php echo date('l, j F'); ?></span>
                    <h2><?php echo $greeting; ?>, <?php echo htmlspecialchars($_SESSION['student_name']); ?> <span class="wave-hand">👋</span></h2>
                    <p>Ready to learn something new today?</p>
                    <span class="hero-chip">📚 <?php echo $totalCourses; ?> courses</span>
                    <span class="hero-chip">🎯 Keep going!</span>
                </div>
                <div class="hero-art">
                    <img src="images/books.svg" alt="">
                </div>
            </div>

            <div class="d-flex flex-wrap gap-3">
                <div class="stat-card p-3" style="width: 200px;">
                    <h6>Total Courses</h6>
                    <h3><?php echo $totalCourses; ?></h3>
                </div>

                <div class="stat-card p-3" style="width: 200px;">
                    <h6>Pending Assignments</h6>
                    <h3>0</h3>
                </div>

                <div class="stat-card p-3" style="width: 200px;">
                    <h6>Latest Notice</h6>
                    <h3><?php echo $latestNotice ? htmlspecialchars($latestNotice['title']) : "No notices yet"; ?></h3>
                </div>
            </div>

            <h4 class="mt-4 section-title">Recent Notices</h4>
            <div class="mt-3">
            <?php while ($notice = mysqli_fetch_assoc($result3)) { ?>
                <div class="notice-item">
                    <strong><?php echo htmlspecialchars($notice['title']); ?></strong> - <?php echo htmlspecialchars($notice['content']); ?>
                </div>
            <?php } ?>
            </div>

            <div class="mt-4">
                <a href="courses.php" class="btn btn-outline-info me-2">My Courses</a>
                <a href="assignments.php" class="btn btn-outline-info">Assignments</a>
            </div>

        </div>

    </div>

</body>
</html>