<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$teacher_name = mysqli_real_escape_string($conn, $_POST['teacher_name']);

$sql = "INSERT INTO courses (course_name, description, teacher_name) VALUES ('$course_name', '$description', '$teacher_name')";
mysqli_query($conn, $sql);

header('Location: courses.php');
exit;
?>