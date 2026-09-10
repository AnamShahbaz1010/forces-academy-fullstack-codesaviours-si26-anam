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
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</h2>
            <div class="d-flex gap-3 mb-4">
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
        <h4 class="mt-4">Recent Notices</h4>
<?php while ($notice = mysqli_fetch_assoc($result3)) { ?>
    <p><strong><?php echo htmlspecialchars($notice['title']); ?></strong> - <?php echo htmlspecialchars($notice['content']); ?></p>
<?php } ?>
<div class="mt-4">
    <a href="courses.php" class="btn btn-outline-info me-2">My Courses</a>
    <a href="assignments.php" class="btn btn-outline-info">Assignments</a>
</div>
</div>

    </div>

</body>
</html>