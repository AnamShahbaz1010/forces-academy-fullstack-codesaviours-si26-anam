<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$id = $_POST['id'];
$sql = "UPDATE courses SET course_name = ?, description = ?, teacher_name = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssi", $_POST['course_name'], $_POST['description'], $_POST['teacher_name'], $id);
mysqli_stmt_execute($stmt);

header('Location: courses.php');
exit;
?>