<?php

 $fname = $_POST['username'];
 $lname = $_POST['pasword'];
 
// hash the password
$hashedPassword = password_hash($lname, PASSWORD_DEFAULT);

$conn = mysqli_connect("localhost","root","","university") or die("Connection Failed");

// store hashed password instead of plain text
$sql = "INSERT INTO logintable(username,password) VALUES ('{$fname}','{$hashedPassword}')";

$result = mysqli_query($conn, $sql) or die("Query Unsuccessful.");

 header("Location: adminLogin.php");

mysqli_close($conn);

?>
