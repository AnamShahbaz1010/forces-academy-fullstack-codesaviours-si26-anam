<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';
$assignmentsResult = mysqli_query($conn, "SELECT * FROM assignments");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignments</title>
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
            <h2>Assignments</h2>

<?php while ($assignment = mysqli_fetch_assoc($assignmentsResult)) { ?>
    <?php
    $checkSql = "SELECT * FROM submissions WHERE assignment_id = ? AND student_id = ?";
    $stmt = mysqli_prepare($conn, $checkSql);
    mysqli_stmt_bind_param($stmt, "ii", $assignment['id'], $_SESSION['student_id']);
    mysqli_stmt_execute($stmt);
    $checkResult = mysqli_stmt_get_result($stmt);
    $alreadySubmitted = mysqli_num_rows($checkResult) > 0;
    ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5><?php echo htmlspecialchars($assignment['title']); ?></h5>
            <p><?php echo htmlspecialchars($assignment['description']); ?></p>
            <p>Due: <?php echo htmlspecialchars($assignment['due_date']); ?></p>
            <?php if ($alreadySubmitted) { ?>
                <span class="badge bg-success">Submitted</span>
            <?php } else { ?>
                <a href="submit.php?id=<?php echo $assignment['id']; ?>" class="btn btn-primary">Submit Assignment</a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
        </div>

    </div>

</body>
</html>