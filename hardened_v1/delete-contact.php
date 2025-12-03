<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin1.php");
    exit;
}


$stu_id = $_GET['id'];

include 'connection.php';

$sql = "DELETE FROM contact WHERE Id = {$stu_id}";
$result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

header("Location: Managecontact.php");

mysqli_close($conn);

?>
