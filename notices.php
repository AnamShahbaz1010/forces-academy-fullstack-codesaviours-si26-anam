<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}
require_once 'config/db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerm = '%' . $search . '%';

$sql = "SELECT * FROM notices WHERE title LIKE ? ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $searchTerm);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <div class="d-flex">

        <?php include 'sidebar.php'; ?>

        <div class="p-4" style="flex: 1;">
            <h2>Notices</h2>

            <div class="p-4" style="flex: 1;">
    <h2>Notices</h2>

    <form method="GET" class="mb-3">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by title" class="form-control" style="width: 300px;">
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>

<?php while ($notice = mysqli_fetch_assoc($result)) { ?>
    <div class="alert alert-info">
        <strong><?php echo htmlspecialchars($notice['title']); ?></strong><br>
        <?php echo htmlspecialchars($notice['content']); ?><br>
        <small><?php echo date('F j, Y', strtotime($notice['created_at'])); ?></small>
    </div>
<?php } ?>
        </div>

<?php while ($notice = mysqli_fetch_assoc($result)) { ?>
    <div class="alert alert-info">
        <strong><?php echo htmlspecialchars($notice['title']); ?></strong><br>
        <?php echo htmlspecialchars($notice['content']); ?><br>
        <small><?php echo date('F j, Y', strtotime($notice['created_at'])); ?></small>
    </div>
<?php } ?>
        </div>

    </div>

</body>
</html>