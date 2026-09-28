<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';

$studentClass = $_SESSION['student_class'];
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
$timeSlots = ['9:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00', '12:00 - 1:00'];

$sql = "SELECT * FROM timetable WHERE class = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $studentClass);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$entries = [];
while ($row = mysqli_fetch_assoc($result)) {
    $entries[$row['day']][$row['time_slot']] = $row['subject'] . ' (' . $row['teacher'] . ')';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">

            <h2>My Timetable</h2>

            <table class="table table-dark table-bordered">
                <tr>
                    <th>Time</th>
                    <?php foreach ($days as $day) { ?>
                        <th><?php echo $day; ?></th>
                    <?php } ?>
                </tr>
                <?php foreach ($timeSlots as $slot) { ?>
                    <tr>
                        <td><?php echo $slot; ?></td>
                        <?php foreach ($days as $day) { ?>
                            <td><?php echo isset($entries[$day][$slot]) ? htmlspecialchars($entries[$day][$slot]) : ''; ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

        </div>

    </div>

</body>
</html>