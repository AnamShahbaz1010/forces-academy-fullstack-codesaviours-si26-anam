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
    $course_id = $_POST['course_id'];
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $marks = $_POST['marks'];
    $total_marks = $_POST['total_marks'];
    $grade = mysqli_real_escape_string($conn, $_POST['grade']);
    $exam_type = mysqli_real_escape_string($conn, $_POST['exam_type']);

    $sql = "INSERT INTO results (student_id, course_id, subject, marks, total_marks, grade, exam_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iisiiss", $student_id, $course_id, $subject, $marks, $total_marks, $grade, $exam_type);
    mysqli_stmt_execute($stmt);

    $success = "Result uploaded successfully!";
}

$studentsResult = mysqli_query($conn, "SELECT id, full_name FROM students");
$coursesResult = mysqli_query($conn, "SELECT id, course_name FROM courses");
$recentResults = mysqli_query($conn, "SELECT results.*, students.full_name FROM results JOIN students ON results.student_id = students.id ORDER BY results.id DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Results</title>
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

            <h2>Upload Results</h2>

            <?php if ($success) { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php } ?>

            <form method="POST" class="mb-4">
                <div class="mb-2">
                    <select name="student_id" class="form-control" required>
                        <option value="">Select Student</option>
                        <?php while ($student = mysqli_fetch_assoc($studentsResult)) { ?>
                            <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['full_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <select name="course_id" class="form-control" required>
                        <option value="">Select Course</option>
                        <?php while ($course = mysqli_fetch_assoc($coursesResult)) { ?>
                            <option value="<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['course_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-2">
                    <input type="text" name="subject" placeholder="Subject" class="form-control" required>
                </div>

                <div class="mb-2">
                    <input type="number" name="marks" placeholder="Marks" class="form-control" required>
                </div>

                <div class="mb-2">
                    <input type="number" name="total_marks" placeholder="Total Marks" class="form-control" required>
                </div>

                <div class="mb-2">
                    <input type="text" name="grade" placeholder="Grade" class="form-control" required>
                </div>

                <div class="mb-2">
                    <input type="text" name="exam_type" placeholder="Exam Type" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Upload Result</button>
            </form>

            <h5>Recently Uploaded Results</h5>
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>Exam Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($result = mysqli_fetch_assoc($recentResults)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($result['subject']); ?></td>
                            <td><?php echo $result['marks']; ?>/<?php echo $result['total_marks']; ?></td>
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