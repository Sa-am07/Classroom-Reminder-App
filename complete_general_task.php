<?php 
$id = $_GET['id'];
include "connection.php";
$qry = "UPDATE reminder SET Status = 1 WHERE Reminder_ID = $id";
mysqli_query($con,$qry);
header("location:../Student/dashboard.php?msg=1");
?>