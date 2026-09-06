<?php
$courses = [
["name" => "Web Development", "teacher" => "Sir Ali", "duration" => "3 Months"],
["name" => "Graphic Design", "teacher" => "Miss Sara", "duration" => "2 Months"],
["name" => "Machine Learning", "teacher" => "Sir Bilal", "duration" => "4 Months"],
];
$notices = [
["title" => "Assignment 1 Due Friday", "date" => "2026-09-05"],
["title" => "New Course Added: UI/UX", "date" => "2026-09-03"],
];
?>
<?php
session_start();
// Temporary — this will come from the real login once the database class happens
if (!isset($_SESSION['student_name'])) {
$_SESSION['student_name'] = "Anam";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Forces Academy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-2 col-md-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Courses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Assignments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Results</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Notices</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-10 col-md-9">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?>!</h2>
                <div class="row">
<?php foreach ($courses as $course) { ?>
<div class="col-md-4 mb-3">
<div class="card">
<div class="card-body">
<h5 class="card-title"><?php echo $course["name"]; ?></h5>
<p class="card-text">Teacher: <?php echo $course["teacher"]; ?></p>
<p class="card-text">Duration: <?php echo $course["duration"]; ?></p>
</div>
</div>
</div>
<?php } ?>
</div>
<ul class="list-group">
<?php foreach ($notices as $notice) { ?>
<li class="list-group-item">
<?php echo $notice["title"]; ?> — <?php echo $notice["date"]; ?>
</li>
<?php } ?>
</ul>
            </div>

        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>