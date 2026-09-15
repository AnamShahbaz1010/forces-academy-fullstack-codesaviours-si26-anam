<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "INSERT INTO notices (title, content) VALUES ('$title', '$content')";
    mysqli_query($conn, $sql);

    $success = "Notice posted successfully!";
}

$noticesResult = mysqli_query($conn, "SELECT * FROM notices ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Notice</title>
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

            <h2>Post Notice</h2>

            <?php if ($success) { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php } ?>

            <form method="POST" class="mb-4">
                <div class="mb-2">
                    <input type="text" name="title" placeholder="Notice Title" class="form-control" required>
                </div>
                <div class="mb-2">
                    <textarea name="content" placeholder="Notice Content" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Post Notice</button>
            </form>

            <h5>Existing Notices</h5>
            <?php while ($notice = mysqli_fetch_assoc($noticesResult)) { ?>
                <div class="alert alert-info d-flex justify-content-between align-items-start">
                    <div>
                        <strong><?php echo htmlspecialchars($notice['title']); ?></strong><br>
                        <?php echo htmlspecialchars($notice['content']); ?><br>
                        <small><?php echo date('F j, Y', strtotime($notice['created_at'])); ?></small>
                    </div>
                    <a href="delete_notice.php?id=<?php echo $notice['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this notice?');">
                        Delete
                    </a>
                </div>
            <?php } ?>

        </div>

    </div>

</body>
</html>