<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class = mysqli_real_escape_string($conn, $_POST['class']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $time_slot = mysqli_real_escape_string($conn, $_POST['time_slot']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $teacher = mysqli_real_escape_string($conn, $_POST['teacher']);

    $sql = "INSERT INTO timetable (class, day, time_slot, subject, teacher) VALUES ('$class', '$day', '$time_slot', '$subject', '$teacher')";
    mysqli_query($conn, $sql);
}

$timetableResult = mysqli_query($conn, "SELECT * FROM timetable ORDER BY class, day");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <h2>Timetable</h2>

            <form method="POST" class="mb-4">
                <div class="mb-2">
                    <input type="text" name="class" placeholder="Class (e.g. BSCS-2A)" class="form-control" required>
                </div>
                <div class="mb-2">
                    <select name="day" class="form-control" required>
                        <option value="">Select Day</option>
                        <option>Monday</option>
                        <option>Tuesday</option>
                        <option>Wednesday</option>
                        <option>Thursday</option>
                        <option>Friday</option>
                    </select>
                </div>
            <div class="mb-2">
                <select name="time_slot" class="form-control" required>
                    <option value="">Select Time Slot</option>
                    <option>9:00 - 10:00</option>
                    <option>10:00 - 11:00</option>
                    <option>11:00 - 12:00</option>
                    <option>12:00 - 1:00</option>
                </select>
            </div>
                <div class="mb-2">
                    <input type="text" name="subject" placeholder="Subject" class="form-control" required>
                </div>
                <div class="mb-2">
                    <input type="text" name="teacher" placeholder="Teacher" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Entry</button>
            </form>

            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Day</th>
                        <th>Time Slot</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($entry = mysqli_fetch_assoc($timetableResult)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['class']); ?></td>
                            <td><?php echo htmlspecialchars($entry['day']); ?></td>
                            <td><?php echo htmlspecialchars($entry['time_slot']); ?></td>
                            <td><?php echo htmlspecialchars($entry['subject']); ?></td>
                            <td><?php echo htmlspecialchars($entry['teacher']); ?></td>
                            <td>
                                <a href="delete_timetable.php?id=<?php echo $entry['id']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this entry?');">
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