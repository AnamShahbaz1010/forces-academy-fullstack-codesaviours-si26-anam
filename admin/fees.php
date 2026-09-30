<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];
    $description = $_POST['description'];

    $sql = "INSERT INTO fees (student_id, amount, due_date, description) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "idss", $student_id, $amount, $due_date, $description);
    mysqli_stmt_execute($stmt);

    $success = "Fee record added successfully!";
}

$studentsResult = mysqli_query($conn, "SELECT id, full_name, roll_number FROM students");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Fees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <h2>Manage Fees</h2>

            <?php if ($success) { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php } ?>

            <form method="POST" style="max-width: 500px;">
                <div class="mb-2">
                    <select name="student_id" class="form-control" required>
                        <option value="">Select Student</option>
                        <?php while ($student = mysqli_fetch_assoc($studentsResult)) { ?>
                            <option value="<?php echo $student['id']; ?>">
                                <?php echo htmlspecialchars($student['full_name'] . ' (' . $student['roll_number'] . ')'); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-2">
                    <input type="number" step="0.01" min="0" name="amount" placeholder="Amount" class="form-control" required>
                </div>
                <div class="mb-2">
                    <input type="date" name="due_date" class="form-control" required>
                </div>
                <div class="mb-2">
                    <input type="text" name="description" placeholder="Description (e.g. Semester fee)" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Fee Record</button>
            </form>

        </div>

    </div>

</body>
</html>