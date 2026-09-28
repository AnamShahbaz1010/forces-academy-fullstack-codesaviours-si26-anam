<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';

$sql = "SELECT * FROM results WHERE student_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['student_id']);
mysqli_stmt_execute($stmt);
$resultsData = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">
            <h2>My Results</h2>

<table class="table table-dark table-bordered">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Marks</th>
            <th>Total</th>
            <th>Grade</th>
            <th>Exam Type</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($result = mysqli_fetch_assoc($resultsData)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($result['subject']); ?></td>
                <td><?php echo htmlspecialchars($result['marks']); ?></td>
                <td><?php echo htmlspecialchars($result['total_marks']); ?></td>
                <td><?php echo htmlspecialchars($result['grade']); ?></td>
                <td><?php echo htmlspecialchars($result['exam_type']); ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
        </div>

    </div>

</body>
</html>