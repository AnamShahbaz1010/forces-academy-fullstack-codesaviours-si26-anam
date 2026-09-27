<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require_once '../config/db.php';

$id = $_POST['id'];
$sql = "UPDATE assignments SET title = ?, description = ?, course_id = ?, due_date = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssisi", $_POST['title'], $_POST['description'], $_POST['course_id'], $_POST['due_date'], $id);
mysqli_stmt_execute($stmt);

header('Location: assignments.php');
exit;
?>