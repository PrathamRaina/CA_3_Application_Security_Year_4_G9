<?php

// Prevent PHP/MySQL from showing detailed errors to the user (fix for V7)
mysqli_report(MYSQLI_REPORT_OFF);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$mname = $_POST['mname'];
$ftname = $_POST['ftname'];
$address = $_POST['addres'];
$gender = $_POST['gender'];
$state = $_POST['ste'];
$city = $_POST['city'];
$dob = $_POST['dob'];
$pincode = $_POST['pincode'];
$course = $_POST['course'];
$emailid = $_POST['emailid'];

$conn = mysqli_connect("localhost","root","","university") or die("Connection Failed");

$sql = "INSERT INTO reg(fname,lname,mname,ftname,addres,gender,ste,city,dob,pincode,course,emailid)
        VALUES ('{$fname}','{$lname}','{$mname}','{$ftname}','{$address}',
                '{$gender}','{$state}','{$city}','{$dob}','{$pincode}','{$course}','{$emailid}')";

$result = mysqli_query($conn, $sql);

// If query fails, log the real error but show only a simple message to the user
if (!$result) {
    error_log("reg-insert failed: " . mysqli_error($conn));
    header("Location: reg1.php?error=1");
    exit;
}

header("Location: reg1.php");
mysqli_close($conn);

?>
