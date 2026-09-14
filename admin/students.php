<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerm = '%' . $search . '%';

$sql = "SELECT * FROM students WHERE full_name LIKE ? OR roll_number LIKE ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);
mysqli_stmt_execute($stmt);
$studentsResult = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
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
            <h2>Manage Students</h2>

<form method="GET" class="mb-3">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name or roll number" class="form-control" style="width: 300px;">
    <button type="submit" class="btn btn-primary mt-2">Search</button>
</form>

<table class="table table-dark table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Roll Number</th>
            <th>Class</th>
            <th>Registered</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($student = mysqli_fetch_assoc($studentsResult)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($student['full_name']); ?></td>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
                <td><?php echo htmlspecialchars($student['roll_number']); ?></td>
                <td><?php echo htmlspecialchars($student['class']); ?></td>
                <td><?php echo date('F j, Y', strtotime($student['created_at'])); ?></td>
                <td>
                    <a href="delete_student.php?id=<?php echo $student['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this student?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
        </div>

    </div>

</body>
</html>