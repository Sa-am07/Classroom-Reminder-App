<?php 
$id = $_GET['id'];
include "connection.php";
$qry = "UPDATE personal_reminder SET Status = 1 WHERE Reminder_ID = $id";
mysqli_query($con,$qry);
header("location:../Student/personal_reminder.php?msg=2");
?>