<?php
$is_local = ($_SERVER['SERVER_NAME'] === 'localhost');

if ($is_local) {
    $conn = mysqli_connect("localhost", "root", "", "forces_academy_lms");
} else {
    $conn = mysqli_connect("sql103.infinityfree.com", "if0_42959759", "pI2jGdNKCmI5", "if0_42959759_XXX");
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>