<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin1.php");
    exit;
}


$stu_id = $_GET['id'];

include 'connection.php';

$sql = "DELETE FROM blog WHERE Id = {$stu_id}";
$result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

header("Location: Manageblog.php");

mysqli_close($conn);

?>
