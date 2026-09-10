<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';
$result = mysqli_query($conn, "SELECT * FROM notices ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
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
            <h2>Notices</h2>

<?php while ($notice = mysqli_fetch_assoc($result)) { ?>
    <div class="alert alert-info">
        <strong><?php echo htmlspecialchars($notice['title']); ?></strong><br>
        <?php echo htmlspecialchars($notice['content']); ?><br>
        <small><?php echo date('F j, Y', strtotime($notice['created_at'])); ?></small>
    </div>
<?php } ?>
        </div>

    </div>

</body>
</html>