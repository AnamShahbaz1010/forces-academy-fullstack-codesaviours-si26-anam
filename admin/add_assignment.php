<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$title = mysqli_real_escape_string($conn, $_POST['title']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$course_id = $_POST['course_id'];
$due_date = $_POST['due_date'];

$sql = "INSERT INTO assignments (title, description, course_id, due_date) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssis", $title, $description, $course_id, $due_date);
mysqli_stmt_execute($stmt);

header('Location: assignments.php');
exit;
?>