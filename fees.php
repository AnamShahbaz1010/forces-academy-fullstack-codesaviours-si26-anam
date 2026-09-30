<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';

$studentId = $_SESSION['student_id'];

// total pending amount
$sql = "SELECT SUM(amount) AS total_pending FROM fees WHERE student_id = ? AND status = 'pending'";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $studentId);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$totalPending = $row['total_pending'] ?? 0;

// all fee records for this student
$feesSql = "SELECT * FROM fees WHERE student_id = ? ORDER BY due_date DESC";
$feesStmt = mysqli_prepare($conn, $feesSql);
mysqli_stmt_bind_param($feesStmt, "i", $studentId);
mysqli_stmt_execute($feesStmt);
$feesResult = mysqli_stmt_get_result($feesStmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Fees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <h2>My Fees</h2>

            <div class="alert alert-warning">
                Total Pending: Rs. <?php echo number_format($totalPending, 2); ?>
            </div>

            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fee = mysqli_fetch_assoc($feesResult)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fee['description']); ?></td>
                            <td>Rs. <?php echo number_format($fee['amount'], 2); ?></td>
                            <td><?php echo date('F j, Y', strtotime($fee['due_date'])); ?></td>
                            <td><?php echo htmlspecialchars($fee['status']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>

    </div>

</body>
</html>