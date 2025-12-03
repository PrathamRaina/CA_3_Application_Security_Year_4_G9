<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin1.php");
    exit;
}

$stu_id = intval($_GET['id']);

include 'connection.php';

$sql = "DELETE FROM courseadd WHERE Id = {$stu_id}";
$result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");


header("Location: courseManage.php");

mysqli_close($conn);
?>
